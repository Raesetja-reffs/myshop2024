<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" type="text/css" />
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

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
        }

        th, td {
            text-align: left;
            border: 1px solid #dddddd;

        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }
        .table-container{
            height: 200px;
            overflow: scroll;
        }

        tr.row_selectedYellowish td{background-color:#91ff00 !important;}

        .wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
        }
    </style>
</head>
<body style="font-family: Sans-serif">
<?php
if ((Auth::guest()))
{

}else{
    $v  =  new \App\Http\Controllers\SalesForm();
    $warehouse = $v->getThings(Auth::user()->GroupId,'Warehousereport');
    $salesreport = $v->getThings(Auth::user()->GroupId,'sales reports');
    $outofstock = $v->getThings(Auth::user()->GroupId,'Out of stock report');
    $routeandLoading = $v->getThings(Auth::user()->GroupId,'Route And Loading Report');
    $routeandLoading = $v->getThings(Auth::user()->GroupId,'Route And Loading Report');
    $strictlymanagers = $v->getThings(Auth::user()->GroupId,'strictly managers');
}
?>
<h2>Reports Screen</h2>
<div class="wrapper">
    @if($strictlymanagers != "0")
    <div><h3>Management</h3>
        <a href='{!!url("/viewStatusReport")!!}'  onclick="window.open(this.href, 'consolidatedreport',
'left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;" style="text-decoration: underline">Progress and Status Report</a>
    </div>
    @endif

    @if ($salesreport != "0")
    <div><h3>Sales</h3>
        <a style="text-decoration: underline" href='{!!url("/salesPerformanceview")!!}'  onclick="window.open(this.href, 'telesalesperformance',
'left=20,top=20,width=1200,height=1000,toolbar=1,resizable=0'); return false;">Sales Performance</a><br>
 <a style="text-decoration: underline" href='{!!url("/getreportAuthBelowMargin")!!}'  onclick="window.open(this.href, 'getreportAuthBelowMargin',
'left=20,top=20,width=1200,height=1000,toolbar=1,resizable=0'); return false;">Authorization Of Orders/Products Below Minimum GP%</a><br>

        <a style="text-decoration: underline" href='{!!url("/getOrderPlacedAfterCutOff")!!}'  onclick="window.open(this.href, 'getOrderPlacedAfterCutOff',
'left=20,top=20,width=1200,height=1000,toolbar=1,resizable=0'); return false;">Orders After Cut-off time</a><br>
    </div>
    @endif

    <div><h3>Warehouse and Dispatch</h3>
        @if ($outofstock != "0")
        <a style="text-decoration: underline" href='{!!url("/getNoStockItem")!!}'  onclick="window.open(this.href, 'nostocks',
'left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">No Stock Item</a><br>
        @endif
        <a style="text-decoration: underline" href='{!!url("/getShortLoadedReport")!!}'  onclick="window.open(this.href, 'getShortLoadedReport',
'left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">Short Loaded</a><br>
        <a style="text-decoration: underline" href='{!!url("/getDriverBIReport")!!}'  onclick="window.open(this.href, 'getDriverBIReport',
'left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">Drivers BI Report</a><br>

        @if ($routeandLoading != "0")
        <a style="text-decoration: underline" href='{!!url("/viewStatusReport")!!}'  onclick="window.open(this.href, 'consolidatedreport',
'left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;" style="text-decoration: underline">Route and Loading status</a>
        @endif
    </div>
    <div><h3>Drivers</h3>
        <a href='{!!url("/driverreq_report")!!}' onclick="window.open(this.href, 'driverreq_report',
'left=20,top=20,width=1500,height=1000,toolbar=1,resizable=0'); return false;"   style="text-decoration: underline">Returns</a>
    </div>
    <div><h3>Other</h3>
        <a href='{!!url("/reports")!!}' onclick="window.open(this.href, 'reports',
'left=20,top=20,width=1500,height=1000,toolbar=1,resizable=0'); return false;"   style="text-decoration: underline">Other Reports</a>
    </div>
</div>

<script type="text/javascript" charset="utf-8">


    $(document).ready(function() {
        $('#authRemoteOrder').hide();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    });


</script>
</body>
</html>
