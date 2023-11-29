/**
 * Created by Reginald on 29/07/2017.
 */

/**This Script is mainly used for common stuffs
 *
 * @param tag = usually is a div id ,or ID of any html element /Paul would say a control instead of element
 * @param url = ajax url as defined in Laravel routes
 */
function getRoutes(tag,url)
{
    $.ajax({
        url: url,
        type: "GET",
        success: function(data){
            var toAppend = '';
            $.each(data,function(i,o){
                console.debug("All routes");

                toAppend += '<option value="'+o.Routeid+'">'+o.Route+'</option>';
            });
            $(tag).append(toAppend);
        }
    });
}
function getOrderTypes(tag,url)
{
    $.ajax({
        url: url,
        type: "GET",
        success: function(data){
            var toAppend = '';
            $.each(data,function(i,o){
                toAppend += '<option value="'+o.OrderTypeId+'">'+o.OrderType+'</option>';
            });

            $(tag).append(toAppend);

        }
        ,
        error : function(xhr, textStatus, errorThrown ) {
            if (textStatus == 'timeout') {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    //try again
                    $.ajax(this);
                    return;
                }
                return;
            }
            if (xhr.status == 500) {
                //handle error
            } else {
                //handle error
            }
        }
    });
}
function sendMail(url,subject,body,type,CustomerCode)
{

    $.ajax({
        url: url,
        type: "POST",
        data:{CustomerCode:CustomerCode,
            Subject:subject,
            Body:body,
            Type:type
        },
        success: function(data){
           //alert(data);
        }
    });
}
function appenOderIds(tag,url)
{
    $(tag).empty();
    $.ajax({
        url: url,
        type: "GET",
        success: function(data){
            var toAppend = '';
            $.each(data,function(i,o){
                var option = o.OrderId+' -- '+o.StoreName;
                toAppend += '<option value="'+o.OrderId+'">'+option+'</option>';
            });

            $(tag).append(toAppend);

        }
    });
}
function appenOderIdsOfCustomer(tag,url,customerCode)
{
    $(tag).empty();
    $.ajax({
        url: url,
        type: "POST",
        data:{customerCode:customerCode},
            success: function(data){
            var toAppend = '';
            $.each(data,function(i,o){
                toAppend += '<option value="'+o.OrderId+'">'+o.OrderId+'</option>';
            });

            $(tag).append(toAppend);

        }
    });
}

function getDeliveryDates(tag,url)
{
    $.ajax({
        url: url,
        type: "GET",
        success: function(data){
            var toAppend = '';
            toAppend += '<option value=""></option>';
            $.each(data,function(i,o){
                console.debug("DeliveryDate");
                toAppend += '<option value="'+o.DeliveryDate+'">'+o.DeliveryDate+'</option>';
            });
            $(tag).append(toAppend);
        }
    });
}

function getDimsUsers(tag,url)
{
    $.ajax({
        url: url,
        type: "GET",
        success: function(data){
            var toAppend = '';
            toAppend += '<option value=""></option>';
            $.each(data,function(i,o){

                toAppend += '<option value="'+o.UserID+'">'+o.UserName+'</option>';
            });

            $(tag).append(toAppend);

        }
    });
}
/**
 * This function get the price of the product depending on customer code and dellivery date
 * @param customerCode  the customer account -known as customerPastelCode
 * @param deliveryDate  the delivery date ,this is created at the time the order is generated
 * @param productCode   product code
 * @returns {number}
 */
function getPriceForProductDependingOnCustAndDeliveryDate(url,customerCode,deliveryDate,productCode,warehouseid)
{
    var price='';
    $.ajax({
        url:url,
        type: "POST",
        data:{customerID:customerCode,deliveryDate : deliveryDate ,productCode: productCode,warehouseid},
        success: function(data){
            console.debug(data);
            if($.isEmptyObject(data)){
                price = '';
            }else {
                price = parseFloat(data[0].Price).toFixed(2);
            }

        }
    });
    return price;
}

