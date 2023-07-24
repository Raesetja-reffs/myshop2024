@extends('layouts.app')

@section('content')
    <html>
    <head>



    </head>
    <div class="col-lg-12"  style="background: white;    font-family: 'Helvetica Neue', arial, sans-serif;">

        <fieldset class="well">
            <legend class="well-legend">Customer Specials</legend>
            <form>
                <div class="col-md-12">
                    <div class="form-group col-md-2" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="inputCustAcc" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Account</label>
                        <input type="text" name="custCode" class="form-control input-sm" id="inputCustAcc" style="height:22px;font-size: 10px;font-weight: 900;color: black;">
                        <input type="hidden" name="customerId" class="form-control input-sm" id="customerId" style="height:22px;font-size: 10px;font-weight: 900;color: black;" required>
                    </div>

                    <div class="form-group col-md-3" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="inputCustName" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Name</label>
                        <input type="text" name="custDescription" class="form-control input-sm" id="inputCustName" style="height:22px;font-size: 10px;font-weight: 900;color: black;" required>
                    </div>

                    <div class="form-group col-md-2" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="custheadid" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Contract ID</label>
                        <select class="form-control input-sm" id="custheadid" style="font-weight: 900;color: black;font-size: 13px;"></select>
                    </div>

                    <div class="form-group col-md-2" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="dateFrom" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date From</label>
                        <input type="text" class="form-control input-sm" id="dateFrom" style="font-weight: 900;color: black;font-size: 13px;">
                    </div>

                    <div class="form-group col-md-2" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="dateTo" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date To</label>
                        <div class="input-group">
                            <input type="text" class="form-control input-sm" id="dateTo" style="font-weight: 900;color: black;font-size: 13px;">
                            <div class="input-group-btn">
                                <button type="button" id="submitFiltersOnCreatingCustSpecial" class="btn btn-success" style="padding: 2px 12px;height: 25px;font-size: 12px;">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="col-md-12" style="margin-top: 25px;">

                <div class="col-md-8">


                    <button type="button" id="getContractDetails" class="btn-xs btn-primary " style="padding: 2px 19px;">Get Contract Details</button>
                    <button type="button" id="copyContractIntoLines" class="btn-xs btn-primary " style="padding: 2px 19px;">Copy Contract</button>

                </div>

            </div>

        </fieldset>
    </div>
    <div class="col-lg-12">

        <div class="col-lg-11">

        <table id ="tblCreateNewSpecial" class="table table-bordered table-condensed">
            <thead>
            <tr style="font-size: 12px;">
                <td>Code</td>
                <td>Description</td>
                <td>Date From</td>
                <td>Date To</td>
                <td>Price</td>
                <td>Cost</td>
                <td>GP</td>
                <td>Cost Created</td>
                <td>C.S Price</td>
                <td>Actions</td>
            </tr>
            </thead>
            <tbody></tbody>
        </table>

        <button class="btn-xs btn-success my-2 pull-right" id="SaveNewSpecial" >Top Up Special</button>
        <hr>
        </div>
        <div class="col-lg-1 bg-light flex-column" id="hidebeforesubmit"  >
            <button class="btn btn-success w-100 my-2" id="addnewline" >Add Line</button>
            <hr>
            <button type="button" id="importexcel" class="btn btn-primary w-100 my-2">Import Excel</button>
            <button type="button" id="exportexcel" class="btn btn-primary w-100 my-2">Export Excel</button>
            <hr>
            <button type="button" id="deletelines" class="btn btn-danger w-100 my-2" >Delete All - Lines</button>
            <button type="button" id="deleteall" class="btn btn-danger w-100 my-2">Delete Contract </button>
            <hr>
            <button id="doneCreating" class="btn btn-primary w-100 my-2">Update Data</button>
            <button id="savenewspecials" class="btn btn-success w-100 my-2">Save Data</button>
        </div>
    </div>

    <div class="col-lg-11" id="afterFilter">

        <div id="gridContainer" style="     width:100%;height:62%">
        </div>


        <div title="Items having duplicate specials. Press Yes to push the products, No closes the dialog" id="duplicatespecials">
            <h2>These lines have duplicate specials.</h2>
            <form>

                <div class="form-group  col-md-12" >
                    <table class="table2 table-bordered  dataTable">
                        <thead>
                        <tr>
                            <td>Item Code</td>
                            <td>Item Name</td>
                            <td>Price</td>
                            <td>Date From</td>
                            <td>Date To</td>
                            <td>Contract ID</td>
                        </tr>
                        </thead>
                        <tbody id="gridduplicatespecials">

                        </tbody>
                    </table>

                </div>
            </form>

        </div>
        <div title="Copy Contract" id="dialogcopycontracts">
            <h3>Copy Contract From </h3>
            <form>
                <div class="col-md-12">
                    <div class="form-group  col-md-12" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="custcodeto"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Enter Contact ID You Want To Copy From</label>
                        <input class="form-control input-sm col-md-4 auto-complete-off" name="entercontracts" id="entercontracts" style="height:30px;font-size: 10px;"></input>
                    </div>
                    <div class="col-md-12">
                        <button type="button" id="validateConTractId" class="btn-warning btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Validate The Contract ID</button>

                    </div>
                    <div class="col-md-12" id="messagevalidatingthecontract">

                    </div>
                    <div class="col-md-12">
                        <button type="button" id="finalisecopy" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Finalise Copying</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    @endsection
    <style>

        .dx-datagrid-table{
            font-size:10px;
        }
    </style>
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <script>
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        var datagrids="";

        today = yyyy  + '-' +mm  + '-' +dd ;
        console.debug(today);
        $( document ).on( 'focus', ':input', function(){
            $( this ).attr( 'autocomplete', 'off' );
        });

        var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});
        var jArray = JSON.stringify({!! json_encode($products) !!});

        console.debug(jArray);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var finalDataProduct = $.map(JSON.parse(jArray), function (item) {
            return {
                value: item.PastelCode,
                PastelCode: item.PastelCode,
                PastelDescription: item.PastelDescription,
                UnitSize: item.UnitSize,
                Tax: item.Tax,
                Cost: parseFloat(item.Cost).toFixed(2),
                QtyInStock: item.QtyInStock,
                Margin: item.Margin,
                Alcohol: item.Alcohol,
                Available: parseFloat(item.Available).toFixed(2)
            }

        });
        var finalDataProductDescription = $.map(JSON.parse(jArray), function (item) {
            return {
                value: item.PastelDescription,
                PastelCode: item.PastelCode,
                PastelDescription: item.PastelDescription,
                UnitSize: item.UnitSize,
                Tax: item.Tax,
                Cost: parseFloat(item.Cost).toFixed(2),
                QtyInStock: item.QtyInStock,
                Margin: item.Margin,
                Alcohol: item.Alcohol,
                Available: parseFloat(item.Available).toFixed(2)
            }

        });

        var finalData =$.map(JSON.parse(jArrayCustomer), function(item) {

            return {
                BalanceDue:item.BalanceDue,
                CustomerPastelCode:item.CustomerPastelCode,
                StoreName:item.StoreName,
                UserField5:item.UserField5,
                CustomerId:item.CustomerId,
                CreditLimit:item.CreditLimit,
                Email:item.Email,
                Routeid:item.Routeid,
                Discount:item.Discount,
                OtherImportantNotes:item.OtherImportantNotes,
                Routeid:item.Routeid,
                strRoute:item.strRoute
            }

        });

        $(document).ready(function() {
            generateALine2();
            /*
                        $('#messagevalidatingthecontract').empty();

                        console.debug("customerid-----------"+$('#custheadid').val()+"---------dFrom-----"+dFrom.length+"------------"+dateTo.length);
                        if($('#custheadid').val() == "-99" && dFrom.length < 8 && dateTo.length < 8  )
            */
            $('#importexcel').click(function(){


                var dFromImporting =$('#dateFrom').val();
                var dFromExporting =$('#dateTo').val();
                if($("#custheadid").val() == "-99" || dFromImporting.length < 8 || dFromExporting.length < 8){
                    var dialog = $('<p><strong style="color:red">Contract ID Empty or Dates not selected yet</strong></p>').dialog({
                        height: 200, width: 700,modal: true,containment: false,
                        buttons: {
                            "Okay": function () {
                                dialog.dialog('close');
                            }
                        }
                    });
                }else{
                    // window.location = '{!!url("/export")!!}/'+$('#custheadid').val();
                    window.open('{!!url("/dialogtoimportspecials")!!}/' + $('#customerId').val()+"/"+ $('#custheadid').val() + "/" +$('#dateFrom').val()+ "/" + $('#dateFrom').val(), "Contract Id" + $('#custheadid').val(), "location=1,status=1,scrollbars=1, width=500,height=500");
                    $('#importexcel').css('background-color','green');}
//
//showDialogWithoutClose('#uploaddocument',400,400);
            });


            $('#orderListing').hide();
            $('#SaveNewSpecial').hide();
            $('#addinCurrentPrices').hide();
            $('#addinHistory').hide();
            $('#pricing').hide();
            $('#pricingOnCustomer').hide();
            $('#callList').hide();
            $('#tabletLoadingApp').hide();
            $('#copyOrdersBtn').hide();
            $('#salesOnOrder').hide();
            $('#salesInvoiced').hide();
            $('#posCashUp').hide();
            $('#duplicatespecials').hide();
            $('#dialogcopycontracts').hide();
            $('#exportexcel').hide();
            $('#importexcel').hide();
            $('#deletelines').hide();
            $('#deleteall').hide();
            $('#hidebeforesubmit').hide();
            $('#uploaddocument').hide();
            $('#subbuttonmian').hide();
            $('#getContractDetails').hide();
            $('#copyContractIntoLines').hide();
            $('#exportexcel').click(function()
            {
                window.location = '{!!url("/export")!!}/'+$('#custheadid').val();
            });

            var inputCustAccount = $('#inputCustAcc').flexdatalist({
                minLength: 1,
                valueProperty: '*',
                selectionRequired: true,
                searchContain:true,
                focusFirstResult: true,
                visibleProperties: ["CustomerPastelCode","StoreName"],
                searchIn: 'CustomerPastelCode',
                data: finalData
            });
            inputCustAccount.on('select:flexdatalist', function (event, data) {

                $('#inputCustAcc').val(data.CustomerPastelCode);
                $('#inputCustName').val(data.StoreName);
                $('#customerId').val(data.CustomerId);
                $('#subbuttonmian').show();

                $('#getContractDetails').show();
                $('#copyContractIntoLines').show();

                // $('#customerIdfile').val(data.CustomerId);

            });
            var inputCustNumber = $('#inputCustAcc').flexdatalist({
                minLength: 1,
                valueProperty: '*',
                selectionRequired: true,
                searchContain:true,
                focusFirstResult: true,
                visibleProperties: ["CustomerPastelCode","StoreName"],
                searchIn: 'CustomerPastelCode',
                data: finalData
            });
            var inputCustName = $('#inputCustName').flexdatalist({
                minLength: 1,
                valueProperty: '*',
                selectionRequired: true,
                searchContain:true,
                focusFirstResult: true,
                visibleProperties: ["CustomerPastelCode","StoreName"],
                searchIn: 'StoreName',
                data: finalData
            });
            inputCustNumber.on('select:flexdatalist', function (event, data) {

                $('#inputCustAcc').val(data.CustomerPastelCode);
                $('#inputCustName').val(data.StoreName);
                $('#customerId').val(data.CustomerId);
                $('#subbuttonmian').show();
                $('#getContractDetails').show();
                $('#copyContractIntoLines').show();
                //start option population here async
                $.ajax({
                    url: '{!!url("/getContractsPerCustomerID")!!}',
                    type: "POST",
                    data: {
                        customerid: $('#customerId').val()
                    },
                    success: function (data) {
                        //$('#tblCreateNewSpecial tbody').empty();
                        var trHTML = "";
                        $("#custheadid").empty();
                        trHTML+='<option value="-99">Select a Contract ID</option>';
                        $.each(data, function (key, value) {

                            trHTML +=
                                '<option value="'+value.SpecialHeaderId+'">'+value.SpecialHeaderId+' ['+value.DateFrom+' TO '+value.DateTo+']' +'</option>';

                        });
                        $("#custheadid").append(trHTML);
                    }
                });


            });
            inputCustName.on('select:flexdatalist', function (event, data) {

                $('#inputCustAcc').val(data.CustomerPastelCode);
                $('#inputCustName').val(data.StoreName);
                $('#customerId').val(data.CustomerId);
                $('#subbuttonmian').show();
                // $('#customerIdfile').val(data.CustomerId);
                $.ajax({
                    url: '{!!url("/getContractsPerCustomerID")!!}',
                    type: "POST",
                    data: {
                        customerid: $('#customerId').val()
                    },
                    success: function (data) {
                       // $('#tblCreateNewSpecial tbody').empty();
                        var trHTML = "";
                        $("#custheadid").empty();
                        trHTML+='<option value="-99">Select a Contract ID</option>';
                        $.each(data, function (key, value) {

                            trHTML +=
                                '<option value="'+value.SpecialHeaderId+'">'+value.SpecialHeaderId+' ['+value.DateFrom+' TO '+value.DateTo+']' +'</option>';

                        });
                        $("#custheadid").append(trHTML);
                    }
                });


            });
            $('#deletelines').click(function(){
                var dialog = $('<p><strong style="color:red">Are you sure you want to delete all lines?</strong></p>').dialog({
                    height: 200, width: 700,modal: true,containment: false,
                    buttons: {
                        "Yes": function () {
                            $.ajax({
                                url: '{!!url("/deletecontractlines")!!}',
                                type: "POST",
                                data: {
                                    contractid: $('#custheadid').val(),

                                },
                                success: function (data) {
                                    $('.dx-datagrid-table tbody').empty();
                                }
                            });
                            dialog.dialog('close');
                        },
                        "No": function(){
                            dialog.dialog('close');
                        }
                    }
                });



            });
            $('#deleteall').click(function(){


                var dialog = $('<p><strong style="color:red">Are you sure you want to delete the whole contract?</strong></p>').dialog({
                    height: 200, width: 700,modal: true,containment: false,
                    buttons: {
                        "Yes": function () {
                            $.ajax({
                                url: '{!!url("/deleteALLBasedContract")!!}',
                                type: "POST",
                                data: {
                                    contractid: $('#custheadid').val(),

                                },
                                success: function (data) {
                                    $('#tblCreateNewSpecial tbody').empty();
                                    location.reload();
                                }
                            });
                            dialog.dialog('close');
                        },
                        "No": function(){
                            dialog.dialog('close');
                        }
                    }
                });




            });
            $('#addnewline').click(function(){

                generateALine2();
            });
            $("#dateFrom,#dateTo").datepicker({
                changeMonth: true,//this option for allowing user to select month
                changeYear: true, //this option for allowing user to select from year range
                dateFormat: 'yy-mm-dd'
            });
            $('#submitFiltersOnCreatingCustSpecial').click(function(){

                $('#addinCurrentPrices').show();
                $('#importexcel').show();
                $('#hidebeforesubmit').show();
                $('#deleteall').show();
                $('#deletelines').show();
                $('#addinHistory').show();
                $('#afterFilter').show();
                $('#savenewspecials').hide();
                //$('#tblCreateNewSpecial tbody').empty();
                if($("#custheadid").val() == "-99"){
                    //create
                    $.ajax({
                        url: '{!!url("/createnewcustomercontract")!!}',
                        type: "POST",
                        data: {
                            customerId: $('#customerId').val(),
                            dateFrom: $('#dateFrom').val(),
                            dateTo: $('#dateTo').val()
                        },
                        success: function (data) {
                            console.log(data[0].result);
                            $('#custheadid').prepend('<option value="'+data[0].result+'" selected="selected">'+data[0].result+' ['+$('#dateFrom').val()+' TO '+$('#dateTo').val()+']' +'</option>');

                            $('#exportexcel').show();
                            $('#doneCreating').hide();
                            $('#savenewspecials').show();

                            $('#savenewspecials').click(function()
                            {
                                createbrannewspecials();
                            });

                        }
                    });
                }

            });
            $("#custheadid").change(function(){   // 1st way

                $('#exportexcel').show();
                var end = this.value;
                $('#contractIdfile').val(end);
                $.ajax({
                    url: '{!!url("/getcontractDates")!!}',
                    type: "POST",
                    data: {
                        contractId: end
                    },
                    success: function (data) {

                        $('#dateFrom').val($.datepicker.formatDate('yy-mm-dd', new Date( data[0].DateFrom)) );
                        $('#dateTo').val( $.datepicker.formatDate('yy-mm-dd', new Date( data[0].DateTo))  );

                    }
                });

            });
            $('#copyContractIntoLines').click(function(){

                //copy contract
                var dFrom =$('#dateFrom').val();
                var dateTo =$('#dateTo').val();
                $('#messagevalidatingthecontract').empty();

                console.debug("customerid-----------"+$('#custheadid').val()+"---------dFrom-----"+dFrom.length+"------------"+dateTo.length);
                if($('#custheadid').val() == "-99" && dFrom.length < 8 && dateTo.length < 8  )
                {
                    var dialog = $('<p>Sorry <strong style="color:red"> Please put in the dates, or make sure you have selected the contract ID</strong></p>').dialog({
                        height: 200, width: 700,
                        buttons: {
                            "OK": function () {

                                dialog.dialog('close');
                            }
                        }
                    });
                }else{
                    $('#entercontracts').val("");
                    $('#dialogcopycontracts').show();
                    showDialogWithoutClose('#dialogcopycontracts',400,400);
                }

            });
            $('#finalisecopy').click(function(){

                //copy contract
                var contractidtouse = $('#entercontracts').val();
                //	@contructId as bigint,

                if( contractidtouse.length < 2 )
                {
                    var dialog = $('<p>Sorry <strong style="color:red">Please Put In The Contract ID You Want To Copy The Data From </strong></p>').dialog({
                        height: 200, width: 700,
                        buttons: {
                            "OK": function () {

                                dialog.dialog('close');
                            }
                        }
                    });
                }else{
                    $.ajax({
                        url: '{!!url("/copycontract")!!}',
                        type: "POST",
                        data: {
                            contructId: contractidtouse,
                            customerIdToCopyTo: $('#customerId').val(),
                            contractIdToCopyTo: $('#custheadid').val(),
                            dateFrom: $('#dateFrom').val(),
                            dateTo: $('#dateTo').val()

                        },
                        success: function (data) {
                            console.debug(data[0].result);
                            if( data[0].result=="Success"){
                                // $('#dialogcopycontracts').dialog('close');
                                // $('#getContractDetails').click();
                                //contractId
                                var dialog = $('<p> <strong style="color:red">Contract ID is '+data[0].contractId+' </strong></p>').dialog({
                                    height: 200, width: 700,
                                    buttons: {
                                        "OK": function () {
                                            dialog.dialog('close');
                                            location.reload();
                                        }
                                    }
                                });

                            }

                        }
                    });
                }


            });
            $('#validateConTractId').click(function(){

                //copy contract
                $.ajax({
                    url: '{!!url("/validatethecontractId")!!}',
                    type: "GET",
                    data: {
                        entercontracts: $('#entercontracts').val()
                    },
                    success: function (data) {
                        console.debug(data[0].result);
                        //$('#messagevalidatingthecontract').empty();
                        $('#messagevalidatingthecontract').append( data[0].result );
                        $('#messagevalidatingthecontract').dialog('close');

                    }
                });
            });



            $('#addinHistory').click(function(){
                //ajax this to add in history on the contract, refresh page
                //and as well this needs to press done before it adds in history


            var checkedLines = new Array();
            var allGridItems =  $("#gridContainer").dxDataGrid("getDataSource").store().load().done(function (data) {
                checkedLines= data;
     });
            console.log( checkedLines);

            var productsLinesOnPicking ="<xml>";
         /*   */
            console.log( "_________________________");
            //console.log( productsLinesOnPickingPrimary);

            $.each(checkedLines ,function(key,value) {
               if (value.Date == undefined || (value.Date).length < 5){
                    value.Date= $('#dateFrom').val();
                }
                if (value.DateTo == undefined || (value.DateTo).length < 5){
                    value.DateTo= $('#dateTo').val();
                }
                if((value.PastelCode).length > 1 && value.PriceLookedUp !="NaN"){
                    productsLinesOnPicking= productsLinesOnPicking + "<result>";
                    productsLinesOnPicking= productsLinesOnPicking + "<productCode>"+escapeHtml(value.PastelCode)+"</productCode>";
                    productsLinesOnPicking= productsLinesOnPicking + "<price>"+value.PriceLookedUp+"</price>";
                    productsLinesOnPicking= productsLinesOnPicking + "<dateFrom>"+value.Date+"</dateFrom>";
                    productsLinesOnPicking= productsLinesOnPicking + "<dateTo>"+value.DateTo+"</dateTo>";
                    productsLinesOnPicking= productsLinesOnPicking + "<cost_>"+value.Cost+"</cost_>";
                    productsLinesOnPicking= productsLinesOnPicking + "<gp_>"+(1-(value.Cost/value.PriceLookedUp))*100+"</gp_>";
                    productsLinesOnPicking= productsLinesOnPicking + "<customerid>"+escapeHtml($('#customerId').val())+"</customerid>";
                    productsLinesOnPicking= productsLinesOnPicking + "<contractid>"+escapeHtml($('#custheadid').val())+"</contractid>";
                    productsLinesOnPicking= productsLinesOnPicking+ "</result>";

                }
                console.debug("**********"+value.Date);


            });
            productsLinesOnPicking= productsLinesOnPicking+"</xml>";
            $.ajax({
                url: '{!!url("/XmlCreateCustomerSpecialsKFValid")!!}', // createCustomerSpecials
                type: "POST",
                data: {
                    customerCode: $('#inputCustAcc').val(),
                    customerId: $('#customerId').val(),
                    contractDateFrom: $('#dateFrom').val(),
                    contractDateTo: $('#dateTo').val(),
                    contractid: $('#custheadid').val(),
                    orderDetails: productsLinesOnPicking
                },
                success: function (data) {
                    var duplicateresult = data.result;
                    if (data.result.length ==0) // so if there is nothing  do the following
                    {
                        $.ajax({
                            url: '{!!url("/XmlCreateCustomerSpecialsKF")!!}', // createCustomerSpecials
                            type: "POST",
                            data: {
                                customerCode: $('#inputCustAcc').val(),
                                customerId: $('#customerId').val(),
                                contractDateFrom: $('#dateFrom').val(),
                                contractDateTo: $('#dateTo').val(),
                                contractid: $('#custheadid').val(),
                                orderDetails: productsLinesOnPicking
                            },success: function (data) {

                            }
                        });
                    }else{// so if there is nothing  do the following

                        var trHTML = "";

                        $('#gridduplicatespecials').empty();
                        $('#duplicatespecials').show(); //table
                        var dialog = $("#duplicatespecials").dialog({
                            height: 800, modal: true, closeOnEscape: true,
                            width: 800, buttons: {
                                "NO": function () {
                                    dialog.dialog('close');
                                },
                                "YES": function () {

                                    $.ajax({
                                        url: '{!!url("/XmlCreateCustomerSpecialsKF")!!}', // createCustomerSpecials
                                        type: "POST",
                                        data: {
                                            customerCode: $('#inputCustAcc').val(),
                                            customerId: $('#customerId').val(),
                                            contractDateFrom: $('#dateFrom').val(),
                                            contractDateTo: $('#dateTo').val(),
                                            contractid: $('#custheadid').val(),
                                            orderDetails: productsLinesOnPicking
                                        },success: function (data) {

                                        }
                                    });

                                }
                            },containment: false,
                        }).dialogExtend({
                            "closable": true, // enable/disable close button
                            "maximizable": false, // enable/disable maximize button
                            "minimizable": true, // enable/disable minimize button
                            "collapsable": true, // enable/disable collapse button
                            "dblclick": "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
                            "titlebar": false, // false, 'none', 'transparent'
                            "minimizeLocation": "right", // sets alignment of minimized dialogues
                            "icons": { // jQuery UI icon class
                                "close": "ui-icon-circle-close",
                                "maximize": "ui-icon-circle-plus",
                                "minimize": "ui-icon-circle-minus",
                                "collapse": "ui-icon-triangle-1-s",
                                "restore": "ui-icon-bullet"
                            },
                            "load": function (evt, dlg) {
                            }, // event
                            "beforeCollapse": function (evt, dlg) {
                            }, // event
                            "beforeMaximize": function (evt, dlg) {
                            }, // event
                            "beforeMinimize": function (evt, dlg) {
                            }, // event
                            "beforeRestore": function (evt, dlg) {
                            }, // event
                            "collapse": function (evt, dlg) {
                            }, // event
                            "maximize": function (evt, dlg) {
                            }, // event
                            "minimize": function (evt, dlg) {
                            }, // event
                            "restore": function (evt, dlg) {
                            } // event
                        });
                        $.each(duplicateresult, function (key, value) {
                            //p.PastelCode,p.PastelDescription,cs.SpecialHeaderId as [Contract] ,ts.dateFrom, ts.dateTo, CustomerPastelCode, p.PastelCode, p.PastelDescription AS Pdesc, cs.Price
                            trHTML += '<tr style="font-size: 13px !important;color: black;background: lightgrey;font-weight: normal" >' +
                                '<td style="">' + value.PastelCode + '</td>' +
                                '<td style="font-size: 13px !important;">' + value.PastelDescription + '</td>' +
                                '<td style="font-size: 13px !important;">' + value.Price + '</td>' +
                                '<td style="font-size: 13px !important;">' + value.dateFrom + '</td>' +
                                '<td style="font-size: 13px !important;">' + value.dateTo + '</td>' +
                                '<td style="font-size: 13px !important;">' + value.Contract + '</td>' +
                                '</tr>';


                        });
                        $('#gridduplicatespecials').append(trHTML);

                    }



                }
            });



                $.ajax({
                    url: '{!!url("/postCurrentHistoryCustomerSpecialsKF")!!}',//getCurrentHistoryCustomerSpecialsKF
                    type: "POST",
                    data: {
                        customercode:$('#inputCustAcc').val(),
                        customerId: $('#customerId').val(),
                        contractid: $('#custheadid').val()
                    },
                    success: function (data) {

                        location.reload();
                    }
                });

            });
            $('#pricelist2convert').click(function(){
                $.ajax({
                    url: '{!!url("/convertCurrentContractPricelist")!!}',
                    type: "POST",
                    data: {
                        contractid: $('#custheadid').val(),
                        pricelistid: 2
                    },
                    success: function (data) {
                        var dialog = $('<p> <strong style="color:red">Contract Converted to Pricelist 2 Prices. This page will now reload. </strong></p>').dialog({
                            height: 200, width: 700,
                            buttons: {
                                "OK": function () {
                                    dialog.dialog('close');
                                    location.reload();
                                }
                            }
                        });
                    }
                });
            });
            $('#SaveNewSpecial').click(function(){
                var productsLinesOnPicking ="";
                var productsLinesOnPicking ="<xml>";

                $('#tblCreateNewSpecial > tbody  > tr').each(function() {


                    if (($(this).closest('tr').find('.theProductCode_').val()).length > 0 && ($(this).closest('tr').find('.prodDescription_').val()).length > 0 ) {
                        productsLinesOnPicking= productsLinesOnPicking + "<result>";
                    productsLinesOnPicking= productsLinesOnPicking + "<productCode>"+ $(this).closest('tr').find('.theProductCode_').val()+"</productCode>";
                    productsLinesOnPicking= productsLinesOnPicking + "<price>"+$(this).closest('tr').find('.prodPrice_').val()+"</price>";
                    productsLinesOnPicking= productsLinesOnPicking + "<dateFrom>"+dateReturn($('#dateFrom').val()) +"</dateFrom>";
                    productsLinesOnPicking= productsLinesOnPicking + "<dateTo>"+dateReturn( $('#dateTo').val())+"</dateTo>";
                    productsLinesOnPicking= productsLinesOnPicking + "<cost_>"+$(this).closest('tr').find('.cost_').val()+"</cost_>";
                    productsLinesOnPicking= productsLinesOnPicking + "<gp_>"+$(this).closest('tr').find('.gp_').val()+"</gp_>";
                    productsLinesOnPicking= productsLinesOnPicking + "<costCreated_>"+ $(this).closest('tr').find('.costCreated_').val()+"</costCreated_>";
                    productsLinesOnPicking= productsLinesOnPicking + "<contractid>"+$('#custheadid').val()+"</contractid>";
                    productsLinesOnPicking= productsLinesOnPicking+ "</result>";
                    }


                });
                var checkedLines = new Array();
            var allGridItems =  $("#gridContainer").dxDataGrid("getDataSource").store().load().done(function (data) {
                checkedLines= data;
     });
            console.log( checkedLines);

         /*   */
            console.log( "_________________________");
            //console.log( productsLinesOnPickingPrimary);

            $.each(checkedLines ,function(key,value) {
               if (value.Date == undefined || (value.Date).length < 5){
                    value.Date= $('#dateFrom').val();
                }
                if (value.DateTo == undefined || (value.DateTo).length < 5){
                    value.DateTo= $('#dateTo').val();
                }
                if((value.PastelCode).length > 1 && value.PriceLookedUp !="NaN"){
                    productsLinesOnPicking= productsLinesOnPicking + "<result>";
                    productsLinesOnPicking= productsLinesOnPicking + "<productCode>"+escapeHtml(value.PastelCode)+"</productCode>";
                    productsLinesOnPicking= productsLinesOnPicking + "<price>"+value.PriceLookedUp+"</price>";
                    productsLinesOnPicking= productsLinesOnPicking + "<dateFrom>"+value.Date+"</dateFrom>";
                    productsLinesOnPicking= productsLinesOnPicking + "<dateTo>"+value.DateTo+"</dateTo>";
                    productsLinesOnPicking= productsLinesOnPicking + "<cost_>"+value.Cost+"</cost_>";
                    productsLinesOnPicking= productsLinesOnPicking + "<gp_>"+(1-(value.Cost/value.PriceLookedUp))*100+"</gp_>";
                    productsLinesOnPicking= productsLinesOnPicking + "<customerid>"+escapeHtml($('#customerId').val())+"</customerid>";
                    productsLinesOnPicking= productsLinesOnPicking + "<contractid>"+escapeHtml($('#custheadid').val())+"</contractid>";
                    productsLinesOnPicking= productsLinesOnPicking+ "</result>";

                }
                console.debug("**********"+value.Date);


            });

            productsLinesOnPicking= productsLinesOnPicking+"</xml>";
                console.log(productsLinesOnPicking);
                $.ajax({
                    url: '{!!url("/XmlCreateCustomerSpecialsKF")!!}', // createCustomerSpecials
                    type: "POST",
                    data: {
                        customerCode: $('#inputCustAcc').val(),
                        customerId: $('#customerId').val(),
                        contractDateFrom: $('#dateFrom').val(),
                        contractDateTo: $('#dateTo').val(),
                        orderDetails: productsLinesOnPicking
                    },
                    success: function (data) {

                        if (data.result !="SUCCESS")
                        {
                            var dialog = $('<p>'+data.result+'</p>').dialog({
                                height: 200, width: 700, modal: true, containment: false,
                                buttons: {
                                    "OKAY": function () {
                                        dialog.dialog('close');
                                    }
                                }
                            });
                        }else{
                            $('#tblCreateNewSpecial tbody').empty();
                            LoadDataGrid();


                        }



                    }
                });

            });
            $('#pricelist1convert').click(function(){

                $.ajax({
                    url: '{!!url("/convertCurrentContractPricelist")!!}',
                    type: "POST",
                    data: {
                        contractid: $('#custheadid').val(),
                        pricelistid: 1
                    },
                    success: function (data) {
                        var dialog = $('<p> <strong style="color:red">Contract Converted to Pricelist 1 Prices. This page will now reload. </strong></p>').dialog({
                            height: 200, width: 700,
                            buttons: {
                                "OK": function () {
                                    dialog.dialog('close');
                                    location.reload();
                                }
                            }
                        });
                    }
                });
            });
            $('#getContractDetails').click(function(){
                if($("#custheadid").val() == "-99"){
                    alert("There are no details available for the new contract, please select contract.");
                }else{
                    LoadDataGrid();
                }

            });

            $('#doneCreating').click(function()
            {
                var dialog = $('<p> <strong style="color:red">Please ensure that you have pressed the save icon on your special data sheet. </strong></p>').dialog({
                    height: 200, width: 700,
                    buttons: {
                        "YES I DID": function () {
                            PressDone();
                            dialog.dialog('close');
                        },
                        "CANCEL": function () {
                            dialog.dialog('close');
                        }
                    }
                });


            });




        });
        function marginCalculator(cost,onCellVal)
        {
            return (1-(cost/onCellVal))*100;
        }

        function LoadDataGrid(){

            $('#SaveNewSpecial').show();
            $('#hidebeforesubmit').show();
            $('#addinCurrentPrices').show();
                $('#addinHistory').show();
                $('#afterFilter').show();
                $('#addnewline').show();
                $('#deleteall').show();
                $('#exportexcel').hide();
                $('#importexcel').hide();
              //  $('#doneCreating').hide();
                $('#savenewspecials').hide();
                var theVal = this.value;
                $.ajax({
                    url: '{!!url("/getCurrentContractCustomerSpecialsKF")!!}',
                    type: "POST",
                    data: {
                        contractid:$('#custheadid').val()
                    },
                    success: function (data) {
                        $.ajax({
                            url: '{!!url("/getCurrentPricesProductsCustomerSpecialsKF")!!}',
                            type: "POST",
                            data: {
                                customerID: $('#inputCustAcc').val(),
                                deliveryDate:today
                            },
                            success: function(data_products){
                                var added = false;
                        datagrids = $("#gridContainer").dxDataGrid({

                                    dataSource:new DevExpress.data.ArrayStore({
                                        data:data,
                                        key: 'ProductId',

                                    }), //as json
                                    keyboardNavigation: {
                                        enterKeyAction: 'moveFocus',
                                        enterKeyDirection: 'row',
                                        editOnKeyPress: true,
                                    },


                                    showBorders: true,
                                    filterRow: { visible: false },
                                    allowColumnResizing: true,
                                    paging:{
                                        pageSize: 500,
                                    },
                                    export: {
                                        enabled: true,

                                    },
                                    onEditorPreparing(e) {
                                        if (e.parentType === 'dataRow' && e.dataField === 'Position') {
                                            e.editorOptions.readOnly = isChief(e.value);
                                        }
                                    },
                                    onExporting(e) {
                                        var pricelistnamesheet = $('#pricelist option:selected').text();
                                        const workbook = new ExcelJS.Workbook();
                                        const worksheet = workbook.addWorksheet('specials');

                                        DevExpress.excelExporter.exportDataGrid({
                                            component: e.component,
                                            worksheet,
                                            autoFilterEnabled: true,
                                        }).then(() => {
                                            workbook.xlsx.writeBuffer().then((buffer) => {

                                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }),'specials.xlsx');
                                            });
                                        });
                                        e.cancel = true;
                                    },
                                    editing: {
                                        mode: "batch",
                                        refreshMode: "reshape",
                                        allowUpdating: true,
                                        allowAdding: true,
                                        allowDeleting: true,
                                        newRowPosition: 'last',
                                    },
                                    showRowLines: true,

                                    columns: [
                                        {
                                            dataField: "PastelCode",
                                            setCellValue: function(rowData, value) {
                                                console.debug("rowData");
                                                console.debug(rowData);
                                                rowData.PastelCode = value.PastelCode;
                                                rowData.PastelDescription = value.PastelDescription;
                                                rowData.PriceLookedUp = value.Price;

                                                var Odate = new Date($('#dateFrom').val());
                                                console.debug("***** "+Odate);
                                                console.debug("____"+$('#dateFrom').val());
                                                var newODateFrom = $.datepicker.formatDate('dd-mm-yy', new Date(Odate));
                                                var OdateTo = new Date($('#dateTo').val());
                                                var newODateTo = $.datepicker.formatDate('dd-mm-yy', new Date(OdateTo));
                                                rowData.Date= newODateFrom; //this seems to convert a date like 01-06-2022 dd-mm-yyyy into mm-dd-yyyy? why is it american
                                                rowData.Date = $.datepicker.formatDate('dd-mm-yy', new Date(rowData.Date));
                                                rowData.DateTo= newODateTo; //has to be a way to convert then copy
                                                rowData.DateTo=  $.datepicker.formatDate('dd-mm-yy', new Date(rowData.DateTo));
                                                rowData.Cost = value.Cost;
                                                rowData.PriceLookedUpCurrent = value.Price;
                                                rowData.avgQty = value.Qty;


                                            },
                                            caption: "Code",

                                            validationRules: [{ type: 'required' }],
                                            editCellTemplate: dropDownBoxEditorTemplate,
                                        },
                                        {
                                            dataField: "PastelDescription",
                                            caption: "Description",

                                            setCellValue: function(rowData, value) {
                                                rowData.PastelCode = value.PastelCode;
                                                rowData.PastelDescription = value.PastelDescription;
                                                rowData.PriceLookedUp = value.Price;
                                                var Odate = new Date($('#dateFrom').val());

                                                var newODateFrom = $.datepicker.formatDate('dd-mm-yy', new Date(Odate));
                                                console.debug("***** "+newODateFrom);

                                                var OdateTo = new Date($('#dateTo').val());
                                                var newODateTo = $.datepicker.formatDate('dd-mm-yy', new Date(OdateTo));
                                                console.debug("____newODateTo "+newODateTo);
                                                rowData.Date= newODateFrom; //this seems to convert a date like 01-06-2022 dd-mm-yyyy into mm-dd-yyyy? why is it american
                                                rowData.Date = $.datepicker.formatDate('dd-mm-yy', new Date(rowData.Date));
                                                rowData.DateTo= newODateTo; //has to be a way to convert then copy
                                                rowData.DateTo=  $.datepicker.formatDate('dd-mm-yy', new Date(rowData.DateTo));
                                                rowData.Cost = value.Cost;
                                                rowData.PriceLookedUpCurrent = value.Price;
                                                rowData.avgQty = value.Qty;

                                            },
                                            validationRules: [{ type: 'required' }],
                                            editCellTemplate: dropDownBoxEditorTemplateProdDescription,

                                        },{
                                            dataField: "Date",
                                            dataType: 'date',
                                            caption: "Date From",
                                            width: 120,
                                            format:"dd-MM-yyyy"

                                        },{
                                            dataField: "DateTo",
                                            dataType: 'date',
                                            caption: "Date To",
                                            width: 120,
                                            format:"dd-MM-yyyy"

                                        },{
                                            dataField: "PriceLookedUp",
                                            caption: "Price",
                                            width: 70,
                                            dataType: 'number',
                                            format: {
                                                type: "fixedPoint",
                                                precision: 2
                                            }

                                        },{
                                            allowEditing:false,
                                            dataField: "Cost",
                                            caption: "Cost",

                                            dataType: 'number',
                                            format: {
                                                type: "fixedPoint",
                                                precision: 2
                                            }

                                        },{
                                            allowEditing:false,
                                            allowSorting:true,
                                            allowFiltering:true,
                                            calculateCellValue: function(rowData) {
                                                return (1-(rowData.Cost/rowData.PriceLookedUp))*100;
                                            },
                                            caption: "GP",

                                            dataType: 'number',
                                            format: {
                                                type: "fixedPoint",
                                                precision: 2
                                            }

                                        }
                                        ,{
                                            allowEditing:false,
                                            dataField: "PriceLookedUpCurrent",
                                            caption: "Current Selling Price",

                                            dataType: 'number',
                                            format: {
                                                type: "fixedPoint",
                                                precision: 2
                                            }

                                        },
                                    ] ,


                                    onCellClick:function(e){
                                        // console.debug(e.row,cells[e.columnIndex]);
                                        console.log(e);

                                        if (e.columnIndex ==8){
                                            $("#gridContainer").dxDataGrid("cellValue",e.rowIndex,4,e.value);
                                        }
                                        if (e.columnIndex ==9){
                                            $("#gridContainer").dxDataGrid("cellValue",e.rowIndex,4,e.value);

                                        }
                                        if (e.columnIndex ==10){
                                            $("#gridContainer").dxDataGrid("cellValue",e.rowIndex,4,e.value);
                                        }
                                        if (e.columnIndex ==11){
                                            $("#gridContainer").dxDataGrid("cellValue",e.rowIndex,4,e.value);
                                        }
                                        if (e.columnIndex ==12){
                                            $("#gridContainer").dxDataGrid("cellValue",e.rowIndex,4,e.value);
                                        }
                                        if (e.columnIndex ==13){
                                            $("#gridContainer").dxDataGrid("cellValue",e.rowIndex,4,e.value);
                                        }
                                        if (e.columnIndex ==14){
                                            $("#gridContainer").dxDataGrid("cellValue",e.rowIndex,4,e.value);
                                        }
                                        if (e.columnIndex ==15){
                                            $("#gridContainer").dxDataGrid("cellValue",e.rowIndex,4,e.value);
                                        }
                                    },

                                    onEditorPreparing: function(e){
                                        if(e.parentType === "dataRow" && e.dataField === "PastelCode"){
                                            e.editorOptions.onValueChanged = function(ev){
                                                let selectedItem = ev.component.option('selectedItem');
                                                e.setValue(selectedItem);
                                            }
                                        }
                                        if(e.parentType === "dataRow" && e.dataField === "PastelDescription"){
                                            e.editorOptions.onValueChanged = function(ev){
                                                let selectedItem = ev.component.option('selectedItem');
                                                e.setValue(selectedItem);
                                            }
                                        }
                                    },

                                    onEditingStart: function(e) {
                                        console.debug("EditingStart");
                                        editRowKey = e.key;
                                    },
                                    onInitNewRow: function(e) {



                                    },
                                    onRowInserting: function(e) {
                                        console.debug("RowInserting");
                                    },
                                    onRowInserted: function(e) {
                                        console.debug("RowInserted");
                                    },
                                    onRowUpdating: function(e) {
                                    },
                                    onRowPrepared(e){
                                    },


                                    onRowUpdated: function(e) {

                                    },
                                    onRowRemoving: function(e) {
                                        console.debug("RowRemoving");
                                    },
                                    onRowRemoved: function(e) {
                                    },
                                    onContentReady: function(e) {
                                        if(!added){
                                            var s = e.component.getDataSource().store();
                                            for(i =10000;i < 1005; i++ ){
                                                s.insert({ID: i});
                                            }
                                            e.component.refresh();
                                            added = true;
                                        }
                                    },


                                });
                                function dropDownBoxEditorTemplate(cellElement, cellInfo) {
                                    return $('<div>').dxDropDownBox({
                                        dataSource:new DevExpress.data.ArrayStore({
                                            data:data_products,
                                            key: 'ProductId',

                                        }),
                                        displayExpr:'PastelCode',
                                        valueExpr:'PastelCode',
                                        dropDownOptions: { width: 500 },
                                        value: cellInfo.value,

                                        headerFilter: {
                                            visible: true,
                                        },
                                        contentTemplate(e) {
                                            return $('<div>').dxDataGrid({
                                                dataSource:new DevExpress.data.ArrayStore({
                                                    data:data_products,
                                                    key: 'PastelCode',

                                                }),
                                                remoteOperations: true,
                                                showBorders: true,
                                                paging: {
                                                    enabled: true,
                                                    pageSize: 15,
                                                },
                                                headerFilter: {
                                                    visible: true,
                                                },
                                                searchPanel: {
                                                    visible: true,
                                                },
                                                columns: [{caption:'PastelCode',dataField:'PastelCode',  headerFilter: {allowSearch: true,}}, 'PastelDescription', 'Qty'],
                                                hoverStateEnabled: true,
                                                scrolling: { mode: 'virtual' },
                                                height: 250,
                                                selection: { mode: 'single' },
                                                selectedRowKeys: [cellInfo.value],
                                                focusedRowEnabled: true,
                                                focusedRowKey: cellInfo.value,
                                                onSelectionChanged(selectionChangedArgs) {
                                                    console.debug(selectionChangedArgs);
                                                    e.component.option('value', selectionChangedArgs.selectedRowsData[0]);
                                                    cellInfo.setValue(selectionChangedArgs.selectedRowsData[0]);
                                                    console.debug(selectionChangedArgs.selectedRowsData);
                                                    if (selectionChangedArgs.selectedRowsData.length > 0) {
                                                        e.component.close();
                                                    }
                                                },
                                            });
                                        },
                                    });
                                }
                                function dropDownBoxEditorTemplateProdDescription(cellElement, cellInfo) {
                                    return $('<div>').dxDropDownBox({
                                        dataSource: data_products,
                                        displayExpr:'PastelDescription',
                                        valueExpr:'PastelDescription',
                                        dropDownOptions: { width: 500 },
                                        value: cellInfo.value,

                                        headerFilter: {
                                            visible: true,
                                        },
                                        contentTemplate(e) {
                                            return $('<div>').dxDataGrid({
                                                dataSource:new DevExpress.data.ArrayStore({
                                                    data:data_products,
                                                    key: 'PastelCode',

                                                }),
                                                remoteOperations: true,
                                                showBorders: true,
                                                paging: {
                                                    enabled: true,
                                                    pageSize: 15,
                                                },
                                                headerFilter: {
                                                    visible: true,
                                                },
                                                searchPanel: {
                                                    visible: true,
                                                },
                                                columns: ['PastelDescription', 'PastelCode', 'Qty'],
                                                hoverStateEnabled: true,
                                                scrolling: { mode: 'virtual' },
                                                height: 250,
                                                selection: { mode: 'single' },
                                                selectedRowKeys: [cellInfo.value],
                                                focusedRowEnabled: true,
                                                focusedRowKey: cellInfo.value,
                                                onSelectionChanged(selectionChangedArgs) {
                                                    console.debug(selectionChangedArgs);
                                                    e.component.option('value', selectionChangedArgs.selectedRowsData[0]);
                                                    cellInfo.setValue(selectionChangedArgs.selectedRowsData[0]);
                                                    console.debug(selectionChangedArgs.selectedRowsData);
                                                    if (selectionChangedArgs.selectedRowsData.length > 0) {
                                                        e.component.close();
                                                    }
                                                },
                                            });
                                        },
                                    });
                                }
                            }
                        })

                    }
                });


        }
        function createbrannewspecials(){
            var productsLinesOnPicking = new Array();
            $('#tblCreateNewSpecial > tbody  > tr').each(function() {
                // var data = $(this);
                // var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();

                if (($(this).closest('tr').find('.theProductCode_').val()).length > 0 && ($(this).closest('tr').find('.prodDescription_').val()).length > 0 ) {
                    productsLinesOnPicking.push({
                        'productCode': $(this).closest('tr').find('.theProductCode_').val(),
                        'price': $(this).closest('tr').find('.prodPrice_').val(),
                        'dateFrom':  dateReturn($(this).closest('tr').find('.dateFrom').val()) ,
                        'dateTo': dateReturn( $(this).closest('tr').find('.dateTo').val()),
                        'cost_': $(this).closest('tr').find('.cost_').val(),
                        'gp_': $(this).closest('tr').find('.gp_').val(),
                        'costCreated_': $(this).closest('tr').find('.costCreated_').val(),
                        'customerid': $('#customerId').val(),
                    });
                }
            });
            $.ajax({
                url: '{!!url("/XmlCreateCustomerSpecials")!!}', // createCustomerSpecials
                type: "POST",
                data: {
                    customerCode: $('#inputCustAcc').val(),
                    customerId: $('#customerId').val(),
                    contractDateFrom: $('#dateFrom').val(),
                    contractDateTo: $('#dateTo').val(),
                    contractId: $('#custheadid').val(),
                    orderDetails: productsLinesOnPicking
                },
                success: function (data) {

                    if (data.result !="SUCCESS")
                    {
                        var dialog = $('<p>'+data.result+'</p>').dialog({
                            height: 200, width: 700, modal: true, containment: false,
                            buttons: {
                                "OKAY": function () {
                                    dialog.dialog('close');
                                }
                            }
                        });
                    }else{
                        var dialog = $('<p>Special Create</p>').dialog({
                            height: 200, width: 700, modal: true, containment: false,
                            buttons: {
                                "OKAY": function () {
                                    location.reload(true);
                                    dialog.dialog('close');
                                }
                            }
                        });

                    }



                }
            });

        }
        function PressDone()
        {

            $("#gridContainer").dxDataGrid("saveEditData");
            var checkedLines = new Array();
            var allGridItems =  $("#gridContainer").dxDataGrid("getDataSource").store().load().done(function (data) {
                checkedLines= data;
     });
            console.log( checkedLines);

            var productsLinesOnPicking ="<xml>";
         /*   */
            console.log( "_________________________");
            //console.log( productsLinesOnPickingPrimary);

            $.each(checkedLines ,function(key,value) {
               if (value.Date == undefined || (value.Date).length < 5){
                    value.Date= $('#dateFrom').val();
                }
                if (value.DateTo == undefined || (value.DateTo).length < 5){
                    value.DateTo= $('#dateTo').val();
                }
                if((value.PastelCode).length > 1 && value.PriceLookedUp !="NaN"){
                    productsLinesOnPicking= productsLinesOnPicking + "<result>";
                    productsLinesOnPicking= productsLinesOnPicking + "<productCode>"+escapeHtml(value.PastelCode)+"</productCode>";
                    productsLinesOnPicking= productsLinesOnPicking + "<price>"+value.PriceLookedUp+"</price>";
                    productsLinesOnPicking= productsLinesOnPicking + "<dateFrom>"+value.Date+"</dateFrom>";
                    productsLinesOnPicking= productsLinesOnPicking + "<dateTo>"+value.DateTo+"</dateTo>";
                    productsLinesOnPicking= productsLinesOnPicking + "<cost_>"+value.Cost+"</cost_>";
                    productsLinesOnPicking= productsLinesOnPicking + "<gp_>"+(1-(value.Cost/value.PriceLookedUp))*100+"</gp_>";
                    productsLinesOnPicking= productsLinesOnPicking + "<customerid>"+escapeHtml($('#customerId').val())+"</customerid>";
                    productsLinesOnPicking= productsLinesOnPicking + "<contractid>"+escapeHtml($('#custheadid').val())+"</contractid>";
                    productsLinesOnPicking= productsLinesOnPicking+ "</result>";

                }
                console.debug("**********"+value.Date);


            });
            productsLinesOnPicking= productsLinesOnPicking+"</xml>";
            $.ajax({
                url: '{!!url("/XmlCreateCustomerSpecialsKFValid")!!}', // createCustomerSpecials
                type: "POST",
                data: {
                    customerCode: $('#inputCustAcc').val(),
                    customerId: $('#customerId').val(),
                    contractDateFrom: $('#dateFrom').val(),
                    contractDateTo: $('#dateTo').val(),
                    contractid: $('#custheadid').val(),
                    orderDetails: productsLinesOnPicking
                },
                success: function (data) {
                    var duplicateresult = data.result;
                    if (data.result.length ==0) // so if there is nothing  do the following
                    {
                        $.ajax({
                            url: '{!!url("/XmlCreateCustomerSpecialsKF")!!}', // createCustomerSpecials
                            type: "POST",
                            data: {
                                customerCode: $('#inputCustAcc').val(),
                                customerId: $('#customerId').val(),
                                contractDateFrom: $('#dateFrom').val(),
                                contractDateTo: $('#dateTo').val(),
                                contractid: $('#custheadid').val(),
                                orderDetails: productsLinesOnPicking
                            },success: function (data) {
                                var dialog = $('<p>Special Created!</p>').dialog({
                                    height: 200, width: 700, modal: true, containment: false,
                                    buttons: {
                                        "OKAY": function () {
                                            location.reload(true);
                                            dialog.dialog('close');
                                        }
                                    }
                                });
                            }
                        });
                    }else{// so if there is nothing  do the following

                        var trHTML = "";

                        $('#gridduplicatespecials').empty();
                        $('#duplicatespecials').show(); //table
                        var dialog = $("#duplicatespecials").dialog({
                            height: 800, modal: true, closeOnEscape: true,
                            width: 800, buttons: {
                                "NO": function () {
                                    dialog.dialog('close');
                                },
                                "YES": function () {

                                    $.ajax({
                                        url: '{!!url("/XmlCreateCustomerSpecialsKF")!!}', // createCustomerSpecials
                                        type: "POST",
                                        data: {
                                            customerCode: $('#inputCustAcc').val(),
                                            customerId: $('#customerId').val(),
                                            contractDateFrom: $('#dateFrom').val(),
                                            contractDateTo: $('#dateTo').val(),
                                            contractid: $('#custheadid').val(),
                                            orderDetails: productsLinesOnPicking
                                        },success: function (data) {
                                            var dialog = $('<p>Special Updated and Saved!</p>').dialog({
                                                height: 200, width: 700, modal: true, containment: false,
                                                buttons: {
                                                    "OKAY": function () {
                                                        location.reload();
                                                        //dialog.dialog('close');
                                                    }
                                                }
                                            });
                                        }
                                    });

                                }
                            },containment: false,
                        }).dialogExtend({
                            "closable": true, // enable/disable close button
                            "maximizable": false, // enable/disable maximize button
                            "minimizable": true, // enable/disable minimize button
                            "collapsable": true, // enable/disable collapse button
                            "dblclick": "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
                            "titlebar": false, // false, 'none', 'transparent'
                            "minimizeLocation": "right", // sets alignment of minimized dialogues
                            "icons": { // jQuery UI icon class
                                "close": "ui-icon-circle-close",
                                "maximize": "ui-icon-circle-plus",
                                "minimize": "ui-icon-circle-minus",
                                "collapse": "ui-icon-triangle-1-s",
                                "restore": "ui-icon-bullet"
                            },
                            "load": function (evt, dlg) {
                            }, // event
                            "beforeCollapse": function (evt, dlg) {
                            }, // event
                            "beforeMaximize": function (evt, dlg) {
                            }, // event
                            "beforeMinimize": function (evt, dlg) {
                            }, // event
                            "beforeRestore": function (evt, dlg) {
                            }, // event
                            "collapse": function (evt, dlg) {
                            }, // event
                            "maximize": function (evt, dlg) {
                            }, // event
                            "minimize": function (evt, dlg) {
                            }, // event
                            "restore": function (evt, dlg) {
                            } // event
                        });
                        $.each(duplicateresult, function (key, value) {
                            //p.PastelCode,p.PastelDescription,cs.SpecialHeaderId as [Contract] ,ts.dateFrom, ts.dateTo, CustomerPastelCode, p.PastelCode, p.PastelDescription AS Pdesc, cs.Price
                            trHTML += '<tr style="font-size: 13px !important;color: black;background: lightgrey;font-weight: normal" >' +
                                '<td style="">' + value.PastelCode + '</td>' +
                                '<td style="font-size: 13px !important;">' + value.PastelDescription + '</td>' +
                                '<td style="font-size: 13px !important;">' + value.Price + '</td>' +
                                '<td style="font-size: 13px !important;">' + value.dateFrom + '</td>' +
                                '<td style="font-size: 13px !important;">' + value.dateTo + '</td>' +
                                '<td style="font-size: 13px !important;">' + value.Contract + '</td>' +
                                '</tr>';


                        });
                        $('#gridduplicatespecials').append(trHTML);

                    }



                }
            });



        }
        function generateALine2()
        {
            var contractFrom = $('#dateFrom').val();
            var contractTo = $('#dateTo').val();
            var tokenId=Math.floor(Math.pow(10, 9-1) + Math.random() * 9 * Math.pow(10, 9-1));
            var $row = $('<tr id="new_row_ajax'+tokenId+'" class="fast_remove" style="font-weight: 600;font-size: 11px;">' +
                '<td contenteditable="false" class="col-sm-1"><input name="theProductCode" id ="prodCode_'+tokenId+'" class="theProductCode_ set_autocomplete inputs"></td>' +
                '<td contenteditable="false" class="col-md-3"><input name="prodDescription_" id ="prodDescription_'+tokenId+'" class="prodDescription_ set_autocomplete inputs" tabindex="-1"></td>' +
                '<td  contenteditable="false" class="col-md-2"><input type="text" name="dateFrom" id ="dateFrom'+tokenId+'" value= "'+contractFrom+'"  title="in stock" class="dateFrom resize-input-inside inputs"></td>' +
                '<td contenteditable="false" class="col-md-2"><input type="text" name="dateTo"  id ="dateTo'+tokenId+'" value= "'+contractTo+'" class="dateTo resize-input-inside"></td>' +
                '<td contenteditable="false"  class="col-md-1"><input type="text" name="prodPrice_" id ="prodPrice_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>' +
                '<td contenteditable="false"  class="col-md-1"><input type="text" name="cost_" id ="cost_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="cost_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>' +
                '<td contenteditable="false"  class="col-md-1"><input type="text" name="gp_" id ="gp_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="gp_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>' +
                '<td contenteditable="false"  class="col-md-1"><input type="text" name="costCreated_" id ="costCreated_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="costCreated_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
                '<td contenteditable="false"  class="col-md-1"><input type="text" name="prodPriceB_" id ="prodPriceB_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="prodPriceB_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
                '<td><button type="button" id="cancelThis" class="btn-danger btn-xs cancel" style="height: 16px;padding: 0px 5px;font-size: 9px;">Cancel</button></td></tr>');
            $('#tblCreateNewSpecial tbody')
                .append( $row )
                .trigger('addRows', [ $row, false ]);
            if(!$('.lst').is(":focus"))
            {
                $('#prodCode_' + tokenId).focus();

                if ($('#checkboxDescription').is(':checked')) {
                    $('#prodDescription_' + tokenId).focus();
                }
            }


            $('input').on('click keyup' ,function(){
                // $('input').click(function(){
                var ID = $(this).attr('id');
                var jID = '#'+ID;
                var x = ID.indexOf("_");
                var get_token_number = ID.substring(x+1,ID.length);

                if ($(this).hasClass("prodDescription_") && $(this).hasClass("set_autocomplete")) {
                    var columnsD = [{name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'},
                        {name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'}
                        ,{name: 'Available', minWidth:'20px',valueField: 'Available'}];
                    $(""+jID+"").mcautocomplete({
                        source:finalDataProductDescription,
                        columns:columnsD,
                        autoFocus: true,
                        minlength: 2,
                        delay: 0,
                        multiple: true,
                        multipleSeparator: ",",
                        select:function (e, ui) {
                            var n = ID.indexOf("_");
                            var token_number = ID.substring(n + 1, ID.length);

                            if(ui.item.PastelCode == "MISC2" || ui.item.PastelDescription == "MISC - NOTE" || ui.item.PastelDescription =="MISC" || ui.item.PastelCode =="misc")
                            {
                                $('#prodQty_'+token_number).val('0');
                                $('#prodPrice_'+token_number).val('0');
                            }
                            $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                            $('#prodCode_' + token_number).val(ui.item.PastelCode);

                            $('#taxCode' + token_number).val(ui.item.Tax);
                            $('#cost_' + token_number).val(ui.item.Cost);

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            productPrice(token_number);


                        }
                    });

                }

                if ($(this).hasClass("theProductCode_") && $(this).hasClass("set_autocomplete")) {
                    var columnsC = [{name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'},
                        {name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'}
                        ,
                        {name: 'Available', minWidth:'20px',valueField: 'Available'}];
                    $("" + jID + "").mcautocomplete({
                        source: finalDataProduct,
                        /*  source: function(req, response) {
                              var re = $.ui.autocomplete.escapeRegex(req.term);
                              var matcher = new RegExp("^" + re, "i");
                              response($.grep(finalDataProduct, function(item) {
                                  return matcher.test(item.value);
                              }));
                          },*/
                        columns:columnsC,
                        minlength: 1,
                        autoFocus: true,
                        delay: 0,
                        select:function (e, ui) {

                            var n = ID.indexOf("_");
                            var token_number = ID.substring(n + 1, ID.length);
                            if(ui.item.PastelCode == "MISC2" || ui.item.PastelDescription == "MISC - NOTE" || ui.item.PastelDescription =="MISC" || ui.item.PastelCode =="misc")
                            {
                                $('#prodQty_'+token_number).val('0');
                                $('#prodPrice_'+token_number).val('0');
                            }
                            $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                            $('#prodCode_' + token_number).val(ui.item.PastelCode);
                            //checkIfOrderHasMultipleProducts(ui.item.extra,token_number);
                            //$('#inStock_' + token_number).val(ui.item.QtyInStock);
                            $('#taxCode' + token_number).val(ui.item.Tax);
                            $('#cost_' + token_number).val(ui.item.Cost);
                            // $('#prodQty_' + token_number).attr('title', 'In Stock ' + parseFloat(ui.item.QtyInStock).toFixed(3));

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            productPrice(token_number);

                        }

                    });
                }
                //calculator();
            });
            $(".dateTo,.dateFrom").datepicker({
                changeMonth: true,//this option for allowing user to select month
                changeYear: true, //this option for allowing user to select from year range
                dateFormat: 'dd-mm-yy'
            });

            $('#tblCreateNewSpecial').on('click', 'button', function (e) {
                var $this = $(this);
                $this.closest('tr').remove();



            });

        }
        function roundquick(val)
        {
            return parseFloat(val).toFixed(2);
        }
        function productPrice(token_number)
        {
            $.ajax({
                url: '{!!url("/getCutomerPriceOnOrderForm")!!}',
                type: "POST",
                data: {
                    customerID: $('#inputCustAcc').val(),
                    deliveryDate:today,
                    productCode: $('#prodCode_' + token_number).val(),
                    warehouseid:1
                },
                success: function (data) {
                    $('#prodPrice_' + token_number).val(parseFloat(data[0].Price).toFixed(2));
                    $('#prodPriceB_' + token_number).val(parseFloat(data[0].Price).toFixed(2));
                    $('#less10perc_' + token_number).val(parseFloat(data[0].Price*0.9).toFixed(2));
                    $('#gp_'+token_number).val(roundquick(marginCalculator(data[0].Cost,data[0].Price)));
                }
            });
        }
        function avgQty(token_number)
        {
            $.ajax({
                url: '{!!url("/getCustomerAvgQty")!!}',
                type: "POST",
                data: {
                    customerID: $('#customerId').val(),
                    deliveryDate:today,
                    productCode: $('#prodCode_' + token_number).val(),
                    warehouseid:1
                },
                success: function (data) {
                    $('#avgQty_' + token_number).val(data[0].Qty);
                }
            });
        }
        function productPriceForHistories(token_number)
        {
            $.ajax({
                url: '{!!url("/getCutomerPriceOnOrderForm")!!}',
                type: "POST",
                data: {
                    customerID: $('#inputCustAcc').val(),
                    deliveryDate:today,
                    productCode: $('#prodCode_' + token_number).val(),
                    warehouseid:1
                },
                success: function (data) {
                    $('#prodPrice_' + token_number).val(parseFloat(data[0].Price).toFixed(2));
                    $('#prodPriceB_' + token_number).val(parseFloat(data[0].Price).toFixed(2));
                    $('#less10perc_' + token_number).val(parseFloat(data[0].Price*0.9).toFixed(2));
                }
            });
        }
        $(document).on('keydown', '#tblCreateNewSpecial', function(e) {
            var $table = $(this);

            var $active = $('input:focus,select:focus,li:focus',$table);
            var $next = null;
            var focusableQuery = 'input:visible,select:visible,textarea:visible,li:visible';
            var position = parseInt( $active.closest('td').index()) + 1;
            var $celltheProductCode_ = $active.closest('td').find(".theProductCode_").val();

            switch(e.keyCode){
                case 37: // <Left>
                    $next = $active.parent('td').prev().find(focusableQuery);
                    break;
                case 33: // <Up>
                    c
                    if ($celltheProductCode_.length < 1) {
                        $next = $active
                            .closest('tr')
                            .prev()
                            .find('td:nth-child(' + position + ')')
                            .find(focusableQuery)
                        ;
                    }

                    break;
                case 38: // <Up>
                    if ($celltheProductCode_.length < 1) {
                        $next = $active
                            .closest('tr')
                            .prev()
                            .find('td:nth-child(' + position + ')')
                            .find(focusableQuery)
                        ;
                    }
                    break;
                case 34: // <Right>
                    $next = $active.closest('td').next().find(focusableQuery);
                    break;
                case 40: // <Down>
                    if ($celltheProductCode_.length < 1) {
                        $next = $active
                            .closest('tr')
                            .next()
                            .find('td:nth-child(' + position + ')')
                            .find(focusableQuery)
                        ;
                    }
                    console.debug('$celltheProductCode_******** DOWN'+$celltheProductCode_);
                    break;

            }
            if($next && $next.length)
            {
                $next.focus();
            }
        });
        $(document).on('keydown', '.inputs', function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            var testLst = $(this).closest('tr');
            if ((code == 13 || code == 39)) {
                var index = $('.inputs').index(this) + 1;
                $('.inputs').eq(index).focus();
            }
            if (code == 37) {
                var index = $('.inputs').index(this) - 1;
                $('.inputs').eq(index).focus();
            }
            var closesttr =  $(this).closest('tr');
            var prodClosest = closesttr.find(".theProductCode_").val();
            var prodDescClosest = closesttr.find(".prodDescription_").val();
            var prodPriceClosest = closesttr.find(".prodPrice_").val();
            if ( (code == 34 || code == 13 || code == 39 ) && $.trim(prodClosest.length) > 0 && prodDescClosest.length > 0 &&  prodPriceClosest.length > 0) {
                generateALine2();

            }
        });
        $(document).on('keyup', '.lst', function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13 || code == 9) {
                var index = $('.inputs').index(this);

                $('.lst').eq(index).focus();
                generateALine2();

            }
        });
        $(document).on('keyup', '.prodPrice_', function(e) {
            /*  var key = (e.keyCode ? e.keyCode : e.which);
             var $isAuth = $(this).closest("tr").find(".title").attr("id");
             var $priceToken = $(this).closest("tr").find(".prodPrice_").attr("id");*/

            var costing = $(this).closest("tr").find(".cost_").val();
            var prodPriceVal =  $(this).closest("tr").find(".prodPrice_").val();
            $(this).closest("tr").find(".gp_").val( parseFloat( marginCalculator(costing,prodPriceVal)).toFixed(2));


        });
        function escapeHtml(unsafe) {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
        function dateReturn(dates)
        {
            //27-02-2019
            var datearray = dates.split("-");
            if (datearray[0].length > 2){
                var newdateDelivDate = dates;
            }
            else {
                var newdateDelivDate = datearray[2] + '-' + datearray[1] + '-' + datearray[0];
            }


            return newdateDelivDate
        }
        function isFloatNumber(item,evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode==46)
            {
                var regex = new RegExp(/\./g)
                var count = $(item).val().match(regex).length;
                if (count > 1)
                {
                    return false;
                }
            }
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
        function showDialogWithoutClose(tag,width,height)
        {
            $( tag ).dialog({height: height, modal: true,
                width: width,containment: false}).dialogExtend({
                "closable" : false, // enable/disable close button
                "maximizable" : false, // enable/disable maximize button
                "minimizable" : true, // enable/disable minimize button
                "collapsable" : true, // enable/disable collapse button
                "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
                "titlebar" : false, // false, 'none', 'transparent'
                "minimizeLocation" : "right", // sets alignment of minimized dialogues
                "icons" : { // jQuery UI icon class
                    "close" : "ui-icon-circle-close",
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
            $('#authorisations').keydown(function(event) {
                if (event.keyCode == 27) {
                    return false;
                }
            });


        }
        function escapeHtml(unsafe) {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }


    </script>
