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
				<div class="col-lg-4">
				
					<form>
                        <fieldset class="well">
                            <legend class="well-legend">Add Screen</legend>
                            <div class="form-group ">
                                <label class="control-label" for=  "UserName" style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>User Name</h4></label>
                                <input type="text" class="form-control input-sm col-s-2" id="UserName" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a User Name You Want To Add" required>
                              </div>
                            <div class="form-group ">
                                <label class="control-label" for="Password"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Add Password</h4></label>
                                <input type="text" class="form-control input-sm col-s-2" id="Password" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Password Please" required>
                            </div>
							<div class="form-group ">
                                <label class="control-label" for="Email"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Email</h4></label>
                                <input type="text" class="form-control input-sm col-s-2" id="Email" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter an Email Please" required>
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="StatusId"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Status</h4></label>
                                
								<select id="status">
							    <option value="0">-- Please Choose Status--</option>
								<option value="1">True</option>
								<option value="0">False</option>					
							   
								
								</select>
								
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="Administrator"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Administrator</h4></label>
                                
								<select id="Administrator">
							    <option value="0">-- Please Choose Administrator--</option>
								<option value="1">True</option>
								<option value="0">False</option>
								
								</select>
								
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="GroupId"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>GroupId</h4></label>
                                
								<select id="GroupId">
							    <option value="0">-- Please Choose GroupId--</option>
								<option value="1">True</option>
								<option value="0">False</option>
								
								</select>
								
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="Exporting"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Exporting</h4></label>
                                
								<select id="Exporting">
							    <option value="0">-- Please Choose Exporting--</option>
								<option value="1">True</option>
								<option value="0">False</option>
								
								</select>
								
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="exportAllOrders"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>exportAllOrders</h4></label>
                                
								<select id="exportAllOrders">
							    <option value="0">-- Please Choose exportAllOrders--</option>
								<option value="1">True</option>
								<option value="0">False</option>
								
								</select>
								
                            </div>
							
							
							<div class="form-group ">
                                <label class="control-label" for="ExportAllReturns"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>ExportAllReturns</h4></label>
                                
								<select id="ExportAllReturns">
							    <option value="0">-- Please Choose ExportAllReturns--</option>
								<option value="1">True</option>
								<option value="0">False</option>
								
								</select>
								
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="PrinterPathInvoice"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>PrinterPathInvoice</h4></label>
                                
								<select id="PrinterPathInvoice">
							    <option value="0">-- PLease Choose PrinterPathInvoice--</option>
								@foreach($getPrinters as $values)
								<option value="{{$values->strPrinter}}">{{$values->strPrinter}}</option>
								@endforeach
								</select>
							
								
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="PrinterPathPickingSlip"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>PrinterPathPickingSlip</h4></label>
                                
								<select id="PrinterPathPickingSlip">
							    <option value="0">-- PLease Choose PrinterPathPickingSlip--</option>
								@foreach($getPrinters as $values)
								<option value="{{$values->strPrinter}}">{{$values->strPrinter}}</option>
								@endforeach
								</select>
							
								
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="PrinterPathSalesOrder"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>PrinterPathSalesOrder</h4></label>
                                
								<select id="PrinterPathSalesOrder">
							    <option value="0">-- PLease Choose PrinterPathSalesOrder--</option>
								@foreach($getPrinters as $values)
								<option value="{{$values->strPrinter}}">{{$values->strPrinter}}</option>
								@endforeach
								</select>

                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="TabletUser"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Tablet User</h4></label>
                                
								<select id="TabletUser">
							    <option value="0">-- Please Choose TabletUser--</option>
								<option value="1">True</option>
								<option value="0">False</option>
								
								</select>
								
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="CellPhone"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>CellPhone</h4></label>
                                <input type="text" class="form-control input-sm col-s-2" id="CellPhone" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a CellPhone Number Please">
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="RunPastelLinks"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>RunPastelLinks</h4></label>
                                
								<select id="RunPastelLinks">
							    <option value="0">-- Please Choose RunPastelLinks--</option>
								<option value="1">True</option>
								<option value="0">False</option>
								
								</select>
								
                            </div>
							
							<div class="form-group ">
                                <input type="hidden" class="form-control input-sm col-s-2" id="SessionId" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a SessionId Please">
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="PinCode"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>PinCode</h4></label>
                                <input type="text" class="form-control input-sm col-s-2" id="PinCode" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a PinCode Please" required>
                            </div>
							
							<div class="form-group ">
                                <input type="hidden" class="form-control input-sm col-s-2" id="strField6" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a strField6 Please">
                            </div>
							
							
							
							
							
                           
						   
                        </fieldset>
                    </form>
					<button class=" btn btn-success fa fa-plus-circle" type="submit" id="add" >ADD</button>
				</div>
				<div class="col-lg-8">
						<div class="col-lg-12  visible-md visible-lg" >
							<div id="Users" title="Users List">
								<div class="col-lg-12">
									<form>
										<div class="table-responsive scrollable text-center">
											<table border="1" class="table" id="tableUsers">
											<thead>
												<tr>
													<th class="text-center " ><h4>User ID</h4></th>
													<th class="text-center "><h4>User Name</h4></th>
													<th class="text-center " style="display: none;"><h4> Password</h4></th>
													<th class="text-center "><h4>Email</h4></th>
													<th class="text-center "><h4>Status</h4></th>
													<th class="text-center " ><h4>Administrator</h4></th>
													<th class="text-center "><h4>Group Id</h4></th>
													<th class="text-center "><h4> Exporting</h4></th>
													<th class="text-center "><h4>exportAllOrders</h4></th>
													<th class="text-center "><h4>ExportAllReturns</h4></th>
													<th class="text-center "><h4>PrinterPathInvoice</h4></th>
													<th class="text-center " ><h4>PrinterPathPickingSlip</h4></th>
													<th class="text-center "><h4>PrinterPathSalesOrder</h4></th>
													<th class="text-center "><h4> TabletUser</h4></th>
													<th class="text-center "><h4>CellPhone</h4></th>
													<th class="text-center "><h4>RunPastelLinks</h4></th>
													<th class="text-center " style="display: none;"><h4>SessionId</h4></th>
													<th class="text-center "><h4> PinCode</h4></th>
													<th class="text-center "style="display: none;"><h4>strField6</h4></th>
													
													
												</tr>
											</thead>
											<tbody>
											@foreach($readUser as $values)
												<tr class="item{{$values->UserID}}">
													<td class="text-center" >{{$values->UserID}}</td>
													<td class="text-center" >{{$values->UserName}}</td>
													<td class="text-center" style="display: none;">{{$values->Password}}</td>
													<td class="text-center" >{{$values->Email}}</td>
													<td class="text-center" >{{$values->StatusId}}</td>
													<td class="text-center" >{{$values->Administrator}}</td>
													<td class="text-center" >{{$values->GroupId}}</td>
													<td class="text-center" >{{$values->Exporting}}</td>
													<td class="text-center" >{{$values->exportAllOrders}}</td>
													<td class="text-center" >{{$values->ExportAllReturns}}</td>
													<td class="text-center" >{{$values->PrinterPathInvoice}}</td>
													<td class="text-center" >{{$values->PrinterPathPickingSlip}}</td>
													<td class="text-center" >{{$values->PrinterPathSalesOrder}}</td>
													<td class="text-center" >{{$values->TabletUser}}</td>
													<td class="text-center" >{{$values->CellPhone}}</td>
													<td class="text-center" >{{$values->RunPastelLinks}}</td>
													<td class="text-center" style="display: none;">{{$values->SessionId}}</td>
													<td class="text-center" >{{$values->PinCode}}</td>
													<td class="text-center"style="display: none;" >{{$values->strField6}}</td>
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
	 <div id="editUser" title="Please Edit User Information">
		<form>
			<fieldset class="well">
				<legend class="well-legend">Edit Truck Screen</legend>
				<div><h2 id="updatemessage">  </h2>
				</div>
				<div class="form-group ">
					<label class="control-label" for="UserNameEdit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">User Name</label>
					<input type="text" class="form-control input-sm col-xs-1" id="UserNameEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a User Name You want to add" required>
					<input type="hidden" class="form-control input-sm col-xs-1" id="UserIDEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Name You want to add" required>
				  </div>
				<div class="form-group ">
					<label class="control-label" for="PasswordEdit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Password</label>
					<input type="text" class="form-control input-sm col-xs-1" id="PasswordEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Password" required>
				</div>
				<div class="form-group ">
					<label class="control-label" for="EmailEdit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Email</label>
					<input type="text" class="form-control input-sm col-xs-1" id="EmailEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter an Email" required>
				</div>
				
				<div class="form-group ">
                                <label class="control-label" for="StatusIdEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Status</h4></label>
                                
								<select id="statusEdit">
							    <option value="1">True</option>
								<option value="0">False</option>	
								</select>
								
                </div>
				
				<div class="form-group ">
                                <label class="control-label" for="AdministratorEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Administrator</h4></label>
                                
								<select id="AdministratorEdit">
							    <option value="1">True</option>
								<option value="0">False</option>	
								
								</select>
								
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="GroupIdEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>GroupId</h4></label>
                                
								<select id="GroupIdEdit">
							    
								<option value="1">True</option>
								<option value="0">False</option>	
								
								</select>
								
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="ExportingEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Exporting</h4></label>
                                
								<select id="ExportingEdit">
							    
								<option value="1">True</option>
								<option value="0">False</option>	
								
								</select>
								
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="exportAllOrdersEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>exportAllOrders</h4></label>
                                
								<select id="exportAllOrdersEdit">
							     
								<option value="1">True</option>
								<option value="0">False</option>	
								
								</select>
								
                            </div>
							
							
							<div class="form-group ">
                                <label class="control-label" for="ExportAllReturnsEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>ExportAllReturns</h4></label>
                                
								<select id="ExportAllReturnsEdit">
							     <option value="1">True</option>
								<option value="0">False</option>	
								</select>
								
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="PrinterPathInvoiceEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>PrinterPathInvoice</h4></label>
                                
								<select id="PrinterPathInvoiceEdit">
							      --same here
								@foreach($getPrinters as $values)
								<option value="{{$values->strPrinter}}">{{$values->strPrinter}}</option>
								@endforeach
								</select>
							
								
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="PrinterPathPickingSlipEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>PrinterPathPickingSlip</h4></label>
                                
								<select id="PrinterPathPickingSlipEdit">
							     --same here
								@foreach($getPrinters as $values)
								<option value="{{$values->strPrinter}}">{{$values->strPrinter}}</option>
								@endforeach
								</select>
							
								
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="PrinterPathSalesOrderEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>PrinterPathSalesOrder</h4></label>
                                
								<select id="PrinterPathSalesOrderEdit">
							      --same here
								@foreach($getPrinters as $values)
								<option value="{{$values->strPrinter}}">{{$values->strPrinter}}</option>
								@endforeach
								</select>

                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="TabletUserEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Tablet User</h4></label>
                                
								<select id="TabletUserEdit">
							     <option value="1">True</option>
								<option value="0">False</option>	
								
								</select>
								
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="CellPhoneEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>CellPhone</h4></label>
                                <input type="text" class="form-control input-sm col-s-2" id="CellPhoneEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a CellPhone Number Please">
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="RunPastelLinksEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>RunPastelLinks</h4></label>
                                
								<select id="RunPastelLinksEdit">
							    <option value="1">True</option>
								<option value="0">False</option>	
								
								</select>
								
                            </div>
							
							<div class="form-group ">
                                <input type="hidden" class="form-control input-sm col-s-2" id="SessionIdEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a SessionId Please">
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="PinCodeEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>PinCode</h4></label>
                                <input type="text" class="form-control input-sm col-s-2" id="PinCodeEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a PinCode Please" required>
                            </div>
							
							<div class="form-group ">
                                <input type="hidden" class="form-control input-sm col-s-2" id="strField6Edit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a strField6 Please">
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
		$('#editUser').hide();
		                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
		
