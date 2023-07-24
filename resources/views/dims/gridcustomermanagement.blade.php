@extends('layouts.app')

@section('content')

    <div style="height:85%;    overflow: scroll;">
        <?php
        $routeoptions = "";
        $userList = "";
        $groupsList = "";
        foreach($routes as $val)
        {
            $routeoptions .= "<option value='$val->RouteId'>$val->Route</option>";
        }
        foreach($users as $val)
        {
            $userList .= " <option value='$val->UserID'>$val->UserName</option>";
        }
        foreach($groups as $val)
        {
            $groupsList .= "<option value='$val->GroupId'>$val->GroupName</option> ";
        }
        ?>
        <div>
        <div class="col-xs-3" >
            <select  id="rouTabletLoadingtesonPlanning" class="form-control input-sm col-xs-1" name="multicheckbox[]" multiple="multiple" >

                @foreach($routes as $values)
                    <option value="{{$values->RouteId}}">{{$values->Route}}</option>
                @endforeach

            </select>
        </div>
            <div class="col-xs-3" >
            <select  id="userslist" class="form-control input-sm col-xs-1" name="multicheckbox[]" multiple="multiple" >

                @foreach($users as $values)
                    <option value="{{$values->UserID}}">{{$values->UserName}}</option>
                @endforeach

            </select>
        </div>
            <div class="col-xs-3" >
                <button class="btn-mf btn-primary" id="filters">GO</button>
            </div>

        </div>
        <input type="text"  class="form-control input-sm col-xs-1" id="myInput" onkeyup="myFunction()" placeholder="Search...">

        <table id="gridEditCustomers" class="table table-bordered table-condensed table-intel tablesorter" style="font-family: sans-serif;color:black">
        <thead>
            <tr>
                <th >CustomerCode<div id='column-header-1-sizer'></div></th>
                <th >Customer Name<div id='column-header-1-sizer'></div></th>
                <th>Route<div id='column-header-1-sizer'></div></th>
                <th>Salesman</th>
                <th>Group</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thurs</th>
                <th >Fri</th>
                <th>Sat</th>
                <th>Sun</th>
                <th>BuyerName(s)</th>
                <th>Buyer Contact(s)</th>
                <th>Tel</th>
                <th>Cell</th>
                <td></td>
            </tr>
        </thead>
        <tbody>


        @foreach($customereditablelist as $value)
            <tr class="content">
                <td><input name="customerDescription_" id ="customerDescription_{{$value->CustomerPastelCode}}" class="customerCode_ set_autocomplete inputs" value="{{$value->CustomerPastelCode}}" ></td>
                <td><input name="area_" id ="customerCode_{{$value->CustomerPastelCode}}" class="customerDescription_ set_autocomplete inputs" value="{{$value->storeName}}" ></td>
                <td><select name="" class="area_ set_autocomplete inputs" id ="area_{{$value->CustomerPastelCode}}"> <option value="{{$value->routeid}}">{{$value->strRoute}}</option><?php echo $routeoptions ?>  </select> </td>
                <td><select name="" class="Salesman_" id ="Salesman_{{$value->CustomerPastelCode}}"> <option value="{{$value->UserID}}">{{$value->UserName}}</option> <?php echo $userList ?>    </select></td>
                <td><select name="" class="group" id ="group_{{$value->CustomerPastelCode}}"> <option value="{{$value->GroupId}}">{{$value->GroupName}}</option>  <?php echo $groupsList ?>    </select></td>
                <td><input name="area_" class="Monday_" id ="Monday_{{$value->CustomerPastelCode}}" class="Monday_ set_autocomplete inputs" value="{{$value->Monday}}" ></td>
                <td><input name="area_" class="Tuesday_" id ="Tuesday_{{$value->CustomerPastelCode}}" class="Tuesday_ set_autocomplete inputs" value="{{$value->Tueday}}" ></td>
                <td><input name="area_" class="Wednesday_" id ="Wednesday_{{$value->CustomerPastelCode}}" class="Wednesday_ set_autocomplete inputs" value="{{$value->Wednesday}}" ></td>
                <td><input name="area_" class="Thursday_" id ="Thursday_{{$value->CustomerPastelCode}}" class="Thursday_ set_autocomplete inputs" value="{{$value->Thursday}}" ></td>
                <td><input name="area_" class="Friday_" id ="Friday_{{$value->CustomerPastelCode}}" class="Friday_ set_autocomplete inputs" value="{{$value->Friday}}" ></td>
                <td><input name="area_" class="Saturday_" id ="Saturday_{{$value->CustomerPastelCode}}" class="Saturday_ set_autocomplete inputs" value="{{$value->Saturday}}" ></td>
                <td><input name="area_" class="Sunday_" id ="Sunday_{{$value->CustomerPastelCode}}" class="Sunday_ set_autocomplete inputs" value="{{$value->Sunday}}" ></td>

                <td><input name="ContactPerson_"  id ="ContactPerson_{{$value->CustomerPastelCode}}" class="ContactPerson_ set_autocomplete inputs" value="{{$value->ContactPerson}}" ></td>
                <td><input name="BuyerContact_"   id ="BuyerContact_{{$value->CustomerPastelCode}}" class="BuyerContact_ set_autocomplete inputs" value="{{$value->BuyerContact}}" ></td>
                <td><input name="BuyerTelephone_"   id ="BuyerTelephone_{{$value->CustomerPastelCode}}" class="BuyerTelephone_ set_autocomplete inputs" value="{{$value->BuyerTelephone}}" ></td>
                <td><input name="CellPhone_"  id ="CellPhone_{{$value->CustomerPastelCode}}" class="CellPhone_ set_autocomplete inputs" value="{{$value->CellPhone}}" ></td>
                <td><input type="checkbox" id="checkproduct_{{$value->CustomerPastelCode}}" name="checkproduct[]" style="height:12px !important;width:30px" value="{{$value->CustomerPastelCode}}"></td>
                <input type="hidden" class="hiddenChanged_" id="hiddenChanged_{{$value->CustomerPastelCode}}" value="{{$value->routeid}}">
            </tr>
         @endforeach
        </tbody>
    </table>

    </div>
    <div>
        <button id="saveschanges" class="btn-md btn-success">SAVE CHANGES</button>
    </div><script src="{{ asset('public/js/tableSorter.js') }}"></script>