function readyMadeLineOrderLine(tag,prodDesc,prodCodes,prodQty,price,cost,instock,titles,tax,unitSizes,prohib,UnitWeight,SoldByWeight,strBulkUnit,ProductMargin,multiLines,linediscount,dicountproperty,weneedauth,shelf)
{
    calculator();
    var myRow = $(tag).find("tr").last();
    var prod = myRow.find(".theProductCode_").val();
    var myRowId = $(tag).find("tr").last().attr("id");

    console.debug("************************************ AUTMUTLIWAREHOUSE"+multiLines);
    if (multiLines ==1)
    {
        var classAnonymouscols="anonymouscols";
    }else
    {
        var classAnonymouscols="anonymouscolsOff";
    }

    if (prod.length < 1)
    {
        $("#"+myRowId).remove();
    }
    //console.debug("SoldByWeight "+SoldByWeight);
    console.debug("dicountproperty "+dicountproperty);
    console.debug("linediscount "+linediscount);
    var tokenId=new Date().valueOf();
    var $row = $(`
        <tr id="new_row_ajax${tokenId}" class="fast_remove">
            <td class="text-center">
                <input type="hidden" id="title_${tokenId}" class="title" value ="${titles}"/>
                <input type="hidden" id="theOrdersDetailsId" value=""/>
                <input type="hidden" id ="taxCode${tokenId}" value ="${tax}" class="taxCodes"/>
                <input type="hidden" id ="cost_${tokenId}" value ="${cost}" class="costs"/>
                <input type="hidden" id ="inStock_${tokenId}" value ="${instock}" class="inStock"/>
                <input type="hidden" value ="${tokenId}" class="hiddenToken"/>
                <input type="hidden" id ="priceholder_${tokenId}" value="${price}" class="priceholder"/>
                <input type="hidden" id ="alcohol_${tokenId}" value="" class="alcohol"/>
                <input type="hidden" id ="margin_${tokenId}" value ="${ProductMargin}" class="margin"/>
                <input type="hidden" id ="soldByWieght${tokenId}" class="soldByWieght" value="${SoldByWeight}"/>
                <input type="hidden" id ="unitWeight${tokenId}" class="unitWeight" value="${UnitWeight}"/>
                <input type="hidden" id ="strBulkUnit${tokenId}" class="strBulkUnit" value="${strBulkUnit}"/>
                <input type="hidden" id ="prohibited_${tokenId}" value ="${prohib}" class="prohibited"/>
                <button type="button" id="cancelThis" class="btn btn-icon btn-danger btn-sm btn-sm-icon cancel">
                    <i class="bi bi-trash3-fill fs-4"></i>
                </button>
            </td>
            <td contenteditable="false">
                <input style="width: 100px;" name="theProductCode" id ="prodCode_${tokenId}" class="theProductCode_ set_autocomplete inputs form-control" value="${prodCodes}">
                <input name="col1" id ="col1_${tokenId}" class="col1 ${classAnonymouscols}" readonly>
            </td>
            <td contenteditable="false">
                <input style="width: 250px;" name="prodDescription_" id ="prodDescription_${tokenId}" class="prodDescription_ set_autocomplete inputs form-control" title="${prodDesc}" value="${prodDesc}">
                <input name="col8" id ="col8_${tokenId}" class="col8 ${classAnonymouscols}" readonly>
            </td>
            <td contenteditable="false">
                <input style="width: 65px;" type="text" name="prodBulk_"  id ="prodBulk_${tokenId}" class="prodBulk_ resize-input-inside inputs form-control">
                <input name="col3" id ="col3_${tokenId}" class="col3 ${classAnonymouscols}" readonly>
            </td>
            <td contenteditable="false">
                <input style="width: 65px;" type="text" name="prodQty_" id ="prodQty_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="prodQty_ resize-input-inside inputs form-control" value ="${prodQty}">
                <input name="col4" id ="col4_${tokenId}" class="col4 ${classAnonymouscols}" readonly>
            </td>
            <td contenteditable="false">
                <input style="width: 100px;" type="text" name="prodPrice_" id ="prodPrice_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs form-control" value ="${price}" style="font-weight: 800;">
            </td>
            <td contenteditable="false">
                <input style="width: 80px;" type="text" name="prodDisc_" id ="prodDisc_${tokenId}" onkeypress="return isFloatNumber(this,event)" class="prodDisc_ resize-input-inside inputs form-control" value ="${linediscount}" ${dicountproperty}>
                <input name="col6" id ="col6_${tokenId}" class="col6 ${classAnonymouscols}" style="color: brown;" readonly>
            </td>
            <td contenteditable="false">
                <input style="width: 75px;" type="text" name="prodUnitSize_" id ="prodUnitSize_${tokenId}" class="prodUnitSize_ resize-input-inside inputs form-control" value="${unitSizes}">
            </td>
            <td contenteditable="false" style="display: flex;">
                <input style="width: 100px; color: blue;" type="text" name="instockReadOnly" id ="instockReadOnly_${tokenId}" value ="${instock}" class="instockReadOnly_ resize-input-inside inputs form-control">
                <input style="width: 100px; color: red;" type="text" name="shelf_" id ="shelf_${tokenId}" value ="${shelf}" class="shelf_ resize-input-inside inputs form-control">
                <select name="col2" id ="col2_${tokenId}" class="col2 ${classAnonymouscols}">
                </select>
            </td>
            <td contenteditable="false">
                <input style="width: 100px; color:blue;" type="text" name="clcstock" id ="clcstock_${tokenId}" value ="${instock}" class="clcstock_ resize-input-inside inputs form-control">
            </td>
            <td contenteditable="false">
                <input style="width: 100px; color:blue;" type="text" name="additionalcost_" id ="additionalcost_${tokenId}" value ="" class="additionalcost_ resize-input-inside inputs form-control">
            </td>
            <td  contenteditable="false">
                <input style="width: 200px;" type="text" name="prodComment_" id ="prodComment_${tokenId}" class="prodComment_ resize-input-inside inputs lst form-control">
                <input name="col9" id ="col9_${tokenId}" class="col9 ${classAnonymouscols}" readonly>
            </td>
        </tr>'
    `);
    $(tag).append( $row );

    if(weneedauth == 0){
        $(tag).find('#prodQty_'+tokenId).focus();
        $(tag).find('#prodQty_'+tokenId).val('1');
        $(tag).find('#prodQty_'+tokenId).select();

        if($.trim(SoldByWeight) == "1")
        {
            $('#table').find('#prodBulk_' + tokenId).focus();
            $('#prodBulk_' + tokenId).addClass('inputs');
            $('#prodBulk_' + tokenId).addClass('addgreen');
            $('#prodBulk_' + tokenId).val(1);
            $('#prodQty_' + tokenId).val(UnitWeight);
            $('#prodComment_' + tokenId).val(1 +' '+strBulkUnit );
            // $('#prodComment_' + tokenId).prop('title', 1 +' '+strBulkUnit );

        }else
        {
            $('#prodBulk_' + tokenId).prop('readonly', true);
            $('#prodBulk_' + tokenId).val(0);
        }
    }else
    {
        /*var dialog = $('<p><strong style="color:red">Authorization Needed</strong></p>').dialog({
            height: 200, width: 700,modal: true,containment: false,
            buttons: {
                "Okay": function () {
                    dialog.dialog('close');
                    $(tag).find('#prodPrice_'+tokenId).focus();
                   // $(tag).find('#title_'+tokenId).val('1');
                }
            }
        });*/
        $(tag).find('#prodPrice_'+tokenId).focus();
        $(tag).find('#prodQty_'+tokenId).val('1');
        $(tag).find('#prodPrice_'+tokenId).select();

        if($.trim(SoldByWeight) == "1")
        {
            $('#table').find('#prodPrice_' + tokenId).focus();
            $('#prodBulk_' + tokenId).addClass('inputs');
            $('#prodBulk_' + tokenId).addClass('addgreen');
            $('#prodBulk_' + tokenId).val(1);
            $('#prodQty_' + tokenId).val(UnitWeight);
            $('#prodComment_' + tokenId).val(1 +' '+strBulkUnit );
            // $('#prodComment_' + tokenId).prop('title', 1 +' '+strBulkUnit );

        }else
        {
            $('#prodBulk_' + tokenId).prop('readonly', true);
            $('#prodBulk_' + tokenId).val(0);
        }
    }


    var txt = $("#headerWh option:selected").text();
    var val = $("#headerWh option:selected").val();
    $("#col2_"+tokenId).append("<option value='"+val+"'>" + txt + "</option>");
    $.each(wareautocomplete, function (i, item) {
        $("#col2_"+tokenId).append("<option value='"+item.ID+"'>" + item.Warehouse + "</option>");
    });
   // console.debug("weneedauth************"+weneedauth);
   // $(tag).find('#prodQty_'+tokenId).focus();
    var Ltot = 1 * price;
    $("#col6_"+tokenId).val(Ltot.toFixed(2))
}

