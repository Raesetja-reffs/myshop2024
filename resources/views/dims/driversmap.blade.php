<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EON Maps</title>
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        #map {
            position:absolute;
            top:0;
            bottom:0;
            width:100%;
        }
        .onDrag {
            background: rgba(185, 182, 182, 0.54);
        }
        .backgroudcolorOffloaded{
            background:#fd00ff8a;
        }
    </style>

    <script type="text/javascript" src="https://pubnub.github.io/eon/v/eon/1.1.0/eon.js"></script>
    <script type="text/javascript" src="https://pubnub.github.io/eon/v/eon/1.1.0/eon.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>
    <link type="text/css" rel="stylesheet" href="https://pubnub.github.io/eon/v/eon/1.1.0/eon.css"/>
    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />



</head>
<body>
<div id="mapdata" >
<div id='map' style="height:100%;width: 75%;"></div>
<div id='info' style="float: right;width: 24%;">
    <fieldset> <legend>Parameters</legend>
        <label>Del Date</label><br><input type="text" id="deldate"><br>
        <label>Route</label><br><select id="route">
            <option value=""></option>
            @foreach($routes as $val)
                <option value="{{$val->Route}}">{{$val->Route}}</option>
                @endforeach
        </select><br>

        <label>Order Type</label><br><select id="ordertype">
            <option value=""></option>
            @foreach($ordertypes as $val)
                <option value="{{$val->OrderType}}">{{$val->OrderType}}</option>
            @endforeach
        </select><br>
    <button id="submitparams">Update</button>
    </fieldset>
    <table id="infotable">
        <thead>
        <th>STOP NAME</th>
        <th>OFFLOADED TIME</th>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

</div>
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#deldate").datepicker({
        changeMonth: true,//this option for allowing user to select month
        changeYear: true, //this option for allowing user to select from year range
        dateFormat: 'yy-mm-dd'
    });
    L.RotatedMarker = L.Marker.extend({
        options: { angle: 0 },
        _setPos: function(pos) {
            L.Marker.prototype._setPos.call(this, pos);
            if (L.DomUtil.TRANSFORM) {
                // use the CSS transform rule if available
                this._icon.style[L.DomUtil.TRANSFORM] += ' rotate(' + this.options.angle + 'deg)';
            } else if (L.Browser.ie) {
                // fallback for IE6, IE7, IE8
                var rad = this.options.angle * L.LatLng.DEG_TO_RAD,
                    costheta = Math.cos(rad),
                    sintheta = Math.sin(rad);
                this._icon.style.filter += ' progid:DXImageTransform.Microsoft.Matrix(sizingMethod=\'auto expand\', M11=' +
                    costheta + ', M12=' + (-sintheta) + ', M21=' + sintheta + ', M22=' + costheta + ')';
            }
        }
    });

    function getNonZeroRandomNumber(){
        var random = Math.floor(Math.random()*199) - 99;
        if(random==0) return getNonZeroRandomNumber();
        return random;
    }
    var config = {
        apiKey: "AIzaSyCRDe5bY68DecXG7VEfBCtYeOoRdhpDNnQ",
        authDomain: "dimsdriver-f4ac2.firebaseapp.com",
        databaseURL: "https://dimsdriver-f4ac2.firebaseio.com",
        projectId: "dimsdriver-f4ac2",
        storageBucket: "dimsdriver-f4ac2.appspot.com",
        messagingSenderId: "786093288643",
        appId: "1:786093288643:web:8d74c339505b31b9"
    };
    firebase.initializeApp(config);
</script>
<script>

    var pubnub = new PubNub({
        publishKey: 'pub-c-9980143d-ecda-4a95-b4b9-026ae6f7a4ff',
        subscribeKey: 'sub-c-fde66af2-c1e8-11e9-9b2b-52096338bc98'

    });

    function getNonZeroRandomNumber(){
        var random = Math.floor(Math.random()*199) - 99;
        if(random==0) return getNonZeroRandomNumber();
        return random;
    }

    var channel = 'pubnub-mapbox-' + getNonZeroRandomNumber();

    var map = eon.map({
        pubnub: pubnub,
        id: 'map',
        channels: [channel],
        connect: connect,
        options: {
            center: new L.LatLng(-27.0945715, 25.8002323),
            zoom: 7
        },
        provider: 'google',
        googleKey: 'AIzaSyC5vAgb-nawregIa5gRRG34wnabasN3blk',
        googleMutant: {
            type: 'roadmap',
            styles: [
                //{elementType: 'labels', stylers: [{visibility: 'off'}]},
               // {featureType: 'water', stylers: [{color: '#000000'}]}
            ]
        },marker: function (latlng, data,DelvDate,RouteName,OType) {

            var marker = new L.RotatedMarker(latlng, {

            });

            console.debug(data);
           // routeInfo(data[0],data[1],data[2]);
            marker.bindPopup('<button onclick="routeInfo(  \''+data[0]+  '\',\''+data[1]+ '\',\''+data[2]+ '\')" class="trigger">'+data[0]+" "+data[1]+" "+data[3]+'</button>'  );

            return marker;

        }

    });
    $('#submitparams').click(function(){
        routeInfo($('#route').val(),$('#ordertype').val(),$('#deldate').val());
    });

    function connect() {

        var me = {
            icon: {
                'marker-color': '#ce1126'
            }
        };
        var them = {
            icon: {
                'marker-color': '#29abe2'
            }
        };

        var myColumnDefs = new Array();

        setInterval(function(){
            var locationsRef = firebase.database().ref("Driver/users");
            locationsRef.on('child_added', function(snapshot) {
                var data = snapshot.val();
                myColumnDefs.push({latlng:[parseFloat(data.lat), parseFloat(data.lon)],stops:[data.stops]
                    ,dEmail:[data.email]
                    ,DelDate:[data.deldate]
                    ,route:[data.route]
                    ,ordertype:[data.ordertype]

                });
                console.log(myColumnDefs);
            });
            var new_torchys = JSON.parse(JSON.stringify(myColumnDefs));
            console.debug(new_torchys);
            for (var i = 0; i < new_torchys.length; i++) {

                new_torchys[i] = {
                    marker: new_torchys[i].marker,
                    latlng: [
                        new_torchys[i].latlng[0] ,
                        new_torchys[i].latlng[1] //new_torchys[i].route[0]+','+new_torchys[i].ordertype[0]+','+new_torchys[i].DelDate[0] + ' TCounts ('+new_torchys[i].stops[0]+')'
                    ],
                    data:[new_torchys[i].route[0],new_torchys[i].ordertype[0],new_torchys[i].DelDate[0],new_torchys[i].stops[0]]
                }

            }

            pubnub.publish({
                channel: channel,
                message: new_torchys
            });

            myColumnDefs = new Array();
        }, 10000);

    };

    function routeInfo(route,ordertype,deldate)
    {
//infotable
        $.ajax({
            url: '{!! url("/getLiveDriversInfo") !!}',
            type: "POST",
            data: {

                route: route,
                ordertype: ordertype,
                deldate: deldate

            },success: function (data) {
                var trHTML = '';
                $('#infotable tbody').empty();

                $.each(data, function (key, value) {
                    var classes = 'onDrag';

                    if (value.offloaded ==1)
                    {
                        classes = 'onDrag backgroudcolorOffloaded';
                    }
                    trHTML += '<tr class="'+classes+'" style="font-size: 15px;color:black"><td>' +
                        value.StoreName + '</td><td>' +
                        value.dteOffloadedTime + '</td>' +
                        '</tr>';

                });
                $('#infotable tbody').append(trHTML);
            }
        });
    }

</script>

</body>
</html>