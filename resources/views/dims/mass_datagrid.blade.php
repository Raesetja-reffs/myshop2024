@extends('layouts.app')

@section('content')



    <div class="col-lg-12" >
        <a href='{!!url("/advancedcustomerspecials")!!}' onclick="window.open(this.href, 'advancedfilter',
'left=20,top=20,width=1400,height=950,toolbar=1,resizable=0'); return false;">Advanced Filter</a><br>
        <div  class="form-group col-md-2 itCanHide" >
            <h5>{{$datestring}}</h5>
        </div>
        <div class="form-group col-md-2 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="dateFromFilter"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date From</label>
            <input type="text" class="form-control input-sm col-xs-1" id="dateFromFilter" style="font-weight: 900;    color: black;font-size: 13px;" value="{{$dateFrom}}">
        </div>
        <div class="form-group col-md-2 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="dateToFilter"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date To</label>
            <input type="text" class="form-control input-sm col-xs-1" id="dateToFilter" style="font-weight: 900;    color: black;font-size: 13px;" value="{{$dateTo}}">
        </div>
        <div class="form-group col-md-2 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="marginfilterless"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Margin(Less than or equal to)</label>
            <input type="text" class="form-control input-sm col-xs-1" id="marginfilterless" style="font-weight: 900;    color: black;font-size: 13px;" value="100">
        </div>
        <div class="form-group col-md-2 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="marginfiltergreater"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Margin(Greater than or equal to)</label>
            <input type="text" class="form-control input-sm col-xs-1" id="marginfiltergreater" style="font-weight: 900;    color: black;font-size: 13px;" value="{{$marginG}}">

        </div>
        <div class="form-group col-md-2 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="marginfiltergreater"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Salesman Codes</label>
            <select id="salesmancodes">
                <option value="{{$currentRep}}">{{$currentRep}}</option>
                @foreach($salesmancodes as $val)
                    <option value="{{$val->strSalesmanCode}}">{{$val->strSalesmanCode}}</option>
                    @endforeach
            </select>

        </div>

        <button type="button" id="submitFiltersDate" class="btn-xs btn-primary">Submit</button>

        <button class="pull-right" id="savechanges" >Save Changes</button>
    </div>
    <div class="col-lg-12" >

        <button type="button" id="button_row" class="btn-xs btn-success">Add New Lines</button>

            <table class="table">
                <thead style="background: lavender;">
                <tr>
                    <td>Search</td>
                    <td>..</td>
                    <td class="col-sm-1"> <input id="customercode" type="text" class="form-control input-sm col-xs-1"  onkeyup="myFunction(2,'customercode')"> </td>
                    <td class="col-md-3"><input id="customername" onkeyup="myFunction(3,'customername')"> Customer Name</td>
                    <td class="col-sm-1"> <input id="itemcode" onkeyup="myFunction(4,'itemcode')"> Item Code</td>
                    <td class="col-md-3"><input id="itemname" onkeyup="myFunction(5,'itemname')"> Item Name</td>
                    <td class="col-md-1"><input id="costs" onkeyup="myFunction(6,'costs')" > Cost</td>
                    <td class="col-md-1"><input id="prices" onkeyup="myFunction(7,'prices')"> Price</td>
                    <td class="col-md-1"><input id="date_from" onkeyup="myFunction(8,'date_from')"> Date From</td>
                    <td class="col-md-1"><input id="date_to" onkeyup="myFunction(9,'date_to')"> Date To</td>
                    <td class="col-md-1"><input id="the_margin" onkeyup="myFunction(10,'the_margin')"> Margin (%)</td>
                </tr>
                </thead>
                <tbody id="scrollArea" class="clusterize-scroll">

                </tbody>
            </table>
        <div class="clusterize-scroll table-container">
        <table id="table" class="table  table-bordered table-condensed table-intel tablesorter clusterize-content fixed_header" style="font-family: sans-serif;color:black">
            <thead style="background: lavender;">
            <tr>
                <th></th>
                <th>Action</th>
                <th>Customer Code</th>
                <th><div id='column-header-1-sizer'></div>Customer Name</th>
                <th>Item Code</th>
                <th ><div id='column-header-1-sizer'></div>Item Name</th>
                <th> Cost</th>
                <th>Price</th>
                <th>Date From</th>
                <th>Date To</th>
                <th>Margin (%)</th>
            </tr>
            </thead>
            <tbody id="scrollArea" class="clusterize-scroll">
            @foreach($massspecialinfo as $val)
                    <tr style="background: {{$val->colors}}">
                        <?php $adv =  substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(13/strlen($x)) )),1,20); ?>
                        <td><i style="font-size: 0px;">{{$val->CustomerPastelCode}}</i><input type="checkbox" id="checkproduct_{{$adv}}"  name="checkproduct[]" style="height:12px !important;width:30px" value="{{$val->CustomerPastelCode}}"></td><td><button type="button" id="deleteaLine"  class="getOrderDetailLine btn-warning" value="{{$val->CustomerSpecial}}" >Delete</button></td>
                        <td contenteditable="false" class="col-sm-1"><i style="font-size: 0px;">{{$val->CustomerPastelCode}}</i><input name="customercode_" id ="customercode_{{$adv}}" class="customercode_ set_autocomplete inputs" value="{{$val->CustomerPastelCode}}"></td>
                        <td contenteditable="false" class="col-md-3" data-placeholder="Fuzzy search"><i style="font-size: 0px;">{{$val->StoreName}}</i><input name="customerDescription_" id ="customerDescription_{{$adv}}" class="customerDescription_ set_autocomplete inputs" value="{{$val->StoreName}}" tabindex="-1"></td>

                        <td contenteditable="false" class="col-sm-1"><i style="font-size: 0px;">{{$val->PastelCode}}</i><input name="theProductCode" id ="prodCode_{{$adv}}" class="theProductCode_ set_autocomplete inputs" value="{{$val->PastelCode}}" ></td>
                        <td contenteditable="false" class="col-md-3"><i style="font-size: 0px;">{{$val->PastelDescription}}</i><input name="prodDescription_" id ="prodDescription_{{$adv}}" class="prodDescription_ set_autocomplete inputs" tabindex="-1" value="{{$val->PastelDescription}}" ></td>

                        <td  contenteditable="false" class="col-md-1"><i style="font-size: 0px;">{{$val->CostPrice}}</i><input type="text" name="cost_" id ="cost_{{$adv}}"   onkeypress="return isFloatNumber(this,event)" class="cost_ resize-input-inside inputs" value="{{$val->CostPrice}}" ></td>
                        <td contenteditable="false"  class="col-md-1"><i style="font-size: 0px;">{{$val->Price}}</i><input type="text" name="prodPrice_" id ="prodPrice_{{$adv}}" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs" value="{{$val->Price}}"  style="font-weight: 800;width: 100%;" >
                        <td contenteditable="false" class="col-md-1"><i style="font-size: 0px;">{{$val->Date}}</i><input type="text" name="dateFrom"  id ="dateFrom_{{$adv}}" class="dateFrom resize-input-inside inputs"  value="{{$val->Date}}"  ></td>
                        <td contenteditable="false" class="col-md-1"><i style="font-size: 0px;">{{$val->DateTo}}</i><input type="text" name="dateTo"  id ="dateTo_{{$adv}}" class="dateTo resize-input-inside inputs" value="{{$val->DateTo}}"  ></td>
                        <td contenteditable="false" class="col-md-2"><i style="font-size: 0px;">{{$val->a}}</i><input type="text" name="margin"  id ="margin_{{$adv}}" class="margin resize-input-inside lst inputs" value="{{$val->a}}"  style="background:yellow">
                            <input type="hidden" class="hiddenChanged_ " id="hiddenChanged_{{$adv}}" value="{{$val->CustomerSpecial}}" ></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

            <button id="updatefiltered" class="btn-primary btn-md">Update Filtered Information</button>
        </div>
    </div>
        <script src="{{ asset('public/js/tableSorter.js') }}"></script>
