<script>
        $(document).ready(function() {
            

            let bins = {!! json_encode($binData) !!};
            let items = {!! json_encode($productData) !!};
            let stocktakename = {!! json_encode($stocktakename) !!};
            let username = {!! json_encode($username) !!};
           // let bins = []
            //let locationIds;


            const selectWarehouses = $("#selectWarehouses").dxTagBox({
                dataSource: {
                    store: [{
                        'strWareHouse': 'MainWarehouse',
                        'strDisplayName': 'Main WareHouse',
                    }],
                    paginate: true,
                    pageSize: 100
                },
                valueExpr: 'strWareHouse',
                displayExpr: 'strDisplayName',
                applyValueMode: 'useButtons',
                showSelectionControls: true,
                showClearButton: true,
                searchEnabled: true,
                onValueChanged: function(e) {
                },
            }).dxTagBox("instance");



            
            const selectStockTakeTypes = $("#selectStockTakeTypes").dxTagBox({
                dataSource: {
                    store: [{
                        'strStockTakeType': 'ItemsAndBins',
                        'strDisplayName': 'Items And Bins',
                    }],
                    paginate: true,
                    pageSize: 100
                },
                valueExpr: 'strStockTakeType',
                displayExpr: 'strDisplayName',
                applyValueMode: 'useButtons',
                showSelectionControls: true,
                showClearButton: true,
                searchEnabled: true,
                onValueChanged: function(e) {
                },
            }).dxTagBox("instance");
            
            const selectBins = $("#selectBins").dxTagBox({
                dataSource: bins,
                valueExpr: 'intBinId',
                displayExpr: 'strBin',
                applyValueMode: 'useButtons',
                showSelectionControls: true,
                showClearButton: true,
                searchEnabled: true,
                onValueChanged: function(e) {
                },
            }).dxTagBox("instance");

            const gridStockTake = $("#gridStockTake").dxDataGrid({
                dataSource: items,
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
                    mode: "multiple",
                    showCheckBoxesMode: "always" // Optional: shows checkboxes for selection
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
                    visible:false,
                    dataField: "ProductId",
                    caption: "ID",
                    allowEditing: false,
                }, {
                    dataField: "PastelCode",
                    caption: "Item Code",
                    allowEditing: false,
                }, {
                    dataField: "PastelDescription",
                    caption: "Item Description",
                    allowEditing: false,
                },  ]
            }).dxDataGrid('instance');

        $('#submitAllData').click(function(){
                
            var bins = selectBins.option('value');
            var warehouses = selectWarehouses.option('value');
            var stocktaketype = selectStockTakeTypes.option('value');
            
            var selectedArray = new Array();
            var selectedItems = gridStockTake.getSelectedRowsData();
            selectedArray = selectedItems
            var SelectedXMLString = "<xml>";
            $.each(selectedArray ,function(key,value) {
              
                    SelectedXMLString= SelectedXMLString + "<result>";
                    SelectedXMLString= SelectedXMLString + "<ProductId>"+(value.ProductId)+"</ProductId>";
                    SelectedXMLString= SelectedXMLString + "<PastelCode>"+value.PastelCode+"</PastelCode>";
                    SelectedXMLString= SelectedXMLString + "<PastelDescription>"+value.PastelDescription+"</PastelDescription>";
                    SelectedXMLString= SelectedXMLString+ "</result>";
            });

            SelectedXMLString= SelectedXMLString+"</xml>";
            console.log(SelectedXMLString);
                            
            submitStockTakeData(stocktakename,username,bins.join(","), warehouses.join(","),stocktaketype.join(","),SelectedXMLString)
            });
        
        
        
            function submitStockTakeData(stocktakename, username, selectBins, selectWarehouses,selectStocktakeType,itemListXML){
                
                $.ajax({
                    url: '{!! url('/submitMappedStockData') !!}',
                    type: "POST",
                    data: {
                        stocktakename: stocktakename,
                        username: username,
                        bins: selectBins,
                        warehouses: selectWarehouses,
                        stocktaketype: selectStocktakeType,
                        itemlist: itemListXML,
                    },
                    success: function(data) {
                        
                    }
                });
            }
        });
    </script>