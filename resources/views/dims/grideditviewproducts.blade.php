@extends('layouts.app')

@section('content')

    <div style="height:85%;    overflow: scroll;">
        <input type="text"  class="form-control input-sm col-xs-1" id="myInput" onkeyup="myFunction()" placeholder="Search...">

        <table  class="table table-bordered table-condensed" style="font-family: sans-serif;color:black">
            <thead>
            <tr>
                <td>Code</td>
                <td class="col-lg-4" style="">Item Name</td>
                <td>Picking Team
                <td>is Sold By Weight</td>
                <td>Weight</td>
                <td>Mass</td>
                <td>Bulk Unit Of Measure</td>
                <td>Duplicate On Order</td>
                <td>Bin Number</td>
                <td>Product Margin</td>
                <td>Status</td>
                <td></td>
            </tr>
            </thead>
            <tbody id="gridEditProducts">
            @foreach($producsts as $value)
                <tr class="content">
                    <td><input name="code_" id ="Code_{{$value->ProductId}}" class="code_ set_autocomplete inputs" value="{{$value->PastelCode}}" ></td>
                    <td><input name="description_" id ="description_{{$value->ProductId}}" class="description_ set_autocomplete inputs" value="{{$value->PastelDescription}}" ></td>
                    <td><select name="" class="area_ set_autocomplete inputs" id ="team_{{$value->ProductId}}" style="background:grey"> <option value="{{$value->PickingTeam}}">{{$value->PickingTeam}}</option> @foreach($PickingTeams as $val)<option style="color:blue" value="{{$val->PickingTeam}}">{{$val->PickingTeam}}</option>  @endforeach  </select> </td>
                    <td><input name="SoldByWeight_" class="SoldByWeight_" id ="SoldByWeight_{{$value->ProductId}}" class="SoldByWeight_ set_autocomplete inputs" value="{{$value->SoldByWeight}}" ></td>
                    <td><input name="Weight_" class="Weight_" id ="Weight_{{$value->ProductId}}" class="Weight_ set_autocomplete inputs" value="{{round($value->UnitWeight,3)}}" ></td>
                    <td><input name="Mass_" class="Mass_" id ="Mass_{{$value->ProductId}}" class="Mass_ set_autocomplete inputs" value="{{$value->Mass}}" ></td>
                    <td><input name="BulkUnit_" class="BulkUnit_" id ="BulkUnit_{{$value->ProductId}}" class="BulkUnit_ set_autocomplete inputs" value="{{$value->strBulkUnit}}" ></td>
                    <td><input name="MultiLine_" class="MultiLine_" id ="MultiLine_{{$value->ProductId}}" class="Bin_ set_autocomplete inputs" value="{{$value->MultiLineItem}}" ></td>
                    <td><select name="Bin_" class="Bin_" id ="Bin_{{$value->ProductId}}" class="Bin_ set_autocomplete inputs" value="{{$value->Binnumber}}" ><option value="{{$value->Binnumber}}">{{$value->Binnumber}}</option> @foreach($intBinId as $val)<option style="color:blue" value="{{$val->strBin}}">{{$val->strBin}}</option>  @endforeach </select></td>
                    <td><input name="Margin_" class="Margin_" id ="Margin_{{$value->ProductId}}" class="Margin_ set_autocomplete inputs" value="{{$value->ProductMargin}}" ></td>
                    <td><input name="Status_" class="Status_" id ="Status_{{$value->ProductId}}" class="Status_ set_autocomplete inputs" value="{{$value->Status}}" ></td>
                    <td><input type="checkbox" id="checkproduct_{{$value->ProductId}}" name="checkproduct[]" style="height:12px !important;width:30px" value="{{$value->PastelCode}}"></td>
                    <input type="hidden" class="hiddenChanged_" id="hiddenChanged_{{$value->ProductId}}" value="{{$value->PickingTeam}}">
                    <input type="hidden" class="ProductId_" id="ProductId_{{$value->ProductId}}" value="{{$value->ProductId}}">
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <button id="saveschanges" class="btn-md btn-success">SAVE CHANGES</button>
        <button id="printlabels" class="btn-md btn-primary  pull-right">Print Labels</button>
    </div>
@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>

