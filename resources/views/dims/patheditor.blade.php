@extends('layouts.app')

@section('content')
	<head>
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
	</head>


	<div class="container" style="width: 100%;">
		<div class="form-group row add">
			<div class="col-lg-12" >

				<div class="col-lg-12">
					<div class="col-lg-12  visible-md visible-lg" >
						<div id="ListStuff" title="Printer Email List">
							<div class="col-lg-12" style="    background: white;">
								<form>
									<div class="table-responsive scrollable text-center">
										<table class="table table-bordered  " id="tableDetails">
											<thead>
											<tr>
												<th class="text-center " >User ID</th>
												<th class="text-center ">Username</th>
												<th class="text-center ">Email</th>
												<th class="text-center "> Printer Path for Invoices</th>
												<th class="text-center "> Printer Path for Picking Slip</th>
												<th class="text-center "> Printer Path for Purchase Order</th>
												<th class="text-center "> Printer Path for Sales Order</th>
												<th class="text-center "> Printer Path for Truck Control Sheet</th>

											</tr>
											</thead>
											<tbody>
											@foreach($allStuff as $values)
												<tr class="item{{$values->UserID}}">
													<td class="text-center" >{{$values->UserID}}</td>
													<td class="text-center" >{{$values->Username}}</td>
													<td class="text-center" >{{$values->Email}}</td>
													<td class="text-center" >{{$values->PrinterPathInvoice}}</td>
													<td class="text-center" >{{$values->PrinterPathPickingSlip}}</td>
													<td class="text-center" >{{$values->PrinterPathPurchaseOrder}}</td>
													<td class="text-center" >{{$values->PrinterPathSalesOrder}}</td>
													<td class="text-center" >{{$values->PrinterPathTruckControl}}</td>
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
		<div id="editUsers" title="Edit User Information">
			<form>
				<fieldset class="well">
					<legend class="well-legend">Edit Users</legend>
					<div><h2 id="updatemessage">  </h2>
					</div>
					<div class="form-group ">
						<label class="control-label" for="Username"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Username</label>
						<input type="text" class="form-control input-sm col-xs-1" id="Username" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Username" required readonly>
						<input type="hidden" class="form-control input-sm col-xs-1" id="UserID">
					</div>
					<div class="form-group ">
						<label class="control-label" for="Email"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Email</label>
						<input type="text" class="form-control input-sm col-xs-1" id="Email" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter the Email" required>
					</div>
					<div class="form-group ">
						<label class="control-label" for="PrinterPathInvoice"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Printer Path for Invoices</label>
						<input type="text" class="form-control input-sm col-xs-1" id="PrinterPathInvoice" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter Printer Path for Invoices" required>
					</div>
					<div class="form-group ">
						<label class="control-label" for="PrinterPathPickingSlip"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Printer Path for Picking Slips</label>
						<input type="text" class="form-control input-sm col-xs-1" id="PrinterPathPickingSlip" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter Printer Path for Picking Slips" required>
					</div>
					<div class="form-group ">
						<label class="control-label" for="PrinterPathPurchaseOrder"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Printer Path for Purchase Orders</label>
						<input type="text" class="form-control input-sm col-xs-1" id="PrinterPathPurchaseOrder" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter Printer Path for Purchase Orders" required>
					</div>
					<div class="form-group ">
						<label class="control-label" for="PrinterPathSalesOrder"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Printer Path for Sales Order</label>
						<input type="text" class="form-control input-sm col-xs-1" id="PrinterPathSalesOrder" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter Printer Path  for Sales Order" required>
					</div>
					<div class="form-group ">
						<label class="control-label" for="PrinterPathTruckControl"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Printer Path for Truck Control Sheets</label>
						<input type="text" class="form-control input-sm col-xs-1" id="PrinterPathTruckControl" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter Printer Path for Truck Control Sheets" required>
					</div>
				</fieldset>
			</form>
			<div class="col-lg-4">
				<button class="btn btn-primary " type="submit" id="edit">UPDATE</button>
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
					$('#editUsers').hide();
					$('#salesInvoiced').hide();
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});

					$('#tableDetails tbody').on('dblclick', 'tr', function() {
						// $(this).closest("tr").hide();
						$('#editUsers').show();
						var $this = $(this);
						var row = $this.closest("tr");
						var UserID = row.find('td:eq(0)').text();
						var Username = row.find('td:eq(1)').text();
						var Email = row.find('td:eq(2)').text();
						var PrinterPathInvoice = row.find('td:eq(3)').text();
						var PrinterPathPickingSlip = row.find('td:eq(4)').text();
						var PrinterPathPurchaseOrder = row.find('td:eq(5)').text();
						var PrinterPathSalesOrder = row.find('td:eq(6)').text();
						var PrinterPathTruckControl = row.find('td:eq(7)').text();

						showDialog('#editUsers',600,600);
						$('#updatemessage').empty();
						$('#Username').val(Username);
						$('#Email').val(Email);
						$('#PrinterPathInvoice').val(PrinterPathInvoice);
						$('#PrinterPathPickingSlip').val(PrinterPathPickingSlip);
						$('#PrinterPathPurchaseOrder').val(PrinterPathPurchaseOrder);
						$('#PrinterPathSalesOrder').val(PrinterPathSalesOrder);
						$('#PrinterPathTruckControl').val(PrinterPathTruckControl);
						$('#UserID').val(UserID);
						$('#updatemessage').append("You are now editing the information of " + Username+"!");

					});

					$("#edit").click(function()
					{


						$.ajax({
							url: '{!!url("/editUsers")!!}',
							type: "POST",
							data: {
								UserID: $('#UserID').val(),
								Username: $('#Username').val(),
								Email: $('#Email').val(),
								PrinterPathInvoice: $('#PrinterPathInvoice').val(),
								PrinterPathPickingSlip: $('#PrinterPathPickingSlip').val(),
								PrinterPathPurchaseOrder: $('#PrinterPathPurchaseOrder').val(),
								PrinterPathSalesOrder: $('#PrinterPathSalesOrder').val(),
								PrinterPathTruckControl: $('#PrinterPathTruckControl').val()
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