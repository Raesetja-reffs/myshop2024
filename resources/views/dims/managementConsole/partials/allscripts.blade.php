<script>
        $(document).ready(function() {
            const gridManagementConsole = $("#gridManagement").dxDataGrid({
                dataSource: [],
                showBorders: true,
                showRowLines: true,
                showColumnLines: true,
                rowAlternationEnabled: true,
                filterRow: {
                    visible: true
                },
                filterPanel: {
                    visible: true
                },
                headerFilter: {
                    visible: true
                },
                paging:{
                    pageSize: 50,
                },
                export: {
                    enabled: true
                },
                onExporting(e) {
                    const workbook = new ExcelJS.Workbook();
                    const worksheet = workbook.addWorksheet('consoledata');

                    DevExpress.excelExporter.exportDataGrid({
                        component: e.component,
                        worksheet,
                        autoFilterEnabled: true,
                    }).then(() => {
                        workbook.xlsx.writeBuffer().then((buffer) => {
                            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'consoledata.xlsx');
                        });
                    });
                    e.cancel = true;
                },
                columnAutoWidth: true,
                allowColumnResizing: true,
                columnResizingMode: "widget",
                columnFixing: {
                    enabled: true,
                },
                scrolling: {
                    mode: 'virtual'
                },
                columns: [{
                    dataField: "MessageId",
                    caption: "ID",
                    allowEditing: false,
                },{
                    dataField: "ConsoleTypeId",
                    caption: "Log Type ID",
                    allowEditing: false,
                },{
                    dataField: "dtm",
                    caption: "Timestamp",
                    allowEditing: false,
                },{
                    dataField: "userName",
                    caption: "Username",
                    allowEditing: false,
                },{
                    dataField: "UserId",
                    caption: "User ID",
                    allowEditing: false,
                },{
                    dataField: "Message",
                    caption: "Message",
                    allowEditing: false,
                },{
                    dataField: "OrderId",
                    caption: "Order ID",
                    allowEditing: false,
                },
             ],
                onToolbarPreparing: function(e) {
                    // Create a custom header on the left side
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        template: function() {
                            return $('<h3 class="ps-3">').text('Stock Takes');
                        }
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxDateRangeBox",
                        options: {
                            width: 300,
                            class: "myDateRangeBox",
                            displayFormat: 'yyyy-MM-dd',
                            elementAttr: {
                                id: "dateRange"
                            },
                        }
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa-solid fa-search",
                            text: "SEARCH",
                            onClick: function(args) {
                                getConsoleData();
                            },
                        },
                    });
                }
            }).dxDataGrid('instance');

            function getConsoleData() {
                // Get the dxDateRangeBox widget instance using the CSS class
                var dateRangeBox = $("#dateRange").dxDateRangeBox("instance");
                var selectedValues = dateRangeBox.option("value");

                var dateFrom = formatDate(selectedValues[0]);
                var dateTo = formatDate(selectedValues[1]);

                $.ajax({
                    url: '{!! url('/getManagementConsoleData') !!}',
                    type: "POST",
                    data: {
                        dateFrom: dateFrom,
                        dateTo: dateTo
                    },
                    success: function(gridData) {
                        gridManagementConsole.option('dataSource', gridData);
                        gridManagementConsole.refresh();
                    }
                });
            }

            // formats date to yyyy-MM-dd
            function formatDate(date) {
                returnFormat = date.toLocaleDateString("en-ZA", {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit'
                });

                return returnFormat.replace(/\//g, '-');
            }
        });
    </script>