/**
 * Send call
 * @param url
 * @param DeivDate
 * @param CustomerCode
 * @param DeliveryAddressId
 */
function called(url,DeivDate,CustomerCode,DeliveryAddressId,notes)
{
    $.ajax({
        url: url ,
        type: "POST",
        data:{DeivDate:DeivDate,CustomerCode:CustomerCode,Show:'1',
            DeliveryAddressId:DeliveryAddressId,notes:notes},
        success: function(data){

        }
    });
}
function orderDetailsWithDeliveryAddress(url,orderId,orderAddress)
{
    $.ajax({
        url: url ,
        type: "POST",
        data:{orderId:orderId},
        success: function(data){
            var toAppend = '';

            $.each(data,function(i,o){
                toAppend = o.DeliveryAdd1+'<br>'+o.DeliveryAdd2+'<br>'+o.DeliveryAdd3+'<br>'+o.DeliveryAdd4+','+o.DeliveryAdd4

            });
            $(orderAddress).append(toAppend);
        }
    });
}
function orderDetailsWithDeliveryAddressOnOrder(url,orderId,orderDedails)
{


    $.ajax({
        url: url ,
        type: "POST",
        data:{orderId:orderId},
        success: function(data){
            var toAppend = '';

            $.each(data,function(i,o){
                console.debug(o);
                $(".invoiceslisted").remove();
                toAppend +='<tr role="row" class="invoiceslisted"  style="font-size: 9px;color:black"><td>'+
                    o.PastelDescription +'</td><td>'+
                    parseFloat(o.Qty).toFixed(2) +'</td><td>' +
                    o.UnitSize +'</td><td>' +
                    o.Comment +'</td>'+
                    '</tr>';
            });
            $(orderDedails).append(toAppend);

        }
    });
}

function countDelivAddress(url,CustomerCode)
{
    var coutAdderss;
    $.ajax({
        url: url ,
        type: "POST",
        data:{customerCode:CustomerCode},
        success: function(data){
            coutAdderss = data[0].CustomerId;
            console.debug("before"+data[0].CustomerId);
        }
    });

    console.debug("on results"+coutAdderss);
    return coutAdderss;
}
function countomerSingleAddress(tag,url,CustomerCode)
{
    var Address = '';
    $.ajax({
        url: url ,
        type: "POST",
        data:{customerCode:CustomerCode},
        success: function(data){
            Address +=data[0].DAddress1+' , '+data[0].DAddress2+', '+data[0].DAddress3+' ,'+data[0].DAddress4+' , '+data[0].DAddress5;
        }
    });
    $(tag).val(Address);
}
function checkProductsCode() {
    //An Array too check duplicates

}


