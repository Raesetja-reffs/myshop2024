<x-app-layout>

    <x-slot name="header">
        {{ __('Overall Special') }}
    </x-slot>

    <x-slot name="breadcrum">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                Home </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <!--end::Item-->

        <!--begin::Item-->
        <li class="breadcrumb-item text-dark">
            Overall Special </li>
        <!--end::Item-->
    </x-slot>

    @include('dims.overallspecial.partials.searchbar')

    @include('dims.overallspecial.partials.listing')

    <div id="popUpdateLine" title="Please Update">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="specialIdUpdate">Special Id</label>
                        <input type="text" id="specialIdUpdate" class="form-control" readonly>
                    </div>
                    <div class="col-md-12 mb-3">
                        <input type="hidden"  class="form-control" id="hiddenSpecaialFrom" >
                        <input type="hidden"  class="form-control" id="hiddenSpecaialTo" >

                        <label for="itemCode">Code</label>
                        <input type="text" id="itemCode" class="form-control" readonly>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="itemDescription">Description</label>
                        <input type="text" class="form-control" id="itemDescription" readonly>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="specialFrom">Date From</label>
                        <input type="text" class="form-control" id="specialFrom">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="specialTo">Date To</label>
                        <input type="text" class="form-control" id="specialTo">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="specialPrice">Special Price</label>
                        <input type="text" class="form-control" id="specialPrice">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="specialCost">Special Cost</label>
                        <input type="text" class="form-control" id="specialCost" readonly>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="specialGp">GP</label>
                        <input type="text" class="form-control" id="specialGp" readonly>
                    </div>
                    <div class="col-md-12">
                        <button id="updateTheSpecuial" class="btn btn-success btn-sm">Update the Specials</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="updatedspecials" title="Specials Updated">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <button id="btnspecialUpdated" class="btn btn-success btn-sm">OKAY</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    </style>

    <script>
        var jArray = JSON.stringify({!! json_encode($products) !!});
        var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});
        $( document ).on( 'focus', ':input', function(){
            $( this ).attr( 'autocomplete', 'off' );
        });

        $(function() {
            $('.colResizable').colResizable({
                // liveDrag: true, // Allow live dragging of columns
                // minWidth: 50 // Set a minimum width for columns
            });
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


            $(".dateTo").datepicker({
                changeMonth: true,//this option for allowing user to select month
                changeYear: true, //this option for allowing user to select from year range
                dateFormat: 'dd-mm-yy'
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        //showDialog('#tempDeliveryAddressOnTheFly','50%',250);
            $('#submitFiltersOnCustSpecial').click(function(){
                if (($.trim($('#dateFrom').val())).length > 7 && ($.trim($('#dateTo').val())).length > 7){
                    $('#specialslink').empty();
                    generateALine2();
                    $('#afterFilter').show();
                    var from = $.datepicker.formatDate('yy-mm-dd',$.datepicker.parseDate('dd-mm-yy', $('#dateFrom').val()) );
                    var dateTo = $.datepicker.formatDate('yy-mm-dd',$.datepicker.parseDate('dd-mm-yy', $('#dateTo').val()) );

                    console.debug('********'+from);
                    console.debug('******** dateTo'+dateTo);
                    $('#specialslink').append("");
                    $('#specialslink').append(`
                        <a href="{!!url('/overallSpecailJasper')!!}/${from}/${dateTo}"
                            target="blank"
                            class="btn btn-primary btn-sm mb-1 mb-sm-0 me-1"
                        >
                            Spread sheet
                        </a>
                    `);

                    //Select * between this date for this customer

                    $.ajax({
                        url: '{!!url("/overallSpecailByDateOrContract")!!}',
                        type: "POST",
                        data: {
                            dateFrom: $('#dateFrom').val(),
                            dateTo:  $('#dateTo').val()

                        },
                        success: function (data) {
                            var trHTML ="";
                            $('.remthisLine').remove();

                            $.each(data, function (key,value) {
                                trHTML += `
                                    <tr class="remthisLine">
                                        <td>${value.Specialid}</td>
                                        <td>${value.SpecialHeaderId}</td>
                                        <td>${value.PastelCode}</td>
                                        <td>${value.PastelDescription}</td>
                                        <td>${value.Date}</td>
                                        <td>${value.DateTo}</td>
                                        <td>${parseFloat(value.Price).toFixed(2)}</td>
                                        <td>${parseFloat(value.Cost).toFixed(2)}</td>
                                        <td>${parseFloat(value.GP).toFixed(2)}</td>
                                        <td style="display: none;">${parseFloat(value.CostPrice).toFixed(2)}</td>
                                        <td>${value.strOverallSpecialType}</td>
                                        <td>${value.locationName}</td>
                                        <td class="text-center">
                                            <button class="btn btn-icon btn-danger btn-sm btn-sm-icon remove_current_special_product_line" value="${value.Specialid}">
                                                <i class="bi bi-trash3-fill fs-4"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `;
                                $('#specialId').val( value.SpecialHeaderId);
                            });

                            $('#tblCreatedCustomerSpecials tbody').append(trHTML);
                        }
                    });
                }else {
                    alert("Please check your date criteria");
                }
            });

            $(document).on('click', '.remove_current_special_product_line', function(e) {
                var $this = $(this);
                var $thisVal = $(this).attr("value");
                $.ajax({
                    url: '{!!url("/removeOverallSpecial")!!}',
                    type: "POST",
                    data: {
                        removeSpecial: $thisVal
                    },
                    success: function (data) {
                        var dialog = $('<p>Special Removed</p>').dialog({
                            height: 200, width: 700, modal: true, containment: false,
                            buttons: {
                                OKAY: {
                                    text: "OKAY",
                                    class: "btn btn-success btn-sm",
                                    click: function() {
                                        $this.closest('tr').remove();
                                        dialog.dialog('close');
                                    }
                                }
                            }
                        });
                    }
                });
            });

            $('#pleaseAddNewCust').click(function(){
                window.open('{!!url("/addNewGroupSpecial")!!}', "newGroupSpecial", "width=1000, height=800, scrollbars=yes");
            });
            $('#tblCreatedCustomerSpecials tbody').on('click', 'tr', function (e) {
                $("#tblCreatedCustomerSpecials tbody tr").removeClass('row_selected');
                $(this).addClass('row_selected');
            });
            $('#tblCreatedCustomerSpecials tbody').on('dblclick', 'tr', function (e){
                $("#tblCreatedCustomerSpecials tbody tr").removeClass('row_selected');
                $(this).addClass('row_selected');
                $('#popUpdateLine').show();
                showDialog('#popUpdateLine', '40%', 560);
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
                        url: '{!!url("/updateOverallSpecialLine")!!}',
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
                            showDialog('#updatedspecials',380,120);
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
            var contractFrom = $('#dateFrom').val();
            var contractTo = $('#dateTo').val();
            var tokenId=Math.floor(Math.pow(10, 9-1) + Math.random() * 9 * Math.pow(10, 9-1));
            var $row = $(`
                <tr id="new_row_ajax${tokenId}" class="fast_remove">
                    <td contenteditable="false">
                        <input name="theProductCode" id="prodCode_${tokenId}" class="theProductCode_ set_autocomplete inputs form-control" style="width: 200px;">
                    </td>
                    <td contenteditable="false">
                        <input name="prodDescription_" id="prodDescription_${tokenId}" class="prodDescription_ set_autocomplete inputs form-control" style="width: 300px;">
                    </td>
                    <td contenteditable="false">
                        <input type="text" name="dateFrom" id="dateFrom${tokenId}" value="${contractFrom}" title="in stock" class="dateFrom resize-input-inside inputs form-control">
                    </td>
                    <td contenteditable="false">
                        <input type="text" name="dateTo" id="dateTo${tokenId}" value="${contractTo}" class="dateTo resize-input-inside inputs form-control">
                    </td>
                    <td contenteditable="false">
                        <input type="text" name="prodPrice_" id="prodPrice_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs lst form-control" style="font-weight: 800;">
                    </td>
                    <td contenteditable="false">
                        <input type="text" name="cost_" id="cost_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="cost_ resize-input-inside inputs form-control" style="font-weight: 800;" readonly>
                    </td>
                    <td contenteditable="false">
                        <input type="text" name="gp_" id="gp_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="gp_ resize-input-inside inputs form-control" style="font-weight: 800;" readonly>
                    </td>
                    <td contenteditable="false">
                        <input type="text" name="costCreated_" id ="costCreated_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="costCreated_ resize-input-inside inputs form-control" style="font-weight: 800;" readonly>
                    </td>
                    <td class="text-center">
                        <button type="button" id="cancelThis" class="btn btn-icon btn-danger btn-sm btn-sm-icon cancel delete_table_row">
                            <i class="bi bi-trash3-fill fs-4"></i>
                        </button>
                    </td>
                </tr>
            `);

            $('#tblCreateNewSpecial tbody').append( $row ).trigger('addRows', [ $row, false ]);
            if (!$('.lst').is(":focus")) {
                $('#prodCode_' + tokenId).focus().click();

                if ($('#checkboxDescription').is(':checked')) {
                    $('#prodDescription_' + tokenId).focus().click();
                }
            }

            $(".dateTo,.dateFrom").datepicker({
                changeMonth: true,//this option for allowing user to select month
                changeYear: true, //this option for allowing user to select from year range
                dateFormat: 'dd-mm-yy'
            });
        }
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
        function marginCalculator(cost,onCellVal)
        {
            return ((cost/onCellVal))*100;
        }
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
        $(document).on('keyup', '#specialPrice', function(e) {
            $('#specialGp').val(parseFloat( marginCalculator($('#specialCost').val(),$('#specialPrice').val())).toFixed(2));
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

    </script>

</x-app-layout>
