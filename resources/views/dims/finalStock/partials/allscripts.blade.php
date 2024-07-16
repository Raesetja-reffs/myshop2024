<script>
        $(document).ready(function() {

            const gridStockTake = $("#gridStockTake").dxDataGrid({
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
                paging: {
                    enabled: false
                },
                selection: {
                    mode: "single",
                },
                editing: {
                    mode: 'cell',
                    allowUpdating: true,
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
                export: {
                enabled: true
                },
                onExporting(e) {
                const workbook = new ExcelJS.Workbook();
                const worksheet = workbook.addWorksheet('finalstock');

                DevExpress.excelExporter.exportDataGrid({
                    component: e.component,
                    worksheet,
                    autoFilterEnabled: true,
                        }).then(() => {
                         workbook.xlsx.writeBuffer().then((buffer) => {
                          saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'finalstock.xlsx');
                                      });
                        });
                        e.cancel = true;
                },
                columns: [
						{
						   dataField: "stockName",
						   caption: "Stocktake Name",
						   width: 200,

						},{
						   dataField: "strItemCode",
						   caption: "Item Code",
						   width: 200,

						},  {
						   dataField: "strDesc",
						   caption: " Item Description",
						   width: 300,

						}, {
						   dataField: "FinalQty",
						   caption: "Final Quantity",
						   width: 150,
						   dataType:"number",format: "#0.##" ,

						},{
						   dataField: "OnHandQty",
						   caption: " On Hand Quantity",
						   width: 150,
						   dataType:"number",format: "#0.##" ,

						},{
						   dataField: "Cost",
						   caption: "Cost",
						   width: 100,

						},  {
						   dataField: "Variance",
						   caption: "Variance",
						   width: 100,
						   dataType:"number",format: "#0.##" ,

						},{
						   dataField: "VarianceValue",
						   caption: "Variance Value",
						   width: 100,
						   dataType:"number",format: "#0.##" ,

						},{
						   dataField: "strCategory",
						   caption: "Product Category",
						   width: 100

						},  {
						   dataField: "binloc",
						   caption: "Bin Location",
						   width: 100,

						},  {
						   dataField: "warehouse",
						   caption: "Warehouse",
						   width: 100,

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
                                getFinalStock();
                            },
                        },
                    });
                }
            }).dxDataGrid('instance');

            function getFinalStock() {
                // Get the dxDateRangeBox widget instance using the CSS class
                var dateRangeBox = $("#dateRange").dxDateRangeBox("instance");
                var selectedValues = dateRangeBox.option("value");

                var dateFrom = formatDate(selectedValues[0]);
                var dateTo = formatDate(selectedValues[1]);

                $.ajax({
                    url: '{!! url('/getFinalStock') !!}',
                    type: "POST",
                    data: {
                        dateFrom: dateFrom,
                        dateTo: dateTo
                    },
                    success: function(gridData) {
                        gridStockTake.option('dataSource', gridData);
                        gridStockTake.refresh();
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