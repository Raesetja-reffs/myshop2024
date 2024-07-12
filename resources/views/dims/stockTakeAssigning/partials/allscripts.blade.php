<script>
        $(document).ready(function() {
            let stocktakedata    =           {!! json_encode($stocktakedata) !!};
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