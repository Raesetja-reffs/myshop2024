<x-app-layout>
    <div class="container" style="width: 100%;">
        <div class="row">

            <div class="col-lg-12  visible-md visible-lg" style="    background: #32cd32;">
                <div id="callListDialog" title="Call List">
                    <div class="col-lg-12">
                        <form>
                            <div class="form-group col-md-3">
                                <label class="control-label" for="callListOrderDate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Order Date</label>
                                <input type="text" class="form-control input-sm col-xs-1" id="callListOrderDate" style="font-size: 10px;">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label" for="callListDeliveryDate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
                                <input type="text" class="form-control input-sm col-xs-1" id="callListDeliveryDate" style="font-size: 10px;">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label" for="callListUser"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">User</label>
                                <select class="form-control input-sm col-xs-1" name="callListUser"  id="callListUser"  >
                                    <option value="" ></option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label" for="routeToFilterWith"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
                                <select class="form-control input-sm col-xs-1"   name="routeToFilterWith" id="routeToFilterWith">
                                    <option value="" ></option>
                                </select>
                            </div>
                            <button type="button" id="passCallistFilter" class="btn-xs btn-success" style="background: deeppink;border-color: deeppink;">Go</button>
                        </form>

                    </div>
                </div>
                <div class="col-lg-10  visible-md visible-lg" style=" overflow-y: auto;width:100%;height:60%">
                    <table class="table  search-table" id="callListTable" style="color:black;font-size: 12px;font-family: sans-serif;" tabindex="0">
                        <thead>
                        <tr style="font-size: 19px">
                            <th>Code</th><th>Description</th>
                            <th>Account Contact</th><th>Buyer Tel</th><th>Buyer Cell</th><th>Route</th>
                            <th>Buyer</th> <th>Call</th><th>Notes</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="col-lg-12  visible-md visible-lg" >
                    <button id="refresh" class="btn-primary btn-lg">REFRESH</button>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>
    var jArraydelivRoutes = JSON.stringify({!! json_encode($routesNames) !!});
    var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});
    var jArray = JSON.stringify({!! json_encode($products) !!});


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
        var toAppendRoutes = '';
        $.each(JSON.parse(jArraydelivRoutes), function (i, o) {
            toAppendRoutes += '<option value="' + o.Routeid + '">' + o.Route + '</option>';
        });
        var currentdate = new Date();
        $("#callListOrderDate").val($.datepicker.formatDate('dd-mm-yy', currentdate));
        $("#callListDeliveryDate").val($.datepicker.formatDate('dd-mm-yy', currentdate));
        $("#callListDeliveryDate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true,
            dateFormat: "dd-mm-yyyy" //this option for allowing user to select from year range
        });
        $("#callListOrderDate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true //this option for allowing user to select from year range
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        getDimsUsers('#callListUser', '{!!url("/getDimsUsers")!!}');
        $('#routeToFilterWith').append(toAppendRoutes);
        productsOnOrder();
        $('#passCallistFilter').click(function(){
            productsOnOrder();
        });
        $("#refresh").click(function(){
            productsOnOrder();
        });
        $('#callListTable tbody').on('click', 'tr', function (e){
            $("#callListTable tbody tr").removeClass('row_selected');
            $(this).addClass('row_selected');
        });
    });
    function productsOnOrder()
    {

        $.ajax({
            url: '{!!url("/getCallList")!!}',
            type: "POST",
            data: {
                userId: $('#callListUser').val(),
                routeId: $('#routeToFilterWith').val(),
                OrderDate: $('#callListOrderDate').val(),
                deliveryDate: $('#callListDeliveryDate').val()
            },
            success: function (data) {
                var trHTML = '';
                $('.fast_removeCallList').empty();
                $.each(data, function (key, value) {
                    var tokenIdn=parseInt(Math.random()*1000000000, 10);
                    //var
                    trHTML += '<tr role="row" class="fast_removeCallList"  style="font-size: 13px;color:black"><td>' +
                        value.CustomerPastelCode + '</td><td>' +
                        $.trim(value.StoreName) + '</td><td>' +
                        value.ContactPerson + '</td><td>' +
                        value.BuyerTelephone + '</td><td>' +
                        value.CellPhone + '</td><td>' +
                        value.Routeid + '</td><td>' +
                        value.BuyerContact + '</td><td>' +
                        '<input type="checkbox"  name="called" style="width:18px;height:15px !important" value="' + value.CustomerPastelCode + '" onclick="javascript: SelectallColorsForStyle(this, value,'+tokenIdn+');" >' +
                        '</td><td><input type="text" id="'+tokenIdn +'" class="notes" value="' + value.notes + '"></td>' +
                        '</tr>';

                });
                $('#callListTable').append(trHTML);
            }
        });
    }
    function SelectallColorsForStyle(e, val,note) {
        console.debug("e.value//////"+e.value);
        console.debug("val***+-//////"+val);
        $.ajax({
            url: '{!!url("/isCalled")!!}',
            type: "POST",
            data: {
                CustomerCode: e.value,
                DeivDate: $('#callListDeliveryDate').val(),
                Show:"0",
                DeliveryAddressId: "0", notes:$('#'+note).val()
            },
            success: function (data) {
                console.debug("data saved");
            }
        });
    }

</script>