function calculator()
{
    var arrayPrice = [];
    var arrayPrice = [];
    var arrayQty = [];
    var arrayDisc = [];
    var arrayPriceInc = [];
    var arrayProductsCode = [];
    var arrayAdditionalcst = [];
    var cost = [];
    var sumTotalCost = 0.00;
    var totalPrice = 0.00;
    $('#table tbody tr').each(function() {

        var valuesPrice = [];
        var valuesQty = [];
        var valuesDisc = [];
        var valuesPriceInc = [];
        var valuesAdditionalcst = [];
        var valuesProdCodes = [];
        var valuesCost = [];


        $(this).find(".prodPrice_").each(function(){
            valuesPrice.push($(this).val());
            var mQty = $(this).closest('tr').find('.prodQty_').val();
            var myTDisc = $(this).closest('tr').find('.prodDisc_').val();

            if($.trim($(this).val()) !='')
            {
                totalPriceDisc = (parseFloat($(this).val())* parseFloat(mQty)) *((100-myTDisc)/100) ;
                totalPrice = parseFloat(totalPrice) + totalPriceDisc ;

            }
        });
        $(this).find(".additionalcost_").each(function(){
            //var codes = $(this).closest('tr').find('.theProductCode_').val();
console.debug("additional cost "+$(this).val());



            if ($.trim(($(this).val())).length < 1)
            {
                valuesAdditionalcst.push(0);
            }
            else
            {
                valuesAdditionalcst.push($(this).val());
            }



        });
        $(this).find(".prodQty_").each(function(){
            valuesQty.push($(this).val());
        });
        $(this).find(".prodDisc_").each(function(){
            if ($.trim(($(this).val())).length < 1)
            {
                valuesDisc.push(0);
            }
            else
            {
                valuesDisc.push($(this).val());
            }

        });
        $(this).find(".taxCodes").each(function(){
            valuesPriceInc.push($(this).val());
        });
        $(this).find(".theProductCode_").each(function(){

            if($.trim($(this).val()) !='')
            {

                arrayProductsCode.push($(this).val());

            }

        });
        $(this).find(".costs").each(function(){
            var mQty = $(this).closest('tr').find('.prodQty_').val();
            if($.trim($(this).val()) !='') {
                sumTotalCost = parseFloat(sumTotalCost) + (parseFloat($(this).val()) * parseFloat(mQty) );
                console.debug("****************************sumTotalCost "+sumTotalCost);
            }
            //valuesCost.push($(this).val());
        });

        arrayPrice.push(valuesPrice);
        arrayQty.push(valuesQty);
        arrayDisc.push(valuesDisc);
        arrayPriceInc.push(valuesPriceInc);
        arrayAdditionalcst.push(valuesAdditionalcst);
        //cost.push(valuesCost);

    });
    var ar3 = [];
    for(var i = 0; i < arrayPrice.length; i++){
        var valu = arrayPrice[i] * arrayQty[i];
        ar3[i] = valu;
    }

    var arPriceInclusive=[];
    for(var i = 0; i < arrayPrice.length; i++){
        var valu = (arrayPrice[i] * arrayQty[i])*(arrayPriceInc[i]/100) + (arrayPrice[i] * arrayQty[i]);
        console.debug(valu);
        arPriceInclusive[i] = valu;
    }
    var arPriceInclusiveDisc=[];
    for(var i = 0; i < arrayPrice.length; i++){
        var valu = ((arrayPrice[i]* ((100-arrayDisc[i])/100)) * arrayQty[i])*(arrayPriceInc[i]/100) + ((arrayPrice[i] * ((100-arrayDisc[i])/100)) * arrayQty[i]);

        arPriceInclusiveDisc[i] = valu;
    }
   // var arAdditional=[];
    var addcsttot = 0;
    for(var i = 0; i < arrayAdditionalcst.length; i++){
         addcsttot = addcsttot + parseFloat(arrayAdditionalcst[i]) ;
       // console.debug("------------------------------------------------------------------"+valu);
      // arAdditional[i] = valu;
    }
    var totalCost = sumTotalCost;

    if($.trim($('#dicPercHeader').val()).length < 1)
    {
        $('#dicPercHeader').val(0);
    }

    var totalMargin = marginCalculator(totalCost,totalPrice);

    var sumarray = eval((ar3).join("+"));
    var sumPriceInc = eval((arPriceInclusive).join("+"));
    var sumPriceIncDisc = eval((arPriceInclusiveDisc).join("+"));
   // var sumAdditionals = eval((arAdditional).join("+"));
    ///I need to remove 1.15 , in a hurry
    var sumarrayOnInclusiveForDiscount = (sumPriceInc - parseFloat((parseFloat($('#dicPercHeader').val())/100) * sumPriceInc) +(parseFloat(addcsttot) * 1.15) ).toFixed(2);
    var sumarrayOnInclusiveForDiscountAndLineDisc = (sumPriceIncDisc - parseFloat((parseFloat($('#dicPercHeader').val())/100) * sumPriceIncDisc) ).toFixed(2);
    var sumarrayOnExclusiveForDiscount = (sumarray - parseFloat((parseFloat($('#dicPercHeader').val())/100) * sumarray)+parseFloat(addcsttot) ).toFixed(2) ;


    $('#numberOfLines').empty();
    console.debug("I am reginald "+arrayProductsCode.length);
    console.debug(arrayProductsCode);
    $('#numberOfLines').append(arrayProductsCode.length);
    $('#totalEx').val(parseFloat(sumarrayOnExclusiveForDiscount).toFixed(2) );
    $('#totalInc').val(parseFloat(sumarrayOnInclusiveForDiscount).toFixed(2));
    $('#totalInOrder').val(parseFloat(sumarrayOnInclusiveForDiscountAndLineDisc).toFixed(2));
    $('#totalmargin').val(totalMargin.toFixed(2));
    $('#totaddidtionalcst').val( parseFloat(addcsttot).toFixed(2));


    // console.debug("array sum" + sumarray.toFixed(2));
    //console.debug("array sum" + sumPriceInc.toFixed(2));
    var crLimit = parseFloat($('#totalInc').val()) + parseFloat($('#balDue').val());
    $('#creditLimitWarningMessage').empty();
    if (crLimit > $('#creditLimit').val()) {
        var difference  = crLimit - $('#creditLimit').val();
        $('#creditLimitWarningMessage').append('CREDIT LIMIT REACHED: '+difference.toFixed(2));
        $('#creditLimitStutusMesg').val('CREDIT LIMIT REACHED: '+difference.toFixed(2));



    }

}
function adjustQuantingOnPickingForm(orderId,message,url,customerCode)
{
    var productsLinesOnPicking = new Array();
    /*$('#table > tbody  > tr').each(function() {*/
    $('#tableDispatch > tbody  > tr').each(function() {
        var data = $(this);
        var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
        console.debug($(this).closest('tr').find('.theProductCode_').val());
        productsLinesOnPicking.push({'productCode': $(this).closest('tr').find('.theProductCode_').val(),'desc':  $(this).closest('tr').find('.prodDescription_').val(),
            'qty':$(this).closest('tr').find('.prodQty_').val(),'price':$(this).closest('tr').find('.prodPrice_').val(),'comment':$(this).closest('tr').find('.prodComment_').val(),
            'orderDetailID':orderDetailID,'customerCode':customerCode});

    });
    $.ajax({
        url: url,
        type: "POST",
        data: {
            orderId: orderId,
            message: message,
            prodLines: productsLinesOnPicking,
            orderNo:$('#orderNumberOnDispatch').val(),
            awaiting:$('#awaitingStockOnDispatchOrPickingForm').val()
        },
        success: function (data) {
        }
    });

}
function marginCalculator(cost,onCellVal)
{
    return (1-(cost/onCellVal))*100;
}
function adjustQuantingOnPickingFormPrintitng(orderId,message,url,customerCode,url2)
{
    var productsLinesOnPicking = new Array();
    $('#table > tbody  > tr').each(function() {
        var data = $(this);
        var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
        console.debug($(this).closest('tr').find('.theProductCode_').val());
        productsLinesOnPicking.push({'productCode': $(this).closest('tr').find('.theProductCode_').val(),'desc':  $(this).closest('tr').find('.prodDescription_').val(),
            'qty':$(this).closest('tr').find('.prodQty_').val(),'price':$(this).closest('tr').find('.prodPrice_').val(),'comment':$(this).closest('tr').find('.prodComment_').val(),
            'orderDetailID':orderDetailID,'customerCode':customerCode});
    });
    $.ajax({
        url: url2,
        type: "POST",
        data: {
            orderId: orderId,
            message: message,
            prodLines: productsLinesOnPicking
        },
        success: function (dataDetails) {
            console.debug("before**********");
            console.debug(dataDetails);
            console.debug("*************AFTER");
                    $('.fast_remove_backOrder').remove();
                    var props = '';
                    $.each(dataDetails, function (keyDetails, valueDetails) {
                        var tokenId = new Date().valueOf();
                        var $row = $('<tr id="new_row_ajax' + tokenId + '" class="fast_remove_backOrder" style="font-weight: 600;font-size: 11px;">' +
                            '<td contenteditable="false" class="col-sm-1"><input name="theProductCode" id ="prodCode_' + tokenId + '" class="theProductCode_ set_autocomplete" value="' + valueDetails.PastelCode + '" ' + props + ' ></td>' +
                            '<td contenteditable="false" class="col-md-4"><input name="prodDescription_" id ="prodDescription_' + tokenId + '" class="prodDescription_ set_autocomplete" value="' + valueDetails.PastelDescription + '" ' + props + ' ></td>' +
                            '<td  contenteditable="false" class="col-md-1"><input type="text" name="prodQty_" id ="prodQty_' + tokenId + '"   onkeypress="return isFloatNumber(this,event)"  class="prodQty_ resize-input-inside" value="' + (parseFloat(valueDetails.Qty)).toFixed(2) + '" ' + props + '></td>' +
                            '<td  style="display: none;" contenteditable="false" class="col-md-1"><input type="text" name="prodBulk_"  id ="prodBulk_' + tokenId + '" class="prodBulk_ resize-input-inside inputs" ' + props + '></td>' +
                            '<td  contenteditable="false"  class="col-md-1"><input type="text" name="prodPrice_" id ="prodPrice_' + tokenId + '" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs" value="' + (parseFloat(valueDetails.Price)).toFixed(2) + '" ' + props + '></td>' +
                            '<td  style="display: none;"  contenteditable="false"  class="col-md-1"><input type="text" name="prodDisc_" id ="prodDisc_' + tokenId + '" onkeypress="return isFloatNumber(this,event)" class="prodDisc_ resize-input-inside inputs" value="' + valueDetails.LineDisc + '" ' + props + ' ></td>' +
                            '<td  contenteditable="false"  class="col-md-1"><input  type="text" name="prodUnitSize_" id ="prodUnitSize_' + tokenId + '" class="prodUnitSize_ resize-input-inside inputs" value="' + valueDetails.UnitSize + '" ' + props + ' ></td>' +
                            '<td contenteditable="false"  class="col-md-1"><input type="text" name="instockReadOnly" id ="instockReadOnly_' + tokenId + '" value="' + valueDetails.QtyInStock + '"  class="instockReadOnly_ resize-input-inside inputs" style="font-weight: 800;width: 80%;color:blue;font-size:8px !important;">' +
                            '<td  contenteditable="false" class="col-md-3"><input type="text" name="prodComment_" id ="prodComment_' + tokenId + '" class="prodComment_ resize-input-inside last inputs" value="' + valueDetails.Comment + '" ' + props + ' ></td>' +
                            '<td><input type="hidden" id="title_' + tokenId + '" class="title" value="" /><input type="hidden" id="theOrdersDetailsId" value="' + valueDetails.OrderDetailId + '" /><input type="hidden" id ="taxCode' + tokenId + '" value="' + valueDetails.Tax + '" class="taxCodes" />' +
                            '<input type="hidden" id ="cost_' + tokenId + '" value="' + valueDetails.Cost + '" class="costs" /><input type="hidden" id ="inStock_' + tokenId + '" value="' + valueDetails.QtyInStock + '" class="inStock" /><input type="hidden" value ="' + tokenId + '" class="hiddenToken" />' +
                            '<input type="hidden" id ="priceholder_'+tokenId+'" value="'+(parseFloat(valueDetails.Price)).toFixed(2) +'" class="priceholder" />' +
                            '<input type="hidden" id ="alcohol_' + tokenId + '" value="" class="alcohol" /><input type="hidden" id ="margin_' + tokenId + '" value="" class="margin" />' +
                            '<input type="hidden" id ="soldByWieght' + tokenId + '" value="" class="soldByWieght" />' +
                            '<input type="hidden" id ="unitWeight' + tokenId + '" value="" class="unitWeight" />' +
                            '<input type="hidden" id ="strBulkUnit' + tokenId + '" value="" class="strBulkUnit" />' +
                            '<input type="hidden" id ="prohibited_' + tokenId + '" value="" class="prohibited" />' +
                            '<input type="hidden" id ="productmarginauth' + tokenId + '" value="0" class="productmarginauth" />' +
                            '<button type="button" id="deleteaLine" value="' + valueDetails.OrderDetailId + '" class="getOrderDetailLine btn-warning" >Delete</button>' +
                            '</td></tr>');
                        $('#tableDispatch tbody').append($row);
                    });
                }


    });

}

