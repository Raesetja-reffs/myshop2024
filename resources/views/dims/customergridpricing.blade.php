@extends('layouts.app')

@section('content')



    <div class="col-lg-12" >

        <div class="form-group col-md-2 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="dateFromFilter"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date From</label>
            <input type="text" class="form-control input-sm col-xs-1" id="dateFromFilter" value="{{$dateFrom}}" style="font-weight: 900;    color: black;font-size: 13px;">
        </div>
        <div class="form-group col-md-2 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="dateToFilter"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;" >Date To</label>
            <input type="text" class="form-control input-sm col-xs-1" id="dateToFilter" value="{{$dateto}}" style="font-weight: 900;    color: black;font-size: 13px;">
        </div>
        <div class="form-group col-md-2 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="dateFromFilter2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date From2</label>
            <input type="text" class="form-control input-sm col-xs-1" id="dateFromFilter2" value="{{$dateFrom2}}" style="font-weight: 900;    color: black;font-size: 13px;">
        </div>
        <div class="form-group col-md-2 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="dateToFilter2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;" >Date To2</label>
            <input type="text" class="form-control input-sm col-xs-1" id="dateToFilter2" value="{{$dateto2}}" style="font-weight: 900;    color: black;font-size: 13px;">
        </div>
        <div class="form-group col-md-2 itCanHide">
            <button type="button" id="submitFiltersDate" class="btn-xs btn-primary">Submit</button>
        </div>
        <button class="pull-right" id="savechanges" >Save Changes</button>
    </div>
    <div class="col-lg-12" >
