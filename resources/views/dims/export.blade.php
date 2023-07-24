@extends('layouts.app')

@section('content')
    <div class="col-lg-12"   style="height:100%;">
        <div class="col-lg-4">
            <form>
                <fieldset class="well">
                    <legend class="well-legend">Filters</legend>
                    <div class="form-group ">
                        <label class="control-label" for="delvDate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
                        <input type="text" class="form-control input-sm " id="delvDate" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">

                    </div>
                    <div class="form-group ">
                        <label class="control-label" for="orderType"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order Type</label>
                        <select id="orderType" name="orderType" class="form-control input-sm "style="font-size: 12px;font-family: sans-serif;font-weight: 900;">
                            <option value="9999999">Choose OrderType</option>
                            @foreach($orderTypes as $value)
                                <option value="{{$value->OrderTypeId}}">{{$value->OrderType}}</option>
                                @endforeach
                        </select>

                    </div>
                    <div class="form-group ">
                        <label class="control-label" for="route"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
                        <select id="route" name="route" class="form-control input-sm "style="font-size: 12px;font-family: sans-serif;font-weight: 900;">
                            <option value="9999999">Choose Route</option>
                            @foreach($route as $value)
                                <option value="{{$value->Routeid}}">{{$value->Route}}</option>
                            @endforeach
                        </select>
                      </div>
                    <div class="form-group ">
                       <select id="exportTo" name="exportTo" class="form-control input-sm "style="font-size: 12px;font-family: sans-serif;font-weight: 900;">
                            <option value="9999999">Choose User</option>
                            @foreach($exportUser as $value)
                                <option value="{{$value->Num}}">{{$value->UserName}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" id="exportInvoice" class="btn-xs btn-primary">Export Invoices</button>
                </fieldset>
            </form>
        </div>
        <div class="col-lg-8">
            <h5>UnExported Invoices</h5>
            <table id="unexptable" class="table2 table-bordered  dataTable" style="overflow-y: scroll; width: 100%;font-family: sans-serif;height:62% !important;">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Route</th>
                    <th>OrderType</th>
                    <th>Order date</th>
                    <th>Delivery date</th>
                    <th>Order ID</th>
                    <th>Invoice Number</th>
                    <th>User</th>
                </tr>
                </thead>
                <tbody>
                @foreach($unexp as $value)
                <tr>
                    <td>{{$value->CustomerPastelCode}}</td>
                    <td>{{$value->StoreName}}</td>
                    <td>{{$value->Route}}</td>
                    <td>{{$value->OrderType}}</td>
                    <td>{{$value->OrderDate}}</td>
                    <td>{{$value->DeliveryDate}}</td>
                    <td>{{$value->OrderId}}</td>
                    <td>{{$value->InvoiceNo}}</td>
                    <td>{{$value->UserName}}</td>
                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div id="popUpStockReport" title="Stock Report Before Exports">
        <div class="col-lg-12">
            <div class="col-lg-6"><button class="btn-danger btn-md pull-left" id="closeStockReportBack">DO NOT EXPORT</button></div>
            <div class="col-lg-6"><button class="btn-success btn-md pull-right" id="closeStockReportContinue">CONTINUE EXPORTING</button></div>

        </div>
        <div class="col-lg-12">
        <table id="stockReport" class="table2 table-bordered  dataTable" style="overflow-y: scroll; width: 100%;font-family: sans-serif;height:62% !important;">
            <thead>
            <tr>
                <th>Code</th>
                <th>Description</th>
                <th>Sum Of Qty To Export</th>
                <th>Quantity In Stock</th>

            </tr>
            </thead>
            <tbody>
            @foreach($stockReport as $value)
                <tr>
                    <td>{{$value->PastelCode}}</td>
                    <td>{{$value->PastelDescription}}</td>
                    <td>{{$value->sumQty}}</td>
                    <td>{{$value->QtyInStock}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#unexptable').DataTable();
        $('#stockReport').DataTable();

        $('#orderListing').hide();
        $('#pricing').hide();
        $('#pricingOnCustomer').hide();
        $('#callList').hide();
        $('#tabletLoadingApp').hide();
        $('#copyOrdersBtn').hide();
        $('#salesOnOrder').hide();
        $('#salesInvoiced').hide();
        $('#posCashUp').hide();
        $('#afterFilter').hide();
        $('#popUpStockReport').hide();

        $("#delvDate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $('#exportInvoice').click(function(){
            showDialogWithoutClose('#popUpStockReport',700,700);
        });
        $('#closeStockReportContinue').click(function(){
            //INSERT INTO THE TABLE
            $.ajax({
                url: '{!!url("/insertIntoExportTable")!!}',
                type: "POST",
                data:{
                    deliveryDate:$('#delvDate').val(),
                    orderType:$('#orderType').val(),
                    route:$('#route').val(),
                    exportTo:$('#exportTo').val()
                },
                success: function(data){

                }
            });

        });
    });
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
    }

</script>