function finishArray(url,CustomerCode,OrderId,url2)
{
    var arrayProductCodes = [];
    var arrayarrayProductDescription = [];
    var arrayQuantity = [];
    var arrayPrices = [];
    var arrayComments = [];
    var arrayOrderDetailsId = [];
    var objectTable = [];
    var i = 0;
    $('#table > tbody  > tr').each(function() {
        var valueProductCodes = [];
        var valueProductDescription = [];
        var valueQuantity = [];
        var valuePrices = [];
        var valueComments = [];
        var orderdetailsid = [];
        var valueobjectTable = [];

        $(this).find(".theProductCode_").each(function () {
            valueProductCodes.push($(this).val());
            valueobjectTable["productCode"] = $(this).val();

        });
        $(this).find(".prodDescription_").each(function () {
            valueProductDescription.push($(this).val());
            valueobjectTable["prodDescription"] = $(this).val();

        });
        $(this).find(".prodQty_").each(function () {
            valueQuantity.push($(this).val());
            valueobjectTable["productQty"] = $(this).val();

        });
        $(this).find(".prodPrice_").each(function () {
            valuePrices.push($(this).val());
            valueobjectTable["productPrices"] = $(this).val();

        });
        $(this).find(".prodComment_").each(function () {
            valueComments.push($(this).val());
            valueobjectTable["productComment"] = $(this).val();

        });
        $(this).find("#theOrdersDetailsId").each(function () {
            orderdetailsid.push($(this).val());
            valueobjectTable["ordersDetailsId"] = $(this).val();

        });
        arrayProductCodes.push(valueProductCodes);
        arrayarrayProductDescription.push(valueProductDescription);
        arrayQuantity.push(valueQuantity);
        arrayPrices.push(valuePrices);
        arrayComments.push(valueComments);
        arrayOrderDetailsId.push(orderdetailsid);
       // console.debug(valueobjectTable["prodDescription"].length);
        if (valueobjectTable["prodDescription"].length > 0 &&  valueobjectTable["productCode"].length > 0 && valueobjectTable["productQty"].length > 0 )
        {
            objectTable[i] = valueobjectTable;
            i=i+1;

        }else
        {
            console.debug("equal to zero");
        }

    });

    for ( var i = 0; i < objectTable.length;i++ ) {
        console.debug("order details id"+objectTable[i]['ordersDetailsId']);
        $.ajax({
            url:url,
            type: "POST",
            data:{productCode:objectTable[i]['productCode'],
                prodDescription:objectTable[i]['prodDescription'],
                productQty:objectTable[i]['productQty'],
                productPrices:objectTable[i]['productPrices'],
                productComment:objectTable[i]['productComment'],
                CustomerCode:CustomerCode,
                OrderId:OrderId,
                orderIdDetails:objectTable[i]['ordersDetailsId']
            },
            success: function(data){
                $.ajax({
                    url:url2,
                    type: "POST",
                    data:{ConsoleTypeId:1,
                        Importance:1,
                        Message:OrderId+": OrderDetail ID "+data.ID+" has been created",
                        Reviewed:0,
                        OrderId:OrderId,
                        productid:data.productid,
                        CustomerId:data.CustomerId,
                        OldQty:0,
                        NewQty:data.NewQty,
                        OldPrice:0,
                        NewPrice:data.NewPrice,
                        ReviewedUserId:0,
                        ReferenceNo:data.ReferenceNo,
                        DocType:1,
                        DocNumber:OrderId,
                        machine:"browser",
                        ReturnId:0
                    },
                    success: function(data){

                        //alert("done");
                    }});
            }
        });
    }

    /**
     * Log data into tblManagementConsole
     * @param url
     * @param ConsoleTypeId
     * @param Importance
     * @param Message
     * @param Reviewed
     * @param OrderId
     * @param productid
     * @param CustomerId
     * @param OldQty
     * @param NewQty
     * @param OldPrice
     * @param NewPrice
     * @param ReviewedUserId
     * @param ReferenceNo
     * @param DocType
     *  @param machine
     * @param DocNumber
     * @param ReturnId
     */
    function consoleManagement(url,ConsoleTypeId,Importance,Message,Reviewed,OrderId,productid,
                               CustomerId,OldQty,NewQty,OldPrice,NewPrice,ReviewedUserId,ReferenceNo,DocType,machine,DocNumber,ReturnId)
    {
        $.ajax({
            url:url,
            type: "POST",
            data:{ConsoleTypeId:ConsoleTypeId,
                Importance:Importance,
                Message:Message,
                Reviewed:Reviewed,
                OrderId:OrderId,
                productid:productid,
                CustomerId:CustomerId,
                OldQty:OldQty,
                NewQty:NewQty,
                OldPrice:OldPrice,
                NewPrice:NewPrice,
                ReviewedUserId:ReviewedUserId,
                ReferenceNo:ReferenceNo,
                DocType:DocType,
                DocNumber:DocNumber,
                machine:machine,
                ReturnId:ReturnId
            },
            success: function(data){

                //Try to use web sql
            }});
    }

    //Authorisation
    function authorise(url,ConsoleTypeId,Importance,Message,Reviewed,OrderId,productid,
                       CustomerId,OldQty,NewQty,OldPrice,NewPrice,ReviewedUserId,ReferenceNo,DocType,machine,DocNumber,ReturnId,userName,userId)
    {
        $.ajax({
            url:url,
            type: "POST",
            data:{ConsoleTypeId:ConsoleTypeId,
                Importance:Importance,
                Message:Message,
                Reviewed:Reviewed,
                OrderId:OrderId,
                productid:productid,
                CustomerId:CustomerId,
                OldQty:OldQty,
                NewQty:NewQty,
                OldPrice:OldPrice,
                NewPrice:NewPrice,
                ReviewedUserId:ReviewedUserId,
                ReferenceNo:ReferenceNo,
                DocType:DocType,
                DocNumber:DocNumber,
                machine:machine,
                ReturnId:ReturnId,
                userId:userId,
                userName:userName},
            success: function(data){

                //Try to use web sql
            }});
    }

}
/**
 * function to post order lines
 * @param customerCode
 * @param OrderId
 * @param url
 */
