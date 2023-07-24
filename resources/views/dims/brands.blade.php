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
                                <label class="control-label" for="Brand"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Brand</h4></label>
								<input type="text" class="form-control input-sm col-s-2" id="Brand" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Brand" required>
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="GroupId"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Group Id</h4></label>
                                
								<select id="GroupId">
							    <option value="0">-- Please Choose a GroupId--</option>
								@foreach($getGroups as $values)
								<option value="{{$values->GroupId}}">{{$values->GroupId}}</option>
								@endforeach
								</select>

                            </div>
							
							
							<div class="form-group ">
                                <label class="control-label" for="NewRec"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>New Rec</h4></label>
                                
								<select id="NewRec">
							    <option value="0">-- Please Choose New Rec--</option>
								<option value="1">True</option>
								<option value="0">False</option>
								
								</select>
								
                            </div>
							
							<div class="form-group ">
                                <label class="control-label" for="OwnerId"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Owner Id</h4></label>
								<input type="text" class="form-control input-sm col-s-2" id="OwnerId" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Brand" required>
                            </div>
							
                           <button class=" btn btn-success fa fa-plus-circle" type="submit" id="add" >ADD</button>
						   
                        </fieldset>
                    </form>
					
				</div>
				<div class="col-lg-8">
						<div class="col-lg-12  visible-md visible-lg" >
							<div id="Brands" title="Brands List">
								<div class="col-lg-12">
									<form>
										<div class="table-responsive scrollable text-center">
											<table class="table table-borderless" id="tableBrands">
											<thead>
												<tr>
													<th class="text-center " ><h3>Brand ID</h3></th>
													<th class="text-center "><h3>Brand</h3></th>
													<th class="text-center "><h3>Group Id</h3></th>
													<th class="text-center "><h3>New Rec</h3></th>
													<th class="text-center "><h3>Owner Id</h3></th>
													
												</tr>
											</thead>
											<tbody>
											@foreach($readBrand as $values)
												<tr class="item{{$values->BrandId}}">
													<td class="text-center" >{{$values->BrandId}}</td>
													<td class="text-center" >{{$values->Brand}}</td>
													<td class="text-center" >{{$values->GroupId}}</td>
													<td class="text-center" >{{$values->NewRec}}</td>
													<td class="text-center" >{{$values->OwnerId}}</td>
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
	<div id="editBrand" title="Please Edit Driver Information">
		<form>
			<fieldset class="well">
				<legend class="well-legend">Edit Screen</legend>
				<div><h2 id="updatemessage">  </h2>
				</div>
				
				<div class="form-group ">
					<input type="hidden" class="form-control input-sm col-xs-1" id="BrandIdEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Name You want to add" required>
				 </div>
				 
				<div class="form-group ">
					<label class="control-label" for="BrandEdit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Brand</label>
					<input type="text" class="form-control input-sm col-xs-1" id="BrandEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Brand" required>
				</div>
				
				<div class="form-group ">
                                <label class="control-label" for="GroupIdEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Group Id</h4></label>
								<input type="text" class="form-control input-sm col-s-2" id="GroupIdEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Brand" required>
                </div>
							
							
				<div class="form-group ">
                <label class="control-label" for="NewRecEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>New Rec</h4></label>
                                
								<select id="NewRecEdit">
								<option value="1">True</option>
								<option value="0">False</option>
								
								</select>
								
                </div>
							
				<div class="form-group ">
                                <label class="control-label" for="OwnerIdEdit"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Owner Id</h4></label>
								<input type="text" class="form-control input-sm col-s-2" id="OwnerIdEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Brand" required>
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
		$('#editBrand').hide();
		                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
		
$("#add").click(function()
{

	
	  $.ajax({
                    url: '{!!url("/addBrand")!!}',
                    type: "POST",
                    data: {
                        BrandId: $('#BrandId').val(),
						Brand: $('#Brand').val(),
						GroupId: $('#GroupId').val(),
						NewRec: $('#NewRec').val(),
						OwnerId: $('#OwnerId').val(),
                        statement: 'Insert'
                    },
                    success: function (data) 
					{
						location.reload(true);
                    }
                });
	

});


  $('#tableBrands tbody').on('dblclick', 'tr', function() {
        // $(this).closest("tr").hide();
		 $('#editBrand').show();
		 var $this = $(this);
		 var row = $this.closest("tr");
		 var brandId = row.find('td:eq(0)').text();
		 var brand = row.find('td:eq(1)').text();
		 var groupId = row.find('td:eq(2)').text();
		 var newRec = row.find('td:eq(3)').text();
		 var ownerId = row.find('td:eq(4)').text();
		 showDialog('#editBrand',600,600);
		 $('#updatemessage').empty();
		 $('#BrandIdEdit').val(brandId);
		 $('#BrandEdit').val(brand);
		 $('#GroupIdEdit').val(groupId);
		 $('#NewRecEdit').val(newRec);
		 $('#OwnerIdEdit').val(ownerId);
		 $('#updatemessage').append("You are now editing the Brand of " + brand+"!");
		 
   });
   
	 $('#tableBrands tbody').on('click', 'button', function (e) {
         $('#deleteBrand').show();
		 var $this = $(this);
		 var row = $this.closest("button");
		 showDialog('#deleteBrand',600,600); 
		 
});

   
$("#edit").click(function()
{

		
	  $.ajax({
                    url: '{!!url("/editBrand")!!}',
                    type: "POST",
                    data: {
                        BrandId: $('#BrandIdEdit').val(),
						Brand: $('#BrandEdit').val(),
						GroupId: $('#GroupIdEdit').val(),
						NewRec: $('#NewRecEdit').val(),
						OwnerId: $('#OwnerIdEdit').val(),
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
                    url: '{!!url("/deleteBrand")!!}',
                    type: "POST",
                    data: {
                        BrandId: $('#BrandIdEdit').val(),
						Brand: $('#BrandEdit').val(),
						GroupId: $('#GroupIdEdit').val(),
						NewRec: $('#NewRecEdit').val(),
						OwnerId: $('#OwnerIdEdit').val(),
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