@endsection
        <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>

<style>
    .tablesorter thead tr .header {
        background-image:url({{asset('images/bg.gif')}});
        background-repeat: no-repeat;
        background-position: center right;
        cursor: pointer;
    }

    .tablesorter thead tr .headerSortDown {
        background-image: url({{asset('images/asc.gif')}});
    }
    .tablesorter thead tr .headerSortDown {
        background-image: url({{asset('images/desc.gif')}});
    }


    /* max-height - the only parameter in this file that needs to be edited.
 * Change it to suit your needs. The rest is recommended to leave as is.
 */
    .clusterize-scroll{
        max-height: 600px;
        overflow: auto;
    }

    /**
     * Avoid vertical margins for extra tags
     * Necessary for correct calculations when rows have nonzero vertical margins
     */
    .clusterize-extra-row{
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }

    /* By default extra tag .clusterize-keep-parity added to keep parity of rows.
     * Useful when used :nth-child(even/odd)
     */
    .clusterize-extra-row.clusterize-keep-parity{
        display: none;
    }

    /* During initialization clusterize adds tabindex to force the browser to keep focus
     * on the scrolling list, see issue #11
     * Outline removes default browser's borders for focused elements.
     */
    .clusterize-content{
        outline: 0;
        counter-reset: clusterize-counter;
    }

    /* Centering message that appears when no data provided
     */
    .clusterize-no-data td{
        text-align: center;
    }