function finishArray2(customerCode,OrderId,url)
{
    var productsLinesOnPicking = new Array();
    $('#table > tbody  > tr').each(function() {
        var data = $(this);
        var orderDetailID = $(this).closest('tr').find('#theOrdersDetailsId').val();
        console.debug($(this).closest('tr').find('.theProductCode_').val());
        if (($(this).closest('tr').find('.theProductCode_').val()).length > 0) {
            productsLinesOnPicking.push({
                'productCode': $(this).closest('tr').find('.theProductCode_').val(),
                'desc': $(this).closest('tr').find('.prodDescription_').val(),
                'qty': $(this).closest('tr').find('.prodQty_').val(),
                'price': $(this).closest('tr').find('.prodPrice_').val(),
                'comment': $(this).closest('tr').find('.prodComment_').val(),
                'orderDetailID': orderDetailID,
                'customerCode': customerCode,
                'prodDisc': $(this).closest('tr').find('.prodDisc_').val(),
                'unitCount': $(this).closest('tr').find('.prodBulk_').val()
            });
        }

    });
    calculator();
    $.ajax({
        url: url,
        type: "POST",
        data: {
            OrderId: OrderId,
            orderDetails: productsLinesOnPicking,
            exclusive:$('#totalEx').val()
        },
        success: function (data) {
        }
    });
}
function addAddressLineOnSingleCustAddress(tag)
{
    var tokenId = new Date().valueOf();
    var $row = $(`
        <tr id="new_row_ajax_remove_address_line" class="fast_remove_addressLine">
            <td contenteditable="false">
                <input type="text" name="AddressLine1" id ="AddressLine1_${tokenId}" class="AddressLine1 inputs form-control" value ="">
            </td>
            <td contenteditable="false">
                <input type="text" name="AddressLine2" id ="AddressLine3_${tokenId}" class="AddressLine2 inputs form-control" value ="">
            </td>
            <td contenteditable="false">
                <input type="text" name="AddressLine3" id ="AddressLine2_${tokenId}" class="AddressLine3 inputs form-control" value ="">
            </td>
            <td contenteditable="false">
                <input type="text" name="AddressLine4" id ="AddressLine4_${tokenId}" class="AddressLine4 inputs form-control" value ="">
            </td>
            <td contenteditable="false">
                <input type="text" name="AddressLine5" id ="AddressLine5_${tokenId}" class="AddressLine5 inputs form-control" value ="">
            </td>
        </tr>
    `);
    $(tag).append($row);
}
function Tablenavigate()
{
    $(document).on('keydown','#addNewAddressModal', function(e) {
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
        if($next && $next.length)
        {
            $next.focus();
        }
    });
}
function emailSalesOrderOnTheFly()
{
    var objectTable = new Array();
    var i = 0;
    $('#table > tbody  > tr').each(function() {

        objectTable.push({ 'desc':$(this).find(".prodDescription_").val(), 'code':$(this).find(".theProductCode_").val() , 'qty':$(this).find(".prodQty_").val(),
            'price':$(this).find(".prodPrice_").val() ,'comment':$(this).find(".prodComment_").val()});

        //objectTable[i] = valueobjectTable;
        //i=i+1;
    });

    return objectTable;
}
/**
 * make a line
 * @param orderID
 * @param tag
 * @param orderDetailsUrl
 * @param urlContact
 * @param arrayOfCustomerInfo
 */
