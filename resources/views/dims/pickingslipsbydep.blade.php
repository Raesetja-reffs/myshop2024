<!DOCTYPE html>

<html>
<head>
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ... -->


    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" type="text/css" />
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <!-- DevExtreme library -->



    <style>
        .dx-datagrid{
            font:10px verdana;
        }

table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
    </style>
</head>
<body style="font-family: Sans-serif">
    <div class="container" style="width: 100%;">
        <div class="row">

            <div class="col-lg-12  visible-md visible-lg" style="    background: #32cd32;">
                <div id="callListDialog" title="Call List">
                    <div class="col-lg-12">
                        <form>

                            <div class="form-group col-md-3">
                                <label class="control-label" for="deldate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
                                <input type="text" class="form-control input-sm col-xs-1" id="deldate" style="font-size: 10px;color:black;font-weight:900">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label" for="ordertype"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order Type</label>
                                <select class="form-control input-sm col-xs-1" style="color:black;font-weight:900" name="ordertype"  id="ordertype"  >
                                    @foreach($ordertype as $val)
									<option value="{{$val->OrderTypeId}}" >{{$val->OrderType}}</option>
									@endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label" for="routeToFilterWith"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route/Area</label>
                                <select class="form-control input-sm col-xs-1" style="color:black;font-weight:900"  name="routeToFilterWith" id="routeToFilterWith">
                                    @foreach($routes as $val)
									<option value="{{$val->Routeid}}" >{{$val->Route}}</option>
									@endforeach
                                </select>
                            </div>

							<div class="form-group col-md-3">
                                <label class="control-label" for="dept"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Department</label>
                                <select class="form-control input-sm col-xs-1"  style="color:black;font-weight:900" name="dept" id="dept">
                                    @foreach($strDepartment as $val)
									<option value="{{$val->departmentID}}" >{{$val->strDepartment}}</option>
									@endforeach
                                </select>
                            </div>
                            <button type="button" id="getdata" class="btn-xs btn-success" style="height: 43px;width: 100%;    margin-left: 15px;">GET DATA</button>
                        </form>

                    </div>
                </div>
                <div class="col-lg-10  visible-md visible-lg" style=" overflow-y: auto;width:100%;height:60%">
                <table class="table  search-table" id="callListTable" style="color:black;font-size: 12px;font-family: sans-serif;width:100%;margin-top:20px;">
                    <thead>
                    <tr style="font-size: 19px">
                        <th>Customer Name</th><th>OrderId</th>
                        <th>Select</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                </div>
                <div class="col-lg-12  visible-md visible-lg" >
                    <button id="selectAll" class="btn-primary btn-lg" style="float: right;margin-right: 72px;height: 43px;">Select All</button>
                </div>
				<br>
				<div class="col-lg-12  visible-md visible-lg" >
                    <button id="Deselectselect" class="btn-primary btn-lg">Deselect All</button>
                </div>
				<br><br>
				<div class="col-lg-12  visible-md visible-lg" >
                    <button id="printselected" class="btn-primary btn-lg">Print Selected</button>
                </div>
            </div>

        </div>
    </div>


<script>



    var callists = '';
    var editor;

    $(document).ready(function(){
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#tabletLoadingApp').hide();
        $('#callList').hide();
        $('#copyOrdersBtn').hide();
        $('#salesOnOrder').hide();
        $('#pricingOnCustomer').hide();
        $('#posCashUp').hide();
        $('#selectAll').hide();
        $('#Deselectselect').hide();
        $('#printselected').hide();
		$("#deldate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true,
            dateFormat: "dd-mm-yy" //this option for allowing user to select from year range
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
		 $('#selectAll').on('click',function(){
            $($("input[name='caseProd[]']")).each(function(){
                $(this).prop('checked',true);
            });
        });
		$('#Deselectselect').on('click',function(){
            $($("input[name='caseProd[]']")).each(function(){
                $(this).prop('checked',false);
            });
        });
        $('#getdata').click(function(){
			$('#selectAll').show();
            $('#Deselectselect').show();
			$('#printselected').show();
			productsOnOrder();
		});
		$('#printselected').click(function(){
			var valuesProd = new Array();

            $.each($("input[name='caseProd[]']:checked"),
                function () {
                    var data = $(this).parents('tr:eq(0)');
                    valuesProd.push({ 'orderId':$(data).find('td:eq(1)').text()});

                });
			$.ajax({
            url: '{!!url("/printselectedCustomers")!!}',
            type: "POST",
            data: {
                Orderid: valuesProd,
                deptId: $('#dept').val(),
				routeid: $('#routeToFilterWith').val(),
                ordertypeid: $('#ordertype').val(),
                deliverydate: $('#deldate').val()

            },
            success: function (data) {
                console.debug("data saved");
				location.reload();
            }
        });
		});


    });
    function productsOnOrder()
    {

        $.ajax({
            url: '{!!url("/getPickingSlipbyDeptInfo")!!}',
            type: "POST",
            data: {
                routeid: $('#routeToFilterWith').val(),
                ordertypeid: $('#ordertype').val(),
                deliverydate: $('#deldate').val(),
                deptype: $('#dept').val()
            },
            success: function (data) {
                var trHTML = '';
                $('.fast_removeCallList').empty();
                $.each(data, function (key, value) {
                    trHTML += '<tr role="row" class="fast_removeCallList"  style="font-size: 13px;color:black"><td>' +
                        value.StoreName + '</td><td>' +
                        $.trim(value.OrderId) + '</td><td>' +

                        '<input type="checkbox"  name="caseProd[]" style="width:18px;height:15px !important" value="' + value.OrderId + '" ></td><td>' +
                        '</tr>';

                });
                $('#callListTable').append(trHTML);
            }
        });
    }


</script>
</body>
