<!DOCTYPE html>
<html>
<head>
    <title>Waypoints in Directions</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <style type="text/css">
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 4px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
        #right-panel {
            font-family: "Roboto", "sans-serif";
            line-height: 30px;
            padding-left: 10px;
        }

        #right-panel select,
        #right-panel input {
            font-size: 15px;
        }

        #right-panel select {
            width: 100%;
        }

        #right-panel i {
            font-size: 12px;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #map {
            height: 100%;
            float: left;
            width: 50%;
            height: 100%;
        }

        #right-panel {
            margin: 20px;
            border-width: 2px;
            width: 40%;
            height: 400px;
            float: left;
            text-align: left;
            padding-top: 0;
        }

        #directions-panel {
            margin-top: 10px;
            background-color: #ffee77;
            padding: 10px;
            overflow: scroll;
            height: 174px;
        }
    </style>
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <script>
        var alphas = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
        var storenames= JSON.stringify({!! json_encode($storenames) !!});
        console.debug(storenames);
        var zoomlat = -15.406667319980695;
        var zoomlon = 28.276175907525925;
        function initMap() {
            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer();
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 6,
                center: { lat:zoomlat, lng: zoomlon },
            });
            directionsRenderer.setMap(map);
            document.getElementById("submit").addEventListener("click", () => {
                calculateAndDisplayRoute(directionsService, directionsRenderer);
            });
        }

        function calculateAndDisplayRoute(directionsService, directionsRenderer) {
            var finalDataProductTest = '';

            const waypts = [];
            const checkboxArray = document.getElementById("waypoints");
            var jArray = JSON.stringify({!! json_encode($all) !!});


            /* waypts.push({
                 location: new google.maps.LatLng(-34.0264,23.3812),
                 stopover: true,
             });
             waypts.push({
                 location: new google.maps.LatLng(-34.0505,23.358),
                 stopover: true,
             });
             waypts.push({
                 location: new google.maps.LatLng(-34.0102,23.3729),
                 stopover: true,
             });
             waypts.push({
                 location: new google.maps.LatLng(-34.0552,23.372),
                 stopover: true,
             });
   waypts.push({
                 location: new google.maps.LatLng(-34.0549,23.3719),
                 stopover: true,
             });
 */
            finalDataProductTest = $.map(JSON.parse(jArray), function (item) {
                return {
                    fltLatitude: item.fltLatitude,
                    fltLongitude: item.fltLongitude
                }

            });
            console.debug(finalDataProductTest);
            //console.debug(waypts);
            for (let i = 0; i < finalDataProductTest.length; i++) {
                console.debug( finalDataProductTest[i].fltLatitude);
                console.debug( finalDataProductTest[i].fltLongitude);
                // if (checkboxArray.options[i].selected) {
                waypts.push({
                    location: new google.maps.LatLng(parseFloat(finalDataProductTest[i].fltLatitude),  parseFloat(finalDataProductTest[i].fltLongitude) ),
                    stopover: true,
                });
                // }
            }
            /*  for (let i = 0; i < checkboxArray.length; i++) {
                   console.debug( checkboxArray[i].value);
                   if (checkboxArray.options[i].selected) {
                       waypts.push({
                           location: new google.maps.LatLng(parseFloat(checkboxArray[i].value) ),
                           stopover: true,
                       });
                   }
               }*/
            var f = (finalDataProductTest.length)-1;
            console.debug("Lat Point"+f);
            const selectedOpt =$('#routeoptimize').val();
            var blnisopt = false;
            // alert(selectedOpt);
            if(selectedOpt =="yes")
            {
                //alert(selectedOpt);
                blnisopt = true;
            }
            directionsService.route(
                {
                    origin: new google.maps.LatLng(<?php  echo env('LATLON'); ?>),
                    //origin: new google.maps.LatLng(document.getElementById("start").value),
                    destination: new google.maps.LatLng(parseFloat(finalDataProductTest[f].fltLatitude),  parseFloat(finalDataProductTest[f].fltLongitude) ),
                    //destination: new google.maps.LatLng(document.getElementById("end").value),
                    waypoints: waypts,
                    optimizeWaypoints: blnisopt,
                    travelMode: google.maps.TravelMode.DRIVING,
                },
                (response, status) => {
                    if (status === "OK" && response) {
                        directionsRenderer.setDirections(response);

                        console.debug(response.routes[0].waypoint_order);
                        const route = response.routes[0];
                        const summaryPanel = document.getElementById("directions-panel");
                        summaryPanel.innerHTML = "";

                        // For each route, display summary information.
                        for (let i = 0; i < route.legs.length; i++) {
                            const routeSegment = i + 1;
                            summaryPanel.innerHTML +=
                                "<b>Route explanation: " + routeSegment + "</b><br>";
                            summaryPanel.innerHTML += route.legs[i].start_address + " to ";
                            summaryPanel.innerHTML += route.legs[i].end_address + "<br>";
                            summaryPanel.innerHTML +=
                                route.legs[i].distance.text + "<br><br>";
                        }

                        //Restructuring  //alphas
                        var trHTML ='';
                        $('#optimized tbody').empty();
                        for (k = 0; k<response.routes[0].waypoint_order.length;k++)
                        {
                            trHTML += '<tr role="row" style="height: 26px !important;"  ><td>' +
                                alphas[k] + '</td><td>' +
                                JSON.parse(storenames)[response.routes[0].waypoint_order[k]] + '</td></tr>';
                            //console.debug(JSON.parse(storenames)[response.routes[0].waypoint_order[k]]);
                        }
                        $('#optimized tbody').append(trHTML);

                    } else {
                        window.alert("Directions request failed due to " + status);
                    }
                }
            );

        }
    </script>
</head>
<body>


<div id="map"></div>
<div id="right-panel">
    <div style="display:flex;">
        <div>
            <select id="routeoptimize">
                <option value="no">Use My Route Planner Sequence</option>
                <option value="yes">Auto Optimize</option>
            </select>
            <input type="submit" id="submit" />
            <table  id = "tableRoutePlan">
                <thead>
                <tr>

                    <th class="col-md-4" id="facility_header"  style="font-size: 10px;">Customer</th>

                    <th style="font-size: 10px;">OrderIDs</th>


                    <th style="font-size: 10px;">Seq</th>
                    <th style="font-size: 10px;color:blue;">Mass</th>
                    <th style="font-size: 10px;color:red;">OrderValue</th>
                    <th style="font-size: 10px;color:blue;">Address</th>

                </tr>
                </thead>

                <tbody>
                @foreach($all as $value)
                    <tr style = "font-size:11px;">

                        <td>{{$value->StoreName}}</td>

                        <td>{{$value->OrderId}}</td>

                        <td>{{$value->DeliverySequence}}</td>
                        <td>{{round($value->Mass,3)}}</td>
                        <td>{{round($value->OrderValue,2)}}</td>
                        <td>{{$value->deliveryAddress1}}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <div>
            <h4>Route Optimization Suggestions</h4>
            <hr style="border:2px solid black;">
            <table  id = "optimized">
                <thead>
                <tr>

                    <th>Letter</th>
                    <th class="col-md-4"  style="font-size: 10px;">Customer</th>

                </tr>
                </thead>

                <tbody>


                </tbody>
            </table>
        </div>
    </div>
    <div id="directions-panel">

    </div>
</div>

<!-- Async script executes immediately and must be after any DOM elements used in callback. -->
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5vAgb-nawregIa5gRRG34wnabasN3blk&callback=initMap&libraries=&v=weekly"
    async
></script>
</body>
</html>