function makeALineWithOrderID(orderID,tag,orderDetailsUrl,urlContact,arrayOfCustomerInfo)
{
    var isAwaitingStock = '';
    var messageINV = '';
    var orderNumber = '';
    var multiLines = "<?php  echo Auth::user()->intAllowMultiLines?>";
    console.debug(arrayOfCustomerInfo);
    $.ajax({
        url: orderDetailsUrl,
        type: "POST",
        data: {orderId: $.trim(orderID)},
        success: function (dataDetails) {
            var InvoiceTotalPriceInc = 0;
            var InvoiceTotalPriceExcl = 0;
            $('.fast_remove').remove();
            $.each(dataDetails, function (keyDetails, valueDetails) {
                var tokenId = new Date().valueOf();
                var props = '';
                if (($('#invNo').val()).length > 1) {
                    props = "disabled";
                }




                var $row = $('<tr id="new_row_ajax'+tokenId+'" class="fast_remove" style="font-weight: 600;font-size: 11px;">' +
                    '<td contenteditable="false" class="col-sm-1"><input name="theProductCode" id ="prodCode_' + tokenId + '" class="theProductCode_ set_autocomplete" value="' + valueDetails.PastelCode + '" ' + props + ' ></td>' +
                    '<td contenteditable="false" class="col-md-3"><input name="prodDescription_" id ="prodDescription_' + tokenId + '" class="prodDescription_ set_autocomplete" value="' + valueDetails.PastelDescription + '" ' + props + ' ></td>' +
                    '<td  contenteditable="false" class="col-md-1"><input type="text" name="prodQty_" id ="prodQty_' + tokenId + '"   onkeypress="return isFloatNumber(this,event)"  class="prodQty_ resize-input-inside" value="' + (parseFloat(valueDetails.Qty)).toFixed(2) + '" ' + props + '></td>' +
                    '<td  style="display: none;" contenteditable="false" class="col-md-1"><input type="text" name="prodBulk_"  id ="prodBulk_' + tokenId + '" class="prodBulk_ resize-input-inside" ' + props + '></td>' +
                    '<td  contenteditable="false"  class="col-md-1"><input type="text" name="prodPrice_" id ="prodPrice_' + tokenId + '" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs" value="' + (parseFloat(valueDetails.Price)).toFixed(2) + '" ' + props + '></td>' +
                    '<td  style="display: none;"  contenteditable="false"  class="col-md-1"><input type="text" name="prodDisc_" id ="prodDisc_' + tokenId + '" onkeypress="return isFloatNumber(this,event)" class="prodDisc_ resize-input-inside" value="' + valueDetails.LineDisc + '" ' + props + ' ></td>' +
                    '<td  contenteditable="false"  class="col-md-1"><input  type="text" name="prodUnitSize_" id ="prodUnitSize_' + tokenId + '" class="prodUnitSize_ resize-input-inside inputs" value="' + valueDetails.UnitSize + '" ' + props + ' ></td>' +
                    '<td contenteditable="false"  class="col-md-1"><input type="text" name="instockReadOnly" id ="instockReadOnly_' + tokenId + '" value="' + (parseFloat(valueDetails.QtyInStock)).toFixed(2) + '"  class="instockReadOnly_ resize-input-inside inputs" style="font-weight: 800;width: 80%;color:blue;font-size:8px !important;">' +
                    '<td  contenteditable="false" class="col-md-3"><input type="text" name="prodComment_" id ="prodComment_' + tokenId + '" class="prodComment_ resize-input-inside last inputs" value="' + valueDetails.Comment + '" ' + props + ' ></td>' +
                    '<td><input type="hidden" id="title_' + tokenId + '" class="title" value="" /><input type="hidden" id="theOrdersDetailsId" value="' + valueDetails.OrderDetailId + '" /><input type="hidden" id ="taxCode' + tokenId + '" value="' + valueDetails.Tax + '" class="taxCodes" />' +
                    '<input type="hidden" id ="cost_' + tokenId + '" value="' + valueDetails.Cost + '" class="costs" /><input type="hidden" id ="inStock_' + tokenId + '" value="' + valueDetails.QtyInStock + '" class="inStock" /><input type="hidden" value ="' + tokenId + '" class="hiddenToken" />' +
                    '<input type="hidden" id ="alcohol_' + tokenId + '" value="" class="alcohol" /><input type="hidden" id ="margin_' + tokenId + '" value="" class="margin" />' +
                    '</td></tr>');
                $(tag).append($row);
                if (valueDetails.Price == null || valueDetails.IncPrice == null) {
                    InvoiceTotalPriceExcl = (parseFloat(InvoiceTotalPriceExcl) + (0 * parseFloat(valueDetails.Qty))).toFixed(2);
                    InvoiceTotalPriceInc = (parseFloat(InvoiceTotalPriceInc) + (0 * parseFloat(valueDetails.Qty))).toFixed(2);
                } else {
                    InvoiceTotalPriceExcl = (parseFloat(InvoiceTotalPriceExcl) + (parseFloat(valueDetails.Price) * parseFloat(valueDetails.Qty))).toFixed(2);
                    InvoiceTotalPriceInc = (parseFloat(InvoiceTotalPriceInc) + (parseFloat(valueDetails.IncPrice) * parseFloat(valueDetails.Qty))).toFixed(2);

                }
                isAwaitingStock = valueDetails.AwaitingStock;
                orderNumber = valueDetails.OrderNo;
                messageINV = valueDetails.MESSAGESINV;

            });
            if(($('#invNo').val()).length < 1 ){
               // generateALine();
            }
            $('#awaitingStockOnDispatchOrPickingForm').val(isAwaitingStock)
            if(($('#awaitingStockOnDispatchOrPickingForm').val(isAwaitingStock)) == '1')
            {
                $( "#awaitingStockOnDispatchOrPickingForm").prop('checked', true);
            }
            else
            {
                $( "#awaitingStockOnDispatchOrPickingForm").prop('checked', false);
            }

            $('#totalExD').val(InvoiceTotalPriceExcl);
            $('#totalIncD').val(InvoiceTotalPriceInc);
            $('#dispatchMessage').val(messageINV);
            $('#orderNumberOnDispatch').val(orderNumber);

        }

    });
    $.ajax({
        url: urlContact,
        type: "POST",
        data:{OrderID:orderID},
        success: function(data){
            $('#contactCellOnDispatch').val(data[0].CellPhone);
            $('#contactPersonOnDispatch').val(data[0].ContactPerson);
            $('#telOnDispatch').val(data[0].ContactTel);
        }
    });

    $('#inputCustAccD').val(arrayOfCustomerInfo[1]);
    $('#inputCustNameD').val(arrayOfCustomerInfo[2]);
    $('#orderIds').val(orderID);
    $('#DeliveryDate').val(arrayOfCustomerInfo[0]);
}
function orderLock(url,orderID)
{
    $.ajax({
        url: url,
        type: "POST",
        data: {
            orderID: orderID
        },
        success: function (data) {
            if (data !="Inserted"){
                    var dialog = $('<p>'+data+'</p>').dialog({
                    height: 200, width: 700, modal: true, containment: false,
                    buttons: {
                        "Okay": function () {
                            dialog.dialog('close');
                        }
                    }
                });

            }

        }
    });
}
function orderUnLock(url)
{
    $.ajax({
        url: url,
        type: "POST",
        success: function (data) {

        }
    });
}
function updateCount() {
    var cs = $(this).val().length;
    $('#characters').text(cs);
}

