@extends('layouts.app')

@section('content')
    <div class="col-lg-12"  style="background: white;">
        <button class="btn-md btn-success" id="pleaseAddNewCust" >Please Add New Group Special</button>
        <fieldset class="well">
            <legend class="well-legend">Filters</legend>
            <form>
                <div class="form-group  col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="inputCustAcc"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Group ID</label>
                    <input type="text" name="custCode" class="form-control input-sm col-xs-1" id="inputCustAcc" style="background:grey;height:22px;font-size: 10px;font-weight: 900;    color: black;" readonly>
                </div>

                <div class="form-group col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="inputCustName"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Group Name</label>
                    <input type="text" name="custDescription" class="form-control input-sm col-xs-1" id="inputCustName" style="height:22px;font-size: 10px;font-weight: 900;    color: black;">
                </div>
                <div class="form-group col-md-3 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="dateFrom"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date From</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="dateFrom" style="font-weight: 900;    color: black;font-size: 13px;">
                </div>
                <div class="form-group col-md-3 "  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="dateTo"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date To</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="dateTo" style="font-weight: 900;    color: black;font-size: 13px;">

                </div>

                <button type="button" id="submitFiltersOnCustSpecial" class="btn-xs btn-primary">Submit</button>
            </form>
        </fieldset>
    </div>
    <div class="col-lg-12" id="afterFilter">
        <div class="col-lg-12" style="overflow: scroll;height:650px;">
            <h5 id="specialslink"></h5>
           <div><h4>Current Specials</h4><button id="extend" class="btn-md btn-primary pull-right">Extend Specials</button><button class="btn-md btn-success" id="bulkediting" style="    float: right;">Bulk Editing</button></div>
        <table id ="tblCreatedCustomerSpecials" class="table table-bordered table-condensed" style="font-family: sans-serif;" tabindex=0>
                <thead>
                <tr style="font-size: 12px;">
                    <td>ID</td>
                    <td>Ref</td>
                    <td>Code</td>
                    <td>Description</td>
                    <td>Date From</td>
                    <td>Date To</td>
                    <td>Price</td>
                    <td>Cost</td>
                    <td>Current GP</td>
                    <td style="display: none;">Cost Created</td>
                    <td>Available</td>
                    <td>Instock</td>
                    <td>Actions</td>

                </tr>
                </thead>
                <tbody></tbody>

            </table>
        </div>


        <div class="col-lg-12" style="background: green;height: 80%;display:none;">
            <h4>Please start adding new products below.</h4>
            <fieldset class="well" style="display:none;">
                <legend class="well-legend">Filters</legend>
                <form>
                    <div class="form-group col-md-3 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="dateFrom"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date From</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="dateFrom" style="font-weight: 900;    color: black;font-size: 13px;">
                    </div>
                    <div class="form-group col-md-3 "  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="dateTo"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date To</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="dateTo" style="font-weight: 900;    color: black;font-size: 13px;">

                    </div>

                    <button type="button" id="createnewSpecial" class="btn-xs btn-success">Create</button>
                </form>
            </fieldset>
            <div class="col-lg-12" style="background: white;height: 60%;overflow-y: scroll">

                <button class="btn-success btn-xs" id="addLine">Add</button>
                <table id ="tblCreateNewSpecial" class="table table-bordered table-condensed">
                    <thead>
                    <tr style="font-size: 12px;">
                        <td>Code</td>
                        <td>Description</td>
                        <td>DtFrom</td>
                        <td>DtTo</td>
                        <td>Price</td>
                        <td>Cost</td>
                        <td>Current GP</td>
                        <td>Cost Created</td>
                        <td>Available</td>
                        <td>Instock</td>
                        <td>Cost Used</td>
                        <td>Actions</td>

                    </tr>
                    </thead>
                    <tbody></tbody>

                </table>

            </div>
            <div class="col-lg-12" style="background: white;">
                <button id="doneCreating" class="btn-xs btn-success">Done</button>
            </div>
        </div>
        <input type="button" id="deleteSelected" class="btn-xs btn-danger" value="Delete Selected">
        <input type="button" id="checkall" class="btn-xs btn-danger" value="Check All" style="float:right;">
    </div>
    <div id="popUpdateLine" title="Please Update">
        <div class="col-lg-12" >
            <label class="control-label" for="specialIdUpdate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Special Id</label><br>
            <input type="text"  class="form-control input-sm col-xs-1" id="specialIdUpdate" style="font-weight: 900;    color: black;font-size: 13px;" readonly><br>
            <input type="hidden"  class="form-control input-sm col-xs-1" id="hiddenSpecaialFrom" >
            <input type="hidden"  class="form-control input-sm col-xs-1" id="hiddenSpecaialTo" >
            <label class="control-label" for="itemCode"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Code</label><br>
            <input type="text"  class="form-control input-sm col-xs-1" id="itemCode" style="font-weight: 900;    color: black;font-size: 13px;" readonly><br>
            <label class="control-label" for="itemDescription"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Description</label><br>
            <input type="text"  class="form-control input-sm col-xs-1" id="itemDescription" style="font-weight: 900;    color: black;font-size: 13px;" readonly><br>
            <label class="control-label" for="specialFrom"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date From</label><br>
            <input type="text"  class="form-control input-sm col-xs-1" id="specialFrom" style="font-weight: 900;    color: black;font-size: 13px;" ><br>
            <label class="control-label" for="specialTo"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date To</label><br>
            <input type="text"  class="form-control input-sm col-xs-1" id="specialTo" style="font-weight: 900;    color: black;font-size: 13px;"><br>
            <label class="control-label" for="specialPrice"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Special Price</label><br>
            <input type="text"  class="form-control input-sm col-xs-1" id="specialPrice" style="font-weight: 900;    color: black;font-size: 13px;" ><br>
            <label class="control-label" for="specialCost"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Special Cost</label><br>
            <input type="text"  class="form-control input-sm col-xs-1" id="specialCost" style="font-weight: 900;    color: black;font-size: 13px;" readonly><br>
            <label class="control-label" for="specialGp"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">GP</label><br>
            <input type="text"  class="form-control input-sm col-xs-1" id="specialGp" style="font-weight: 900;    color: black;font-size: 13px;" readonly><br>
        </div>
        <div class="col-lg-12" >
            <button id="updateTheSpecuial" class="btn-md btn-success">Update the Specials</button>
        </div>

    </div>
    <div id="updatedspecials" title="Specials Updated" >
        <button id="btnspecialUpdated" class="btn-md btn-success">OKAY</button>
    </div>
    <div id="extedingspecial" title="Extending Group Specials">
        <label class="control-label" for="specialFrom"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date From</label><br>
        <input type="text"  class="form-control input-sm col-xs-1" id="specialdateext" style="font-weight: 900;    color: black;font-size: 13px;" ><br>
        <label class="control-label" for="specialTo"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date To</label><br>
        <input type="text"  class="form-control input-sm col-xs-1" id="specialdateextTo" style="font-weight: 900;    color: black;font-size: 13px;" ><br>
        <button id="doneext" class="btn-md btn-success">Done Extending</button>
    </div>
