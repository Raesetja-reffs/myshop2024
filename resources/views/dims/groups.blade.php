@extends('layouts.app')

@section('content')
<head>
<style>
h2{color:red;}
h3 {color:blue;}
h4 {color:blue;}
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
</head>


<div class="container" style="width: 100%;">
        <div class="form-group row add">
		   <div class="col-lg-12" >
				<div class="col-lg-4">

					<form>
                        <fieldset class="well">
                            <legend class="well-legend">Add Screen</legend>
                            <div class="form-group ">
                                <label class="control-label" for="GroupName"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Group Name</h4></label>
								<input type="text" class="form-control input-sm col-s-2" id="GroupName" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter an Group Name" required>
                            </div>

							<div class="form-group ">
                                <label class="control-label" for="GroupCode"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Group Code</h4></label>
								<input type="text" class="form-control input-sm col-s-2" id="GroupCode" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter an Group Code">
                            </div>

							<div class="form-group ">
                                <label class="control-label" for="RebateAcc"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Rebate Acc</h4></label>
								<input type="text" class="form-control input-sm col-s-2" id="RebateAcc" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter an RebateAcc">
                            </div>

							<div class="form-group ">
                                <label class="control-label" for="RebatePercent"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Rebate Percent</h4></label>
								<input type="text" class="form-control input-sm col-s-2" id="RebatePercent" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter an RebateAcc" required>
                            </div>

							<div class="form-group ">
                                <label class="control-label" for="InvoiceSeperately"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>InvoiceSeperately</h4></label>

								<select id="InvoiceSeperately">
							    <option value="0">-- Please Choose NewRec--</option>
								<option value="1">True</option>
								<option value="0">False</option>

								</select>

                            </div>

							<div class="form-group ">
                                <label class="control-label" for="NewRec"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>New Rec</h4></label>

								<select id="NewRec">
							    <option value="0">-- Please Choose NewRec--</option>
								<option value="1">True</option>
								<option value="0">False</option>

								</select>

                            </div>




                        </fieldset>
                    </form>
					<button class=" btn btn-success fa fa-plus-circle" type="submit" id="add" >ADD</button>
				</div>
				<div class="col-lg-8">
						<div class="col-lg-12  visible-md visible-lg" >
							<div id="Groups" title="Groups List">
								<div class="col-lg-12">
									<form>
										<div class="table-responsive scrollable text-center">
											<table border="1" id="tableGroups">
											<thead>
												<tr>
													<th class="text-center " ><h4>Group ID</h4></th>
													<th class="text-center "><h4>Group Name</h4></th>
													<th class="text-center "><h4>Group Code</h4></th>
													<th class="text-center "><h4>RebateAcc</h4></th>
													<th class="text-center "><h4>RebatePercent</h4></th>
													<th class="text-center "><h4>InvoiceSeperately</h4></th>
													<th class="text-center "><h4>New Rec</h4></th>

												</tr>
											</thead>
											<tbody>
											@foreach($readGroup as $values)
												<tr class="item{{$values->GroupId}}">
													<td class="text-center" >{{$values->GroupId}}</td>
													<td class="text-center" >{{$values->GroupName}}</td>
													<td class="text-center" >{{$values->GroupCode}}</td>
													<td class="text-center" >{{$values->RebateAcc}}</td>
													<td class="text-center" >{{$values->RebatePercent}}</td>
													<td class="text-center" >{{$values->InvoiceSeperately}}</td>
													<td class="text-center" >{{$values->NewRec}}</td>
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
	<div id="editGroup" title="Please Edit Group Information">
		<form>
			<fieldset class="well">
				<legend class="well-legend">Edit Screen</legend>
				<div><h2 id="updatemessage">  </h2>
				</div>

				<div class="form-group ">
					<input type="hidden" class="form-control input-sm col-xs-1" id="GroupIdEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Name You want to add" required>
				 </div>

				<div class="form-group ">
                                <label class="control-label" for="GroupNameEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Group Name</h4></label>
								<input type="text" class="form-control input-sm col-s-2" id="GroupNameEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter an Group Name" required>
                            </div>

							<div class="form-group ">
                                <label class="control-label" for="GroupCodeEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Group Code</h4></label>
								<input type="text" class="form-control input-sm col-s-2" id="GroupCodeEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter an Group Code" required>
                            </div>

							<div class="form-group ">
                                <label class="control-label" for="RebateAccEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Rebate Acc</h4></label>
								<input type="text" class="form-control input-sm col-s-2" id="RebateAccEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter Rebate Acc" required>
                            </div>

							<div class="form-group ">
                                <label class="control-label" for="RebatePercentEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Rebate Percent</h4></label>
								<input type="text" class="form-control input-sm col-s-2" id="RebatePercentEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter an RebateAcc" required>
                            </div>

							<div class="form-group ">
                                <label class="control-label" for="InvoiceSeperatelyEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>InvoiceSeperately</h4></label>

								<select id="InvoiceSeperatelyEdit">
								<option value="1">True</option>
								<option value="0">False</option>

								</select>

                            </div>

							<div class="form-group ">
                                <label class="control-label" for="NewRecEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>New Rec</h4></label>

								<select id="NewRecEdit">
								<option value="1">True</option>
								<option value="0">False</option>

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


