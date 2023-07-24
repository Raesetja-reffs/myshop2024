@extends('layouts.app')

@section('content')
<div class="col-lg-6  pull-right" >
    <div class="col-md-3 pull-right"><button class="btn-success" id="approvedDeals">Approved Deals</button></div>
    <div class="col-md-3 pull-right"><button class="btn-danger" id="rejectedDeals">Rejected Deals</button></div>
</div>
<h4>Below are the pending deals</h4>
<div class="col-lg-12" id="deals" title="Pending Deal" style="background: darkgoldenrod">
    <table class="table" id="tblDeals" style=" color: black;overflow-y: scroll; width: 100%;font-family: sans-serif;font-weight: 700;" >
        <thead>

        <tr>
            <th class="col-sm-1">Customer Code</th>
            <th class="col-sm-1">Product Code</th>
            <th>Price Given</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Token</th>
            <th>Created By</th>
            <th>Date Time Created</th>
            <th></th>
            <th></th>

        </tr>
        </thead>
        <tbody>
        @foreach($deals as $value)
            <tr>
                <th class="col-sm-1">{{$value->CustomerCode}}</th>
                <th class="col-sm-1">{{$value->strProductCode}}</th>
                <th>{{$value->fltNewPrice}}</th>
                <th>{{$value->dteDealStarts}}</th>
                <th>{{$value->dteDealEnds}}</th>
                <th>{{$value->ID}}</th>
                <th>{{$value->UserName}}</th>
                <th>{{$value->dteTimeCreated}}</th>
                <th><a href='{!!url("/approveadeal")!!}/{{$value->ID}}' style="color: #eaf3e6;" >APPROVE</a></th>
                <th><a href='{!!url("/rejecatdeal")!!}/{{$value->ID}}' >REJECT</a></th>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="col-lg-12" id="aprrovedDealsPop" title="Approved Deals" >
    <table class="table search-table" id="aprrovedDealsPop"  style=" color: black;overflow-y: scroll; width: 100%;font-family: sans-serif;font-weight: 700;" >
        <thead>

        <tr>
            <th class="col-sm-1">Customer Code</th>
            <th class="col-sm-1">Product Code</th>
            <th>Price Given</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Token</th>
            <th>Created By</th>
            <th>Date Time Created</th>
            <th></th>


        </tr>
        </thead>
        <tbody></tbody>

    </table>
</div>
<div class="col-lg-12" id="rejectedDealsPop" title="Rejected Deals" >
    <table class="table search-table" id="rejdealstbl"  style=" color: black;overflow-y: scroll; width: 100%;font-family: sans-serif;font-weight: 700;" >
        <thead>

        <tr>
            <th class="col-sm-1">Customer Code</th>
            <th class="col-sm-1">Product Code</th>
            <th>Price Given</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Token</th>
            <th>Date Time Created</th>
            <th></th>


        </tr>
        </thead>
        <tbody></tbody>

    </table>
</div>
@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#aprrovedDealsPop').hide();
        $('#rejectedDealsPop').hide();
        $('#approvedDeals').click(function(){
            $('#aprrovedDealsPop').show();
            showDialog('#aprrovedDealsPop',1100,400);
            $.ajax({
                url: '{!!url("/approveddeal")!!}',
                type: "GET",
                success: function (data) {
                    $('#aprrovedDealsPop tbody').empty();
                    var trHTML = '';
                    $.each(data, function (key, value) {
                        trHTML += '<tr><td>' +
                            value.CustomerCode + '</td><td>' +
                            value.strProductCode + '</td><td>' +
                            value.fltNewPrice + '</td><td>' +
                            value.dteDealStarts + '</td><td>' +
                            value.dteDealEnds + '</td><td>' +
                            value.ID + '</td><td>' +
                            value.UserName + '</td><td>' +
                            value.dteTimeCreated + '</td><td></td>' +
                            '</tr>';
                    });
                    $('#aprrovedDealsPop tbody').append(trHTML);
                }
            });

                });
        $('#rejectedDeals').click(function(){
            $('#rejectedDealsPop').show();
            showDialog('#aprrovedDealsPop',1100,400);
            $.ajax({
                url: '{!!url("/rejecteddeal")!!}',
                type: "GET",
                success: function (data) {
                    $('#rejdealstbl tbody').empty();
                    var trHTML = '';
                    $.each(data, function (key, value) {
                        trHTML += '<tr><td>' +
                            value.CustomerCode + '</td><td>' +
                            value.strProductCode + '</td><td>' +
                            value.fltNewPrice + '</td><td>' +
                            value.dteDealStarts + '</td><td>' +
                            value.dteDealEnds + '</td><td>' +
                            value.ID + '</td><td>' +
                            value.UserName + '</td><td>' +
                            value.dteTimeCreated + '</td><td></td>' +
                            '</tr>';
                    });
                    $('#rejdealstbl tbody').append(trHTML);
                }
            });

                });
        function showDialog(tag,width,height)
        {
            $( tag ).dialog({height: height, modal: false,
                width: width,containment: false}).dialogExtend({
                "closable" : true, // enable/disable close button
                "maximizable" : false, // enable/disable maximize button
                "minimizable" : true, // enable/disable minimize button
                "collapsable" : true, // enable/disable collapse button
                "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
                "titlebar" : false, // false, 'none', 'transparent'
                "minimizeLocation" : "right", // sets alignment of minimized dialogues
                "icons" : { // jQuery UI icon class

                    "maximize" : "ui-icon-circle-plus",
                    "minimize" : "ui-icon-circle-minus",
                    "collapse" : "ui-icon-triangle-1-s",
                    "restore" : "ui-icon-bullet"
                },
                "load" : function(evt, dlg){ }, // event
                "beforeCollapse" : function(evt, dlg){ }, // event
                "beforeMaximize" : function(evt, dlg){ }, // event
                "beforeMinimize" : function(evt, dlg){ }, // event
                "beforeRestore" : function(evt, dlg){ }, // event
                "collapse" : function(evt, dlg){  }, // event
                "maximize" : function(evt, dlg){ }, // event
                "minimize" : function(evt, dlg){  }, // event
                "restore" : function(evt, dlg){  } // event
            });
        }
    });
</script>