@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>
    var jArray = JSON.stringify({!! json_encode($products) !!});
    var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    var finalDataProduct = $.map(JSON.parse(jArray), function (item) {
        return {
            value: item.PastelCode,
            PastelCode: item.PastelCode,
            PastelDescription: item.PastelDescription,
            UnitSize: item.UnitSize,
            Tax: item.Tax,
            Cost: parseFloat(item.Cost).toFixed(2),
            QtyInStock: item.QtyInStock,
            Margin: item.Margin,
            Alcohol: item.Alcohol,
            Available: parseFloat(item.Available).toFixed(2)
        }

    });
    var finalDataProductDescription = $.map(JSON.parse(jArray), function (item) {
        return {
            value: item.PastelDescription,
            PastelCode: item.PastelCode,
            PastelDescription: item.PastelDescription,
            UnitSize: item.UnitSize,
            Tax: item.Tax,
            Cost: parseFloat(item.Cost).toFixed(2),
            QtyInStock: item.QtyInStock,
            Margin: item.Margin,
            Alcohol: item.Alcohol,
            Available: parseFloat(item.Available).toFixed(2)
        }

    });
    var finalData =$.map(JSON.parse(jArrayCustomer), function(item) {

        return {
            GroupName:item.GroupName,
            GroupId:item.GroupId,
        }

    });

    $(document).ready(function() {
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#pricingOnCustomer').hide();
        $('#callList').hide();
        $('#tabletLoadingApp').hide();
        $('#copyOrdersBtn').hide();
        $('#salesOnOrder').hide();
        $('#salesInvoiced').hide();
        $('#posCashUp').hide();
        $('#afterFilter').hide();
        $('#popUpdateLine').hide();
        $('#updatedspecials').hide();
        $('#deleteSelected').hide();
        $('#extedingspecial').hide();

        var inputGroupAccount = $('#inputCustName').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["GroupId","GroupName"],
            searchIn: 'GroupName',
            data: finalData
        });
        inputGroupAccount.on('select:flexdatalist', function (event, data) {

            $('#inputCustAcc').val(data.GroupId);
            $('#inputCustName').val(data.GroupName);
        });

        $('#bulkediting').click(function(){

            var inputCustAcc = $('#inputCustAcc').val();
            var  dateFrom = $('#dateFrom').val();
            var  dateTo = $('#dateTo').val();
            window.open('{!!url("/getgroupspecialbulkeditingLandingage")!!}/'+inputCustAcc+"/"+dateFrom+"/"+dateTo, inputCustAcc, "location=1,status=1,scrollbars=1, width=1200,height=850");

        });
        $('#addLine').click(function(){

            generateALine2();
        });
        generateALine2();

        $(".dateTo").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $("#specialdateext,#specialdateextTo").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });
        $("#dateFrom,#dateTo,#specialFrom,#specialTo").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $('#tblCreateNewSpecial').on('click', 'button', function (e) {
            var $this = $(this);
            $this.closest('tr').remove();
        });

        $('#doneCreating').click(function()
        {
            var productsLinesOnPicking = new Array();
            $('#tblCreateNewSpecial > tbody  > tr').each(function() {
                // var data = $(this);
                // var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();

                if (($(this).closest('tr').find('.theProductCode_').val()).length > 0 && ($(this).closest('tr').find('.prodDescription_').val()).length > 0 ) {
                    productsLinesOnPicking.push({
                        'productCode': $(this).closest('tr').find('.theProductCode_').val(),
                        'desc': $(this).closest('tr').find('.prodDescription_').val(),
                        'price': $(this).closest('tr').find('.prodPrice_').val(),
                        'dateFrom': $(this).closest('tr').find('.dateFrom').val(),
                        'dateTo': $(this).closest('tr').find('.dateTo').val(),
                        'cost_': $(this).closest('tr').find('.cost_').val(),
                        'gp_': $(this).closest('tr').find('.gp_').val(),
                        'costCreated_': $(this).closest('tr').find('.costCreated_').val()
                    });
                }
            });
            $.ajax({
                url: '{!!url("/createGroupSpecials")!!}',
                type: "POST",
                data: {
                    customerCode: $('#inputCustAcc').val(),
                    orderDetails: productsLinesOnPicking,
                    contractDateFrom:$('#dateFrom').val(),
                    contractDateTo:$('#dateTo').val()
                },
                success: function (data) {
                    var dialog = $('<p>Done</p>').dialog({
                        height: 200, width: 700, modal: true, containment: false,
                        buttons: {
                            "OKAY": function () {
                                dialog.dialog('close');
                                $('#submitFiltersOnCustSpecial').click();

                            }
                        }
                    });
                }
            });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
//showDialog('#tempDeliveryAddressOnTheFly','50%',250);
        $('#submitFiltersOnCustSpecial').click(function(){
            if (($.trim($('#dateFrom').val())).length > 7 && ($.trim($('#dateTo').val())).length > 7){

                $('#afterFilter').show();

                //Select * between this date for this customer
                $('#specialslink').empty();
                $('#deleteSelected').empty();
                $('#deleteSelected').show();

                var from = $.datepicker.formatDate('yy-mm-dd',$.datepicker.parseDate('dd-mm-yy', $('#dateFrom').val()) );
                var dateTo = $.datepicker.formatDate('yy-mm-dd',$.datepicker.parseDate('dd-mm-yy', $('#dateTo').val()) );
                $('#specialslink').append("<a href={!!url('/groupSpecailJasper')!!}/"+from+"/"+dateTo+"/"+$('#inputCustAcc').val()+" target=blank style= background: red;color: white;font-weight: 900;padding: 3px;>Print Result</a>" +
                    "<a href={!!url('/viewgroupinexcel')!!}/"+from+"/"+dateTo+"/"+$('#inputCustAcc').val()+" target=blank style= 'background: red;color: white;font-weight: 900;padding: 3px;'>View In Grid</a>");


                $.ajax({
                    url: '{!!url("/customerGroupByDateOrContract")!!}',
                    type: "POST",
                    data: {
                        groupId: $('#inputCustAcc').val(),
                        dateFrom: $('#dateFrom').val(),
                        dateTo:  $('#dateTo').val()

                    },
                    success: function (data) {
                        var trHTML ="";
                        $('.remthisLine').remove();

                        $.each(data, function (key,value) {
                            trHTML += '<tr  class="remthisLine" style="font-size: 11px;color:black;"><td>' +
                                value.SpecialGroupid + '</td><td>' +
                                value.SpecialHeaderId + '</td><td>' +
                                value.PastelCode + '</td><td>' +
                                value.PastelDescription+ '</td><td>' +
                                value.Date+'</td><td>' +
                                value.DateTo + '</td><td>'+
                                parseFloat(value.Price).toFixed(2) + '</td><td>'+
                                parseFloat(value.Cost).toFixed(2) + '</td><td>'+
                                parseFloat(value.GP).toFixed(2) + '</td><td  style="display: none;">'+
                                parseFloat(value.CostPrice).toFixed(2) + '</td><td>'+
                                parseFloat(value.Available).toFixed(2) + '</td><td>'+
                                parseFloat(value.Instock).toFixed(2) + '</td><td>'+
                                parseFloat(value.CostPrice).toFixed(2) + '</td>'+

                                '<td><button class="btn-sx" value="' +value.SpecialGroupid +'">Delete</button>' +
                                '<input type="checkbox" name="checkproduct[]" value ="'+value.PastelCode+'" style="height:18px !important;width:30px"></td></tr>';
                            $('#specialId').val( value.SpecialHeaderId);
                        });
                        $('#tblCreatedCustomerSpecials').append(trHTML);
                    }
                });
            }else {
                alert("Please check your date criteria");
            }
            $('#checkall').on('click',function(){
                $($("input[name='checkproduct[]']")).each(function(){
                    $(this).prop('checked',true);
                });
            });
        });

        $('#tblCreatedCustomerSpecials').on('click', 'button', function (e) {
            var $this = $(this);
            var $thisVal = $(this).val();
            $.ajax({
                url: '{!!url("/removeGroupSpecial")!!}',
                type: "POST",
                data: {
                    removeSpecial: $thisVal
                },
                success: function (data) {

                    var dialog = $('<p>Special Removed</p>').dialog({
                        height: 200, width: 700, modal: true, containment: false,
                        buttons: {
                            "OKAY": function () {
                                $this.closest('tr').remove();
                                dialog.dialog('close');
                            }
                        }
                    });
                }
            });
        });

        $('#deleteSelected').click(function(){
            var valuesProd = new Array();
            var groupName = $('#inputCustAcc').val();
            $.each($("input[name='checkproduct[]']:checked"),
                function () {
                    var data = $(this).parents('tr:eq(0)');

                    var codeID = data.find('td:eq(0)').text();
                    var datefrom = data.find('td:eq(4)').text();
                    var dateto = data.find('td:eq(5)').text();

                    valuesProd.push({'groupName': groupName,'lineid':codeID});
                });
            $.ajax({
                url: '{!!url("/deleteselectedgroupspeciallines")!!}',
                type: "POST",
                data: {
                    griddetails: valuesProd,
                    groupid: groupName
                },
                success: function (data) {

                    var dialog = $('<p>Done</p>').dialog({
                        height: 200, width: 700, modal: true, containment: false,
                        buttons: {
                            "OKAY": function () {
                                location.reload(true);

                            }
                        }
                    });

                }
            });
        });

        $('#extend').click(function(){
            //extedingspecial
            $('#extedingspecial').show();
            showDialog('#extedingspecial','50%',250);

            var groupName = $('#inputCustAcc').val();

            $('#doneext').click(function(){
                var valuesProd = new Array();
                $.each($("input[name='checkproduct[]']:checked"),
                    function () {

                        var data = $(this).parents('tr:eq(0)');
                        var codeID = data.find('td:eq(0)').text();
                        var datefrom = $('#specialdateext').val();
                        var dateto = $('#specialdateextTo').val();
                        console.debug("Date from **************************************"+datefrom);
                        valuesProd.push({  'groupName': groupName,'lineid':codeID,'datefrom':dateReturn(datefrom),'dateto':dateReturn(dateto)});

                    });
                $.ajax({
                    url: '{!!url("/doneextendinggroupspecials")!!}',
                    type: "POST",
                    data: {
                        groupId: groupName,
                        griddetails: valuesProd
                    },
                    success: function (data) {
                        location.reload(true);
                    }
                });
            });
        });

        $('#pleaseAddNewCust').click(function(){
            window.open('{!!url("/addNewGroupSpecial")!!}', "newGroupSpecial", "width=1500, height=800, scrollbars=yes");
        });
        $('#tblCreatedCustomerSpecials tbody').on('click', 'tr', function (e) {
            $("#tblCreatedCustomerSpecials tbody tr").removeClass('row_selected');
            $(this).addClass('row_selected');
        });
        $('#tblCreatedCustomerSpecials tbody').on('dblclick', 'tr', function (e){
            $("#tblCreatedCustomerSpecials tbody tr").removeClass('row_selected');
            $(this).addClass('row_selected');
            $('#popUpdateLine').show();
            showDialog('#popUpdateLine','60%',450);
            var rowOnOrder =  $(this).closest("tr");

            $('#specialIdUpdate').val(rowOnOrder.find('td:eq(0)').text());
            $('#itemCode').val(rowOnOrder.find('td:eq(2)').text());
            $('#itemDescription').val(rowOnOrder.find('td:eq(3)').text());
            $('#specialFrom').val(rowOnOrder.find('td:eq(4)').text());
            $('#hiddenSpecaialFrom').val(rowOnOrder.find('td:eq(4)').text());
            $('#specialTo').val(rowOnOrder.find('td:eq(5)').text());
            $('#hiddenSpecaialTo').val(rowOnOrder.find('td:eq(5)').text());
            $('#specialPrice').val(rowOnOrder.find('td:eq(6)').text());
            $('#specialCost').val(rowOnOrder.find('td:eq(7)').text());
            $('#specialGp').val(rowOnOrder.find('td:eq(8)').text());
            $('#updateTheSpecuial').click(function(){
                $.ajax({
                    url: '{!!url("/updategGroupSpecialLine")!!}',
                    type: "POST",
                    data: {
                        itemCode: $('#itemCode').val(),
                        specialIdUpdate: $('#specialIdUpdate').val(),
                        itemDescription: $('#itemDescription').val(),
                        specialFrom: $('#specialFrom').val(),
                        specialTo: $('#specialTo').val(),
                        specialPrice: $('#specialPrice').val(),
                        specialCost: $('#specialCost').val(),
                        specialGp: $('#specialGp').val()
                    },
                    success: function (data) {
                        $('#updatedspecials').show();
                        showDialog('#updatedspecials',380,100);
                        $('#btnspecialUpdated').click(function(){
                            $('#popUpdateLine').dialog('close');
                            $('#updatedspecials').dialog('close');
                            $('#submitFiltersOnCustSpecial').click();
                        });
                    }
                });
            });
        });
    });
    function generateALine2()
    {
        var tokenId=Math.floor(Math.pow(10, 9-1) + Math.random() * 9 * Math.pow(10, 9-1));
        var $row = $('<tr id="new_row_ajax'+tokenId+'" class="fast_remove" style="font-weight: 600;font-size: 11px;">' +
            '<td contenteditable="false" class="col-sm-1"><input name="theProductCode" id ="prodCode_'+tokenId+'" class="theProductCode_ set_autocomplete inputs"></td>' +
            '<td contenteditable="false" class="col-md-4"><input name="prodDescription_" id ="prodDescription_'+tokenId+'" class="prodDescription_ set_autocomplete inputs" tabindex="-1"></td>' +
            '<td  contenteditable="false" class="col-md-2"><input type="text" name="dateFrom" id ="dateFrom'+tokenId+'"   title="in stock" class="dateFrom resize-input-inside inputs"></td>' +
            '<td contenteditable="false" class="col-md-2"><input type="text" name="dateTo"  id ="dateTo'+tokenId+'" class="dateTo resize-input-inside"></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="prodPrice_" id ="prodPrice_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="cost_" id ="cost_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="cost_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" readonly ></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="gp_" id ="gp_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="gp_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" readonly></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="costCreated_" id ="costCreated_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="costCreated_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" readonly></td>'+
            '<td><button type="button" id="cancelThis" class="btn-danger btn-xs cancel" style="height: 16px;padding: 0px 5px;font-size: 9px;">Cancel</button></td></tr>');
        $('#tblCreateNewSpecial tbody')
            .append( $row )
            .trigger('addRows', [ $row, false ]);
        if(!$('.lst').is(":focus"))
        {
            $('#prodCode_' + tokenId).focus();

            if ($('#checkboxDescription').is(':checked')) {
                $('#prodDescription_' + tokenId).focus();
            }
        }


        $('input').on('click keyup' ,function(){
            // $('input').click(function(){
            var ID = $(this).attr('id');
            var jID = '#'+ID;
            var x = ID.indexOf("_");
            var get_token_number = ID.substring(x+1,ID.length);

            if ($(this).hasClass("prodDescription_") && $(this).hasClass("set_autocomplete")) {
                var columnsD = [{name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'},
                    {name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'}
                    ,{name: 'Available', minWidth:'20px',valueField: 'Available'}];
                $(""+jID+"").mcautocomplete({
                    source: function(req, response) {
                        var re = $.ui.autocomplete.escapeRegex(req.term);
                        var matcher = new RegExp("^" + re, "i");
                        response($.grep(finalDataProductDescription, function(item) {
                            return matcher.test(item.value);
                        }));
                    },
                    columns:columnsD,
                    autoFocus: true,
                    minlength: 2,
                    delay: 0,
                    multiple: true,
                    multipleSeparator: ",",
                    select:function (e, ui) {
                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);

                        if(ui.item.PastelCode == "MISC2" || ui.item.PastelDescription == "MISC - NOTE" || ui.item.PastelDescription =="MISC" || ui.item.PastelCode =="misc")
                        {
                            $('#prodQty_'+token_number).val('0');
                            $('#prodPrice_'+token_number).val('0');
                        }
                        $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                        $('#prodCode_' + token_number).val(ui.item.PastelCode);

                        $('#taxCode' + token_number).val(ui.item.Tax);
                        $('#cost_' + token_number).val(ui.item.Cost);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                    }
                });

            }

            if ($(this).hasClass("theProductCode_") && $(this).hasClass("set_autocomplete")) {
                var columnsC = [{name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'},
                    {name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'}
                    ,
                    {name: 'Available', minWidth:'20px',valueField: 'Available'}];
                $("" + jID + "").mcautocomplete({
                    //source: finalDataProduct,
                    source: function(req, response) {
                        var re = $.ui.autocomplete.escapeRegex(req.term);
                        var matcher = new RegExp("^" + re, "i");
                        response($.grep(finalDataProduct, function(item) {
                            return matcher.test(item.value);
                        }));
                    },
                    columns:columnsC,
                    minlength: 1,
                    autoFocus: true,
                    delay: 0,
                    select:function (e, ui) {

                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);
                        if(ui.item.PastelCode == "MISC2" || ui.item.PastelDescription == "MISC - NOTE" || ui.item.PastelDescription =="MISC" || ui.item.PastelCode =="misc")
                        {
                            $('#prodQty_'+token_number).val('0');
                            $('#prodPrice_'+token_number).val('0');
                        }
                        $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                        $('#prodCode_' + token_number).val(ui.item.PastelCode);
                        //checkIfOrderHasMultipleProducts(ui.item.extra,token_number);
                        //$('#inStock_' + token_number).val(ui.item.QtyInStock);
                        $('#taxCode' + token_number).val(ui.item.Tax);
                        $('#cost_' + token_number).val(ui.item.Cost);
                        // $('#prodQty_' + token_number).attr('title', 'In Stock ' + parseFloat(ui.item.QtyInStock).toFixed(3));

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                    }

                });
            }
            //calculator();
        });
        $(".dateTo,.dateFrom").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $('#tblCreateNewSpecial').on('click', 'button', function (e) {
            var $this = $(this);
            var $thisVal = $(this).val();
            $this.closest('tr').remove();


        });

    }
    function marginCalculator(cost,onCellVal)
    {
        return ((cost/onCellVal))*100;
    }
    $(document).on('keyup', '#specialPrice', function(e) {
        $('#specialGp').val(parseFloat( marginCalculator($('#specialCost').val(),$('#specialPrice').val())).toFixed(2));
    });
    $(document).on('keydown', '#tblCreateNewSpecial', function(e) {
        var $table = $(this);

        var $active = $('input:focus,select:focus,li:focus',$table);
        var $next = null;
        var focusableQuery = 'input:visible,select:visible,textarea:visible,li:visible';
        var position = parseInt( $active.closest('td').index()) + 1;
        var $celltheProductCode_ = $active.closest('td').find(".theProductCode_").val();

        switch(e.keyCode){
            case 37: // <Left>
                $next = $active.parent('td').prev().find(focusableQuery);
                break;
            case 33: // <Up>
                c
                if ($celltheProductCode_.length < 1) {
                    $next = $active
                        .closest('tr')
                        .prev()
                        .find('td:nth-child(' + position + ')')
                        .find(focusableQuery)
                    ;
                }

                break;
            case 38: // <Up>
                if ($celltheProductCode_.length < 1) {
                    $next = $active
                        .closest('tr')
                        .prev()
                        .find('td:nth-child(' + position + ')')
                        .find(focusableQuery)
                    ;
                }
                break;
            case 34: // <Right>
                $next = $active.closest('td').next().find(focusableQuery);
                break;
            case 40: // <Down>
                if ($celltheProductCode_.length < 1) {
                    $next = $active
                        .closest('tr')
                        .next()
                        .find('td:nth-child(' + position + ')')
                        .find(focusableQuery)
                    ;
                }
                console.debug('$celltheProductCode_******** DOWN'+$celltheProductCode_);
                break;

        }
        if($next && $next.length)
        {
            $next.focus();
        }
    });

    $(document).on('keyup', '.prodPrice_', function(e) {
        /*  var key = (e.keyCode ? e.keyCode : e.which);
         var $isAuth = $(this).closest("tr").find(".title").attr("id");
         var $priceToken = $(this).closest("tr").find(".prodPrice_").attr("id");*/

        var costing = $(this).closest("tr").find(".cost_").val();
        var prodPriceVal =  $(this).closest("tr").find(".prodPrice_").val();
        $(this).closest("tr").find(".gp_").val( parseFloat( marginCalculator(costing,prodPriceVal)).toFixed(2));


    });
    $(document).on('keydown', '.inputs', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        var testLst = $(this).closest('tr');
        if ((code == 13 || code == 39)) {
            var index = $('.inputs').index(this) + 1;
            $('.inputs').eq(index).focus();
        }
        if (code == 37) {
            var index = $('.inputs').index(this) - 1;
            $('.inputs').eq(index).focus();
        }
        var closesttr =  $(this).closest('tr');
        var prodClosest = closesttr.find(".theProductCode_").val();
        var prodDescClosest = closesttr.find(".prodDescription_").val();
        var prodPriceClosest = closesttr.find(".prodPrice_").val();
        if ( (code == 34 || code == 13 || code == 39 ) && $.trim(prodClosest.length) > 0 && prodDescClosest.length > 0 &&  prodPriceClosest.length > 0) {
            generateALine2();

        }
    });
    $(document).on('keyup', '.lst', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13 || code == 9) {
            var index = $('.inputs').index(this);

            $('.lst').eq(index).focus();
            generateALine2();

        }
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
    function dateReturn(dates)
    {
        //27-02-2019
        var datearray = dates.split("-");
        if (datearray[0].length > 2){
            var newdateDelivDate = dates;
        }
        else {
            var newdateDelivDate = datearray[2] + '-' + datearray[1] + '-' + datearray[0];
        }


        return newdateDelivDate
    }
</script>