<script>
        $(document).ready(function() {
            let stocktakedata    =           {!! json_encode($stocktakedata) !!};
            let clickTimeout;
            const gridStockTake = $("#gridStockTake").dxDataGrid({
                dataSource: stocktakedata,
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
                columns: [{
                    dataField: "Username",
                    caption: "Username",
                    allowEditing: false,
                }, {
                    dataField: "Team",
                    caption: "Team Name",
                    allowEditing: false,
                }, ],
                onRowClick: function(e) {
                    clearTimeout(clickTimeout);
                    clickTimeout = setTimeout(function() {
                        // Single click action
                        window.open('{!!url("/viewStockTakeMappings/")!!}' + '/' + reference + '/' + e.data.Username, "_blank");
                    }, 300); // Adjust the timeout value as needed
                },
                onRowDblClick: function(e) {
                    clearTimeout(clickTimeout);
                    // Double click action
                        window.open('{!!url("/assignStockTakeProductBinMappings/")!!}' + '/' + reference + '/' + e.data.Username, "_blank");
                        
                },
                onToolbarPreparing: function(e) {
                    // Create a custom header on the left side
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        template: function() {
                            return $('<h3 class="ps-3">').text('Stock Takes');
                        }
                    });
                }
            }).dxDataGrid('instance');


        });
    </script>