@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>

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
		$('#salesInvoiced').hide();
		$('#editGroup').hide();
		                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

$("#add").click(function()
{


	  $.ajax({
                    url: '{!!url("/addGroup")!!}',
                    type: "POST",
                    data: {
                        GroupId: $('#GroupId').val(),
						GroupName: $('#GroupName').val(),
						GroupCode: $('#GroupCode').val(),
						RebateAcc: $('#RebateAcc').val(),
						RebatePercent: $('#RebatePercent').val(),
						InvoiceSeperately: $('#InvoiceSeperately').val(),
						NewRec: $('#NewRec').val(),

                        statement: 'Insert'
                    },
                    success: function (data)
					{
						location.reload(true);
                    }
                });


});


  $('#tableGroups tbody').on('dblclick', 'tr', function() {
        // $(this).closest("tr").hide();
		 $('#editGroup').show();
		 var $this = $(this);
		 var row = $this.closest("tr");
		 var groupId = row.find('td:eq(0)').text();
		 var groupName = row.find('td:eq(1)').text();
		 var groupCode = row.find('td:eq(2)').text();
		 var rebateAcc = row.find('td:eq(3)').text();
		 var rebatePercent = row.find('td:eq(4)').text();
		 var invoiceSeperately = row.find('td:eq(5)').text();
		 var newRec= row.find('td:eq(6)').text();
		 showDialog('#editGroup',600,600);
		 $('#updatemessage').empty();
		 $('#GroupIdEdit').val(groupId);
		 $('#GroupNameEdit').val(groupName);
		 $('#GroupCodeEdit').val(groupCode);
		 $('#RebateAccEdit').val(rebateAcc);
		 $('#RebatePercentEdit').val(rebatePercent);
		 $('#InvoiceSeperatelyEdit').val(invoiceSeperately);
		 $('#NewRecEdit').val(newRec);
		 $('#updatemessage').append("You are now editing the Group of " + groupName+"!");

   });

	 $('#tableGroups tbody').on('click', 'button', function (e) {
         $('#deleteGroups').show();
		 var $this = $(this);
		 var row = $this.closest("button");
		 showDialog('#deleteGroups',600,600);

});


$("#edit").click(function()
{


	  $.ajax({
                    url: '{!!url("/editGroup")!!}',
                    type: "POST",
                    data: {
                       GroupId: $('#GroupIdEdit').val(),
						GroupName: $('#GroupNameEdit').val(),
						GroupCode: $('#GroupCodeEdit').val(),
						RebateAcc: $('#RebateAccEdit').val(),
						RebatePercent: $('#RebatePercentEdit').val(),
						InvoiceSeperately: $('#InvoiceSeperatelyEdit').val(),
						NewRec: $('#NewRecEdit').val(),
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
                    url: '{!!url("/deleteGroup")!!}',
                    type: "POST",
                    data: {
                        GroupId: $('#GroupIdEdit').val(),
						GroupName: $('#GroupNameEdit').val(),
						GroupCode: $('#GroupCodeEdit').val(),
						RebateAcc: $('#RebateAccEdit').val(),
						RebatePercent: $('#RebatePercentEdit').val(),
						InvoiceSeperately: $('#InvoiceSeperatelyEdit').val(),
						NewRec: $('#NewRecEdit').val(),
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


