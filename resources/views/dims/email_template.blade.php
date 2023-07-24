<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MyShop') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/grid.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/smoothcss.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/scroller.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet"  type='text/css'>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />



    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/jquery.zoomooz.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('js/commonScript.js') }}"></script>
    <script src="https://use.fontawesome.com/0f659c6d48.js"></script>


    <style>
        /*TAB*/
        li div.tab-frame input{ display:none;}
        li div.tab-frame label{ display:block; float:left;padding:5px 10px; cursor:pointer}
        li div.tab-frame input:checked + label{ background:black; color:white; cursor:default}
        li div.tab-frame div.tab{ display:none; padding:5px 10px;clear:left}

        li div.tab-frame input:nth-of-type(1):checked ~ .tab:nth-of-type(1),
        li div.tab-frame input:nth-of-type(2):checked ~ .tab:nth-of-type(2),
        li div.tab-frame input:nth-of-type(3):checked ~ .tab:nth-of-type(3),
        li div.tab-frame input:nth-of-type(4):checked ~ .tab:nth-of-type(4){ display:block;}
        /*END OF TABS*/
        .push_product{
            background: #c0dcd0;
        }
        .hidden_row {
            display: none;
        }
        .table-condensed{
            font-size: 10px;
        }

    </style>

</head>
<body>
<div class="container" style="width: 100%;">

    <div class="row">

</div>
<div class="col-lg-12" style="background: #e4e4e4">
    <div class="col-lg-12" style="background: #e4e4e4">

            <div class="row">
                <div class="col-xs-6" id="orderinfoAddress" style="font-size: 10px;">
                    {{$message[0]->StoreName}}

                </div>
                <div class="col-xs-6" id="orderinfo" style="font-size: 10px;">
                    <img src="{{ public_path() . '/images/logo.png' }}">
                </div>
            </div>

    <table class="table" id="tableQuotePreview">
<thead><tr>
        <th>Item Code</th>
        <th>Description</th>
        <th>Measure</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>PriceInc</th>
        <th>LineTotalInc</th></tr></thead>
        <tbody>
        @foreach($message as $value)
            <tr style="font-size: 11px;color:black;">
            <td>{{$value->PastelCode}}</td>
            <td>{{$value->PastelDescription}}</td>
            <td>{{$value->strUnitSize}}</td>
            <td>{{round($value->fltQuantity,2)}}</td>
            <td>{{round($value->fltPrice,2)}}</td>
            <td>{{round($value->fltPriceInc,2)}}</td>
            <td>{{round($value->priceIncLineTot,2)}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="col-md-5 pull-right hidebody">
        <table class="table table-condensed-footer">
            <tr>
                <td>Total In</td>
                <td>{{$total}}</td>
            </tr>
        </table>

    </div>
</div>
    </div>
</div>
</body>
</html>

