@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Stock Take')


{{-- Set to show navbar --}}
@php
    $includeMenu = true;
@endphp

@section('page')

    <div id="gridStockTake" class="col-lg-12"></div>
    <div id="popupCreate">
        <div class="dx-field">
            <div class="dx-field-label">Reference</div>
            <div class="dx-field-value">
                <div id="inputReference"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Select Location</div>
            <div class="dx-field-value">
                <div id="selectLocations"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Select Bins</div>
            <div class="dx-field-value">
                <div id="selectBins"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Select Product Groups</div>
            <div class="dx-field-value">
                <div id="selectProductGroups"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Select Stock Take Teams</div>
            <div class="dx-field-value">
                <div id="selectTeams"></div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <style>
        #gridStockTake {
            height: calc(100vh - 2rem);
            max-height: calc(100vh - 2rem);
        }
    </style>

    <script>
        $(document).ready(function() {

            let locations = {!! json_encode($locations) !!};
            let bins = []
            let productGroups = {!! json_encode($productGroups) !!};
            let locationIds;

            const inputReference = $("#inputReference").dxAutocomplete({
                dataSource: [],
                valueExpr: 'InvoiceNo',
                showClearButton: true,
                searchEnabled: true,
                onValueChanged: function(e) {
                },
            }).dxAutocomplete("instance");


            const selectLocations = $("#selectLocations").dxSelectBox({
                dataSource: locations,
                valueExpr: 'intLocationNameId',
                displayExpr: 'strLocationName',
                applyValueMode: 'useButtons',
                showSelectionControls: true,
                showClearButton: true,
                searchEnabled: true,
                onValueChanged: function(e) {
                    locationIds = e.value;
                    getBinsForLocations();
                },
            }).dxSelectBox("instance");

            const selectBins = $("#selectBins").dxTagBox({
                dataSource: bins,
                valueExpr: 'intBinId',
                displayExpr: 'strBin',
                applyValueMode: 'useButtons',
                showSelectionControls: true,
                showClearButton: true,
                searchEnabled: true,
                multiline: false,
                onValueChanged: function(e) {

                },
            }).dxTagBox("instance");

            const selectProductGroups = $("#selectProductGroups").dxTagBox({
                dataSource: productGroups,
                valueExpr: 'ItemGroup',
                displayExpr: 'ItemGroupDescription',
                applyValueMode: 'useButtons',
                showSelectionControls: true,
                showClearButton: true,
                searchEnabled: true,
                multiline: false,
                onValueChanged: function(e) {

                },
            }).dxTagBox("instance");

            const selectTeams = $("#selectTeams").dxTagBox({
                dataSource: {
                    store: [{
                        'strTeamName': 'RedTeam',
                        'strDisplayName': 'Red Team',
                    }, {
                        'strTeamName': 'BlueTeam',
                        'strDisplayName': 'Blue Team',
                    }],
                    paginate: true,
                    pageSize: 100
                },
                valueExpr: 'strTeamName',
                displayExpr: 'strDisplayName',
                applyValueMode: 'useButtons',
                showSelectionControls: true,
                showClearButton: true,
                searchEnabled: true,
                multiline: false,
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
                            var reference = inputReference.option('value');
                            var locations = selectLocations.option('value');
                            var bins = selectBins.option('value');
                            var productGroups = selectProductGroups.option('value');
                            var teams = selectTeams.option('value');

                            console.log(reference);
                            // console.log(locations.join(','));
                            console.log(locations);
                            console.log(bins.join(','));
                            console.log(productGroups.join(','));
                            console.log(teams.join(','));

                            createStockTake(reference, locations, bins.join(','), productGroups.join(','), teams.join(','))
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
                },  {
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
                masterDetail: {
                    enabled: true,
                    template(container, options) {
                        const ID = options.data.intAutoId;
                        const gridStockDetailSummary = $('<div>')
                        .dxDataGrid({
                            dataSource: {
                                load: function(loadOptions) {
                                    return $.ajax({
                                        url: '{!!url("/getStockCounts")!!}',
                                        method: 'GET',
                                        data: { 
                                            ID: ID,
                                        },
                                        xhrFields: { withCredentials: true },
                                    });
                                },
                                update: function (key, values) {
                                    gridStockDetailSummary.dxDataGrid('instance').refresh();
                                },
                                insert: function (key, values) {
                                    gridStockDetailSummary.dxDataGrid('instance').refresh();
                                },
                            },                        
                            showBorders: true,     
                            filterRow: {
                                visible: true
                            },
                            filterPanel: {
                                visible: true
                            },
                            headerFilter: {
                                visible: true
                            },
                            editing: {
                                mode: 'row',
                                allowUpdating: true,
                            },
                            paging: {
                                enabled: false
                            },
                            columns:[
                                {
                                    dataField: "intMainStockCountID",
                                    caption: "intMainStockCountID",
                                    visible: false,
                                    allowEditing: false,
                                },
                                {
                                    dataField: "strStockTakeName",
                                    caption: "strStockTakeName",
                                    allowEditing: false,
                                },
                                {
                                    dataField: "strItemCode",
                                    caption: "strItemCode",
                                    allowEditing: false,
                                },
                                
                                {
                                    dataField: "intBinId",
                                    caption: "Bin ID",
                                    visible: false,
                                    allowEditing: false,
                                },
                                {
                                    dataField: "strBinName",
                                    caption: "Bin Name",
                                    allowEditing: false,
                                },
                                {
                                    dataField: "mnyBlueSingle",
                                    caption: "Blue Single",
                                    dataType: 'number',
                                    alignment: 'center',
                                    allowEditing: false,
                                },
                                {
                                    dataField: "mnyRedSingle",
                                    caption: "Red Single",
                                    dataType: 'number',
                                    alignment: 'center',
                                    allowEditing: false,
                                },
                                {
                                    dataField: "mnyManagerSingle",
                                    caption: "Manager Single",
                                    dataType: 'number',
                                    alignment: 'center',
                                },
                                {
                                    dataField: "mnyBluePallet",
                                    caption: "Blue Pallet",
                                    dataType: 'number',
                                    alignment: 'center',
                                    allowEditing: false,
                                },
                                {
                                    dataField: "mnyRedPallet",
                                    caption: "Red Pallet",
                                    dataType: 'number',
                                    alignment: 'center',
                                    allowEditing: false,
                                },
                                {
                                    dataField: "mnyManagerPallet",
                                    caption: "Manager Pallet",
                                    dataType: 'number',
                                    alignment: 'center',
                                },
                                {
                                    dataField: "mnyBlueTotal",
                                    caption: "Blue Total",
                                    dataType: 'number',
                                    alignment: 'center',
                                    allowEditing: false,
                                },
                                {
                                    dataField: "mnyRedTotal",
                                    caption: "Red Total",
                                    dataType: 'number',
                                    alignment: 'center',
                                    allowEditing: false,
                                },
                                {
                                    dataField: "mnyManagerTotal",
                                    caption: "Manager Total",
                                    dataType: 'number',
                                    alignment: 'center',
                                },
                                {
                                    dataField: "mnyOnHand",
                                    caption: "OnHand",
                                    dataType: 'number',
                                    alignment: 'center',
                                    allowEditing: false,
                                },
                                {
                                    dataField: "strRowColor",
                                    caption: "strRowColor",
                                    visible: false,
                                    allowEditing: false,
                                },
                            ],
                            onContentReady: function (e) {

                            },
                            onCellPrepared: function(e) {
                                if(e.rowType === "data" && (e.column.dataField === "mnyManagerSingle" || e.column.dataField === "mnyManagerPallet" || e.column.dataField === "mnyManagerTotal")) {
                                    e.cellElement.css("background-color", "#4287f5");
                                    e.cellElement.css("color", "white");
                                }
                            },
                            onRowPrepared: function (e){
                                if (e.data){
                                    // console.log(e.data.strRowColor);
                                    if (e.data.strRowColor != null) {
                                        e.rowElement.css("background-color", e.data.strRowColor);
                                        e.rowElement.css("color", "white");
                                    }
                                }
                            },
                            onToolbarPreparing: function(e) {
                                e.toolbarOptions.items.push({
                                    location: 'after',
                                    widget: "dxButton",
                                    options: {
                                        icon: "fa fa-plus-circle",
                                        text: "SET MANAGERS QTYS",
                                        type: 'default',
                                        stylingMode: 'contained',
                                        onClick: function(args) {
                                            // $('#modalAddgroupspecial').modal('show');
                                        },
                                    },
                                });
                                e.toolbarOptions.items.push({
                                    location: 'after',
                                    widget: "dxButton",
                                    options: {
                                        icon: "fa fa-plus-circle",
                                        text: "APPROVE",
                                        type: 'default',
                                        stylingMode: 'contained',
                                        onClick: function(args) {
                                            // $('#modalAddgroupspecial').modal('show');
                                        },
                                    },
                                });
                            }
                        }).appendTo(container);
                    },
                },
                onRowUpdated: function(e) {
                    var stockTakeId = e.data.intAutoId;
                    var statusId = e.data.blnIsOpened;
                    updateStockTakeStatus(stockTakeId, statusId)
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
                    type: "GET",
                    data: {
                        datefrom: dateFrom,
                        dateto: dateTo
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

            function getBinsForLocations() {
                $.ajax({
                    url: '{!! url('/getBinsForLocations') !!}',
                    type: "GET",
                    data: {
                        locationIds: locationIds,
                    },
                    success: function(binsData) {
                        selectBins.option('dataSource', binsData);
                        selectBins.repaint();
                    }
                });
            }

            function createStockTake(reference, locations, bins, productGroups, teams){
                $.ajax({
                    url: '{!! url('/createStockTake') !!}',
                    type: "POST",
                    data: {
                        reference: reference,
                        locations: locations,
                        bins: bins,
                        productGroups: productGroups,
                        teams: teams,
                    },
                    success: function(data) {
                        getStockTakes();
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
        });
    </script>

@endsection
