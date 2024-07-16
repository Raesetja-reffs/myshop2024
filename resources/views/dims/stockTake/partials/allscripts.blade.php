<script>
        $(document).ready(function() {

            let users = {!! json_encode($users) !!};
           // let bins = []
            //let locationIds;

            const inputStockTakeName = $("#inputStockTakeName").dxAutocomplete({
                dataSource: [],
                valueExpr: 'strStockTakeName',
                showClearButton: true,
                searchEnabled: true,
                onValueChanged: function(e) {
                },
            }).dxAutocomplete("instance");


            const selectBlues = $("#selectBlues").dxTagBox({
                dataSource: users,
                valueExpr: 'UserId',
                displayExpr: 'UserName',
                applyValueMode: 'useButtons',
                showSelectionControls: true,
                showClearButton: true,
                searchEnabled: true,
                onValueChanged: function(e) {
                },
            }).dxTagBox("instance");

            const selectReds = $("#selectReds").dxTagBox({
                dataSource: users,
                valueExpr: 'UserId',
                displayExpr: 'UserName',
                applyValueMode: 'useButtons',
                showSelectionControls: true,
                showClearButton: true,
                searchEnabled: true,
                onValueChanged: function(e) {
                },
            }).dxTagBox("instance");

            const selectManagers = $("#selectManagers").dxTagBox({
                dataSource: users,
                valueExpr: 'UserId',
                displayExpr: 'UserName',
                applyValueMode: 'useButtons',
                showSelectionControls: true,
                showClearButton: true,
                searchEnabled: true,
                onValueChanged: function(e) {
                },
            }).dxTagBox("instance");



            // Note from Kyle - If you add to the popup, make sure you initialize the components before the popup
            const popupCreate = $("#popupCreate").dxPopup({
                showTitle: true,
                title: 'Create Stock Take',
                hideOnOutsideClick: true,
                showCloseButton: true,
                width: 500,
                height: 600,
                height: 'auto',
                toolbarItems: [{
                    widget: 'dxButton',
                    toolbar: 'bottom',
                    location: 'after',
                    options: {
                        icon: "fa-solid fa-add",
                        text: "CREATE STOCK TAKE",
                        onClick: function(args) {
                            var reference = inputStockTakeName.option('value');
                            var blueTeamMembers = selectBlues.option('value');
                            var redTeamMembers = selectReds.option('value');
                            var managerTeamMembers = selectManagers.option('value');
                            console.log(blueTeamMembers.join(","));
                            console.log(redTeamMembers.join(","));
                            console.log(managerTeamMembers.join(","));


                            createStockTake(reference, blueTeamMembers.join(","), redTeamMembers.join(","), managerTeamMembers.join(","))
                        },
                    },
                }],
            }).dxPopup("instance");

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
                columns: [{
                    dataField: "intAutoId",
                    caption: "ID",
                    allowEditing: false,
                }, {
                    dataField: "strStockTakeName",
                    caption: "Stock Take Name",
                    allowEditing: false,
                }, {
                    dataField: "stockTakeLocation",
                    caption: "Stock Take Location",
                    allowEditing: false,
                }, {
                    dataField: "dtmCreated",
                    caption: "Date Created",
                    allowEditing: false,
                }, {
                    dataField: "blnIsOpened",
                    caption: "Is Active",
                    lookup: {
                        dataSource: [
                            {
                                "value": "1", "display": "Active"
                            },{
                                "value": "0", "display": "In-Active"
                            },
                        ],
                        valueExpr: 'value',
                        displayExpr: 'display',
                    },
                }, ],
                onRowUpdated: function(e) {
                    var stockTakeId = e.data.intAutoId;
                    var statusId = e.data.blnIsOpened;
                    updateStockTakeStatus(stockTakeId, statusId)
                },
                onRowDblClick: function(e) {
                    
                        window.open('{!!url("/confirmStocktakeFor/")!!}' + '/' + e.data.strStockTakeName, "_blank");
                        
                },
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
                                getStockTakes();
                            },
                        },
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa-solid fa-add",
                            text: "ADD",
                            onClick: function(args) {
                                popupCreate.show();
                            },
                        },
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa-solid fa-add",
                            text: "FINAL STOCKTAKE",
                            onClick: function(args) {
                                redirectFinalStockTake();
                            },
                        },
                    });e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa-solid fa-add",
                            text: "BIN VARIANCE",
                            onClick: function(args) {
                                redirectBinVariance();
                            },
                        },
                    });
                }
            }).dxDataGrid('instance');

            function getStockTakes() {
                // Get the dxDateRangeBox widget instance using the CSS class
                var dateRangeBox = $("#dateRange").dxDateRangeBox("instance");
                var selectedValues = dateRangeBox.option("value");

                var dateFrom = formatDate(selectedValues[0]);
                var dateTo = formatDate(selectedValues[1]);

                $.ajax({
                    url: '{!! url('/getStockTakes') !!}',
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


            function createStockTake(reference, blues, reds, managers){
                $.ajax({
                    url: '{!! url('/createStockTake') !!}',
                    type: "POST",
                    data: {
                        reference: reference,
                        blues: blues,
                        reds: reds,
                        managers: managers,
                    },
                    success: function(data) {
                        window.open('{!!url("/confirmStocktakeFor/")!!}' + '/' + reference, "_blank");
                    }
                });
            }

            function updateStockTakeStatus(stockTakeId, statusId){
                $.ajax({
                    url: '{!! url('/updateStockTakeStatus') !!}',
                    type: "POST",
                    data: {
                        stockTakeId: stockTakeId,
                        statusId: statusId,
                    },
                    success: function(data) {
                        getStockTakes();
                    }
                });
            }
            function redirectFinalStockTake(){

                window.open('{!!url("/finalstock/")!!}', "_blank");

            }
            function redirectBinVariance(){

                window.open('{!!url("/binvariance/")!!}', "_blank");

            }
        });
    </script>