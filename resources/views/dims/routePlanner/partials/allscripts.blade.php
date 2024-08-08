<script>
    var orderTypes = {!! json_encode($orderTypes) !!};
    var routes = {!! json_encode($routes) !!};

    orderTypes.unshift({
        OrderTypeId: "-99",
        OrderType: "All"
    });

    var statuses = [{
        id: "3",
        value: "All",
    }, {
        id: "1",
        value: "Not Invoiced",
    }, {
        id: "2",
        value: "Invoiced",
    }, ];

    let orderMass = 0;
    let orderVal = 0;

    $(document).ready(function() {
        // inputs to get data
        const selectDateRange = $("#selectDateRange").dxDateRangeBox({
            displayFormat: 'yyyy-MM-dd',
            showClearButton: true,
        }).dxDateRangeBox("instance");

        const selectStatus = $("#selectStatus").dxSelectBox({
            dataSource: statuses,
            searchEnabled: true,
            value: '3',
            valueExpr: 'id',
            displayExpr: 'value',
        }).dxSelectBox("instance");

        const selectOrderType = $("#selectOrderType").dxSelectBox({
            dataSource: orderTypes,
            value: '-99',
            searchEnabled: true,
            valueExpr: 'OrderTypeId',
            displayExpr: 'OrderType',
        }).dxSelectBox("instance");

        const selectRoute = $("#selectRoute").dxTagBox({
            dataSource: routes,
            applyValueMode: 'useButtons',
            showSelectionControls: true,
            showClearButton: true,
            searchEnabled: true,
            multiline: false,
            valueExpr: 'Routeid',
            displayExpr: 'Route',
        }).dxTagBox("instance");

        const inputMass = $('#inputMass').dxNumberBox({
            // readOnly: true,
        }).dxNumberBox("instance");

        const inputOrderVal = $('#inputOrderVal').dxNumberBox({
            // readOnly: true,
        }).dxNumberBox("instance");


        // grid to load routes
        const gridRoutePlanner = $("#gridRoutePlanner").dxDataGrid({
            dataSource: [], //as json
            hoverStateEnabled: true,
            showBorders: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            height: '70vh',
            filterRow: {
                visible: true
            },
            headerFilter: {
                visible: true
            },
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
            paging: {
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
                    var data = gridRoutePlanner.option('dataSource');
                    const toIndex = data.findIndex((item) => item.OrderId === visibleRows[e
                        .toIndex].data.OrderId);
                    const fromIndex = data.findIndex((item) => item.OrderId === e.itemData
                        .OrderId);

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
                        const {
                            gridCell
                        } = options;
                        const {
                            excelCell
                        } = options;

                        if (gridCell.rowType === 'data') {

                            if (gridCell.data.Locked == "1") {
                                console.debug(gridCell.data.Locked);
                                options.backgroundColor =
                                    "#9b9bdc"; // Set the fill color here
                                if (gridCell.column.dataField === 'StoreName') {
                                    excelCell.fill = {
                                        fgColor: {
                                            argb: '9b9bdc'
                                        }
                                    };
                                }
                            }
                        }

                    },
                }).then(() => {
                    workbook.xlsx.writeBuffer().then((buffer) => {
                        saveAs(new Blob([buffer], {
                            type: 'application/octet-stream'
                        }), 'routeplanner.xlsx');
                    });
                });
                e.cancel = true;
            },

            columns: [{
                dataField: "OrderDate",
                caption: "Order Date",
            }, {
                dataField: "DeliveryDate",
                caption: "Delivery date",
            }, {
                dataField: "Route",
                caption: "Route",
            }, {
                dataField: "StoreName",
                caption: "Customer",
                cellTemplate: function(container, options) {
                    container.css('background-color',
                        '#f8ff18'); // Set background color to green
                    container.text(options.data.StoreName);
                }
            }, {
                dataField: "InvoiceNo",
                caption: "Invoice No",
            }, {
                dataField: "OrderId",
                caption: "Order ID",
            }, {
                dataField: "OrderType",
                caption: "Del Type",
            }, {
                dataField: "DeliverySequence",
                caption: "Seq",
            }, {
                dataField: "Mass",
                caption: "Mass",
            }, {
                dataField: "OrderValue",
                caption: "Order Val",
                customizeText: function(cellInfo) {
                    return Number(cellInfo.value).toFixed(2);
                }
            }, {
                dataField: "deliveryAddress1",
                caption: "Address",
            }, {
                dataField: "optionalField",
                caption: "Notes",
            }, {
                dataField: "tTime",
                caption: "On Hold",
            }],
            onRowPrepared(e) {
                if (e.data) {
                    if (e.data.strRowColor != null) {
                        e.rowElement.css("background-color", e.data.strRowColor);
                    }
                }
                if (e.rowType == 'data') {
                    orderMass = parseFloat(orderMass) + parseFloat(e.data.Mass);
                    orderVal = parseFloat(orderVal) + parseFloat(e.data.OrderValue);
                }
            },
            onSelectionChanged: function(e) {
                var selectedRows = e.selectedRowsData;
                var data = gridRoutePlanner.option('dataSource');
                var totalStops = data.length;

                if (selectedRows.length > 0) {
                    btnMoveOrders.option('disabled', false);
                    $('#inputStops').text("STOPS: " + selectedRows.length);
                } else {
                    btnMoveOrders.option('disabled', true);
                    $('#inputStops').text("STOPS: " + totalStops);
                }
            },
            onRowDblClick: function(e) {
                var orderId = e.data.OrderId;
                window.open('{!! url('/productontheminiorderform') !!}/' + orderId, "OrderId",
                    "width=760, height=500, scrollbars=yes")

            },
        }).dxDataGrid("instance");


        // Side buttons start here
        const btnGetStops = $('#btnGetStops').dxButton({
            stylingMode: 'contained',
            height: '50px',
            text: 'Get Stops',
            type: 'success',
            width: '100%',
            onClick() {
                getStops();
            },
        }).dxButton("instance");

        const btnMoveOrders = $('#btnMoveOrders').dxButton({
            stylingMode: 'contained',
            disabled: true,
            height: '50px',
            text: 'Move Orders',
            type: 'default',
            width: '100%',
            onClick() {
                popupMoveOrders.show();
            },
        }).dxButton("instance");

        const btnSetSequence = $('#btnSetSequence').dxButton({
            stylingMode: 'contained',
            disabled: true,
            height: '50px',
            text: 'Set Sequence',
            type: 'default',
            width: '100%',
            onClick() {
                setSequence();
            },
        }).dxButton("instance");

        const btnPreview = $('#btnPreview').dxButton({
            stylingMode: 'contained',
            height: '50px',
            text: 'Preview',
            type: 'default',
            width: '100%',
            onClick() {
                var allRoutes = selectRoute.option('value');
                if (allRoutes.length > 1) {
                    DevExpress.ui.notify({
                        message: 'Please Select one Route to View the Preview',
                        type: 'error', // 'info', 'success', 'warning'
                        displayTime: 5000,
                    });
                } else {
                    var dateRange = selectDateRange.option('value')
                    window.open('{!! url('/routePlannerPrintPreview') !!}/' +
                        formatDate(dateRange[0]) + '/' +
                        formatDate(dateRange[1]) + '/' +
                        selectOrderType.option('value') + '/' +
                        selectRoute.option('value') + '/' +
                        selectStatus.option('value'),
                        "PREVIEW", "location=1,status=1,scrollbars=1, width=1200,height=850"
                    );
                }

            },
        }).dxButton("instance");

        const btnNotifyPickers = $('#btnNotifyPickers').dxButton({
            stylingMode: 'contained',
            height: '50px',
            visible: false,
            text: 'Notify Pickers',
            type: 'default',
            width: '100%',
            onClick() {
                var allRoutes = selectRoute.option('value');
                if (allRoutes.length > 1) {
                    DevExpress.ui.notify({
                        message: 'Please Select one Route to Notify The pickers',
                        type: 'error', // 'info', 'success', 'warning'
                        displayTime: 5000,
                    });
                } else {
                    var dateRange = selectDateRange.option('value');

                    // $.ajax({
                    //     url: '{!! url('/notifypickers') !!}',
                    //     type: "POST",
                    //     data: {
                    //         routeId: selectRoute.option('value'),
                    //         deliveryDate: formatDate(dateRange[0]),
                    //         OrderType: selectOrderType.option('value'),
                    //         dateTo: formatDate(dateRange[1]),
                    //     },
                    //     success: function(data) {
                    //         DevExpress.ui.notify({
                    //             message: 'Pickers Have been notified',
                    //             type: 'success', // 'info', 'success', 'warning'
                    //             displayTime: 3500,
                    //         });
                    //     }
                    // });
                }
            },
        }).dxButton("instance");

        const btnRouteOptimization = $('#btnRouteOptimization').dxButton({
            stylingMode: 'contained',
            height: '50px',
            text: 'Route Optimization',
            type: 'default',
            width: '100%',
            onClick() {
                window.open('{!! url('/routeOptimization') !!}', '_blank');
            },
        }).dxButton("instance");

        const btnReprintRoutes = $('#btnReprintRoutes').dxButton({
            stylingMode: 'contained',
            visible: false,
            height: '50px',
            text: 'Reprint Routes',
            type: 'default',
            width: '100%',
            onClick() {
                window.open('{!! url('/reprinting') !!}', 'Re-Print Route',
                    "location=1,status=1,scrollbars=1, width=1500,height=850");
            },
        }).dxButton("instance");

        const btnInvoicesNotPrinting = $('#btnInvoicesNotPrinting').dxButton({
            stylingMode: 'contained',
            height: '50px',
            text: 'Invoices Not Printing',
            type: 'danger',
            width: '100%',
            onClick() {
                window.open('{!! url('/invoicesnotprinting') !!}', "Invoices Not printed",
                    "location=1,status=1,scrollbars=1, width=1200,height=850");
            },
        }).dxButton("instance");

        const btnLogisticsPlan = $('#btnLogisticsPlan').dxButton({
            stylingMode: 'contained',
            height: '50px',
            text: 'Logistics Plan',
            type: 'default',
            width: '100%',
            onClick() {
                var todaysDate = new Date();
                window.open('{!! url('/logisticsPlan') !!}/' + formatDate(todaysDate), '_blank');
            },
        }).dxButton("instance");

        const btnInvoice = $('#btnInvoice').dxButton({
            stylingMode: 'contained',
            visible: false,
            height: '50px',
            text: 'Invoice',
            type: 'success',
            width: '100%',
            onClick() {
                var dateRange = selectDateRange.option('value');
                var selectedRoutes = selectRoute.option('value');

                window.open('{!! url('/selectInvoicesToPrint') !!}/' +
                    formatDate(dateRange[0]) + '/' + formatDate(dateRange[1]) + '/' +
                    selectOrderType.option('value') + '/' + selectedRoutes.join(
                        ',') + '/' + selectStatus.option('value'),
                    "location=1,status=1,scrollbars=1, width=1500,height=850");
            },
        }).dxButton("instance");

        const btnAssignTruck = $('#btnAssignTruck').dxButton({
            stylingMode: 'contained',
            visible: false,
            height: '50px',
            text: 'Assign Truck',
            type: 'default',
            width: '100%',
            onClick() {
                console.log('1');
            },
        }).dxButton("instance");
        // Side buttons end here


        // Move Orders Popup UI starts here
        const selectMoveDeliveryDate = $("#selectMoveDeliveryDate").dxDateBox({
            displayFormat: 'yyyy-MM-dd',
            showClearButton: true,
            onValueChanged: function(e) {}
        }).dxDateBox("instance");

        const selectMoveOrderType = $("#selectMoveOrderType").dxSelectBox({
            dataSource: orderTypes,
            searchEnabled: true,
            valueExpr: 'OrderTypeId',
            displayExpr: 'OrderType',
            onValueChanged: function(e) {},
        }).dxSelectBox("instance");

        const selectMoveRoute = $("#selectMoveRoute").dxSelectBox({
            dataSource: routes,
            searchEnabled: true,
            valueExpr: 'Routeid',
            displayExpr: 'Route',
            onValueChanged: function(e) {},
        }).dxSelectBox("instance");

        const popupMoveOrders = $("#popupMoveOrders").dxPopup({
            showTitle: true,
            title: 'Move Order',
            onHidden: function(e) {},
            hideOnOutsideClick: false,
            showCloseButton: true,
            width: 600,
            height: 'auto',
            toolbarItems: [{
                widget: 'dxButton',
                toolbar: 'bottom',
                location: 'after',
                options: {
                    type: 'default',
                    stylingMode: 'contained',
                    icon: "fa fa-plus-circle",
                    text: "Submit Move",
                    onClick: function(args) {
                        moveOrders();
                    },
                },
            }, ],
        }).dxPopup("instance");
        // Move Orders Popup UI ends here

        function getStops() {
            getMassAndRVal();

            var dateRange = selectDateRange.option('value')
            btnSetSequence.option('disabled', false);

            $.ajax({
                url: '{!! url('/getRoutePlannerStops') !!}',
                type: "POST",
                data: {
                    routeId: selectRoute.option('value'),
                    deliveryDate: formatDate(dateRange[0]),
                    OrderType: selectOrderType.option('value'),
                    dateTo: formatDate(dateRange[1]),
                    status: selectStatus.option('value'),
                },
                success: function(data) {
                    gridRoutePlanner.option('dataSource', data);
                    gridRoutePlanner.refresh();

                    var totalStops = data.length;

                    $("#inputStops").text('STOPS: ' + totalStops);
                },
            });
        }

        function getMassAndRVal() {
            var dateRange = selectDateRange.option('value')

            $.ajax({
                url: '{!! url('/getRouteMassAndValueOnPlanner') !!}',
                type: "GET",
                data: {
                    dateFrom: formatDate(dateRange[0]),
                    dateTo: formatDate(dateRange[1]),
                },
                success: function(data) {
                    $.each(data, function(key, value) {
                        inputMass.option('value', value.Mass);
                        inputOrderVal.option('value', value.randVal);
                    });
                }
            });
        }

        function moveOrders() {
            var orderIdsToMove = [];

            var selectedRows = gridRoutePlanner.getSelectedRowsData();

            $.each(selectedRows, function(index, row) {
                orderIdsToMove.push({
                    'orderId': row.OrderId
                })
            });

            $.ajax({
                url: '{!! url('/moveOrder') !!}',
                type: "POST",
                data: {
                    delivDate: formatDate(selectMoveDeliveryDate.option('value')),
                    orderTypeId: selectMoveOrderType.option('value'),
                    routeId: selectMoveRoute.option('value'),
                    orderId: orderIdsToMove,
                },
                success: function(data) {
                    getStops();
                    popupMoveOrders.hide();
                    DevExpress.ui.notify({
                        message: 'Sucessfully Moved Orders',
                        type: 'success', // 'info', 'success', 'warning'
                        displayTime: 3500,
                    });
                }
            });
        }

        function setSequence() {
            // This function sets the sequence of the Route!
            var gridData = gridRoutePlanner.option('dataSource');
            var sortedSequence = [];

            var seq = 0;

            gridData.forEach((element, index, value) => {
                sortedSequence.push({
                    'index': seq,
                    'orderId': element["OrderId"]
                });
                seq += 1;
            });

            $.ajax({
                url: '{!! url('/sequenceStops') !!}',
                type: "POST",
                data: {
                    ordersToStop: sortedSequence
                },

                success: function(data) {
                    DevExpress.ui.notify({
                        message: 'Sucessfully Sequenced ' + data.count + ' Stops',
                        type: 'success', // 'info', 'success', 'warning'
                        displayTime: 3500,
                    });
                    getStops();
                }
            });
        }
    });
</script>
