@extends('layouts.base')
@section('title', 'Drivers Map')

@section('page')

    <div class="container-fluid h-100">
        <div class="row full-height bg-dark h-100">
            <div class="col-md-2 full-height p-2">
                <h3 class="text-white">DRIVERS MAP</h3>
                <div class="mb-3">
                    <label for="deliveryDate" class="form-label text-white">Delivery Date</label>
                    <input type="date" class="form-control" id="deliveryDate" aria-describedby="deliveryDateHelp">
                    <div id="deliveryDateHelp" class="form-text">Select a delivery date</div>
                </div>
                <div class="mb-3">
                    <label for="route" class="form-label text-white">Route</label>
                    <select id="route" class="form-select" aria-describedby="routeHelp">
                        <option></option>
                        @foreach ($routes as $route)
                            <option value="{{ $route->Route }}">{{ $route->Route }}</option>
                        @endforeach
                    </select>
                    <div id="routeHelp" class="form-text">Select a route</div>
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label text-white">Type</label>
                    <select id="type" class="form-select" aria-describedby="typeHelp">
                        <option></option>
                        @foreach ($ordertypes as $type)
                            <option value="{{ $type->OrderType }}">{{ $type->OrderType }}</option>
                        @endforeach
                    </select>
                    <div id="typeHelp" class="form-text">Select a route type</div>
                </div>
                <button id='btnGetRoute' class="btn btn-primary w-100 mb-2">GET ROUTE</button>

                <div class="w-100 bg-light p-2 rounded">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="chkPlanned">
                        <label class="form-check-label fw-bold text-primary" for="chkPlanned">
                            Planned Route
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="chkDelivered">
                        <label class="form-check-label fw-bold text-danger" for="chkDelivered">
                            Delivered Route
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="chkOptimized">
                        <label class="form-check-label fw-bold text-success" for="chkOptimized">
                            Optimized Route
                        </label>
                    </div>
                </div>

            </div>
            <div class="col-md-7 full-height p-0 overflow-auto" style="background-color: lightgrey;">
                <div id="map" style="height: 100%;"></div>
                
            </div>
            <div class="col-md-3 p-0 full-height mh-100">
                <div id="gridRoute"></div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

<style>
    #gridRoute {
        height: 100% !important;
        max-height: 100% !important;
    }

    .dx-datagrid{
        max-width: 100% !important;
    }
</style>


