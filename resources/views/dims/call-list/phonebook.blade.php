<x-app-layout>
    <x-slot name="header">
        {{ __('Extra Contacts') }}
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
            Call List </li>
        <!--end::Item-->
    </x-slot>

    <div class="card mb-5 mt-5">
        <div class="card-body">
            <form>
                <div class="row">
                    <h5>Filters</h5>
                    <div class="col-md-4 mb-2">
                        <label for="inputCustAcc">Customer Code</label>
                        <input type="text" name="custCode" class="form-control" id="inputCustAcc">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="inputCustName">Customer Name</label>
                        <input type="text" name="custDescription" class="form-control" id="inputCustName">
                        <input type="hidden" name="customerid" class="form-control" id="customerid" >
                    </div>
                    <div class="col-md-4 mb-2">
                        <button type="button" id="submitFiltersOnCustSpecial" class="btn btn-primary btn-sm mt-md-6">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-12" id="afterFilter">
        <h5 id="specialslink"></h5>
        <div class="col-lg-6">
            <h4>Current Contacts</h4>
            <table id ="tblCustomerPhoneBook" class="table table-bordered table-condensed" style="font-family: sans-serif;" tabindex=0>
                <thead>
                <tr style="font-size: 12px;">
                    <td>System ID</td>
                    <td>Company</td>
                    <td>Contact Person</td>
                    <td>Contact Numbers</td>
                    <td>Reference</td>
                    <td></td>

                </tr>
                </thead>
                <tbody></tbody>

            </table>

        </div>
        <div class="col-lg-6" style="background: green;height: 80%;">

            <button class="btn-success btn-xs" id="addLine">Add Line</button>
            <div class="col-lg-12" style="background: white;height: 60%;overflow-y: scroll">


                <table id ="tblCreateNewContanct" class="table table-bordered table-condensed">
                    <thead>
                    <tr style="font-size: 12px;">

                        <td>Contact Person</td>
                        <td>Contact Numbers</td>
                        <td>Reference</td>
                        <td></td>

                    </tr>
                    </thead>
                    <tbody></tbody>

                </table>

            </div>
            <div class="col-lg-12" style="background: white;">
                <button id="doneCreating" class="btn-xs btn-success">Done</button>
            </div>
        </div>

    </div>
    <div id="popUpdateLine" title="Please Update">
        <div class="col-lg-12" >
            <label class="control-label" for="specialIdUpdate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Contact Person</label><br>
            <input type="text"  class="form-control input-sm col-xs-1" id="" style="font-weight: 900;    color: black;font-size: 13px;" readonly><br>
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
</x-app-layout>