</style>
<script>


    var jArray = JSON.stringify({!! json_encode($products) !!});
    var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});
    var jArrayMass = JSON.stringify({!! json_encode($massspecialinfo) !!});
    var finalDataProduct = '';
    var finalData = '';

    $(document).ready(function() {
        //retreiveMassSpecialGrid();
      $('table').tablesorter();
        $( "#table table" ).colResizable({ liveDrag : true });

        var finalDataProduct = $.map(JSON.parse(jArray), function (item) {
            return {
                value: item.PastelCode,
                PastelCode: item.PastelCode,
                PastelDescription: item.PastelDescription,
                UnitSize: item.UnitSize,
                Tax: item.Tax,
                Cost: item.Cost,
                QtyInStock: item.QtyInStock,
                Margin: item.Margin,
                Alcohol: item.Alcohol,
                UnitWeight: item.UnitWeight,
                SoldByWeight: item.SoldByWeight,
                strBulkUnit: item.strBulkUnit,
                Available: parseFloat(item.Available).toFixed(2)
            }

        });
        var finalData = $.map(JSON.parse(jArrayCustomer), function (item) {

            return {

                CustomerPastelCode: item.CustomerPastelCode,
                StoreName: item.StoreName

            }

        });

        var JSONObject = JSON.parse(jArrayMass); // Replace ... with your JavaScript Object
        for(var i=0; i < JSONObject.length; i++) {
            console.log(JSONObject[i].CustomerPastelCode);
            var tokenId=Math.floor(Math.pow(10, 9-1) + Math.random() * 9 * Math.pow(10, 9-1));


        }

        $( "#table table" ).colResizable({ liveDrag : true });
        //$("#table").tablesorter();

        for(var i=0; i < 5; i++)
        {
            //generateALine2();
        }

        $('#button_row').click(function () {
            for(var i=0; i < 4; i++)
            {
                generateALine2();
            }
        });
        $('#QuoteDetails').hide();
        $('#extraInfo').hide();
        $('#salesQEmail').hide();
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#callList').hide();
        $('#copyOrdersBtn').hide();
        $('#tabletLoadingApp').hide();
        $('#pricingOnCustomer').hide();
        $('#salesOnOrder').hide();
        $('#posCashUp').hide();
        $('#dropdown').hide();
        $('#editTrucks').hide();
        $('#salesInvoiced').hide();

        $('#updatefiltered').click(function(){
            window.open ('{!!url("/changefiltereddatamassspecials")!!}/'+$('#marginfiltergreater').val()+'/'+$('#marginfilterless').val()+'/'+$('#dateFromFilter').val()+'/'+$('#dateToFilter').val()+'/'+$('#salesmancodes').val(), "mywindow",'left=20,top=20,width=1000,height=800,toolbar=1,resizable=0');
        });

        function generateALine2()
        {
            //calculator();
            var tokenId=Math.floor(Math.pow(10, 9-1) + Math.random() * 9 * Math.pow(10, 9-1));
            var $row = $('<tr id="new_row_ajax'+tokenId+'" class="fast_remove" style="font-weight: 600;font-size: 11px;">' +
                '<td><input type="checkbox" id="checkproduct_'+tokenId+'"  name="checkproduct[]" style="height:12px !important;width:30px" ></td><td><button type="button" id="deleteaLine"  class="getOrderDetailLine btn-warning" >Delete</button></td>'+
                '<td contenteditable="false" class="col-sm-1"><input name="customercode_" id ="customercode_'+tokenId+'" class="customercode_ set_autocomplete inputrow_selectedYellowish inputs"></td>' +
                '<td contenteditable="false" class="col-md-3"><input name="customerDescription_" id ="customerDescription_'+tokenId+'" class="customerDescription_ set_autocomplete inputrow_selectedYellowish inputs" tabindex="-1"></td>' +

                '<td contenteditable="false" class="col-sm-1"><input name="theProductCode" id ="prodCode_'+tokenId+'" class="theProductCode_ set_autocomplete inputrow_selectedYellowish inputs"></td>' +
                '<td contenteditable="false" class="col-md-3"><input name="prodDescription_" id ="prodDescription_'+tokenId+'" class="prodDescription_ set_autocomplete inputrow_selectedYellowish inputs" tabindex="-1"></td>' +

                '<td  contenteditable="false" class="col-md-1"><input type="text" name="cost_" id ="cost_'+tokenId+'"   onkeypress="return isFloatNumber(this,event)" class="cost_ resize-input-inside inputs"></td>' +
                '<td contenteditable="false"  class="col-md-1"><input type="text" name="prodPrice_" id ="prodPrice_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" >' +
                '<td contenteditable="false" class="col-md-1"><input type="text" name="dateFrom"  id ="dateFrom_'+tokenId+'" class="dateFrom resize-input-inside inputs"></td>' +
                '<td contenteditable="false" class="col-md-1"><input type="text" name="dateTo"  id ="dateTo_'+tokenId+'" class="dateTo resize-input-inside inputs"></td>' +
                '<td contenteditable="false" class="col-md-2"><input type="text" name="margin"  id ="margin_'+tokenId+'" class="margin resize-input-inside lst inputs" style="background:yellow">' +
                '<input type="hidden" class="hiddenChanged_" id="hiddenChanged_'+tokenId+'"   ></td>' +

                '</tr>');
            $('#table tbody')
                .append( $row )
                .trigger('addRows', [ $row, false ]);

            $( "#table table" ).colResizable({ liveDrag : true });

            $('.input').on('click keyup' ,function(){
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

                        source: finalDataProduct,
                        columns:columnsD,
                        autoFocus: true,
                        minlength: 2,
                        delay: 0,
                        multiple: true,
                        multipleSeparator: ",",
                        select:function (e, ui) {
                            var n = ID.indexOf("_");
                            var token_number = ID.substring(n + 1, ID.length);

                            $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                            $('#prodCode_' + token_number).val(ui.item.PastelCode);
                            //checkIfOrderHasMultipleProducts(ui.item.extra,token_number);
                            $('#prodQty_' + token_number).val('');

                            $('#table').find('#prodQty_' + token_number).focus();
                            $('#prodUnitSize_' + token_number).val(ui.item.UnitSize);
                            //   $('#instockReadOnly_' + token_number).val(ui.item.QtyInStock);
                            $('#taxCode' + token_number).val(ui.item.Tax);
                            $('#cost_' + token_number).val(ui.item.Cost);
                            $('#inStock_' + token_number).val(ui.item.Available);
                            $('#soldByWieght' + token_number).val(ui.item.SoldByWeight);
                            $('#unitWeight' + token_number).val(ui.item.UnitWeight);
                            $('#strBulkUnit' + token_number).val(ui.item.strBulkUnit);
                            $('#margin_' + token_number).val(ui.item.Margin);


                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            //productPrice(token_number);


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

                            $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                            $('#prodCode_' + token_number).val(ui.item.PastelCode);

                            $('#prodQty_' + token_number).val('');
                            $('#prodQty_' + token_number).focus();

                            $('#table').find('#prodQty_' + token_number).focus();
                            $('#prodUnitSize_' + token_number).val(ui.item.UnitSize);

                            $('#taxCode' + token_number).val(ui.item.Tax);
                            $('#cost_' + token_number).val(ui.item.Cost);
                            $('#inStock_' + token_number).val(ui.item.Available);
                            $('#soldByWieght' + token_number).val(ui.item.SoldByWeight);
                            $('#unitWeight' + token_number).val(ui.item.UnitWeight);
                            $('#strBulkUnit' + token_number).val(ui.item.strBulkUnit);
                            $('#margin_' + token_number).val(ui.item.Margin);

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                        }

                    });
                }


                //The customers
                if ($(this).hasClass("customercode_") && $(this).hasClass("set_autocomplete")) {


                    var inputCustNames = $("" + jID + "").flexdatalist({
                        minLength: 1,
                        valueProperty: '*',
                        selectionRequired: true,
                        focusFirstResult: true,
                        searchContain:true,
                        visibleProperties: ["StoreName","CustomerPastelCode"],
                        searchIn: 'CustomerPastelCode',
                        data: finalData
                    });
                    inputCustNames.on('select:flexdatalist', function (event, data) {

                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);
                        $('#customercode_' + token_number).val(data.CustomerPastelCode);
                        $('#customerDescription_' + token_number).val(data.StoreName);

                    });
                }

                if ($(this).hasClass("customerDescription_") && $(this).hasClass("set_autocomplete")) {
                    var inputCustNames = $("" + jID + "").flexdatalist({
                        minLength: 1,
                        valueProperty: '*',
                        selectionRequired: true,
                        focusFirstResult: true,
                        searchContain:true,
                        visibleProperties: ["StoreName","CustomerPastelCode"],
                        searchIn: 'StoreName',
                        data: finalData
                    });
                    inputCustNames.on('select:flexdatalist', function (event, data) {

                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);
                        $('#customercode_' + token_number).val(data.CustomerPastelCode);
                        $('#customerDescription_' + token_number).val(data.StoreName);

                    });
                }
                //calculator();
            });

        }
        $(".dateFrom,.dateTo,#dateFromFilter,#dateToFilter").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });

        //submitFiltersDate
        $('#submitFiltersDate').on('click',function() {
            window.location = '{!!url("/masscusterspecialdatefilter")!!}/'+$('#dateFromFilter').val()+'/'+$('#dateToFilter').val()+'/'+$('#marginfilterless').val()+'/'+$('#marginfiltergreater').val()+'/'+$('#salesmancodes').val();
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#table tbody').on('click', 'tr', function (e){
            $("#table tbody tr").removeClass('inputrow_selectedYellowish');
            $(this).addClass('inputrow_selectedYellowish');
        });
        $('#savechanges').on('click',function() {
            var valuesProd = new Array();
            $.each($("input[name='checkproduct[]']:checked"),
                function () {
                    var data = $(this).parents('tr:eq(0)');
                    var Prodcost =$(data).find('.theProductCode_').val();
                    //var codeID = $(this).find('#area_'+$(data).find('td:eq(0)').text()).val();
                    console.debug('*************change*******'+Prodcost );

                    if ((Prodcost.trim()).length > 0)
                    {
                        valuesProd.push({'theProductCode_': $(data).find('.theProductCode_').val(),'customerCode':$(data).find('.customercode_').val(),
                            'prodPrice_':$(data).find('.prodPrice_').val(),'dateFrom':$(data).find('.dateFrom').val(),
                            'dateTo':$(data).find('.dateTo').val(),'margin':$(data).find('.margin').val(),'hiddenChanged_':$(data).find('.hiddenChanged_').val(),'cost_':$(data).find('.cost_').val()});
                    }

                });
            $.ajax({
                url: '{!!url("/masscustomerspecialupgrade")!!}',
                type: "POST",
                data: {
                    griddetails: valuesProd
                },
                success: function (data) {

                    console.debug(data);
                    alert("DATA SAVED")
                    //location.reload(true);

                }
            });
        });
        $('#table').on('click', 'button', function (e) {
             var theVal = $(this).val();
            var $this = $(this);
            $.ajax({
                url: '{!!url("/removeCustomerSpecial")!!}',
                type: "POST",
                data: {
                    removeSpecial: theVal,

                },
                success: function (data) {

                    if (data.deletedId != 'FAILED') {

                            $this.closest('tr').remove();


                    }
                    else {
                        // $('#table').on('click', 'button', function (e) {
                        var dialog = $('<p><strong style="color:red">Sorry something went wrong when deleting a line ,please try again</strong></p>').dialog({
                            height: 200, width: 700, modal: true, containment: false,
                            buttons: {
                                "Okay": function () {
                                    dialog.dialog('close');
                                }
                            }
                        });
                    }
                    calculator();

                }
            });
        });


        $('input ,select').on('click keyup' ,function() {
            // $('input').click(function(){
            var ID = $(this).attr('id');
            var jID = '#' + ID;
            var x = ID.indexOf("_");
            var get_token_number = ID.substring(x+1,ID.length);
            console.debug("--********"+get_token_number);
            $("#checkproduct_"+get_token_number).prop('checked',true);
            // var areaIs =
            $("#hiddenChanged_"+get_token_number).val();
        });
});

    $(document).on('keyup', '.lst', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13 || code == 9) {
            console.debug("sales");
            var myRow = $('#table').find("tr").last();
            var prod = myRow.find(".theProductCode_").val();
            var prodDesc = myRow.find(".prodDescription_").val();
            var prodQty_ = myRow.find(".prodQty_").val();
            var prodPrice_ = myRow.find(".prodPrice_").val();
            var myRowId = $('#table').find("tr").last().attr("id");

            if (prod.length < 1 || prodDesc.length < 1 || prodQty_.length < 1 || prodPrice_.length < 1)
            {

                var index = $('.inputs').index(this);
                myRow.find(".theProductCode_").focus();
            }else
            {
                $('.lst').eq(index).focus();
                generateALine2();


            }


        }
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
});
function marginCalculator(cost,onCellVal)
{
    return (1-(cost/onCellVal))*100;
}
function marginToPrice(cost,margin)
{
    return (cost/(1-(margin/100)));
}
$(document).on('keyup', '.margin', function(e) {
    var margin = $(this).closest("tr").find(".margin").val();
    var cost = $(this).closest("tr").find(".cost_  ").val();
    $(this).closest("tr").find(".prodPrice_ ").val(  parseFloat(marginToPrice(cost,margin)).toFixed(2)) ;
});
function isFloatNumber(item,evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode==46)
    {
        var regex = new RegExp(/\./g)
        var count = $(item).val().match(regex).length;
        if (count > 1)
        {
            return false;
        }
    }
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

    $(document).on('keyup', '.margin', function(e) {
        var margin = $(this).closest("tr").find(".margin").val();
        var cost = $(this).closest("tr").find(".cost_ ").val();
        $(this).closest("tr").find(".prodPrice_ ").val(  parseFloat(marginToPrice(cost,margin)).toFixed(2)) ;
    });
