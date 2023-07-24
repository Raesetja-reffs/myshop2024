<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <title></title>
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.39.1/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.39.1/mapbox-gl.css' rel='stylesheet' />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body { margin:0; padding:0; }
        #map { position:absolute; top:0; bottom:0; width:100%;height: 100% }
    </style>
</head>
<body>

        <div class="col-lg-12  visible-md visible-lg">

        </div> <div id='map'></div>


<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoicmVnaW5hbGRsIiwiYSI6ImNpZmpubGFkcDAxMHJ0dGtuOWo2MmZhenIifQ.KR-F3rA01DEbiHxc8n5NGA';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/dark-v9',
        center: [30.409300000000002,-29.578199999999999],
        zoom: 8
    });
    var url = '{!!url("/drone")!!}';
    map.on('load', function() {

        window.setInterval(function() {
            map.getSource('drone').setData(url);
        }, 2000);

        map.addSource('drone', { type: 'geojson', data: url });
        map.addLayer({
            "id": "drone",
            "type": "symbol",
            "source": "drone",
            "layout": {
                "icon-image": "rocket-15"
            }
        });
        // Add a new source from our GeoJSON data and set the
        // 'cluster' option to true. GL-JS will add the point_count property to your source data.
        map.addSource("earthquakes", {
            type: "geojson",
            // Point to GeoJSON data. This example visualizes all M1.0+ earthquakes
            // from 12/22/15 to 1/21/16 as logged by USGS' Earthquake hazards program.
            data:'{!!url("/geoJson")!!}',
            cluster: true,
            clusterMaxZoom: 14, // Max zoom to cluster points on
            clusterRadius: 50 // Radius of each cluster when clustering points (defaults to 50)
        });

        map.addLayer({
            id: "clusters",
            type: "circle",
            source: "earthquakes",
            filter: ["has", "point_count"],
            paint: {
                "circle-color": {
                    property: "point_count",
                    type: "interval",
                    stops: [
                        [0, "#51bbd6"],
                        [100, "#f1f075"],
                        [750, "#f28cb1"],
                    ]
                },
                "circle-radius": {
                    property: "point_count",
                    type: "interval",
                    stops: [
                        [0, 20],
                        [100, 30],
                        [750, 40]
                    ]
                }
            }
        });

        map.addLayer({
            id: "cluster-count",
            type: "symbol",
            source: "earthquakes",
            filter: ["has", "point_count"],
            layout: {
                "text-field": "{point_count_abbreviated}",
                "text-font": ["DIN Offc Pro Medium", "Arial Unicode MS Bold"],
                "text-size": 12
            }
        });

        map.addLayer({
            id: "unclustered-point",
            type: "circle",
            source: "earthquakes",
            filter: ["!has", "point_count"],
            paint: {
                "circle-color": "#11b4da",
                "circle-radius": 4,
                "circle-stroke-width": 1,
                "circle-stroke-color": "#fff"
            }
        });
    });
</script>

</body>
</html>