$("#add").click(function()
{

	
	  $.ajax({
                    url: '{!!url("/addUser")!!}',
                    type: "POST",
                    data: {
                        UserID: $('#UserID').val(),
                        UserName: $('#UserName').val(),
						Password: $('#Password').val(),
						Email: $('#Email').val(),
						StatusId: $('#status').val(),
						Administrator: $('#Administrator').val(),
                        GroupId: $('#GroupId').val(),
						Exporting: $('#Exporting').val(),
						exportAllOrders: $('#exportAllOrders').val(),
						ExportAllReturns: $('#ExportAllReturns').val(),
						PrinterPathInvoice: $('#PrinterPathInvoice').val(),
                        PrinterPathPickingSlip: $('#PrinterPathPickingSlip').val(),
						PrinterPathSalesOrder: $('#PrinterPathSalesOrder').val(),
						TabletUser: $('#TabletUser').val(),
						CellPhone: $('#CellPhone').val(),
						RunPastelLinks: $('#RunPastelLinks').val(),
						SessionId: $('#SessionId').val(),
						PinCode: $('#PinCode').val(),
						strField6: $('#strField6').val(),
                        statement: 'Insert'
                    },
                    success: function (data) 
					{
						location.reload(true);
                    }
                });
	

});

  $('#tableUsers tbody').on('dblclick', 'tr', function() {
        // $(this).closest("tr").hide();
		 $('#editUser').show();
		// $('#statusEdit').prepend('<option value="'+value.StatusId+'"selected="selected">'+value.StatusId+'</option>');
		 var $this = $(this);
		 var row = $this.closest("tr");
		 var userId = row.find('td:eq(0)').text();
		 var userName = row.find('td:eq(1)').text();
		 var password = row.find('td:eq(2)').text();
		 var email = row.find('td:eq(3)').text();
		 var status = row.find('td:eq(4)').text();
		 var administrator = row.find('td:eq(5)').text();
		 var groupid = row.find('td:eq(6)').text();
		 var exporting = row.find('td:eq(7)').text();
		 var exportallorders = row.find('td:eq(8)').text();
		 var exportallreturns = row.find('td:eq(9)').text();
		 var printingpathinvoice = row.find('td:eq(10)').text();
		 var printingpathpickingslip = row.find('td:eq(11)').text();
		 var printingpathsalesorder = row.find('td:eq(12)').text();
		 var tabletuser = row.find('td:eq(13)').text();
		 var cellphone = row.find('td:eq(14)').text();
		 var runpastellinks = row.find('td:eq(15)').text();
		 var sessionid = row.find('td:eq(16)').text();
		 var pincode = row.find('td:eq(17)').text();
		 var strfield6 = row.find('td:eq(18)').text();
		 showDialog('#editUser',600,600);
		 $('#updatemessage').empty();
		 $('#UserIDEdit').val(userId);
		 $('#UserNameEdit').val(userName);
		 $('#PasswordEdit').val(password);
		 $('#EmailEdit').val(email);
		 $('#statusEdit').val(status);
		 $('#AdministratorEdit').val(administrator);
		 $('#GroupIdEdit').val(groupid);
		 $('#ExportingEdit').val(exporting);
		 $('#exportAllOrdersEdit').val(exportallorders);
		 $('#ExportAllReturnsEdit').val(exportallreturns);
		 $('#PrinterPathInvoiceEdit').val(printingpathinvoice);
		 $('#PrinterPathPickingSlipEdit').val(printingpathpickingslip);
		 $('#PrinterPathSalesOrderEdit').val(printingpathsalesorder);
		 $('#TabletUserEdit').val(tabletuser);
		 $('#CellPhoneEdit').val(cellphone);
		 $('#RunPastelLinksEdit').val(runpastellinks);
		 $('#SessionIdEdit').val(sessionid);
		 $('#PinCodeEdit').val(pincode);
		 $('#strField6Edit').val(exportallorders);
		 $('#updatemessage').append("You are now editing the information of " + UserName+"!");
		 
   });
 $('#tableUsers tbody').on('click', 'button', function (e) {
         $('#deleteTrucks').show();
		 var $this = $(this);
		 var row = $this.closest("button");
		 showDialog('#deleteTrucks',600,600); 
   
});
   
