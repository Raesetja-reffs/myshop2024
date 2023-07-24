@extends('layouts.app')
<script type="text/javascript">
    //<![CDATA[


    <?php

    /*		HERE IS WHERE THE RESULTS ARE COLLECTED
    */
    $lat=array();
    $long=array();
    foreach($coordinates as $value){
        $lat[] = $value->fltLatitude;
        $long[] = $value->fltLongitude;
    }


    $latLongSize = sizeof($lat)-1;
    ?>
    function initMap() {

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: {lat: -33.935761, lng: 23.245972}
        });

        // Create an array of alphabetical characters used to label the markers.
        var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // Add some markers to the map.
        // Note: The code uses the JavaScript Array.prototype.map() method to
        // create an array of markers based on a given "locations" array.
        // The map() method here has nothing to do with the Google Maps API.
        var markers = locations.map(function(location, i) {
            return new google.maps.Marker({
                position: location,
                label: labels[i % labels.length]
            });

            var marker = new google.maps.Marker({
                position: location,
                label: labels[i % labels.length],
                title: cllis[i]
            });
            var contentString = 'which you can defined content you like';
            var infowindow = new google.maps.InfoWindow({ content: contentString });
            google.maps.event.addListener(marker, 'click', function(evt) {
                infowindow.open(map, marker); });
            return marker;


        });

        // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
    }
    var locations = [

            <?php

            for($i=0; $i<=$latLongSize; $i++){ ?>
        {lat: <?php echo $lat[$i];?>, lng: <?php echo $long[$i]; ?>},
        <?php } ?>
    ]
</script>
<!-- Replace following script src -->
<script src="https://unpkg.com/@google/markerclustererplus@5.1.0/dist/markerclustererplus.min.js"></script>

<script defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5vAgb-nawregIa5gRRG34wnabasN3blk&callback=initMap">
</script>
<style>
    .backgroudcolorOffloaded{
        background: #0bc90b;
        color: black;
    }
</style>
@section('content')

    <div class="col-lg-12 ">

        <div class="col-lg-2">
            Delivery Date<input id="deliverydate" >
        </div>
        <div  class="col-lg-2">
            <select  id="rouTabletLoadingtesonPlanning" class="form-control input-sm col-xs-1" name="multicheckbox[]" multiple="multiple" >

                @foreach($routes as $values)
                    <option value="{{$values->RouteId}}">{{$values->Route}}</option>
                @endforeach

            </select>
        </div>

        <button class="btn-lg btn-primary" id="submit">GO</button>
    </div>
    <div class="col-lg-12" style="display: flex">
        <div id="map"  style="width: 70%; height: 700px" class="col-lg-8 "></div>

        <div class="col-lg-4 ">
            <h4>Trip Info</h4>
           </div>
    </div>
@endsection

<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script type="text/javascript" charset="utf-8">
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    $(document).ready(function() {

        $("#deliverydate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });

        $('#rouTabletLoadingtesonPlanning').multiselect({
            columns: 1,
            placeholder: 'Select Route(s)',
            selectAll: true
        });
        $('#ordertypes').multiselect({
            columns: 1,
            placeholder: 'Select Delivery Type(s)',
            selectAll: true
        });
        $('#submit').click(function(){
            var routes = ($('#rouTabletLoadingtesonPlanning').val()).join();
            var ordertypes = ($('#ordertypes').val()).join();
            var dte = ($('#deliverydate').val());
            window.location = '{!!url("/mappage")!!}/'+dte+'/'+routes+'/'+ordertypes;

        });
    });
</script>
