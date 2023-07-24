<!DOCTYPE html>
<html>
<head>
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .rag-red {
            background-color: #f00f0c;
        }
        .rag-green {
            background-color: lightgreen;
        }
        .rag-amber {
            background-color: lightsalmon;
        }
        .rag-yellow {
            background-color: #f6ff23;
        }

        .rag-red-outer .rag-element {
            background-color: lightcoral;
        }

        .rag-green-outer .rag-element {
            background-color: lightgreen;
        }

        .rag-amber-outer .rag-element {
            background-color: lightsalmon;
        }

    </style>
</head>
<body style="font-family: Sans-serif">
<h2>Extra information For Item {{$code}} </h2>


   <input type="hidden" id="prodid" value="{{$prodid}}">
<button class="btn btn-lg btn-primary" id="printbarcode">Print Barcode</button>

<fieldset>
    <legend>Product Summary Information</legend>
<div id="ProductInfo">
    @foreach($productextrainfo as $val)
        <label>Product Picking Team</label><br>
        <select id="teams">
            <option value="{{$val->PickingTeamId}}">{{$val->theRealPickingTeam}}</option>
            @foreach($teams as $val2)
                <option value="{{$val2->PickingTeamId}}"> {{$val2->PickingTeam}}</option>
            @endforeach
        </select><br>
        <label>Product Bin</label><br>
        <select id="bins">
            <option value="{{$val->Binnumber}}">{{$val->Binnumber}}</option>

        </select>
        <label>Product Margin</label><br>
        <input id="prodMargin" value="{{$val->ProductMargin}}" ><br>
    @endforeach
    <button class="btn-success" style="background: green;
    color: white;
    font-weight: 900;
    padding: 4px 71px;
    margin-top: 12px;"  id="btnsavesummary">Save</button>
</div>
</fieldset>
<div id="myGrid" style="height: 700px;width:95%;" class="ag-theme-balham"></div>

<fieldset>
    <legend>Crowd Favourites</legend>
    <h5>Please Mark This Item To Appear On The Online For Everyone</h5>
    <input type="checkbox" id="markitpublic" value="0"><button class="btn-success btn-lg" id="savepublicproduct">Save</button>
</fieldset>
<script type="text/javascript" charset="utf-8">

   $(document).ready(function() {
      //  $('#myGrid').hide();

       $('#printbarcode').click(function(){
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });
           $.ajax({
               url: '{!!url("/printbarcode")!!}',
               type: "POST",
               data:{
                   productId:$('#printbarcode').val()

               },
               success: function(data) {

                   alert("Document sent to the printer");
               }
           });
       });

       $('input[type="checkbox"]').click(function(){
           if($(this).prop("checked") == true){
               $('#markitpublic').val(1);
           }
           else if($(this).prop("checked") == false){
               $('#markitpublic').val(0);
           }
       });
       $('#savepublicproduct').click(function(){
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });
           $.ajax({
               url: '{!!url("/crowdpromotion")!!}',
               type: "POST",
               data:{
                   markitpublic:$('#markitpublic').val(),
                   productId:$('#prodid').val()

               },
               success: function(data) {
                   console.log(data);
                   var trHTML = 'Saved';
                   $.each(data, function (keyDetails, valueDetails) {

                        trHTML += '<h5>'+valueDetails.strDesc+'<h5><br>';

                   });
                   var dialog = $('<p><strong style="color:red">trHTML</strong></p>').dialog({
                       height: 200, width: 700,modal: true,containment: false,
                       buttons: {
                           "Okay": function () {
                               dialog.dialog('close');
                           }
                       }
                   });

                  // alert("Document sent to the printer");
               }
           });
       });

       $('#btnsavesummary').click(function(){
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });
           $.ajax({
               url: '{!!url("/updateproductsummary")!!}',
               type: "GET",
               data:{
                   productId:$('#prodid').val(),
                   bin:$('#bins').val(),
                   teams:$('#teams').val(),
                   prodMargin:$('#prodMargin').val()

               },
               success: function(data) {

                   alert("saved");
               }
           });
       });

   });
    var columnDefs = [
        {headerName: "Ware House", field: "Warehouse",width: 180},
        {headerName: "Location", field: "locationName",width: 180},
        {headerName: "Available", field: "Available",width: 90},
        {headerName: "In stock", field: "Instock",width: 90},
        {headerName: "Cost", field: "Cost",width: 90}
    ];

    // let the grid know which columns and what data to use
    var gridOptions = {
        columnDefs: columnDefs,
        floatingFilter: true,
        enableSorting: true,
        enableFilter: true,
        enableColResize: true

    };

      //  $( "#myGrid" ).empty();
     //   $('#myGrid').show();
        // specify the columns

        // lookup the container we want the Grid to use
        var eGridDiv = document.querySelector('#myGrid');
        new agGrid.Grid(eGridDiv, gridOptions);
        var productid = $('#prodid').val();
        // create the grid passing in the div to use together with the columns & data we want to use

        fetch('{!!url("/getproductextrainformation")!!}/'+productid).then(function (response) {
            return response.json();
        }).then(function (data) {
            console.debug(data);
            gridOptions.api.setRowData(data);
        });




</script>
</body>
</html>