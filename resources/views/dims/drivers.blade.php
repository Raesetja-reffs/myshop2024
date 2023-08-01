<x-app-layout>

    <x-slot name="header">
        {{ __('Drivers') }}
    </x-slot>

    <x-slot name="breadcrum">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                Home </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <!--end::Item-->

        <!--begin::Item-->
        <li class="breadcrumb-item text-dark">
            Drivers </li>
        <!--end::Item-->
    </x-slot>

    <style>
        h2{color:red;}
        h3 {color:blue;}
        h4 {color:orange;}
        td{color:orange;}
        tbody{background-color:black;}


        input[type=text], select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 2px;
            box-sizing: border-box;
            cursor: text;
        }

        div.scrollable
        {
            width:100%;
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-y: scroll
        }



    </style>


	<div class="container" style="width: 100%;">
		<div class="form-group row add">



			<div class="col-lg-12" >

				<div class="col-lg-4">

					<form>
						<fieldset class="well">
							<legend class="well-legend">Add Screen</legend>
							<div class="form-group ">
								<label class="control-label" for=  "DriverName" style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Driver Name</h4></label>
								<input type="text" class="form-control input-sm col-s-2" id="DriverName" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Name You Want To Add" required>
							</div>
							<div class="form-group ">
								<label class="control-label" for="GLCode"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Driver GL Code</h4></label>

								@if(count($glCode)>0)
									<select id="glCode">
										<option value="0">-- PLease Choose GL Code--</option>
										@foreach($glCode as $values)
											<option value="{{$values->GLCode}}">{{$values->GLCode}}</option>
										@endforeach
									</select>
							@endif

							<!--<input type="text" class="form-control input-sm col-s-2" id="GLCode" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a GLCode" required>-->
							</div>
							<button class=" btn btn-success fa fa-plus-circle" type="submit" id="add" >ADD</button>

						</fieldset>
					</form>

				</div>
				<div class="col-lg-8">
					<div class="col-lg-12  visible-md visible-lg" >
						<div id="Drivers" title="Drivers List">
							<div class="col-lg-12">
								<form>
									<div class="table-responsive scrollable text-center">
										<table class="table table-borderless" id="tableDriver">
											<thead>
											<tr>
												<th class="text-center " ><h3>Driver ID</h3></th>
												<th class="text-center "><h3>Driver Name</h3></th>
												<th class="text-center "><h3>GL Codes</h3></th>

											</tr>
											</thead>
											<tbody>
											@foreach($readItems as $values)
												<tr class="item{{$values->DriverId}}">
													<td class="text-center" >{{$values->DriverId}}</td>
													<td class="text-center" >{{$values->DriverName}}</td>
													<td class="text-center" >{{$values->GLCode}}</td>
												</tr>
											@endforeach
											</tbody>

										</table>
									</div>


								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="editDriver" title="Please Edit Driver Information">
			<form>
				<fieldset class="well">
					<legend class="well-legend">Edit Screen</legend>
					<div><h2 id="updatemessage">  </h2>
					</div>
					<div class="form-group ">
						<label class="control-label" for="DriverNameEdit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Driver Name</label>
						<input type="text" class="form-control input-sm col-xs-1" id="DriverNameEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Name You want to add" required>
						<input type="hidden" class="form-control input-sm col-xs-1" id="DriverIdEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Name You want to add" required>
					</div>
					<div class="form-group ">
						<label class="control-label" for="GLCodeEdit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Driver GL Code</label>
                        <select id="GLCodeEdit">

                            @foreach($glCode as $values)
                                <option value="{{$values->GLCode}}">{{$values->GLCode}}</option>
                            @endforeach
                        </select>
                    </div>


				</fieldset>
			</form>
			<div class="col-lg-4">
				<button class="btn btn-primary " type="submit" id="edit">UPDATE</button>
			</div>
			<div class="col-lg-4">
				<button class=" btn btn-danger "  type="submit" id="delete">DELETE</button>
			</div>



		</div>



	</div>


    <script>
        $(document).ready(function(){
            $('#QuoteDetails').hide();
            $('#extraInfo').hide();
            $('#salesQEmail').hide();
            $('#orderListing').hide();
            $('#pricing').hide();
            $('#callList').hide();
            $('#copyOrdersBtn').hide();
            $('#tabletLoadingApp').hide();
            $('#pricingOnCustomer').hide();
            $('#salesOnOrder').hide();
            $('#posCashUp').hide();
            $('#dropdown').hide();
            $('#editDriver').hide();
            $('#salesInvoiced').hide();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#add").click(function()
            {
                if ($('#DriverName').val() && $('#DriverName').val().trim().length > 0 ) {
                    $.ajax({
                        url: '{!!secure_url("/addItem")!!}',
                        type: "POST",
                        data: {
                            DriverId: $('#DriverId').val(),
                            DriverName: $('#DriverName').val(),
                            GLCode: $('#glCode').val(),
                            statement: 'Insert'
                        },
                        success: function (data)
                        {
                            location.reload(true);
                        }
                    });
                }

            });

            $('#tableDriver tbody').on('dblclick', 'tr', function() {
                // $(this).closest("tr").hide();
                $('#editDriver').show();
                var $this = $(this);
                var row = $this.closest("tr");
                var driverId = row.find('td:eq(0)').text();
                var driverName = row.find('td:eq(1)').text();
                var glCode = row.find('td:eq(2)').text();
                showDialog('#editDriver',600,600);
                $('#updatemessage').empty();
                $('#DriverNameEdit').val(driverName);
                $('#GLCodeEdit').val(glCode);
                $('#DriverIdEdit').val(driverId);
                $('#updatemessage').append("You are now editing the information of " + driverName+"!");

            });

            $('#tableDriver tbody').on('click', 'button', function (e) {
                $('#deleteDriver').show();
                var $this = $(this);
                var row = $this.closest("button");
                showDialog('#deleteDriver',600,600);

            });


            $("#edit").click(function()
            {

                $.ajax({
                    url: '{!!secure_url("/editItem")!!}',
                    type: "POST",
                    data: {
                        DriverId: $('#DriverIdEdit').val(),
                        DriverName: $('#DriverNameEdit').val(),
                        GLCode: $('#GLCodeEdit').val(),
                        statement: 'Update'
                    },
                    success: function (data)
                    {
                        location.reload(true);

                    }

                });


            });

            $("#delete").click(function()
            {

                $.ajax({
                    url: '{!!secure_url("/deleteItem")!!}',
                    type: "POST",
                    data: {
                        DriverId: $('#DriverIdEdit').val(),
                        statement: 'Delete'
                    },
                    success: function (data)
                    {
                        location.reload(true);
                    }

                });


            });

        });
        function showDialog(tag,width,height)
        {
            $( tag ).dialog({height: height, modal: false,
                width: width,containment: false}).dialogExtend({
                "closable" : true, // enable/disable close button
                "maximizable" : false, // enable/disable maximize button
                "minimizable" : true, // enable/disable minimize button
                "collapsable" : true, // enable/disable collapse button
                "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
                "titlebar" : false, // false, 'none', 'transparent'
                "minimizeLocation" : "right", // sets alignment of minimized dialogues
                "icons" : { // jQuery UI icon class

                    "maximize" : "ui-icon-circle-plus",
                    "minimize" : "ui-icon-circle-minus",
                    "collapse" : "ui-icon-triangle-1-s",
                    "restore" : "ui-icon-bullet"
                },
                "load" : function(evt, dlg){ }, // event
                "beforeCollapse" : function(evt, dlg){ }, // event
                "beforeMaximize" : function(evt, dlg){ }, // event
                "beforeMinimize" : function(evt, dlg){ }, // event
                "beforeRestore" : function(evt, dlg){ }, // event
                "collapse" : function(evt, dlg){  }, // event
                "maximize" : function(evt, dlg){ }, // event
                "minimize" : function(evt, dlg){  }, // event
                "restore" : function(evt, dlg){  } // event
            });
        }


    </script>

</x-app-layout>
