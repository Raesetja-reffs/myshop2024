<script>
        $(document).ready(function() {
            

            let viewMappings = {!! json_encode($viewMappings) !!};

            const gridStockTake = $("#gridStockTake").dxDataGrid({
                dataSource: viewMappings,
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
                    pageSize: 25
                },
                pager: {
                    showPageSizeSelector: true,
                    allowedPageSizes: [25, 50, 100],
                    showInfo: true
                },
                selection: {
                    mode: "single",
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
                columns: [ {
                    dataField: "strProduct",
                    caption: "Item Code",
                    allowEditing: false,
                }, {
                    dataField: "strDescription",
                    caption: "Item Description",
                    allowEditing: false,
                }, {
                    dataField: "Bin",
                    caption: "Bin",
                    allowEditing: false,
                },  ]
            }).dxDataGrid('instance');
        
        });
    </script>