$("#edit").click(function()
{

		
	  $.ajax({
                    url: '{!!url("/editUser")!!}',
                    type: "POST",
                    data: {
                        UserID: $('#UserIDEdit').val(),
                        UserName: $('#UserNameEdit').val(),
						Password: $('#PasswordEdit').val(),
						Email: $('#EmailEdit').val(),
						StatusId: $('#statusEdit').val(),
						Administrator: $('#AdministratorEdit').val(),
                        GroupId: $('#GroupIdEdit').val(),
						Exporting: $('#ExportingEdit').val(),
						exportAllOrders: $('#exportAllOrdersEdit').val(),
						ExportAllReturns: $('#ExportAllReturnsEdit').val(),
						PrinterPathInvoice: $('#PrinterPathInvoiceEdit').val(),
                        PrinterPathPickingSlip: $('#PrinterPathPickingSlipEdit').val(),
						PrinterPathSalesOrder: $('#PrinterPathSalesOrderEdit').val(),
						TabletUser: $('#TabletUserEdit').val(),
						CellPhone: $('#CellPhoneEdit').val(),
						RunPastelLinks: $('#RunPastelLinksEdit').val(),
						SessionId: $('#SessionIdEdit').val(),
						PinCode: $('#PinCodeEdit').val(),
						strField6: $('#strField6Edit').val(),
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
                    url: '{!!url("/deleteUser")!!}',
                    type: "POST",
                    data: {
                        UserID: $('#UserIDEdit').val(),
						UserName: $('#UserNameEdit').val(),
						Password: $('#PasswordEdit').val(),
						Email: $('#EmailEdit').val(),
						StatusId: $('#statusEdit').val(),
						Administrator: $('#AdministratorEdit').val(),
                        GroupId: $('#GroupIdEdit').val(),
						Exporting: $('#ExportingEdit').val(),
						exportAllOrders: $('#exportAllOrdersEdit').val(),
						ExportAllReturns: $('#ExportAllReturnsEdit').val(),
						PrinterPathInvoice: $('#PrinterPathInvoiceEdit').val(),
                        PrinterPathPickingSlip: $('#PrinterPathPickingSlipEdit').val(),
						PrinterPathSalesOrder: $('#PrinterPathSalesOrderEdit').val(),
						TabletUser: $('#TabletUserEdit').val(),
						CellPhone: $('#CellPhoneEdit').val(),
						RunPastelLinks: $('#RunPastelLinksEdit').val(),
						SessionId: $('#SessionIdEdit').val(),
						PinCode: $('#PinCodeEdit').val(),
						strField6: $('#strField6Edit').val(),
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