@endsection

<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script src="{{ asset('js/jquery.easy-autocomplete.min.js') }}"></script>
<link href="{{ asset('css/easy-autocomplete.min.css') }}" rel="stylesheet"  type='text/css'>
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
</style>

<script>

    $(function() {
        var thHeight = $("table#gridEditCustomers th:first").height();
        $("table#gridEditCustomers th").resizable({
            handles: "e",
            minHeight: thHeight,
            maxHeight: thHeight,
            minWidth: 40,
            resize: function (event, ui) {
                var sizerID = "#" + $(event.target).attr("id") + "-sizer";
                $(sizerID).width(ui.size.width);
            }
        });
    });

    $(document).on('keydown','#gridEditCustomers', function(e) {
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

        $('#rouTabletLoadingtesonPlanning').multiselect({
            columns: 1,
            placeholder: 'Select Route(s)',
            selectAll: true
        });
        $('#userslist').multiselect({
            columns: 1,
            placeholder: 'Select user(s)',
            selectAll: true
        });

        $('#filters').click(function(){
            var routes = ($('#rouTabletLoadingtesonPlanning').val()).join();
            var users = ($('#userslist').val()).join();
            window.location = '{!!url("/gridCustomermanagement")!!}/'+users+'/'+routes;

        });

        $("#gridEditCustomers").tablesorter();

        $('.content input ,.content select').on('click keyup' ,function() {
            // $('input').click(function(){
            var ID = $(this).attr('id');
            var jID = '#' + ID;
            var x = ID.indexOf("_");
            var get_token_number = ID.substring(x+1,ID.length);
            console.debug("--********"+get_token_number);
            $("#checkproduct_"+get_token_number).prop('checked',true);
           // var areaIs =
            $("#hiddenChanged_"+get_token_number).val($("#area_"+get_token_number).val());
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
                    console.debug('*************change*******'+$(data).find('.area_').val() );

                    valuesProd.push({'route': $(data).find('.area_').val(),'customerCode':$(data).find('.customerCode_').val(),
                        'Monday':$(data).find('.Monday_').val(),'Tuesday':$(data).find('.Tuesday_').val(),
                        'Wednesday':$(data).find('.Wednesday_').val(),'Thursday':$(data).find('.Thursday_').val(),
                        'Friday':$(data).find('.Friday_').val(),'Saturday':$(data).find('.Saturday_').val(),
                        'ContactPerson_':$(data).find('.ContactPerson_').val(),'BuyerContact_':$(data).find('.BuyerContact_').val(),
                        'BuyerTelephone_':$(data).find('.BuyerTelephone_').val(),'CellPhone_':$(data).find('.CellPhone_').val(),
                        'Sunday':$(data).find('.Sunday_').val(),'Salesman_':$(data).find('.Salesman_').val(),'group_':$(data).find('.group').val()});
                });
            $.ajax({
                url: '{!!url("/updategridroutes")!!}',
                type: "POST",
                data: {
                    griddetails: valuesProd
                },
                success: function (data) {
                   // location.reload(true);

                }
            });
        });


    });
    $(document).on('click', '.Monday_', function(e) {
        $(this).select();
    });
    $(document).on('click', '.Tuesday_', function(e) {
        $(this).select();
    });
    $(document).on('click', '.Wednesday_', function(e) {
        $(this).select();
    });
    $(document).on('click', '.Thursday_', function(e) {
        $(this).select();
    });
    $(document).on('click', '.Friday_', function(e) {
        $(this).select();
    });
    $(document).on('click', '.Saturday_', function(e) {
        $(this).select();
    });
    $(document).on('click', '.Sunday_', function(e) {
        $(this).select();
    });

    function myFunction() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("gridEditCustomers");
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

    function getCustomerInfo()
    {
        $.ajax({
            url: '{!!url("/getRouteDataMultiSelected")!!}',
            type: "POST",
            data: {
                routeId: $('#rouTabletLoadingtesonPlanning').val(),
                user: $('#userslist').val()

            },
            success: function (data) {
                var trHTML = '';

                var classes = 'onDrag';
                $('.onDrag').remove();

                $.each(data, function (key, value) {


                    trHTML += '<tr role="row" class="'+classes+'" style="height: 26px !important;"  >'+
                        '<td style="height: 26px ;font-size:10px;color:black;">' +
                        value.OrderDate + '</td><td style="height: 26px ;font-size:10px;color:blue;    font-weight: 900;">' +
                        value.DeliveryDate + '</td><td style="height: 26px ;font-size:10px;color:black;">' +
                        value.Route + '</td><td style="background:yellow;font-size:14px">' +

                        value.StoreName+ '</td><td style="height: 26px ;font-size:10px;color:black;">' +
                        value.InvoiceNo + '</td><td style="height: 26px ;font-size:10px;color:black;">' +
                        value.OrderId + '</td><td style="font-weight:900">' +
                        value.OrderType + '</td><td style="display: none;">' +
                        value.OrderTypeId + '</td><td style="display: none;">' +
                        value.RouteId + '</td><td>' +
                        value.DeliverySequence + '</td><td style="color:blue;font-size: 8;">' +
                        parseFloat(value.Mass).toFixed(3) + '</td><td  style="font-size: 10px;">' +
                        parseFloat(value.OrderValue).toFixed(3) + '</td><td style="height: 26px ;font-size:10px;color:black;">' +
                        value.deliveryAddress1 + '</td><td style="font-size:10px;">' +
                        value.optionalField + '</td><td>' +
                        value.tTime + '  </td><td>' +
                        '<button class="btn-xs btn-success" style="width: 50px;height: 24px;font-size: 8px;"  value="'+value.OrderId+'">View</button>' +
                        '</td><td><input type="checkbox" name="caseProd[]" style="height:20px;width:30px" onchange="Selectallcheckbox('+status+','+value.OrderId +')" class="ghost" value="'+value.OrderId+'"  readTheOnly></td><td>' +
                        value.UserField3+
                        '<td></tr>';
                });
                $('#unsequenced').append(trHTML);
                $('#mass').val(parseFloat(massTotal).toFixed(3));
                $('#ordervaluetot').val(parseFloat(ordervalue).toFixed(2));
                $("#unsequenced").trigger("update");



            }
        });
    }
</script>