<input id="custAcc" value="{{$custAcc}}">
<button class="btn-lg btn-danger" id="printpreview">Preview & Print</button>
        <table class="table">
            <thead style="background: lavender;">
            <tr>
                <td>Search</td>
                <td>..</td>
                <td class="col-sm-1"> <input id="customercode" type="text" class="form-control input-sm col-xs-1"  onkeyup="myFunction(2,'customercode')"> Product Name</td>


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
                    <th>PastelCode</th>
                    <th>PastelDescription</th>
                    <th>This Year</th>
                    <th>Last Year</th>
                    <th>Qty Trend</th>

                    <th>Cost</th>
                    <th>Price</th>
                    <th>Special Price</th>
                    <th>Listed Price</th>
                    <th>Margin (%)</th>
                </tr>
                </thead>
                <tbody id="scrollArea" class="clusterize-scroll">
                @foreach($customergridpricing as $val)
                    <tr>
                        <?php $adv =  substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(13/strlen($x)) )),1,20); ?>
                        <td><i style="font-size: 0px;">{{$val->PastelCode}}</i><input type="checkbox" id="checkproduct_{{$adv}}"  name="checkproduct[]" style="height:12px !important;width:30px" value="{{$val->PastelCode}}"></td>
                        <td contenteditable="false" class="col-sm-1"><i style="font-size: 0px;">{{$val->PastelCode}}</i><input name="PastelCode_" id ="PastelCode_{{$adv}}" class="PastelCode_ set_autocomplete inputs" value="{{$val->PastelCode}}"></td>
                        <td contenteditable="false" class="col-md-3" data-placeholder="Fuzzy search"><i style="font-size: 0px;">{{$val->PastelDescription}}</i><input name="PastelDescription_" id ="PastelDescription_{{$adv}}" class="PastelDescription_ set_autocomplete inputs" value="{{$val->PastelDescription}}" tabindex="-1"></td>

                            <td contenteditable="false" class="col-md-1"><i style="font-size: 0px;">{{$val->thisyear}}</i><input name="thisyear_" id ="thisyear_{{$adv}}" class="thisyear_ set_autocomplete inputs" tabindex="-1" value="{{$val->thisyear}}" ></td>

                            <td contenteditable="false" class="col-sm-1"><i style="font-size: 0px;">{{$val->lastyear}}</i><input name="lastyear" id ="lastyear_{{$adv}}" class="lastyear_ set_autocomplete inputs" value="{{$val->lastyear}}" ></td>
                            @if($val->qtytrend < 0)
                            <td  contenteditable="false" class="col-md-1"><i style="font-size: 0px;">{{$val->qtytrend}}</i><input type="text" name="qtytrend_" id ="qtytrend_{{$adv}}"    class="qtytrend_ resize-input-inside inputs" value="{{$val->qtytrend}}" style="font-weight: 800;width: 100%;background: red" ></td>
                            @else
                                <td contenteditable="false"  class="col-md-1"><i style="font-size: 0px;">{{$val->qtytrend}}</i><input type="text" name="trendPercent_" id ="trendPercent_{{$adv}}" class="trendPercent_ resize-input-inside inputs" value="{{$val->qtytrend}}"  style="font-weight: 800;width: 100%;background: greenyellow" ></td>
                            @endif
                        <td contenteditable="false" class="col-md-1"><i style="font-size: 0px;">{{$val->Cost}}</i><input type="text" name="Cost"  id ="Cost_{{$adv}}" class="Cost_ resize-input-inside inputs"  value="{{$val->Cost}}"  ></td>
                        <td contenteditable="false" class="col-md-1"><i style="font-size: 0px;">{{$val->Price}}</i><input type="text" name="Price" id ="Price_{{$adv}}" class="Price_ resize-input-inside inputs" style="background:#4a10ff;color:white;font-weight: 900;" value="{{$val->Price}}"  ></td>
                        <td contenteditable="false" class="col-md-1"><i style="font-size: 0px;">{{$val->cutp}}</i><input type="text" name="cutp"  id ="cutp_{{$adv}}" class="cutp_ resize-input-inside inputs" value="{{$val->cutp}}"  ></td>
                        <td contenteditable="false" class="col-md-1"><i style="font-size: 0px;">{{$val->listprice}}</i><input type="text" name="listprice"  id ="listprice_{{$adv}}" class="listprice resize-input-inside inputs" value="{{$val->listprice}}"  ></td>
                        <td contenteditable="false" class="col-md-2"><i style="font-size: 0px;">{{$val->Margin}}</i><input type="text" name="margin"  id ="margin_{{$adv}}" class="margin resize-input-inside lst inputs" value="{{$val->Margin}}"  style="background:yellow">
                            <input type="hidden" class="hiddenChanged_ " id="hiddenChanged_{{$adv}}" value="{{$val->PastelCode}}" ></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div id="Attention" title="ATTENTION.........." style="background: red">
            <h1>THIS WILL CREATE OR UPDATE PRICING ON CUSTOMER SPECIAL ,PLEASE NOTE THAT THIS WILL NOT UPDATE YOUR LIST PRICE FOR THE CUSTOMER </h1>
            <button class="btn-md btn-danger" id="close">OKAY</button>
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

            var finalDataProduct = '';
            var finalData = '';

            $(document).ready(function() {
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
                $('#Attention').hide();
                //   $("table#table").trigger("update");

                $('#printpreview').click(function(){

                    window.open('{!!url("/viewcustomerpricingjson")!!}/'+$('#custAcc').val()+'/'+$('#dateFromFilter').val()+'/'+$('#dateToFilter').val()+'/'+$('#dateFromFilter2').val()+'/'+$('#dateToFilter2').val(),'_blank');

                });

                //$('table').DataTable();

                $('table').tablesorter();
                $( "#table table" ).colResizable({ liveDrag : true });


                $( "#table table" ).colResizable({ liveDrag : true });


                $("#dateFromFilter").datepicker({
                    changeMonth: true,//this option for allowing user to select month
                    changeYear: true, //this option for allowing user to select from year range
                    dateFormat: 'yy-mm-dd'
                });
                $("#dateToFilter").datepicker({
                    changeMonth: true,//this option for allowing user to select month
                    changeYear: true, //this option for allowing user to select from year range
                    dateFormat: 'yy-mm-dd'
                });
                $("#dateFromFilter2").datepicker({
                    changeMonth: true,//this option for allowing user to select month
                    changeYear: true, //this option for allowing user to select from year range
                    dateFormat: 'yy-mm-dd'
                });
                $("#dateToFilter2").datepicker({
                    changeMonth: true,//this option for allowing user to select month
                    changeYear: true, //this option for allowing user to select from year range
                    dateFormat: 'yy-mm-dd'
                });

                //submitFiltersDate
                $('#submitFiltersDate').on('click',function() {
                    window.location = '{!!url("/customerupdatepricingfromcustomerssalespage")!!}/'+$('#custAcc').val()+'/'+$('#dateFromFilter').val()+'/'+$('#dateToFilter').val()+'/'+$('#dateFromFilter2').val()+'/'+$('#dateToFilter2').val();
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
                    $('#Attention').show();
                    var valuesProd = new Array();
                    $.each($("input[name='checkproduct[]']:checked"),
                        function () {
                            var data = $(this).parents('tr:eq(0)');
                            var Prodcost =$(data).find('.PastelCode_').val();
                            //var codeID = $(this).find('#area_'+$(data).find('td:eq(0)').text()).val();
                            console.debug('*************change*******'+Prodcost );//

                            if ((Prodcost.trim()).length > 0)
                            {
                                valuesProd.push({'theProductCode_': $(data).find('.PastelCode_').val(),'Price_':$(data).find('.Price_').val(),'dateFrom':$('#dateFromFilter2').val(),'cutp_':$(data).find('.cutp_').val(),
                                    'dateTo':$('#dateToFilter2').val(),'listprice': $(data).find('.listprice').val(),'custCode':$('#custAcc').val()});
                            }

                        });
                    $.ajax({
                        url: '{!!url("/updatecustomergridpricing")!!}',
                        type: "POST",
                        data: {
                            griddetails: valuesProd
                        },
                        success: function (data) {

                            console.debug(data);
                            alert("DATA SAVED");
                            //location.reload(true);

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

            $(document).on('keyup', '.Price_', function(e) {
                var margin = $(this).closest("tr").find(".Price_").val();
                var cost = $(this).closest("tr").find(".Cost_").val();
                $(this).closest("tr").find(".margin").val(  parseFloat(marginCalculator(cost,margin)).toFixed(2)) ;
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
        </script>