<script>

    $(document).on('keydown','#gridEditProducts', function(e) {
        var $table = $(this);
        var $active = $('input:focus,select:focus',$table);
        var $next = null;
        var focusableQuery = 'input:visible,select:visible,textarea:visible';
        var position = parseInt( $active.closest('td').index()) + 1;
        console.log('position :',position);
        switch(e.keyCode){
            case 37: // <Left>
                $next = $active.parent('td').prev().find(focusableQuery);
                break;
            case 38: // <Up>
                $next = $active
                    .closest('tr')
                    .prev()
                    .find('td:nth-child(' + position + ')')
                    .find(focusableQuery)
                ;

                break;
            case 39: // <Right>
                $next = $active.closest('td').next().find(focusableQuery);
                break;
            case 40: // <Down>
                $next = $active
                    .closest('tr')
                    .next()
                    .find('td:nth-child(' + position + ')')
                    .find(focusableQuery)
                ;
                break;

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

        //
        $('.area_').on('change', function() {
            //alert( this.value );
            //alert( $(this).find(":selected").val() );
            var $this = this.value;
            var id = $(this).attr('id');
            var x = id.indexOf("_");
            var get_token_number = id.substring(x+1,id.length);

            $("#hiddenChanged_"+get_token_number).val($this );
            //
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
            $("#hiddenChanged_"+get_token_number).val($("#team_"+get_token_number).val());
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#saveschanges').on('click',function() {
            var valuesProd = new Array();
            $.each($("input[name='checkproduct[]']:checked"),
                function () {
                    var data = $(this).parents('tr:eq(0)');
                    var Prodcost = $(data).find('.hiddenChanged_').val();
                    //var codeID = $(this).find('#area_'+$(data).find('td:eq(0)').text()).val();
                    console.debug('*************change*******'+Prodcost );

                    valuesProd.push({'team_': Prodcost,'code_':$(data).find('.code_').val(),'id_':$(data).find('.ProductId_').val(),
                        'description':$(data).find('.description_').val(),'Mass':$(data).find('.Mass_').val(),
                        'Weight':$(data).find('.Weight_').val(),'BulkUnit':$(data).find('.BulkUnit_').val(),
                        'MultiLine':$(data).find('.MultiLine_').val(),'Bin':$(data).find('.Bin_').val(),
                        'Margin':$(data).find('.Margin_').val(),'Status':$(data).find('.Status_').val(),
                        'SoldByWeight':$(data).find('.SoldByWeight_').val()});
                });
            $.ajax({
                url: '{!!url("/updategridproductsAndTeams")!!}',
                type: "POST",
                data: {

                    griddetails: valuesProd
                },
                success: function (data) {
                    location.reload(true);

                }
            });
        });
        $('#printlabels').on('click',function() {
            var valuesProd = new Array();
            $.each($("input[name='checkproduct[]']:checked"),
                function () {
                    var data = $(this).parents('tr:eq(0)');
                    var Prodcost = $(data).find('.hiddenChanged_').val();
                    //var codeID = $(this).find('#area_'+$(data).find('td:eq(0)').text()).val();
                    console.debug('*************change*******'+Prodcost );

                    valuesProd.push({'team_': Prodcost,'code_':$(data).find('.code_').val(),'id_':$(data).find('.ProductId_').val()
                     });
                });
            $.ajax({
                url: '{!!url("/printbulklabels")!!}',
                type: "POST",
                data: {

                    griddetails: valuesProd
                },
                success: function (data) {
                    location.reload(true);

                }
            });
        });
    });
    $(document).on('click', '.Weight_ ', function(e) {
        $(this).select();
    });
    $(document).on('click', '.Mass_', function(e) {
        $(this).select();
    });
    $(document).on('click', '.BulkUnit_', function(e) {
        $(this).select();
    });
    $(document).on('click', '.MultiLine_', function(e) {
        $(this).select();
    });
    $(document).on('click', '.Friday_', function(e) {
        $(this).select();
    });
    $(document).on('click', '.Bin_', function(e) {
        $(this).select();
    });
    $(document).on('click', '.Margin_', function(e) {
        $(this).select();
    });
    $(document).on('click', '.Status_', function(e) {
        $(this).select();
    });
    $(document).on('click', '.SoldByWeight_', function(e) {
        $(this).select();
    });
    function myFunction() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("gridEditProducts");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    function filterText()
    {
        var rex = new RegExp($('#filterText').val());
        if(rex =="/all/"){clearFilter()}else{
            $('.content').hide();
            $('.content').filter(function() {
                return rex.test($(this).text());
            }).show();
        }
    }

    function clearFilter()
    {
        $('.filterText').val('');
        $('.content').show();
    }
</script>