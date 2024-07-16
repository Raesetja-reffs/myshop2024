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
                columns: [
						{
						   dataField: "stockName",
						   caption: "Stock Take Name",
						   width: 100,

						}, 
						{
						   dataField: "strItemCode",
						   caption: "Item Code",
						   width: 200,

						},{
						   dataField: "strDesc",
						   caption: "Item Description",
						   width: 200,

						},  {
						   dataField: "RedTeam",
						   caption: " Red Team",
						   width: 100,
						   dataType:"number",format: "#0.##" ,

						}, {
						   dataField: "BlueTeam",
						   caption: " Blue Team",
						   width: 100,
						   dataType:"number",format: "#0.##" ,

						},{
						   dataField: "Manager",
						   caption: " Manager",
						   width: 100,
						   dataType:"number",format: "#0.##" ,

						}, {
						   dataField: "OnHandQty",
						   caption: " On Hand Quantity",
						   width: 100,
						   dataType:"number",format: "#0.##" ,

						}, {
						   dataField: "FinalQty",
						   caption: "Final Quantity",
						   width: 100,
						   dataType:"number",format: "#0.##" ,

						}, {
						   dataField: "Variance",
						   caption: "Variance",
						   width: 100,
						   dataType:"number",format: "#0.##" ,

						}, {
						   dataField: "Cost",
						   caption: "Cost",
						   width: 100,

						}, {
						   dataField: "Color",
						   caption: "Item Color",
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
                                getBinVariance();
                            },
                        },
                    });
                }
            }).dxDataGrid('instance');

            function getBinVariance() {
                // Get the dxDateRangeBox widget instance using the CSS class
                var dateRangeBox = $("#dateRange").dxDateRangeBox("instance");
                var selectedValues = dateRangeBox.option("value");

                var dateFrom = formatDate(selectedValues[0]);
                var dateTo = formatDate(selectedValues[1]);

                $.ajax({
                    url: '{!! url('/getBinVariance') !!}',
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