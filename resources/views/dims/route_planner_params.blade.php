<x-app-layout>

    <x-slot name="header">
        {{ __('Route Planner') }}
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
            Route Planner </li>
        <!--end::Item-->
    </x-slot>

    <?php
    if ((Auth::guest())){

    }else{
        $v  =  new \App\Http\Controllers\SalesForm();
        $routeplanner = $v->getThings(Auth::user()->GroupId,'Route Planner Particulars');
        $logistic = $v->getThings(Auth::user()->GroupId,'Logistic Planner');
    }
    ?>

    <div class="row mt-3" id="routePlanningPopUp">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="deliveryDatesonPlanning">From</label>
                            <input type="text" name="deliveryDatesonPlanning" class="form-control" id="deliveryDatesonPlanning" value="{{$selectedDelivDate}}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="orderTypesTabletLoadingonPlanning">Delivery Type</label>
                            <select name="orderTypesTabletLoadingonPlanning" class="form-control form-select" id="orderTypesTabletLoadingonPlanning">
                                @foreach($orderTypeSelected  as $values)
                                    <option value="{{$values->OrderTypeId}}">
                                        {{$values->OrderType}}
                                    </option>
                                @endforeach
                                <option value="-99">All</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="statusRoutePlanner">
                                Status @if (Auth::guest()) [<i style="color:red;">LOGGED OUT</i>] @endif
                            </label>
                            <select id="statusRoutePlanner" class="form-control form-select">
                                <option value="3">All</option>
                                <option value="0">Not Invoiced</option>
                                <option value="1">Invoiced</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="deliveryDatesonPlanning2" >To</label>
                            <input type="text" name="deliveryDatesonPlanning2" class="form-control" id="deliveryDatesonPlanning2" value="{{$selectedDelivDate}}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="rouTabletLoadingtesonPlanning" >Route</label>
                            <select name="multicheckbox[]" class="form-control form-select" id="rouTabletLoadingtesonPlanning" multiple="multiple">
                                @foreach($routes as $values)
                                    <option value="{{$values->Routeid}}">
                                        {{$values->Route}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="form-label">Mass</label>
                            <input type="number" class="form-control" id="massroute" value="0"/>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="form-label">Order Val</label>
                            <input type="number" class="form-control" id="orderval" value="0"/>
                        </div>
                    </div>
                    <div class="row">
                        <div id="gridContainer" class="col-md-12">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="card">
                <div class="card-body">
                    <h1 id="totalorders" class="align-middle w-100 my-3">STOPS: 0</h1>

                    <button type="button" id="getOrders" class="btn btn-success btn-auto-height w-100">
                        GET ORDERS
                    </button>

                    @if($routeplanner !="0")
                        <hr>
                        <button id="moveSelectedOrders" class="btn btn-primary btn-auto-height w-100 mb-2">
                            MOVE ORDERS
                        </button>
                        <button id="setSequence" class="btn btn-primary btn-auto-height w-100 mb-2">
                            SET SEQUENCE
                        </button>
                        <button id="printPriview" class="btn btn-primary btn-auto-height w-100 mb-2">
                            PREVIEW
                        </button>
                        <button id="notifypickers" class="btn btn-primary btn-auto-height w-100 mb-2">
                            NOTIFY PICKERS
                        </button>
                        @if(viewCheckCompanyPermission('isallowrouteoptomo'))
                            <button id="suggestions" class="btn btn-primary btn-auto-height w-100">
                                ROUTE OPTOM
                            </button>
                        @endif

                        <hr>
                        <button id="reprinting" class="btn btn-primary btn-auto-height w-100 mb-2">
                            REPRINT ROUTES
                        </button>
                        <button id="invoicesnotprinting" class="btn btn-danger btn-auto-height w-100">
                            Not Printing
                        </button>

                        <hr>
                        <button id="logisticsPlan" class="btn btn-primary btn-auto-height w-100">
                            Logistics Plan
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="popupmoveThis" title="Order Change">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h5>Please move an order by chosing below</h5>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="truckNameSheetMaster">Route</label>
                            <select name="eRouteName" class="form-control form-select" id="eRouteName">
                                @foreach($routes as $value)
                                    <option value="{{$value->Routeid}}">
                                        {{$value->Route}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="deliveryTypeRun">Delivery Type(Run)</label>
                            <select name="deliveryTypeRun" class="form-control form-select" id="deliveryTypeRun">
                                @foreach($orderTypes as $value)
                                    <option value="{{$value->OrderTypeId}}">
                                        {{$value->OrderType}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="delDateChange">From</label>
                            <input name="delDateChange" class="form-control" id="delDateChange">
                        </div>
                        <div class="col-md-12 mb-3">
                            <button id="submitChanges" class="btn btn-success btn-sm">submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div style="display:none;">
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="dateCreateForControlSheetSheetMaster"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date Created</label>
            <input id="dateCreateForControlSheetSheetMaster" class="form-control input-sm col-xs-1" name="dateCreateForControlSheetSheetMaster" style="height:21px;font-size: 8px;" >
        </div>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="dateCreateForControlSheetSheetMaster"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
            <input id="delvDateForControlSheetSheetMaster" class="form-control input-sm col-xs-1" name="dateCreateForControlSheetSheetMaster" style="height:21px;font-size: 8px;" >
        </div>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="routeSheetMaster"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
            <select id="routeSheetMaster" class="form-control input-sm col-xs-1" name="routeSheetMaster" style="height:21px;font-size: 8px;" ></select>
        </div>
        <button id="doneWithTruckSheetMasterData" class="btn-success btn-md center-block">Submit</button>
    </div>

    <style>
        .modal{
            z-index: 9999 !important;
        }
        .dx-datagrid {
            max-height: calc(80vh - 63px)  !important;
        }
        .dx-datagrid-filter-row {
            height: 50px;
        }
        .dx-datagrid, .dx-datagrid-headers, .dx-datagrid-rowsview, .dx-datagrid-rowsview table {
            font-size: 11px; /* Change the font size to the desired size */
        }
    </style>

    <script>
        //backgroudcolorOffloadedHighNotification is GREEN therefore NOTIFICATION IS THREE
        //lockedbackgroudcolor is LAVENDER therefore it is ON CREDIT HOLD
        //backgroudcolor is RED therefore   it is A BACKORDER
        var jArrayOrderTypes = JSON.stringify({!! json_encode($orderTypes) !!});
        var jArraydelivDates = JSON.stringify({!! json_encode($delivDates) !!});
        var jArraydelivroutes = JSON.stringify({!! json_encode($routes) !!});
        var jArraydDrivers = JSON.stringify({!! json_encode($drivers) !!});
        var jArraydtrucks = JSON.stringify({!! json_encode($trucks) !!});

        var computerName = '<?php echo gethostname() ?>';
        var loggedIn = '{{ auth()->check() ? 'true' : 'false' }}';

        $(document).ready(function() {
            //$('#routePlanningPopUp').hide();
            $('#orderListing').hide();
            $('#pricing').hide();
            $('#callList').hide();
            $('#copyOrdersBtn').hide();
            $('#tabletLoadingApp').hide();
            $('#salesQuotebtn').hide();
            $('#afterFiltering').hide();
            $('#updateSorting').hide();
            $('#popUpForNewTruckControlSheetHeader').hide();
            $('#messageNB').hide();
            $('#straightForwardPrintThtTruckControlId').hide();
            $('#instantPrint').hide();
            $('#trucSheetViewPopUp').hide();
            $('#popupmoveThis').hide();
            $('#pricingOnCustomer').hide();
            $('#salesOnOrder').hide();
            $('#posCashUp').hide();
            $('#salesInvoiced').hide();
            $('#confirmMove').hide();
            $("#creditOnHold").hide();

            var toAppendOrderTypes = '';
            $.each(JSON.parse(jArrayOrderTypes),function(i,o){
                toAppendOrderTypes += '<option value="'+o.OrderTypeId+'">'+o.OrderType+'</option>';
            });
            $('#orderTypesTabletLoadingonPlanning').append(toAppendOrderTypes);

            var Odate = new Date();
            var newODate = $.datepicker.formatDate('dd-mm-yy', new Date(Odate));

            $('#lplan').click(function(){
                window.open('{!!url("/logisticsPlan")!!}/'+newODate, 'SAMPLEV', "location=1,status=1,scrollbars=1, width=1500,height=850");
            });

            $('#reprinting').click(function(){

                window.open('{!!url("/reprinting")!!}', 'Re-Print Route', "location=1,status=1,scrollbars=1, width=1500,height=850");
            });

            var toAppendRecentTruckIdFilter = '<option value=""></option>';

            $('#recentTruckIDOnPrintButton').append(toAppendRecentTruckIdFilter);
            $('#rouTabletLoadingtesonPlanning').multiselect({
                columns: 1,
                placeholder: 'Select Route(s)',
                selectAll: true
            });
            $(".ms-options-wrap button").addClass('form-control');

            $('#suggestions').click(function(){
                var orderType =$('#orderTypesTabletLoadingonPlanning').val();
                var routeId =$('#rouTabletLoadingtesonPlanning').val();
                if(orderType !='-99' && routeId !='-99'){
                    window.open('{!!url("/routePlannerSuggestions")!!}/'+$('#deliveryDatesonPlanning').val()+'/'+$('#orderTypesTabletLoadingonPlanning').val()+'/'+$('#rouTabletLoadingtesonPlanning').val()+'/'+$('#statusRoutePlanner').val());
                }
            });

            $('#getOrders').click(function(){
                getMultiRoutSelected();
            });

            $('#notifypickers').click(function(){

                $.ajax({
                    url: '{!!url("/notifypickers")!!}',
                    type: "POST",
                    data: {
                        routeId: $('#rouTabletLoadingtesonPlanning').val(),
                        deliveryDate: $('#deliveryDatesonPlanning').val(),
                        OrderType: $('#orderTypesTabletLoadingonPlanning').val(),
                        dateTo: $('#deliveryDatesonPlanning2').val()

                    },
                    success: function (data) {

                        var dialog = $('<p><strong style="color:black"> <i>You Have Nofitied the Pickers to Pick </i>'+data+'</strong></p>').dialog({
                            height: 200, width: 900, modal: true, containment: false,
                            buttons: {
                                "Okay": function () {
                                    dialog.dialog('close');
                                },

                            }
                        });
                    }
                });

            });

            $('#tabletLoadingGoonProducts').click(function(){
                if (($('#deliveryDatesonPlanning').val()).length > 6)
                {
                    window.open('{!!url("/listallProductsRoutePlanner")!!}/'+$('#deliveryDatesonPlanning').val()+'/'+$('#orderTypesTabletLoadingonPlanning').val()+'/'+$('#rouTabletLoadingtesonPlanning').val(), "products", "width=760, height=500, scrollbars=yes")

                }
                else {
                    alert("Please select Date")
                }

            });

            $("#deliveryDatesonPlanning,#deliveryDatesonPlanning2,#delDateChange").datepicker({
                changeMonth: true,//this option for allowing user to select month
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });

            // This function sequences the order
            $('#setSequence').click(function(){
                // This function sets the sequence of the Route!
                var allGridItems =  $("#gridContainer").dxDataGrid("getDataSource").items();
                var sortedOrderIds = new Array();

                var seq = 0;

                allGridItems.forEach((element, index, value) => {
                    sortedOrderIds.push({
                        'index':seq,
                        'orderId':element["OrderId"]
                    });
                    seq += 1;
                });

                // console.debug(sortedOrderIds);

                $.ajax({
                    url: '{!!url("/sequencingTheStops")!!}',
                    type: "POST",
                    data: {ordersToStop:sortedOrderIds},

                    success: function (data) {
                        alert(data.count+' Stops being Sequenced');
                        location.reload();
                    }
                });
            });

            // This Does a print preview of the route sequence
            $('#printPriview').click(function(){
                window.open( '{!!url("/routePlannerPrintPreview")!!}/'+$('#deliveryDatesonPlanning').val()+'/'+$('#deliveryDatesonPlanning2').val()+'/'+$('#orderTypesTabletLoadingonPlanning').val()+'/'+$('#rouTabletLoadingtesonPlanning').val()+'/'+$('#statusRoutePlanner').val(), "PREVIEW", "location=1,status=1,scrollbars=1, width=1200,height=850");
            });

            $('#invoicesnotprinting').click(function(){
                window.open( '{!!url("/invoicesnotprinting")!!}', "Invoices Not printed", "location=1,status=1,scrollbars=1, width=1200,height=850");
            });
            $('#logisticsPlan').click(function(){
                var Odate = new Date();
                var newODate = $.datepicker.formatDate('dd-mm-yy', new Date(Odate));
                window.open( '{!!url("/logisticsPlan")!!}/'+newODate, '_blank');
            });

            //The main big function !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            $('#moveSelectedOrders').on('click',function(){
                var valuesProd = new Array();
                // Get a reference to the dxDataGrid control
                var dataGridInstance = $('#gridContainer').dxDataGrid('instance');

                // Get the collection of selected rows
                var selectedRows = dataGridInstance.getSelectedRowsData();

                // Loop through the collection of selected rows
                $.each(selectedRows, function(index, row) {
                    // console.log(row);
                    valuesProd.push({'orderId':row.OrderId})
                });

                showDialog('#popupmoveThis', '60%', 350);
                $('#submitChanges').click(function(){
                    $.ajax({
                        url: '{!!url("/moveTheOrderArray")!!}',
                        type: "POST",
                        data: {
                            orderTypeId:$('#deliveryTypeRun').val(),
                            routeId:$('#eRouteName').val(),
                            orderId:valuesProd,
                            delivDate:$('#delDateChange').val()
                        },
                        success: function (data) {
                            console.log(data);
                            // showDialog('#confirmMove','60%',220);
                            alert("These Lines Have been Moved")
                            window.location = '{!!url("/routePlannerExtParam")!!}/'+$('#deliveryDatesonPlanning').val()+'/'+$('#orderTypesTabletLoadingonPlanning').val()+'/1085/'+$('#statusRoutePlanner').val();
                        }
                    });
                });

            });
            //The main big function !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

        });

        function showDialog(tag,width,height){
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

        function getMultiRoutSelected(){
            var massTotal = 0;
            var orderval = 0;
            // Perform actions after the data grid has finished loading
            $('#massroute').val(0);
            $('#orderval').val(0);
            getMassAndRVal();
            $.ajax({
                url: '{!!url("/getRouteDataMultiSelected")!!}',
                type: "POST",
                data: {
                    routeId: $('#rouTabletLoadingtesonPlanning').val(),
                    deliveryDate: $('#deliveryDatesonPlanning').val(),
                    OrderType: $('#orderTypesTabletLoadingonPlanning').val(),
                    dateTo: $('#deliveryDatesonPlanning2').val(),
                    status: $('#statusRoutePlanner').val()
                },
                success: function (data) {
                    // console.log(data);
                    $("#gridContainer").dxDataGrid({
                        dataSource:data, //as json
                        hoverStateEnabled: true,
                        showBorders: true,
                        allowColumnResizing: true,
                        columnAutoWidth: true,
                        filterRow: { visible: true },
                        // filterPanel: { visible: true },
                        headerFilter: { visible: true },
                        scrolling: {
                            rowRenderingMode: 'infinite',
                        },
                        paging: true,
                        loadPanel: {
                            enabled: true,
                            shadingColor: "rgba(0,0,0,0.4)",
                            shading: true,
                            showIndicator: true,
                            text: "Loading..."
                        },
                        timeout: 60000,
                        paging:{
                            pageSize: Number.MAX_SAFE_INTEGER,
                        },
                        pager: {
                            visible: true,
                            allowedPageSizes: [5, 10, 20, 50, 'all'],
                            showPageSizeSelector: true,
                            showInfo: true,
                            showNavigationButtons: true,
                        },
                        editing: {
                            mode: 'batch',
                            // allowUpdating: true,
                            // allowDeleting: true,
                        },
                        selection: {
                            mode: 'multiple',
                        },
                        rowDragging: {
                            allowReordering: true,
                            showDragIcons: false,
                            onReorder(e) {
                                const visibleRows = e.component.getVisibleRows();
                                const toIndex = data.findIndex((item) => item.OrderId === visibleRows[e.toIndex].data.OrderId);
                                const fromIndex = data.findIndex((item) => item.OrderId === e.itemData.OrderId);

                                data.splice(fromIndex, 1);
                                data.splice(toIndex, 0, e.itemData);

                                e.component.refresh();
                            },
                        },
                        export: {
                            enabled: true
                        },
                        onExporting(e) {
                            const workbook = new ExcelJS.Workbook();
                            const worksheet = workbook.addWorksheet('routeplanner');

                            DevExpress.excelExporter.exportDataGrid({
                                component: e.component,
                                worksheet,
                                autoFilterEnabled: true,
                                customizeCell(options) {
                                    const { gridCell } = options;
                                    const { excelCell } = options;
                                /* if (options.gridCell.data.Backorder === 1) {
                                        options.backgroundColor = "red"; // Set the fill color here
                                    }
                                    if (options.gridCell.data.Locked === 1) {
                                        options.backgroundColor = "#9b9bdc"; // Set the fill color here
                                    }
                                    if (options.gridCell.data.intNotification === 3) {
                                        options.backgroundColor = "rgba(4, 255, 31, 0.54)"; // Set the fill color here
                                    }*/

                                    if (gridCell.rowType === 'data') {

                                        if (gridCell.data.Locked == "1") {
                                            console.debug(gridCell.data.Locked);
                                            options.backgroundColor = "#9b9bdc"; // Set the fill color here
                                            if (gridCell.column.dataField === 'StoreName') {
                                                excelCell.fill = {   fgColor: { argb: '9b9bdc' } };
                                            }
                                        }
                                        /*if (gridCell.column.dataField === 'Phone') {
                                            excelCell.value = parseInt(gridCell.value, 10);
                                            excelCell.numFmt = '[<=9999999]###-####;(###) ###-####';
                                        }
                                        if (gridCell.column.dataField === 'Website') {
                                            excelCell.value = { text: gridCell.value, hyperlink: gridCell.value };
                                            excelCell.font = { color: { argb: 'FF0000FF' }, underline: true };
                                            excelCell.alignment = { horizontal: 'left' };
                                        }*/
                                    }

                                },
                            }).then(() => {
                                workbook.xlsx.writeBuffer().then((buffer) => {
                                    saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'routeplanner.xlsx');
                                });
                            });
                            e.cancel = true;
                        },

                        columns: [
                            {
                                dataField: "OrderDate",
                                caption: "Order Date",
                            },{
                                dataField: "DeliveryDate",
                                caption: "Delivery date",
                            },{
                                dataField: "Route",
                                caption: "Route",
                            },{
                                dataField: "StoreName",
                                caption: "Customer",
                                cellTemplate: function(container, options) {
                                        container.css('background-color', '#f8ff18'); // Set background color to green
                                        container.text(options.data.StoreName);
                                }
                            },{
                                dataField: "InvoiceNo",
                                caption: "Invoice No",
                            },{
                                dataField: "OrderId",
                                caption: "Order ID",
                            },{
                                dataField: "OrderType",
                                caption: "Del Type",
                            },{
                                dataField: "DeliverySequence",
                                caption: "Seq",
                            },{
                                dataField: "Mass",
                                caption: "Mass",
                            },{
                                dataField: "OrderValue",
                                caption: "Order Val",
                                customizeText: function(cellInfo) {
                                    return Number(cellInfo.value).toFixed(2);
                                }
                            },{
                                dataField: "deliveryAddress1",
                                caption: "Address",
                            },{
                                dataField: "optionalField",
                                caption: "Notes",
                            },{
                                dataField: "tTime",
                                caption: "On Hold",
                            }
                        ],
                        onRowUpdating: function(e){
                        },
                        onRowRemoving: function(e) {
                        },
                        onRowPrepared(e) {

                            if (e.rowType == 'data' && e.data.intNotification ==3) {
                                e.rowElement.css('background',  'rgba(4, 255, 31, 0.54)');
                            }
                            if (e.rowType == 'data' && e.data.Locked ==1) {
                                e.rowElement.css('background', '#9b9bdc');
                            }
                            if (e.rowType == 'data' && e.data.Backorder ==1) {
                                e.rowElement.css('background', 'red');
                            }
                            if (e.rowType == 'data'){
                                massTotal = parseFloat(massTotal) + parseFloat(e.data.Mass);
                                orderval = parseFloat(orderval) + parseFloat(e.data.OrderValue);

                            }




                        },
                        onSelectionChanged: function(e) {
                            var selectedRows = e.selectedRowsData;
                            $('#totalorders').text("STOPS: "+selectedRows.length);
                        },
                        onRowDblClick: function (e) {
                            console.debug("Order Id");
                            console.debug(e);
                            var orderId =  e.data.OrderId;
                            window.open('{!!url("/productontheminiorderform")!!}/'+orderId, "OrderId", "width=760, height=500, scrollbars=yes")

                        },
                        onContentReady: function(e) {
                            // Perform actions after the data grid has finished loading
                        }
                    });
                }
            });
        }

        function Selectallcheckbox(element,orderid){

            //url = sendCommunicationForCreditControl
            /*if(element == "1")
            {
                $("#creditOnHold").show();
                showDialog("#creditOnHold", 400 ,400);

                $("#reportOnHold").click(function(){

                        $.ajax({
                            url:  ,
                            type: "GET",
                            data:{
                                orderID:orderid
                            },
                            success: function(data){

                            }
                        });

                });


            }*/

        }

        function printDoc(url,docType,docID,isDeliveryNote,invoiceNumber){
            $.ajax({
                url: url ,
                type: "POST",
                data:{DocType:docType,DocId:docID,PrintDeliveryNote:isDeliveryNote,invoiceNumber:invoiceNumber},
                success: function(data){

                }
            });
        }

        function truckControlSheetHeaderOnFiltering(truckControlId){
            $.ajax({
                url: '{!!url("/getTruckControlSheetHeaderByTruckId")!!}',
                type: "POST",
                data: {
                    truckControlID: truckControlId
                },
                success: function (data) {
                    $('#truckName').prepend('<option value="'+data[0].TruckId+'" selected="selected">'+data[0].TruckName+'</option>');
                    $('#driver').prepend('<option value="'+data[0].DriverId+'" selected="selected">'+data[0].DriverName+'</option>');
                    $('#assistant').prepend('<option value="'+data[0].assistantId+'" selected="selected">'+data[0].Assistant+'</option>');
                    $('#dateCreateForControlSheet').val(data[0].DateCreated);
                    $('#delvDateForControlSheet').val(data[0].DeliveryDate);
                }
            });
        }

        function truckControlSheetDetails(truckControlId){
            $.ajax({
                url: '{!!url("/truckControlSheetDetails")!!}',
                type: "GET",
                data: {
                    truckControlID: truckControlId
                },
                success: function (data) {
                    var trHTML = '';
                    // $('.onDrag').remove();
                    $.each(data, function (key, value) {
                        trHTML += '<tr role="row" class="onDrag2"  style="font-size: 9px;color:black;height: 26px;"><td>' +
                            value.DeliveryDate + '</td><td>' +
                            value.Route + '</td><td>' +
                            value.StoreName + '</td><td>' +
                            value.InvoiceNo + '</td><td>' +
                            value.OrderId + '</td><td  style="font-weight:900">' +
                            value.OrderValue + '</td><td>' +
                            value.DeliverySequence + '</td><td>' +
                            '</tr>';
                    });
                    $('#sequenced').append(trHTML);
                }
            });
        }
        function getMassAndRVal(){
            $.ajax({
                url: '{!!url("/getRouteMassOnPlanner")!!}',
                type: "GET",
                data: {
                    dateFrom: $('#deliveryDatesonPlanning').val(),
                    dateTo:  $('#deliveryDatesonPlanning2').val()
                },
                success: function (data) {
                    var trHTML = '';
                    // $('.onDrag').remove();
                    console.debug("___________mass");

                    $.each(data, function (key, value) {
                        console.debug( value.Mass);
                        $('#massroute').val(value.Mass);
                        $('#orderval').val(value.randVal);

                    });

                }
            });
        }

        /**
         * Log data into tblManagementConsole
         * @param url
         * @param ConsoleTypeId
         * @param Importance
         * @param Message
         * @param Reviewed
         * @param OrderId
         * @param productid
         * @param CustomerId
         * @param OldQty
         * @param NewQty
         * @param OldPrice
         * @param NewPrice
         * @param ReferenceNo
         * @param DocType
         *  @param machine
         * @param DocNumber
         * @param ReturnId
         */
        function consoleManagement(url,ConsoleTypeId,Importance,Message,Reviewed,OrderId,productid,CustomerId,OldQty,NewQty,OldPrice,NewPrice,ReferenceNo,DocType,machine,DocNumber,ReturnId){
            $.ajax({
                url:url,
                type: "POST",
                data:{ConsoleTypeId:ConsoleTypeId,
                    Importance:Importance,
                    Message:Message,
                    Reviewed:Reviewed,
                    OrderId:OrderId,
                    productid:productid,
                    CustomerId:CustomerId,
                    OldQty:OldQty,
                    NewQty:NewQty,
                    ReviewedUserId:0,
                    OldPrice:OldPrice,
                    NewPrice:NewPrice,
                    ReferenceNo:ReferenceNo,
                    DocType:DocType,
                    DocNumber:DocNumber,
                    machine:machine,
                    ReturnId:ReturnId,

                },
                success: function(data){
                    //dd(data);
                    //Try to use web sql
                }});

        }

        function consoleManagementAuths(url,ConsoleTypeId,Importance,Message,Reviewed,OrderId,productid,CustomerId,OldQty,NewQty,OldPrice,NewPrice,ReferenceNo,DocType,machine,DocNumber,ReturnId,userId,userName){
            $.ajax({
                url:url,
                type: "POST",
                data:{ConsoleTypeId:ConsoleTypeId,
                    Importance:Importance,
                    Message:Message,
                    Reviewed:Reviewed,
                    OrderId:OrderId,
                    productid:productid,
                    CustomerId:CustomerId,
                    OldQty:OldQty,
                    NewQty:NewQty,
                    ReviewedUserId:0,
                    OldPrice:OldPrice,
                    NewPrice:NewPrice,
                    ReferenceNo:ReferenceNo,
                    DocType:DocType,
                    DocNumber:DocNumber,
                    machine:machine,
                    ReturnId:ReturnId,
                    userId:userId,
                    userName:userName,

                },
                success: function(data){
                    // dd(data);
                    //Try to use web sql
                }});

        }

    </script>

</x-app-layout>
