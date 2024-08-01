<script>
    $(document).ready(function() {
        var routes = {!! json_encode($routes) !!};
        var types = {!! json_encode($types) !!};

        let markers = {
            sequenceGroup: [],
            actualGroup: [],
            optimizedGroup: []
        };

        const selectDeliveryDate = $("#selectDeliveryDate").dxDateBox({
            type: "date",
            label: "Date and time",
            displayFormat: 'yyyy-MM-dd',
            onValueChanged: function(e) {},
        }).dxDateBox("instance");

        const selectRoute = $("#selectRoute").dxSelectBox({
            dataSource: routes,
            valueExpr: "Route",
            displayExpr: "Route",
            label: "Route",
        }).dxSelectBox("instance");

        const selectType = $("#selectType").dxSelectBox({
            dataSource: types,
            valueExpr: "OrderType",
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
            height: '79vh',
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
            columns: [{
                dataField: 'intSequence',
                caption: 'Seq',
                dataType: 'number',
                allowEditing: false,
            }, {
                dataField: 'StoreName',
                caption: 'Store',
                allowEditing: false,
            }, {
                dataField: 'dteOffloadedTime',
                caption: 'Offload Time',
            }, {
                dataField: 'offloaded',
                caption: 'Offloaded',
                dataType: 'number',
                visible: false,
            }, {
                dataField: 'fltLatitude',
                caption: 'Latitude',
                visible: false,
            }, {
                dataField: 'fltLongitude',
                caption: 'Longitude',
                visible: false,
            }, {
                dataField: 'OrderId',
                caption: 'ID',
                visible: false,
                allowEditing: false,
            }, ],
            onRowPrepared(e) {
                if (e.data) {
                    if (e.data.strRowColor != null) {
                        e.rowElement.css("background-color", e.data.strRowColor);
                    }
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
            height: '75vh',
            apiKey: {
                google: "{{ env('GOOGLE_MAPS_API', 'NONE') }}",
            },
        }).dxMap('instance');

        const selectGroups = $('#selectGroups').dxTagBox({
            items: ['sequenceGroup', 'actualGroup', 'optimizedGroup'],
            disabled: true,
            placeholder: 'Select Groups',
            onValueChanged: function(e) {
                const selectedValues = e.value;
                if (selectedValues.includes('optimizedGroup') && (!markers['optimizedGroup'] ||
                        markers['optimizedGroup'].length === 0)) {
                    optimizeStops().then(() => {
                        updateMapMarkersAndRoutes(selectedValues);
                    }).catch(error => {
                        console.error('Error optimizing:', error);
                        updateMapMarkersAndRoutes(selectedValues);
                    });
                } else if (selectedValues.includes('actualGroup') && (!markers['actualGroup'] ||
                        markers['actualGroup'].length === 0)) {
                    setActualRoute().then(() => {
                        updateMapMarkersAndRoutes(selectedValues);
                    }).catch(error => {
                        console.error('Error setting actual route:', error);
                        updateMapMarkersAndRoutes(selectedValues);
                    });
                } else {
                    // Update the map markers and routes if no optimization is needed
                    updateMapMarkersAndRoutes(selectedValues);
                }
            }
        }).dxTagBox('instance');

        var initMarkers = [{
            fltLatitude: "{{ $companyLat }}",
            fltLongitude: "{{ $companyLng }}",
            StoreName: "{{ $companyName }}",
            intSequence: "{{ $companyAbv }}",
        }];

        setRoutesAndMarkers(initMarkers, '');

        function getStops() {
            $.ajax({
                url: '{!! url('/getLiveDriversInfo') !!}',
                type: "POST",
                data: {
                    route: selectRoute.option('value'),
                    ordertype: selectType.option('value'),
                    deldate: formatDate(selectDeliveryDate.option('value')),
                },
                success: function(results) {
                    results.unshift({
                        "OrderId": "0",
                        "StoreName": "{{ $companyName }}",
                        "fltLatitude": "{{ $companyLat }}",
                        "fltLongitude": "{{ $companyLng }}",
                        "intSequence": 0,
                    });

                    results.push({
                        "OrderId": "0",
                        "StoreName": "{{ $companyName }}",
                        "fltLatitude": "{{ $companyLat }}",
                        "fltLongitude": "{{ $companyLng }}",
                        "intSequence": results.length,
                    });

                    gridRoutes.option('dataSource', results);
                    gridRoutes.refresh();

                    selectGroups.option('disabled', false);
                    selectGroups.option('value', ['sequenceGroup']);

                    markers = {
                        sequenceGroup: [],
                        actualGroup: [],
                        optimizedGroup: []
                    };

                    setRoutesAndMarkers(results, '#4287f5', 'sequenceGroup');
                }
            });
        }

        function setRoutesAndMarkers(data, color, group) {
            // Create a new array for the specified group if it doesn't exist
            if (!markers[group]) {
                markers[group] = [];
            }

            // Iterate over each item in the data
            data.forEach(item => {
                // Construct the marker object for each item
                let marker = {
                    location: [parseFloat(item.fltLatitude), parseFloat(item.fltLongitude)],
                    label: item.intSequence,
                    color: color,
                    tooltip: {
                        text: item.StoreName
                    }
                };

                // Push the marker object into the specified group's markers array
                markers[group].push(marker);
            });

            // Map markers to the format required by the map
            const result = markers[group].map(marker => ({
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
            const locations = markers[group].map(marker => marker.location);

            if (data.length > 1) {
                const batchSize = 25;
                const batches = [];

                for (let i = 0; i < locations.length; i += batchSize) {
                    batches.push(locations.slice(i, i + batchSize));
                }

                batches.forEach((batch, index) => {
                    const routes = [{
                        weight: 6,
                        color: color,
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

        function updateMapMarkersAndRoutes(selectedGroups) {
            const allMarkers = [];
            const allRoutes = [];

            selectedGroups.forEach(group => {
                if (markers[group]) {
                    allMarkers.push(...markers[group]);

                    const locations = markers[group].map(marker => marker.location);
                    if (locations.length > 1) {
                        const batchSize = 25;
                        const batches = [];

                        for (let i = 0; i < locations.length; i += batchSize) {
                            batches.push(locations.slice(i, i + batchSize));
                        }

                        batches.forEach(batch => {
                            allRoutes.push({
                                weight: 6,
                                color: markers[group][0].color,
                                opacity: 0.5,
                                mode: 'driving',
                                locations: batch
                            });
                        });
                    }
                }
            });

            mapRoutes.option('routes', allRoutes);
            mapRoutes.option('markers', allMarkers.map(marker => ({
                location: marker.location,
                iconSrc: 'data:image/svg+xml;utf8,' + encodeURIComponent(
                    `<svg xmlns="http://www.w3.org/2000/svg" height="35" width="35" viewBox="0 0 384 512" fill="${marker.color}">
                <path d="M384 192c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192z"/>
                <text x="50%" y="240" fill="white" font-size="200" font-family="Arial" font-weight="bold" text-anchor="middle" alignment-baseline="middle">${marker.label}</text>
                </svg>`
                ),
                tooltip: marker.tooltip
            })));
        }

        function optimizeStops() {
            var data = gridRoutes.option('dataSource');

            $.ajax({
                url: '{!! url('/optimizeStops') !!}',
                type: "POST",
                data: {
                    routes: data,
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
                        results.solution.forEach((item, index) => {
                            item.intSequence = index;
                        });
                        setRoutesAndMarkers(results.solution, '#8bc34a', 'optimizedGroup');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }

        function setActualRoute() {
            var data = gridRoutes.option('dataSource');

            return new Promise((resolve, reject) => {
                try {
                    // Filter the data where the 'offloaded' column is "1"
                    var filteredData = $.grep(data, function(item) {
                        return item.offloaded === "1";
                    });

                    // Sort the filtered data by 'dteOffloadedTime'
                    filteredData.sort(function(a, b) {
                        var dateA = new Date(a.dteOffloadedTime);
                        var dateB = new Date(b.dteOffloadedTime);
                        return dateA - dateB;
                    });

                    console.log(filteredData);

                    setRoutesAndMarkers(filteredData, '#eb4034', 'actualGroup');
                    resolve();
                } catch (error) {
                    console.error('Error setting actual route:', error);
                    reject(error);
                }
            });
        }
    });
</script>
