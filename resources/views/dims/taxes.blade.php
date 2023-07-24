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
                                <label class="control-label" for="TaxCode"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Tax Code</h4></label>
								<input type="text" class="form-control input-sm col-s-2" id="TaxCode" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Tax Code">
                            </div>
							<div class="form-group ">
                                <label class="control-label" for="Tax"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Tax</h4></label>
								<input type="text" class="form-control input-sm col-s-2" id="Tax" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Tax">
                            </div>
                           
						   
                        </fieldset>
                    </form>
					<button class=" btn btn-success fa fa-plus-circle" type="submit" id="add" >ADD</button>
				</div>
				<div class="col-lg-8">
						<div class="col-lg-12  visible-md visible-lg" >
							<div id="Taxes" title="Taxes List">
								<div class="col-lg-12">
									<form>
										<div class="table-responsive scrollable text-center">
											<table class="table table-borderless" id="tableTaxes">
											<thead>
												<tr>
													<th class="text-center " ><h3>Tax ID</h3></th>
													<th class="text-center "><h3>Tax Code</h3></th>
													<th class="text-center "><h3>Tax</h3></th>
													
												</tr>
											</thead>
											<tbody>
											@foreach($readTax as $values)
												<tr class="item{{$values->TaxId}}">
													<td class="text-center" >{{$values->TaxId}}</td>
													<td class="text-center" >{{$values->TaxCode}}</td>
													<td class="text-center" >{{$values->Tax}}</td>
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
	<div id="editTaxes" title="Please Edit Tax Information">
		<form>
			<fieldset class="well">
				<legend class="well-legend">Edit Screen</legend>
				<div><h2 id="updatemessage">  </h2>
				</div>
				<div class="form-group ">
					<input type="hidden" class="form-control input-sm col-xs-1" id="TaxIdEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Name You want to add" required>
				  </div>
				<div class="form-group ">
					<label class="control-label" for="TaxCodeEdit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Tax Code</label>
					<input type="text" class="form-control input-sm col-xs-1" id="TaxCodeEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Tax Code" required>
				</div>
				<div class="form-group ">
					<label class="control-label" for="TaxEdit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Tax</label>
					<input type="text" class="form-control input-sm col-xs-1" id="TaxEdit" style="font-size: 12px;font-family: sans-serif;font-weight: 900;" placeholder="Enter a Tax" required>
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
		$('#editTaxes').hide();
		$('#salesInvoiced').hide();
		                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
		
$("#add").click(function()
{

	
	  $.ajax({
                    url: '{!!url("/addTax")!!}',
                    type: "POST",
                    data: {
                        TaxId: $('#TaxId').val(),
						TaxCode: $('#TaxCode').val(),
						Tax: $('#Tax').val(),
                        statement: 'Insert'
                    },
                    success: function (data) 
					{
						location.reload(true);
                    }
                });
	

});


  $('#tableTaxes tbody').on('dblclick', 'tr', function() {
        // $(this).closest("tr").hide();
		 $('#editTaxes').show();
		 var $this = $(this);
		 var row = $this.closest("tr");
		 var taxId = row.find('td:eq(0)').text();
		 var taxCode = row.find('td:eq(1)').text();
		 var tax = row.find('td:eq(2)').text();
		 showDialog('#editTaxes',600,600);
		 $('#updatemessage').empty();
		 $('#TaxIdEdit').val(taxId);
		 $('#TaxCodeEdit').val(taxCode);
		 $('#TaxEdit').val(tax);
		 $('#updatemessage').append("You are now editing the Tax of " + taxCode+"!");
		 
   });
   
 $('#tableTaxes tbody').on('click', 'button', function (e) {
         $('#deleteTaxes').show();
		 var $this = $(this);
		 var row = $this.closest("button");
		 showDialog('#deleteTaxes',600,600); 
		 
});

   
$("#edit").click(function()
{

		
	  $.ajax({
                    url: '{!!url("/editTax")!!}',
                    type: "POST",
                    data: {
                        TaxId: $('#TaxIdEdit').val(),
						TaxCode: $('#TaxCodeEdit').val(),
						Tax: $('#TaxEdit').val(),
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
                    url: '{!!url("/deleteTax")!!}',
                    type: "POST",
                    data: {
                        TaxId: $('#TaxIdEdit').val(),
						TaxCode: $('#TaxCodeEdit').val(),
						Tax: $('#TaxEdit').val(),
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