<script>
    $( document ).on( 'focus', ':input', function(){
        $(this).attr('autocomplete', 'off');
    });
    $(document).keydown(function(e) {
        if (e.keyCode == 27) return false;
    });
    var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var finalDataProduct = $.map(JSON.parse(jArrayCustomer), function (item) {
        return {
            BalanceDue:item.BalanceDue,
            CustomerPastelCode:item.CustomerPastelCode,
            StoreName:item.StoreName,
            UserField5:item.UserField5,
            CustomerId:item.CustomerId,
            CreditLimit:item.CreditLimit,
            Email:item.Email,
            Routeid:item.Routeid,
            Discount:item.Discount,
            OtherImportantNotes:item.OtherImportantNotes,
            Routeid:item.Routeid,
            strRoute:item.strRoute,
            mnyCustomerGp:item.mnyCustomerGp,
            Warehouse:item.Warehouse,
            ID:item.ID
        }

    });
    var finalDataProductDescription = $.map(JSON.parse(jArrayCustomer), function (item) {
        return {
            BalanceDue:item.BalanceDue,
            CustomerPastelCode:item.CustomerPastelCode,
            StoreName:item.StoreName,
            UserField5:item.UserField5,
            CustomerId:item.CustomerId,
            CreditLimit:item.CreditLimit,
            Email:item.Email,
            Routeid:item.Routeid,
            Discount:item.Discount,
            OtherImportantNotes:item.OtherImportantNotes,
            Routeid:item.Routeid,
            strRoute:item.strRoute,
            mnyCustomerGp:item.mnyCustomerGp,
            Warehouse:item.Warehouse,
            ID:item.ID
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
            visibleProperties: ["CustomerPastelCode","StoreName"],
            searchIn: 'StoreName',
            data: finalDataProductDescription
        });
        inputGroupAccount.on('select:flexdatalist', function (event, data) {
            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#inputCustName').val(data.StoreName);
            $('#customerid').val(data.CustomerId);
        });
        var inputCode = $('#inputCustAcc').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode","StoreName"],
            searchIn: 'CustomerPastelCode',
            data: finalDataProductDescription
        });
        inputCode.on('select:flexdatalist', function (event, data) {
            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#inputCustName').val(data.StoreName);
            $('#customerid').val(data.CustomerId);
        });

        $('#addLine').click(function(){
            generateALine2();
        });

        $('#doneCreating').click(function()
        {
            var contacts = new Array();
            $('#tblCreateNewContanct > tbody  > tr').each(function() {
                if (($(this).closest('tr').find('.ContactPerson_').val()).length > 0 && ($(this).closest('tr').find('.ContactNumbers_').val()).length > 0 ) {
                    contacts.push({
                        'ContactPerson': $(this).closest('tr').find('.ContactPerson_').val(),
                        'ContactNumbers': $(this).closest('tr').find('.ContactNumbers_').val(),
                        'ReferenceNo': $(this).closest('tr').find('.ReferenceNo').val()
                    });
                }
            });
            $.ajax({
                url: '{!!url("/savephonebook")!!}',
                type: "GET",
                data: {
                    contacts: contacts,
                    customerid:$('#customerid').val()
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

        $('#submitFiltersOnCustSpecial').click(function(){
            $('#tblCreateNewContanct tbody').empty();
            generateALine2();
            $('#afterFilter').show();
            $.ajax({
                url: '{!!url("/customerphonebookcontacts")!!}',
                type: "GET",
                data: {
                    customerId: $('#customerid').val()
                },
                success: function (data) {
                    var trHTML ="";
                    $('.remthisLine').remove();

                    $.each(data, function (key,value) {
                        trHTML += '<tr  class="remthisLine" style="font-size: 11px;color:black;"><td>' +
                            value.intCustomerContactID + '</td><td>' +
                            value.StoreName + '</td><td>' +
                            value.ContactPerson + '</td><td>' +
                            value.ContactNumbers + '</td><td>' +
                            value.ReferenceNo +
                            '</td>'+
                            '<td><button class="btn-sx" value="' +value.intCustomerContactID +'">Delete</button></td></tr>';

                    });
                    $('#tblCustomerPhoneBook').append(trHTML);
                }
            });
        });

        $('#tblCustomerPhoneBook').on('click', 'button', function (e) {
            var $this = $(this);
            var $thisVal = $(this).val();
            $.ajax({
                url: '{!!url("/removePhoneBookContact")!!}',
                type: "GET",
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

        $('#pleaseAddNewCust').click(function(){
            window.open('{!!url("/addNewGroupSpecial")!!}', "newGroupSpecial", "width=1000, height=800, scrollbars=yes");
        });
        $('#tblCustomerPhoneBook tbody').on('click', 'tr', function (e) {
            $("#tblCustomerPhoneBook tbody tr").removeClass('row_selected');
            $(this).addClass('row_selected');
        });
        $('#tblCustomerPhoneBook tbody').on('dblclick', 'tr', function (e){
            $("#tblCustomerPhoneBook tbody tr").removeClass('row_selected');
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
        var contractFrom = $('#dateFrom').val();
        var contractTo = $('#dateTo').val();
        var tokenId=Math.floor(Math.pow(10, 9-1) + Math.random() * 9 * Math.pow(10, 9-1));
        var $row = $('<tr id="new_row_ajax'+tokenId+'" class="fast_remove" style="font-weight: 600;font-size: 11px;">' +
            '<td contenteditable="false" class="col-sm-4"><input name="ContactPerson" id ="ContactPerson_'+tokenId+'" class="ContactPerson_ set_autocomplete inputs"></td>' +
            '<td contenteditable="false" class="col-md-2"><input name="ContactNumbers_" id ="ContactNumbers_'+tokenId+'" maxlength="10"  onkeypress="return isNumber(event)" class="ContactNumbers_ set_autocomplete inputs" tabindex="-1"></td>' +
            '<td  contenteditable="false" class="col-md-6"><input type="text" name="ReferenceNo" id ="ReferenceNo'+tokenId+'" title="in stock" class="ReferenceNo resize-input-inside inputs"></td>' +
            '<td><button type="button" id="cancelThis" class="btn-danger btn-xs cancel" style="height: 16px;padding: 0px 5px;font-size: 9px;">Cancel</button></td></tr>');
        $('#tblCreateNewContanct tbody')
            .append( $row )
            .trigger('addRows', [ $row, false ]);
        if(!$('.lst').is(":focus"))
        {
            $('#ContactPerson_' + tokenId).focus();
        }

        $('#tblCreateNewContanct').on('click', 'button', function (e) {
            var $this = $(this);
            var $thisVal = $(this).val();
            $this.closest('tr').remove();
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
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
