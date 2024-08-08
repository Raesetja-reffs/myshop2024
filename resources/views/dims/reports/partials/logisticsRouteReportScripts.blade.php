<script>
    $(document).ready(function() {
        let dateFrom, dateTo;
        let routeRequisition = {!! json_encode($routeRequisition) !!};

        const gridRouteCreditRequisition = $("#gridRouteCreditRequisition").dxDataGrid({
            dataSource: routeRequisition, //as json
            hoverStateEnabled: true,
            filterRow: {
                visible: true
            },
            allowColumnResizing: true,
            columnAutoWidth: true,
            height: '78vh',
            paging: {
                pageSize: 500,
            },
            export: {
                enabled: true
            },
            selection: {
                mode: 'single',
            },
            onExporting(e) {
                const workbook = new ExcelJS.Workbook();
                const worksheet = workbook.addWorksheet('Credit Requisition');
                DevExpress.excelExporter.exportDataGrid({
                    component: e.component,
                    worksheet,
                    autoFilterEnabled: true,
                }).then(() => {
                    workbook.xlsx.writeBuffer().then((buffer) => {
                        saveAs(new Blob([buffer], {
                            type: 'application/octet-stream'
                        }), 'Route_Credit_Requisition_{{ $deliveryDateId }}.xlsx');
                    });
                });
                e.cancel = true;
            },
            columns: [{
                    dataField: "OrderId",
                    caption: "Order Id",
                },
                {
                    dataField: "PastelCode",
                    caption: "Item Code",
                },
                {
                    dataField: "PastelDescription",
                    caption: "Description",
                },
                {
                    dataField: "strCustomerReason",
                    caption: "Reason",
                },
                {
                    dataField: "returnQty",
                    caption: "Return Qty",
                },
                {
                    dataField: "Qty",
                    caption: "Qty",
                },
                {
                    dataField: "fltQtyPicked",
                    caption: "Qty Picked",
                },
                {
                    caption: "StoreName",
                },
                {
                    dataField: "StoreName",
                    caption: "Customer Code",
                    
                },
                {
                    dataField: "Route",
                    caption: "Route(Area)"
                },
                {
                    dataField: "OrderType",
                    caption: "Type",
                },
                {
                    dataField: "RegNo",
                    caption: "Reg No",
                },
                {
                    dataField: "DriverName",
                    caption: "Driver Name",
                },
                {
                    dataField: "dteOffloadedTime",
                    caption: "Order Offloaded Time",
                },
                {
                    dataField: "dteLineRequisition",
                    caption: "Requisition server time",
                },
            ],
            onToolbarPreparing: function(e) {
                e.toolbarOptions.items.unshift({
                    location: 'before',
                    template: function() {
                        return $('<h5 class="mb-0">').text('Route Credit Requisition');
                    }
                });
            }
        }).dxDataGrid("instance");

        $('#btnUpdateDetails').click(function(){
            $.ajax({
                url: '{!!url("/updateLogisticsInformation")!!}',
                type: "GET",
                data: {
                    routingId: $('#btnUpdateDetails').val(),
                    driverId: $('#driverId').val(),
                    assistantId: $('#assistantId').val(),
                    truckId: $('#truckId').val(),
                    dispatchId: $('#dispatchId').val()
                },
                success: function (data) {
                    alert("Please don't forget to click SUBMIT button to refresh data");
                    close();
                }
            });
        });
    });
</script>
