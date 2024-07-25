<script>
    $(document).ready(function() {
        var routes = {!! json_encode($routes) !!};
        var types = {!! json_encode($types) !!};

        let markers = [];
        let markersData = [];

        const selectDeliveryDate = $("#selectDeliveryDate").dxDateBox({
            type: "date",
            label: "Date and time",
            displayFormat: 'yyyy-MM-dd',
            onValueChanged: function(e) {},
        }).dxDateBox("instance");

        const selectRoute = $("#selectRoute").dxSelectBox({
            dataSource: routes,
            valueExpr: "Routeid",
            displayExpr: "Route",
            label: "Route",
        }).dxSelectBox("instance");

        const selectType = $("#selectType").dxSelectBox({
            dataSource: types,
            valueExpr: "OrderTypeId",
            displayExpr: "OrderType",
            label: "Type",
        }).dxSelectBox("instance");

        const popupGetStops = $("#popupGetStops").dxPopup({
            showTitle: true,
            title: 'Get Stops',
            onHidden: function(e) {
                // selectPushed.option('value', null);
                // selectProhibited.option('value', null);
            },
            hideOnOutsideClick: false,
            showCloseButton: true,
            width: 600,
            height: 'auto',
            toolbarItems: [{
                widget: 'dxButton',
                toolbar: 'bottom',
                location: 'after',
                options: {
                    type: 'default',
                    stylingMode: 'contained',
                    icon: "fa fa-plus-circle",
                    text: "Get Stops",
                    onClick: function(args) {
                        getStops();
                        popupGetStops.hide();
                    },
                },
            }, ],
        }).dxPopup("instance");

        const popupOverview = $("#popupOverview").dxPopup({
            showTitle: true,
            title: 'Trip Overview',
            onHidden: function(e) {
                // selectPushed.option('value', null);
                // selectProhibited.option('value', null);
            },
            hideOnOutsideClick: false,
            showCloseButton: true,
            width: 600,
            height: 'auto',
        }).dxPopup("instance");

        const gridRoutes = $("#gridRoutes").dxDataGrid({
            dataSource: [], //as json
            showBorders: true,
            keyExpr: 'intSequence',
            hoverStateEnabled: true,
            height: '78vh',
            filterRow: {
                visible: true
            },
            filterPanel: {
                visible: true
            },
            headerFilter: {
                visible: true
            },
            selection: {
                mode: 'multiple',
                showCheckBoxesMode: 'none',
            },
            allowColumnResizing: true,
            columnAutoWidth: true,
            scrolling: {
                mode: 'virtual', // Enable infinite scrolling
            },
            paging: {
                pageSize: 10,
            },
            editing: {
                mode: 'row',
                allowUpdating: true,
            },
            rowDragging: {
                allowReordering: true,
                onReorder(e) {
                    const visibleRows = e.component.getVisibleRows();
                    var data = gridRoutes.option('dataSource');
                    const toIndex = data.findIndex((item) => item.intSequence == visibleRows[e.toIndex]
                        .data.intSequence);
                    const fromIndex = data.findIndex((item) => item.intSequence == e.itemData
                        .intSequence);

                    if (toIndex == 0 || toIndex == data.length - 1) {
                        e.cancel = true;
                        return;
                    }

                    if (fromIndex == 0 || fromIndex == data.length - 1) {
                        e.cancel = true;
                        return;
                    }

                    data.splice(fromIndex, 1);
                    data.splice(toIndex, 0, e.itemData);

                    // Update intSequence numbers
                    data.forEach((item, index) => {
                        item.intSequence = index;
                    });

                    e.component.refresh();
                },
            },
            columns: [{
                    dataField: 'intSequence',
                    caption: 'Seq',
                    allowEditing: false,
                },
                {
                    dataField: 'StoreName',
                    caption: 'Store',
                    allowEditing: false,
                },
                {
                    dataField: 'fltLatitude',
                    caption: 'Latitude',
                    // visible: false,
                },
                {
                    dataField: 'fltLongitude',
                    caption: 'Longitude',
                    // visible: false,
                },
                {
                    dataField: 'latlng',
                    caption: 'LatLng',
                    visible: false,
                    calculateCellValue: function(data) {
                        return data.fltLatitude + ', ' + data.fltLongitude;
                    }
                },
                {
                    dataField: 'estimatedArrival',
                    caption: 'Estimated Arrival',
                    visible: false,
                },
                {
                    dataField: 'estimatedDeparture',
                    caption: 'Estimated Departure',
                    visible: false,
                },
                {
                    dataField: 'OrderId',
                    caption: 'ID',
                    visible: false,
                    allowEditing: false,
                },
            ],
            onEditingStart: function(e) {
                if (e.key == 0 || e.key == e.component.totalCount() - 1) {
                    e.cancel = true;
                    alert('Cannot Edit company details');
                } else {
                    gridRoutes.columnOption('fltLatitude', 'visible', false);
                    gridRoutes.columnOption('fltLongitude', 'visible', false);
                    gridRoutes.columnOption('latlng', 'visible', true);
                }
            },
            onRowUpdating: function(e) {
                const newValues = e.newData;
                const latLngString = newValues
                    .latlng; // Assuming that you'll provide latitude and longitude as a single comma-separated string in this field
                const latLngArray = latLngString.split(', ');

                // Set latitude and longitude separately
                newValues.fltLatitude = latLngArray[0];
                newValues.fltLongitude = latLngArray[1];
            },
            onRowUpdated: function(e) {
                DevExpress.ui.dialog.confirm("Would you like to update the customer coordinates?",
                    "Confirmation").then((result) => {
                    if (result) {
                        $.ajax({
                            url: '{!! url('/updateCustomerGeoCoordinates') !!}',
                            type: "POST",
                            data: {
                                OrderId: e.data.OrderId,
                                lat: e.data.fltLatitude,
                                lng: e.data.fltLongitude

                            }, // No need to send data in the request body
                            success: function(response) {
                                DevExpress.ui.notify(
                                    'Customer Location Updated');
                            },
                            error: function(xhr, status, error) {
                                DevExpress.ui.notify(
                                    'Failed To Update Customer Location')
                            }
                        });
                    }
                });
            },
            onSaved: function(e) {
                gridRoutes.columnOption('fltLatitude', 'visible', true);
                gridRoutes.columnOption('fltLongitude', 'visible', true);
                gridRoutes.columnOption('latlng', 'visible', false);
            },
            onRowPrepared: function(e) {
                // Check if it's the first or last row by row index
                if (e.rowIndex === 0 || e.rowIndex === e.component.totalCount() - 1) {
                    // Add a custom CSS class to style the row
                    e.rowElement.addClass("non-draggable-row");

                    // Get the column drag handle elements
                    const dragHandles = e.rowElement.find(".dx-datagrid-drag-action");

                    // Disable column drag for this row by canceling the dragstart event
                    dragHandles.on("dragstart", function(event) {
                        event.preventDefault();
                    });
                }
            },
            onToolbarPreparing: function(e) {
                e.toolbarOptions.items.push({
                    location: 'before',
                    widget: "dxButton",
                    options: {
                        icon: "fa fa-plus-circle",
                        text: "Get Stops",
                        type: 'default',
                        stylingMode: 'contained',
                        onClick: function(args) {
                            popupGetStops.show();
                        },
                    },
                });
                e.toolbarOptions.items.push({
                    location: 'after',
                    toolbar: 'bottom',
                    widget: "dxButton",
                    options: {
                        icon: "fa-solid fa-route",
                        text: "Optimize",
                        type: 'default',
                        stylingMode: 'contained',
                        onClick: function(args) {
                            optimizeStops();
                        },
                    },
                });
                e.toolbarOptions.items.push({
                    location: 'after',
                    toolbar: 'bottom',
                    widget: "dxButton",
                    options: {
                        icon: "fa-solid fa-route",
                        text: "Update Sequence",
                        type: 'default',
                        stylingMode: 'contained',
                        onClick: function(args) {
                            setSequence();
                        },
                    },
                });
            }
        }).dxDataGrid('instance');

        const mapRoutes = $('#mapRoutes').dxMap({
            center: {
                lat: "{{ $companyLat }}",
                lng: "{{ $companyLng }}",
            },
            zoom: 17,
            EnableScrolling: false,
            EnableZooming: false,
            EnablePanning: false,
            provider: 'google',
            width: '100%',
            height: '78vh',
            apiKey: {
                google: "{{ env('GOOGLE_MAPS_API', 'NONE') }}",
            },
        }).dxMap('instance');

        const btnOverview = $('#btnOverview').dxButton({
            text: "Trip Overview",
            type: "default",
            visible: false,
            stylingMode: "contained",
            onClick: function() {
                // Define the action for the button here
                popupOverview.show();
            }
        }).dxButton('instance');

        markers = [{
            fltLatitude: "{{ $companyLat }}",
            fltLongitude: "{{ $companyLng }}",
            StoreName: "{{ $companyName }}",
            intSequence: "{{ $companyAbv }}",
        }];

        setRoutesAndMarkers(markers);

        function getStops() {
            $.ajax({
                url: '{!! url('/getRoutesToOptimize') !!}',
                type: "GET",
                data: {
                    deliveryDate: formatDate(selectDeliveryDate.option('value')),
                    routeId: selectRoute.option('value'),
                    typeId: selectType.option('value'),
                },
                success: function(results) {
                    if (results.length == 0) {
                        DevExpress.ui.notify({
                            message: 'No results found',
                            type: 'error', // 'info', 'success', 'warning'
                            displayTime: 5000,
                        });
                    } else {
                        results.unshift({
                            "OrderId": "0",
                            "StoreName": "{{ $companyName }}",
                            "fltLatitude": "{{ $companyLat }}",
                            "fltLongitude": "{{ $companyLng }}"
                        });

                        results.push({
                            "OrderId": "0",
                            "StoreName": "{{ $companyName }}",
                            "fltLatitude": "{{ $companyLat }}",
                            "fltLongitude": "{{ $companyLng }}"
                        });

                        results.forEach((item, index) => {
                            item.intSequence = index;
                        });

                        gridRoutes.option('dataSource', results);
                        gridRoutes.refresh();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }

        function optimizeStops() {
            var selectedRows = gridRoutes.getSelectedRowsData();
            var data = gridRoutes.option('dataSource');

            selectedRows.sort((a, b) => a.intSequence - b.intSequence);

            // Determine the data to send
            var sendData = selectedRows.length > 2 ? selectedRows : data;

            $.ajax({
                url: '{!! url('/optimizeStops') !!}',
                type: "POST",
                data: {
                    routes: sendData,
                },
                success: function(results) {
                    if (results.issues) {
                        $.each(results.issues, function(index, value) {
                            DevExpress.ui.notify({
                                message: value.message,
                                type: 'error', // 'info', 'success', 'warning'
                                displayTime: 5000,
                            });
                        });
                    } else {
                        if (selectedRows.length > 2) {
                            // Replace the selected rows in their position with results.solution
                            selectedRows.forEach((row, index) => {
                                var rowIndex = data.findIndex(item => item.intSequence ===
                                    row.intSequence);
                                data[rowIndex] = results.solution[index];
                            });
                            gridRoutes.option('dataSource', data);
                        } else {
                            // Replace all rows with results.solution
                            gridRoutes.option('dataSource', results.solution);
                        }

                        // Renumber the rows
                        var rows = gridRoutes.option('dataSource');
                        rows.forEach((item, index) => {
                            item.intSequence = index;
                        });

                        gridRoutes.option('dataSource', rows);
                        gridRoutes.deselectAll();
                        gridRoutes.refresh();

                        setRoutesAndMarkers(rows);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }

        function setRoutesAndMarkers(data) {
            // Create an array to hold the markers
            let markers = [];

            // Iterate over each item in the data
            data.forEach(item => {
                // Construct the marker object for each item
                let marker = {
                    location: [parseFloat(item.fltLatitude), parseFloat(item.fltLongitude)],
                    label: item.intSequence,
                    color: 'rgb(194, 24, 5)',
                    tooltip: {
                        text: item.StoreName
                    }
                };

                // Push the marker object into the markers array
                markers.push(marker);
            });

            // Map markers to the format required by the map
            const result = markers.map(marker => ({
                location: marker.location,
                iconSrc: 'data:image/svg+xml;utf8,' + encodeURIComponent(
                    `<svg xmlns="http://www.w3.org/2000/svg" height="35" width="35" viewBox="0 0 384 512" fill="${marker.color}">
                    <path d="M384 192c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192z"/>
                    <text x="50%" y="240" fill="white" font-size="200" font-family="Arial" font-weight="bold" text-anchor="middle" alignment-baseline="middle">${marker.label}</text>
                    </svg>`
                ),
                tooltip: marker.tooltip
            }));

            // Extract locations for routes
            const locations = markers.map(marker => marker.location);

            if (data.length > 1) {
                const batchSize = 25;
                const batches = [];

                for (let i = 0; i < locations.length; i += batchSize) {
                    batches.push(locations.slice(i, i + batchSize));
                }

                batches.forEach((batch, index) => {
                    const routes = [{
                        weight: 6,
                        color: 'rgb(194, 24, 5)',
                        opacity: 0.5,
                        mode: 'driving',
                        locations: batch
                    }];

                    if (index === 0) {
                        // Set the initial routes and markers
                        mapRoutes.option('routes', routes);
                    } else {
                        // Add subsequent routes to the map
                        mapRoutes.addRoute(routes[0]);
                    }
                });
            }

            // Set markers on the map
            mapRoutes.option('markers', result);

        }

        function setSequence() {
            // This function sets the sequence of the Route!
            var gridData = gridRoutes.option('dataSource');

            if (gridData.length > 2) {
                gridData.shift();
                gridData.pop();

                var sortedSequence = [];

                var seq = 0;

                gridData.forEach((element, index, value) => {
                    sortedSequence.push({
                        'index': seq,
                        'orderId': element["OrderId"]
                    });
                    seq += 1;
                });

                $.ajax({
                    url: '{!! url('/sequenceStops') !!}',
                    type: "POST",
                    data: {
                        ordersToStop: sortedSequence
                    },

                    success: function(data) {
                        DevExpress.ui.notify({
                            message: 'Sucessfully Sequenced ' + data.count + ' Stops',
                            type: 'success', // 'info', 'success', 'warning'
                            displayTime: 3500,
                        });

                        location.reload();
                    }
                });

            } else {
                DevExpress.ui.notify({
                    message: 'Please Get Stops Before trying to Sequence',
                    type: 'error', // 'info', 'success', 'warning'
                    displayTime: 5000,
                });
            }
        }
    });
</script>
