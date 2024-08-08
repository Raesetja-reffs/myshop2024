<script>
    $(document).ready(function() {
        let dateFrom, dateTo;

        const gridCreditRequisitionReport = $("#gridCreditRequisitionReport").dxDataGrid({
            dataSource: [], //as json
            hoverStateEnabled: true,
            filterRow: {
                visible: true
            },
            allowColumnResizing: true,
            columnAutoWidth: true,
            height: '65vh',
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
                        }), 'Credit_Requisition_Report_' + formatDate(dateFrom) + '_' + formatDate(dateTo) + '.xlsx');
                    });
                });
                e.cancel = true;
            },
            columns: [{
                    dataField: "OrderId",
                    caption: "Order Id",
                },
                {
                    dataField: "reqNo",
                    caption: "Req No",
                },
                {
                    dataField: "InvoiceNo",
                    caption: "Invoice No",
                },
                {
                    dataField: "UserName",
                    caption: "Created By",
                },
                {
                    dataField: "StoreName",
                    caption: "Store Name",
                },
                {
                    dataField: "CustomerPastelCode",
                    caption: "Customer Code",
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
                    dataField: "strDispatchComments",
                    caption: "Dispatch Comments",
                },
                {
                    dataField: "strDispatchReturnsAuthBy",
                    caption: "Dispatch Auth By",
                },
                {
                    dataField: "strCreditDeptComment",
                    caption: "Credit Dept Comment",
                },
                {
                    dataField: "strCreditReturnApprovedBy",
                    caption: "Credit Auth By",
                },
                {
                    dataField: "Route",
                    caption: "Route(Area)",
                },
                {
                    dataField: "OrderType",
                    caption: "Type",
                },
                {
                    dataField: "DeliveryDate",
                    caption: "Delivery Date",
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
                    caption: "Generated time",
                },
                {
                    dataField: "OrderDetailId",
                    caption: "Order Detail Id",
                    visible: false,
                },
            ],
            onToolbarPreparing: function(e) {
                e.toolbarOptions.items.unshift({
                    location: 'before',
                    template: function() {
                        return $('<h5 class="mb-0">').text('Search Credit Requisition');
                    }
                });
                e.toolbarOptions.items.push({
                    location: 'after',
                    widget: "dxDateRangeBox",
                    options: {
                        width: 250,
                        id: "dateRange",
                        displayFormat: 'yyyy-MM-dd',
                        showClearButton: true,
                        onValueChanged: function(e) {
                            dateFrom = e.value[0];
                            dateTo = e.value[1];
                        }
                    }
                });
                e.toolbarOptions.items.push({
                    location: 'after',
                    widget: "dxButton",
                    options: {
                        icon: "fa fa-search",
                        text: "SEARCH",
                        type: 'default',
                        stylingMode: 'contained',
                        onClick: function(args) {
                            getCreditRequisitionReport();
                        },
                        elementAttr: {
                            class: "menu-button"
                        },
                    },
                });
            }
        }).dxDataGrid("instance");

        const gridCreditRequests = $("#gridCreditRequests").dxDataGrid({
            dataSource: [], //as json
            hoverStateEnabled: true,
            showBorders: true,
            filterRow: {
                visible: true
            },
            allowColumnResizing: true,
            columnAutoWidth: true,
            height: '65vh',
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
                        }), 'Drivers_App_Credit_Requests_' + formatDate(dateFrom) + '_' + formatDate(dateTo) + '.xlsx');
                    });
                });
                e.cancel = true;
            },
            columns: [{
                    dataField: "strCustomerName",
                    caption: "Customer Name", 
                },
                {
                    dataField: "dteDeliveryDate",
                    caption: "Date Create", 
                },
                {
                    dataField: "strProductName",
                    caption: "Product Name", 
                },
                {
                    dataField: "mnyQty",
                    caption: "Quantity", 
                },
                {
                    dataField: "mnyWeights",
                    caption: "Weights", 
                },
                {
                    dataField: "strComment",
                    caption: "Notes",
                },
                {
                    dataField: "strSignedBy",
                    caption: "Signed By", 
                },
                {
                    dataField: "strEmail",
                    caption: "Email List", 
                },
            ],
            onToolbarPreparing: function(e) {
                e.toolbarOptions.items.unshift({
                    location: 'before',
                    template: function() {
                        return $('<h5 class="mb-0">').text('Search Credit Request');
                    }
                });
                e.toolbarOptions.items.push({
                    location: 'after',
                    widget: "dxDateRangeBox",
                    options: {
                        width: 250,
                        id: "dateRange",
                        displayFormat: 'yyyy-MM-dd',
                        showClearButton: true,
                        onValueChanged: function(e) {
                            dateFrom = e.value[0];
                            dateTo = e.value[1];
                        }
                    }
                });
                e.toolbarOptions.items.push({
                    location: 'after',
                    widget: "dxButton",
                    options: {
                        icon: "fa fa-search",
                        text: "SEARCH",
                        type: 'default',
                        stylingMode: 'contained',
                        onClick: function(args) {
                            getDriversAppCreditRequests();
                        },
                        elementAttr: {
                            class: "menu-button"
                        },
                    },
                });
            }
        }).dxDataGrid("instance");

        function getCreditRequisitionReport(){
            $.ajax({
                url: '{!! url('/getCreditRequisitionReport') !!}',
                type: "GET",
                data: {
                    dateFrom: formatDate(dateFrom),
                    dateTo: formatDate(dateTo),
                },
                success: function(data) {
                    gridCreditRequisitionReport.option('dataSource', data);
                    gridCreditRequisitionReport.refresh();
                }
            });
        }

        function getDriversAppCreditRequests(){
            $.ajax({
                url: '{!! url('/getDriversAppCreditRequests') !!}',
                type: "GET",
                data: {
                    dateFrom: formatDate(dateFrom),
                    dateTo: formatDate(dateTo),
                },
                success: function(data) {
                    gridCreditRequests.option('dataSource', data);
                    gridCreditRequests.refresh();
                }
            });
        }
    });
</script>
