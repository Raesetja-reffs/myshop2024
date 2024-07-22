@extends('layouts.base')
@section('title', 'Route Optimisation')

@section('page')
    <div class="container-fluid h-100">
        <div class="row full-height bg-dark h-100">
            <div class="col-md-2 full-height p-2">
                <h3 class="text-white">ROUTE OPTIMIZATION</h3>
                <div class="mb-3">
                    <label for="deliveryDate" class="form-label text-white">Delivery Date</label>
                    <input type="date" class="form-control" id="deliveryDate" aria-describedby="deliveryDateHelp">
                    <div id="deliveryDateHelp" class="form-text">Select a date that you would like to view the otimized route</div>
                </div>
                <div class="mb-3">
                    <label for="routeId" class="form-label text-white">Route</label>
                    <select id="routeId" class="form-select" aria-describedby="routeHelp">
                        <option></option>
                        @foreach ($routes as $route)
                            <option value="{{ $route->Routeid }}">{{ $route->Route }}</option>
                        @endforeach
                    </select>
                    <div id="routeHelp" class="form-text">Select route to optimize or leave blank to optimize all routes</div>
                </div>
                <div class="mb-3">
                    <label for="typeId" class="form-label text-white">Type</label>
                    <select id="typeId" class="form-select" aria-describedby="typeHelp">
                        <option></option>
                        @foreach ($types as $type)
                            <option value="{{ $type->OrderTypeId }}">{{ $type->OrderType }}</option>
                        @endforeach
                    </select>
                    <div id="typeHelp" class="form-text">Select type or leave blank to optimize all types</div>
                </div>
                <button id='btnGetStops' class="btn btn-primary w-100">Get Stops</button>
            </div>
            <div class="col-md-6 full-height p-0 overflow-auto" style="background-color: lightgrey;">
                <div id="map" style="height: 100%;"></div>
                
            </div>
            <div class="col-md-4 p-0 full-height mh-100 p-2">
                <div id="gridRoute"></div>
                <div class="d-inline-flex w-100">
                    <button id='btnOptimize' class="btn btn-primary w-50 mt-2 me-2" disabled>Optimize Route</button>
                    <button id='btnUpdateMap' class="btn btn-primary w-50 mt-2" disabled>Update Map</button>
                </div>
                
                <button id='btnUpdateSequence' class="btn btn-primary w-100 mt-2" disabled>Update Sequence</button>
                
            </div>
        </div>
    </div>

    {{-- <div class="modal fade modal-lg" id="stopsModal" aria-labelledby="newuserLabel" aria-hidden="true"  tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newuserLabel">STOPS TO OPTIMIZE</h1>
                    <button class="btn btn-primary mx-3" id="btnOpenMaps">OPEN MAPS</button>
                    <button type="button" class="btn-close closestopsModal" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="gridStops"></div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100" id="btnOptimize">OPTIMIZE</button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('scripts')

<style>
    #gridRoute {
        height: 90%;
        max-height: 100% !important;
    }

    .dx-datagrid{
        max-width: 100% !important;
    }

    .non-draggable-row {
        /* Add your custom styling for non-draggable rows here */
        background-color: #eee; /* Example: change the background color */
        /* ... */
    }
</style>

<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API', 'NONE') }}&libraries=places"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('focus', ':input', function() {
        $(this).attr('autocomplete', 'off');
    });

    let map;
    let service;
    let markers = [];
    let renderer;

    $(document).ready(function() {
        $('#routeId').select2({
            theme: 'bootstrap-5',
        });

        $('#typeId').select2({
            theme: 'bootstrap-5',
        });

        loadMap();

        let gridData = [];

        const gridRoute = $('#gridRoute').dxDataGrid({
            dataSource: gridData, //as json
            showBorders: true,
            keyExpr: 'sequence',
            hoverStateEnabled: true,
            filterRow: { visible: true },
            filterPanel: { visible: true },
            headerFilter: { visible: true },
            allowColumnResizing: true,
            columnAutoWidth: true,
            scrolling: {
                mode: 'virtual', // Enable infinite scrolling
            },
            paging:{
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
                    const toIndex = gridData.findIndex((item) => item.sequence === visibleRows[e.toIndex].data.sequence);
                    const fromIndex = gridData.findIndex((item) => item.sequence === e.itemData.sequence);

                    if (toIndex === 0 || toIndex === gridData.length - 1) {
                        e.cancel = true;
                        return;
                    }

                    if (fromIndex === 0 || fromIndex === gridData.length - 1) {
                        e.cancel = true;
                        return;
                    }

                    gridData.splice(fromIndex, 1);
                    gridData.splice(toIndex, 0, e.itemData);

                    // Update sequence numbers
                    gridData.forEach((item, index) => {
                        if (index !== 0 && index !== gridData.length - 1) {
                            item.sequence = index;
                        }
                    });

                    e.component.refresh();
                },
            },
            columns: [
                {
                    type: 'buttons',
                    width: 50,
                    buttons: ['edit'],
                    fixed: true,
                },
                {
                    dataField: 'OrderId',
                    caption: 'ID',
                    visible: false,
                    allowEditing: false,
                },
                {
                    dataField: 'sequence',
                    caption: 'Seq',
                    allowEditing: false,
                },
                {
                    dataField: 'id',
                    caption: 'Store',
                    allowEditing: false,
                },
                {
                    dataField: 'lat',
                    caption: 'Latitude',
                    // visible: false,
                },
                {
                    dataField: 'lng',
                    caption: 'Longitude',
                    // visible: false,
                },
                {
                    dataField: 'latlng',
                    caption: 'LatLng',
                    visible: false,
                    calculateCellValue: function(data) {
                        return data.lat + ', ' + data.lng;
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
            ],
            onEditingStart: function(e) {
                if (e.key == 0 || e.key == e.component.totalCount() - 1) {
                    e.cancel = true;
                    alert('Cannot Edit company details');
                } else {
                    gridRoute.columnOption('lat', 'visible', false);
                    gridRoute.columnOption('lng', 'visible', false);
                    gridRoute.columnOption('latlng', 'visible', true);
                }
            },
            onRowUpdating: function(e) {
                const newValues = e.newData;
                const latLngString = newValues.latlng; // Assuming that you'll provide latitude and longitude as a single comma-separated string in this field
                const latLngArray = latLngString.split(', ');

                // Set latitude and longitude separately
                newValues.lat = latLngArray[0];
                newValues.lng = latLngArray[1];
            },
            onRowUpdated: function(e) {
                gridRoute.columnOption('lat', 'visible', true);
                gridRoute.columnOption('lng', 'visible', true);
                gridRoute.columnOption('latlng', 'visible', false);

                console.log(e.data);

                DevExpress.ui.dialog.confirm("Would you like to update the customer coordinates?", "Confirmation").then((result) => {
                    if (result) {
                        $.ajax({
                            url: '{!! url("/updateCustomerGeoCoordinates") !!}' ,
                            type: "POST",
                            data: {
                                OrderId: e.data.OrderId,
                                lat: e.data.lat,
                                lng: e.data.lng

                            }, // No need to send data in the request body
                            success: function (response) {
                                DevExpress.ui.notify('Customer Location Updated');
                            },
                            error: function(xhr, status, error) {
                                DevExpress.ui.notify('Failed To Update Customer Location')
                            }
                        });
                    }
                });
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
        }).dxDataGrid('instance');

        var today = new Date().toISOString().split('T')[0];
        $('#deliveryDate').val(today);

        $('#btnGetStops').click(function(){
            var deliveryDate = $('#deliveryDate').val();
            var routeId = $('#routeId').val();
            var typeId = $('#typeId').val();

            getRoutesToOptimize(deliveryDate, routeId, typeId);
            loadMap();
            
            $('#btnOptimize').prop('disabled', false);
            $('#btnUpdateMap').prop('disabled', false);
            $('#btnUpdateSequence').prop('disabled', false);
        });

        $('#btnOptimize').click(function(){
            var data = gridRoute.option("dataSource");       

            $.each(data, function(index, item) {
                item.sequence = index;
                item.fltLatitude = item.lat;
                item.fltLongitude = item.lng;
                item.id = item.StoreName;
            });

            var data = data.slice(1, -1);

            // console.log(data);

            optimizeRoutes(data);
        });

        $('#btnUpdateMap').click(function(){
            addToMap();
        });

        $('#btnUpdateSequence').click(function(){
            updateSequence();
        });

        function getRoutesToOptimize(deliveryDate, routeId, typeId){
            $('#overlay').prop('hidden', false);
            $.ajax({
                url: '{!!url("/getRoutesToOptimize")!!}',
                type: "GET",
                data: {
                    deliveryDate: $('#deliveryDate').val(),
                    routeId: $('#routeId').val(),
                    typeId: $('#typeId').val(),
                    api: 'routific'
                },
                success: function (results) {
                    $('#overlay').prop('hidden', true);

                    if (results.length === 0) {
                        alert("No results found");
                    }else{

                        results.unshift(
                            {
                                "OrderId" : "0",
                                "StoreName" : "{{ $companyName }}",
                                "fltLatitude" : "{{ $companyLat }}",
                                "fltLongitude" : "{{ $companyLng }}"
                            }
                        );

                        results.push(
                            {
                                "OrderId" : "0",
                                "StoreName" : "{{ $companyName }}",
                                "fltLatitude" : "{{ $companyLat }}",
                                "fltLongitude" : "{{ $companyLng }}"
                            }
                        );

                        loadStopsToGrid(results);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }

        function optimizeRoutes(data) {
            var data = $.map(data, function(item) {
                return { 
                    StoreName: item.StoreName,
                    fltLatitude: item.fltLatitude,
                    fltLongitude: item.fltLongitude,
                    OrderId: item.OrderId,
                };
            });

            var jsonData = JSON.stringify(data);

            $.ajax({
                url: '{!! url("/optimizeStops") !!}' ,
                type: "POST",
                data: {
                    routes: jsonData,
                }, // No need to send data in the request body
                success: function (response) {
                    // Handle the response
                    if (response.issues) {
                        $.each(response.issues, function(index, value) {
                            alert(value.message);
                        });
                    } else {
                        loadDatatoGrid(response);
                        addToMap();
                    }
                    $('#overlay').prop('hidden', true);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }

        function loadDatatoGrid(data){
            $.each(data.results[0].waypoints, function(index, item) {
                item.fltLatitude = item.lat.toString();
                item.fltLongitude = item.lng.toString();
                item.StoreName = item.id;
            });

            gridRoute.option('dataSource', data.results[0].waypoints);
            gridRoute.refresh();

            gridData = gridRoute.option("dataSource");
        }

        function loadStopsToGrid(data){
            $.each(data, function(index, item) {
                item.sequence = index;
                item.lat = item.fltLatitude;
                item.lng = item.fltLongitude;
                item.id = item.StoreName;
            });

            // console.log(data);

            gridRoute.option('dataSource', data);
            gridRoute.refresh();

            gridData = gridRoute.option("dataSource");
        }

        function addToMap() {
            var stops = gridRoute.option("dataSource");

            var origin = {
                lat: parseFloat(stops[0].lat),
                lng: parseFloat(stops[0].lng),
                name: stops[0].id
            };

            var destination = {
                lat: parseFloat(stops[stops.length - 1].lat),
                lng: parseFloat(stops[stops.length - 1].lng),
                name: stops[stops.length - 1].id
            };
            
            var stations = stops.slice(1, stops.length - 1).map(function (item) {
                return {
                    lat: parseFloat(item.lat),
                    lng: parseFloat(item.lng),
                    name: item.id
                };
            });

            loadMap();

            const infoWindow = new google.maps.InfoWindow();

            // Zoom and center map automatically by stations (including origin and destination)
            var allStations = [origin, ...stations, destination];
            var lngs = allStations.map(function(station) { return station.lng; });
            var lats = allStations.map(function(station) { return station.lat; });
            map.fitBounds({
                west: Math.min.apply(null, lngs),
                east: Math.max.apply(null, lngs),
                north: Math.min.apply(null, lats),
                south: Math.max.apply(null, lats),
            });

            // Create an object to keep track of marker positions and their counts
            const markerPositions = {};

            // Show optimizedRoute on the map as markers
            allStations.forEach((station, i) => {
                const positionKey = `${station.lat}_${station.lng}`;
                let label;
                let title; 

                if (i === 0) {
                    label = `{{ $companyAbv }}`; // Abbreviated label "GE" for the first marker
                    title = `{{ $companyName }}`;
                } else if (i === allStations.length - 1) {
                    label = 'D'; // Abbreviation for Destination
                    title = `Destination: ${station.name}`;
                } else {
                    label = `${i}`; // Use index for other markers
                    title = `STOP ${i}: ${station.name}`;
                }

                if (markerPositions[positionKey]) {
                    // If a marker at this position already exists, assign an abbreviated label
                    // markerPositions[positionKey].label.text += `, ${label}`;
                } else {
                    // If no marker exists at this position, create a new one
                    const marker = new google.maps.Marker({
                        position: station,
                        map: map,
                        title: `${title}`,
                        label: {
                            text: `${label}`,
                            fontWeight: 'bold',
                        },
                    });

                    marker.addListener("click", () => {
                        infoWindow.close();
                        infoWindow.setContent(marker.getTitle());
                        infoWindow.open(map, marker);
                    });

                    markerPositions[positionKey] = marker;
                }
            });

            // Convert the marker positions object to an array of markers and store it in the markers array
            markers.length = 0;
            Object.keys(markerPositions).forEach((positionKey) => {
                markers.push(markerPositions[positionKey]);
            });

            // Divide route to several parts because max stations limit is 25 (23 waypoints + 1 origin + 1 destination)
            for (var i = 0, parts = [], max = 25 - 1; i < allStations.length; i = i + max)
                parts.push(allStations.slice(i, i + max + 1));

            // Service callback to process service results
            var service_callback = function(response, status) {
                if (status != 'OK') {
                    console.log('Directions request failed due to ' + status);
                    return;
                }
                var renderer = new google.maps.DirectionsRenderer;
                renderer.setMap(map);
                renderer.setOptions({ suppressMarkers: true, preserveViewport: true });
                renderer.setDirections(response);
            };

            // Send requests to service to get route (for stations count <= 25 only one request will be sent)
            for (var i = 0; i < parts.length; i++) {
                // Waypoints does not include first station (origin) and last station (destination)
                var waypoints = [];
                for (var j = 1; j < parts[i].length - 1; j++)
                    waypoints.push({location: parts[i][j], stopover: false});
                // Service options
                var service_options = {
                    origin: parts[i][0],
                    destination: parts[i][parts[i].length - 1],
                    waypoints: waypoints,
                    travelMode: 'WALKING'
                };
                // Send request
                service.route(service_options, service_callback);
            }

            $('#overlay').prop('hidden', true);
        }

        function loadMap(){
            // Specify the latitude and longitude for the map center
            var companyLatLng = { lat: {{ $companyLat }}, lng: {{ $companyLng }} }; // Replace with your desired coordinates

            // Create a map object and associate it with the "map" div
            service = new google.maps.DirectionsService;
            map = new google.maps.Map(document.getElementById('map'), {
                center: companyLatLng,
                zoom: 12, // You can adjust the initial zoom level
            });

            const infoWindow = new google.maps.InfoWindow();

            const marker = new google.maps.Marker({
                position: companyLatLng,
                map: map,
                title: `{{ $companyName }}`,
                label: {
                    text: `{{ $companyAbv }}`,
                    fontWeight: 'bold',
                },
            });

            marker.addListener("click", () => {
                infoWindow.close();
                infoWindow.setContent(marker.getTitle());
                infoWindow.open(map, marker);
            });
        }

        function updateSequence(){
            gridData = gridRoute.option("dataSource");

            orders = $.grep(gridData, function(order) {
                return order.OrderId !== 'STARTLOCATION';
            });

            var newSequence = new Array();

            var seq = 0;

            orders.forEach((element, index, value) => {
                
                newSequence.push({
                    'OrderId':element["OrderId"],
                    'seq' : seq,
                });

                seq += 1;
            });

            $.ajax({
                url: '{!!url("/updateRouteToOptimizedSequence")!!}',
                type: "POST",
                data: {
                    newSequence: newSequence,
                },
                success: function (data) {
                    if(data[0].Result == "Success"){
                        location.reload();
                    }else{
                        alert(""+data[0].Result);
                    }
                }
            });
        }

    });
</script>

@endsection