$(document).on('keyup', '.prodPrice_ ', function(e) {

        var price = $(this).closest("tr").find(".prodPrice_").val();
        var cost = $(this).closest("tr").find(".cost_ ").val();

        $(this).closest("tr").find(".margin ").val(  parseFloat(marginCalculator(cost,price)).toFixed(2)) ;
    });
    function myFunction(x,id) {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById(id);
        filter = input.value.toUpperCase();
        table = document.getElementById("table");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[x];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function retreiveMassSpecialGrid()
    {
        $.ajax({
            url: '{!!url("/getJsonCustomerGrid")!!}',
            type: "GET",
            data: {
                dateFrom:$('#dateFromFilter').val(),
                dateTo:$('#dateToFilter').val(),
                marginfilterless:$('#marginfilterless').val(),
                marginfiltergreater:$('#marginfiltergreater').val()
            },
            success: function (data) {
                var trHTML = '';
                $('.fast_removeOrders').empty();
                $.each(data, function (key, value) {
                    var tokenId=Math.floor(Math.pow(10, 9-1) + Math.random() * 9 * Math.pow(10, 9-1));
                    trHTML += '<tr role="row" class="fast_removeOrders"  style="color:black">' +
                     '<td><i style="font-size: 0px;">'+value.CustomerPastelCode+'</i><input type="checkbox" id="checkproduct_'+tokenId+'" name="checkproduct[]" style="height:12px !important;width:30px" value="' + value.CustomerPastelCode + '"></td>' +
                        '<td><button type="button" id="deleteaLine"  class="getOrderDetailLine btn-warning" value="'+value.CustomerSpecial+'" >Delete</button></td>'+
                     '<td contenteditable="false" class="col-sm-1"><i style="font-size: 0px;">'+value.CustomerPastelCode+'</i><input name="customercode_" id ="customercode_'+tokenId+'"  class="customercode_ set_autocomplete inputs" value="' + value.CustomerPastelCode + '"></td>'+
                      '<td contenteditable="false" class="col-md-3" data-placeholder="Fuzzy search"><i style="font-size: 0px;">'+value.StoreName+'</i><input name="customerDescription_" id ="customerDescription_'+tokenId+'" class="customerDescription_ set_autocomplete inputs" value="' + value.StoreName + '" tabindex="-1"></td>'+

                    '<td contenteditable="false" class="col-sm-1"><i style="font-size: 0px;"> '+value.PastelCode+'</i><input name="theProductCode" id ="prodCode_'+tokenId+'" class="theProductCode_ set_autocomplete inputs"   value="' + value.PastelCode + '" ></td>'+
                    ' <td contenteditable="false" class="col-md-3"><i style="font-size: 0px;">'+value.PastelDescription+'</i><input name="prodDescription_" id ="prodDescription_'+tokenId+'" class="prodDescription_ set_autocomplete inputs" tabindex="-1"  value="' + value.PastelDescription + '"></td>'+

                    '<td  contenteditable="false" class="col-md-1"><i style="font-size: 0px;">'+value.CostPrice+'</i><input type="text" name="cost_" id ="cost_'+tokenId+'"  onkeypress="return isFloatNumber(this,event)" class="cost_ resize-input-inside inputs" value="' + value.CostPrice + '"></td>'+
                    '<td contenteditable="false"  class="col-md-1"><i style="font-size: 0px;">'+value.Price+'</i><input type="text" name="prodPrice_" id ="prodPrice_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs" value="' + value.Price + '" style="font-weight: 800;width: 100%;" ></td>'+
                        '<td contenteditable="false" class="col-md-1"><i style="font-size: 0px;">'+value.Date+'</i><input type="text" name="dateFrom"  id ="dateFrom_'+tokenId+'" class="dateFrom resize-input-inside inputs" value="' + value.Date + '"  ></td>'+
                    '<td contenteditable="false" class="col-md-1"><i style="font-size: 0px;"> '+value.DateTo+'</i><input type="text" name="dateTo"  id ="dateTo_'+tokenId+'" class="dateTo resize-input-inside inputs"   value="' + value.DateTo + '" ></td>'+
                   ' <td contenteditable="false" class="col-md-2"><i style="font-size: 0px;">'+value.a+'</i><input type="text" name="margin"  id ="margin_'+tokenId+'" class="margin resize-input-inside lst inputs"   value="' + value.a + '"  style="background:yellow">'+
                        '<input type="hidden" class="hiddenChanged_ " id="hiddenChanged_'+tokenId+'"   value="' + value.CustomerSpecial + '" ></td></tr>';
                });
                $('#table').append(trHTML);
            }
            });

    }
</script>