<!-- Firebase -->
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>

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

    let plannedMarkers = [];
    let plannedRoute = [];

    let deliveredMarkers = [];
    let deliveredRoute = [];

    let optimizedMarkers = [];
    let optimizedRoute = [];

    $(document).ready(function() {
        var today = new Date().toISOString().split('T')[0];
        $('#deliveryDate').val(today);

        $('#route').select2({
            theme: 'bootstrap-5',
        });

        $('#type').select2({
            theme: 'bootstrap-5',
        });

        var data = [];

        // Initilaze the datagrids whith Empty DataSet
        const gridRoute = $('#gridRoute').dxDataGrid({
            dataSource: data, //as json
            // showBorders: true,
            hoverStateEnabled: true,
            filterRow: { visible: true },
            filterPanel: { visible: true },
            headerFilter: { visible: true },
            allowColumnResizing: true,
            columnAutoWidth: true,
            scrolling: {
                rowRenderingMode: 'infinite',
            },
            paging:{
                pageSize: 1000,
            },    
            columns: [
                {
                    dataField: 'intSequence',
                    dataType: 'number',
                    caption: 'Seq',
                    customizeText: function (cellInfo) {
                        // Add 1 to the displayed value and return it as a string
                        return (parseInt(cellInfo.value) + 1).toString();
                    }
                },
                {
                    dataField: 'OrderId',
                    caption: 'Order Id',
                    visible: false,
                },
                {
                    dataField: 'id',
                    caption: 'Store Name',
                    width: 275,
                },
                {
                    dataField: 'dteOffloadedTime',
                    caption: 'Offload Time',
                },
                {
                    dataField: 'offloaded',
                    caption: 'Offloaded',
                    dataType: 'number',
                    visible: false,
                },{
                    dataField: 'lat',
                    caption: 'Latitude',
                    visible: false,
                },{
                    dataField: 'lng',
                    caption: 'Longitude',
                    visible: false,
                }
            ],
            onRowPrepared(e) {
                if (e.rowType == 'data' && e.data.offloaded ==1) {
                    e.rowElement.addClass('bg-success');
                    e.rowElement.addClass('text-white');
                }else if (e.rowType == 'data' && e.data.offloaded !=1) {
                    e.rowElement.addClass('bg-danger');
                    e.rowElement.addClass('text-white');
                }
                e.rowElement.addClass('fw-bold');
            },
            onRowDblClick: function (e) {
                console.debug(e);
            },
            onInitNewRow: function(e) {
                console.debug(e);
            },
            onRowInserting: function(e) {
                console.debug(e);
            },
            onRowInserted: function(e) {
                console.debug(e);
            },
            onRowUpdating: function(e) {
                console.debug(e);
            },
        }).dxDataGrid('instance');

        const companyMarker = [];

        companyMarker.push(
            {
                location: [{{ $companyLat }}, {{ $companyLng }}],
                label: 'LX',
                color: 'green',
                tooltip: {
                    text: '{{ $companyName }}',
                },
            },
        )

        const map = $('#map').dxMap({
            center: { lat: {{ $companyLat }}, lng: {{ $companyLng }} },
            zoom: 17,
            EnableScrolling: false,
            EnableZooming: false,
            EnablePanning: false,
            height:'600px',
            width: '100%',
            provider: 'google',
            apiKey: {
                google: "{{ env('GOOGLE_MAPS_API', 'NONE') }}",
            },
            markers: companyMarker.map(marker => ({
                location: marker.location,
                iconSrc: 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" height="35" width="35" viewBox="0 0 384 512" fill="' + marker.color + '"><path d="M384 192c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192z"/><text x="50%" y="240" fill="white" font-size="200" font-family="Arial" font-weight="bold" text-anchor="middle" alignment-baseline="middle">' + marker.label + '</text></svg>',
            })),
        }).dxMap('instance');

        $('#btnGetRoute').click(function(){
            var deliveryDate = $('#deliveryDate').val();
            var route = $('#route').val();
            var type = $('#type').val();

            getPlannedRoute(route, type, deliveryDate);
        });

        $('#chkPlanned').change(function() {
            if (this.checked) {
                addSetToMap(plannedMarkers, plannedRoute);
            } else {
                removeSetFromMap(plannedMarkers, plannedRoute);
            }
        });

        $('#chkDelivered').change(function() {
            if (this.checked) {
                addSetToMap(deliveredMarkers, deliveredRoute);
            } else {
                removeSetFromMap(deliveredMarkers, deliveredRoute);
            }
        });

        $('#chkOptimized').change(function() {
            if (this.checked) {
                addSetToMap(optimizedMarkers, optimizedRoute);
            } else {
                removeSetFromMap(optimizedMarkers, optimizedRoute);
            }
        });

        function getPlannedRoute(route,type,deliveryDate){
            
            $.ajax({
                url: '{!! url("/getLiveDriversInfo") !!}',
                type: "POST",
                data: {
                    route: route,
                    ordertype: type,
                    deldate: deliveryDate
                },
                success: function (data) {
                    console.log(data);

                    // var modifiedData = data.map(function(item) {
                    //     return {
                    //         OrderId: item.OrderId,
                    //         id: item.StoreName,
                    //         dteOffloadedTime : item.dteOffloadedTime,
                    //         intSequence : item.intSequence,
                    //         offloaded : item.offloaded,
                    //         lat: parseFloat(item.strLatitude),
                    //         lng: parseFloat(item.strLongitude),
                    //     };
                    // });

                    // console.log(modifiedData);

                    // gridRoute.option('dataSource', modifiedData);
                    // gridRoute.refresh();

                    // var stations = gridRoute.option("dataSource");

                    // var stops = stations.map(function (item) {
                    //     return {
                    //         lat: parseFloat(item.lat),
                    //         lng: parseFloat(item.lng),
                    //         name: item.id
                    //     };
                    // });

                    // var origin = {
                    //     lat: parseFloat('{{ $companyLat }}'),  // Replace with your desired value
                    //     lng: parseFloat('{{ $companyLng }}'), // Replace with your desired value
                    //     name: "{{ $companyName }}"  // Replace with your desired name
                    // };

                    // var destination = {
                    //     lat: parseFloat('{{ $companyLat }}'),  // Replace with your desired value
                    //     lng: parseFloat('{{ $companyLng }}'), // Replace with your desired value
                    //     name: "{{ $companyName }}"  // Replace with your desired name
                    // };

                    // stops.unshift(origin);
                    // stops.push(destination);

                    // // addToMap(stops, 'planned', '#0D6EFD')
                    // $("#chkPlanned").prop("checked", true);

                    // // getDeliveredRoute()
                    // $("#chkDelivered").prop("checked", true);

                    // // getOptimizedRoute()
                    // $("#chkOptimized").prop("checked", true);
                }
            });
            
        }
    });

</script>

@endsection