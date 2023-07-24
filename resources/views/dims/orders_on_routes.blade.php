@extends('layouts.app')

@section('content')
    <div><h4>Orders On Wrong Routes</h4>
        <input id="deliveryDate" class="form-control input-sm col-xs-1"><button class="btn-md btn-success" id="done">Submit</button>
        <table class="table cell-border" id="ordersOnWrongRoutes">
            <thead>
            <th class="col-md-1">OrderId</th>
            <th class="col-md-3">StoreName</th>
            <th class="col-md-1">OrderType</th>
            <th class="col-md-3">CustomerRoute</th>
            <th class="col-md-3">OrderRoute</th>
            <th class="col-sm-1">Cust RouteId</th>
            <th class="col-sm-1">Order RouteId</th>
            <th class="col-sm-1">OrderType Id</th>

            </thead>
        </table>
    </div>

@endsection

<script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#routePlanningPopUp').hide();
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#callList').hide();
        $('#copyOrdersBtn').hide();
        $('#tabletLoadingApp').hide();
        $('#salesQuotebtn').hide();
        $('#popupmoveThis').hide();
        $('#pricingOnCustomer').hide();
        $('#salesOnOrder').hide();
        $('#posCashUp').hide();
        $('#salesInvoiced').hide();
        var notCorrectRoute = '';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#deliveryDate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $('#done').click(function(){

            $('#ordersOnWrongRoutes').DataTable( {
                "ajax": {url:'{!!url("/getRouteDifference")!!}',"type": "GET",
                    data:function(data) {

                        data.dateFrom = $('#deliveryDate').val();

                    }
                },
                "columns": [
                    { "data": "OrderId","class":"small" },
                    { "data": "StoreName","class":"small"},
                    { "data": "OrderType","class":"small"},
                    { "data": "CustomerRoute","class":"small"},
                    { "data": "OrderRoute","class":"small"},
                    { "data": "custRouteId","class":"small"},
                    { "data": "orderRouteId","class":"small"},
                    { "data": "LateOrder","class":"small"  }

                ],
                "deferRender": true,
                "scrollY": "200px",
                "scrollCollapse": true,
                searching: true,
                bPaginate: false,
                bFilter: false,
                "LengthChange": false,
                "info":     false,
                "bDestroy": true

            } );
        });

    });

</script>