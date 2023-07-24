@extends('layouts.app')

@section('content')

    <div class="col-lg-12" style=" font-weight: 700; color: black;" >
        <input type="hidden" id="id" value="{{$ID}}">
        <div class="col-lg-6" >
            <div class="col-lg-12" >
                <fieldset class="well">
                <div class="form-group col-md-6">
                  <label class="control-label" for="customerCode"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Code</label>
                    @if(count($assets) > 0)
                  <input id="customerCode" class="form-control input-sm col-xs-1" value="{{$assets[0]->strCustomerCode}}">
                        @else
                        <input id="customerCode" class="form-control input-sm col-xs-1" value="">
                        @endif
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label" for="customerName"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Name</label>
                    @if(count($assets) > 0)
                        <input id="customerName" class="form-control input-sm col-xs-1" value="{{$assets[0]->strCustomerName}}">
                    @else
                        <input id="customerName" class="form-control input-sm col-xs-1" value="">
                    @endif
                </div>


                    <div class="form-group col-md-12">
                        <label class="control-label" for="contactPerson"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Contact Person</label>
                        @if(count($assets) > 0)
                            <input id="contactPerson" class="form-control input-sm col-xs-1" value="{{$assets[0]->strAssetsHoldersContactPeople}}">
                        @else
                            <input id="contactPerson" class="form-control input-sm col-xs-1" value="">
                        @endif
                    </div>

                    <div class="form-group col-md-12">
                        <label class="control-label" for="contacttel"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Telephone Number</label>
                        @if(count($assets) > 0)
                            <input id="contacttel" class="form-control input-sm col-xs-1" value="{{$assets[0]->strAssetAreaTelephone}}">
                        @else
                            <input id="contacttel" class="form-control input-sm col-xs-1" value="">
                        @endif
                    </div>

                    <div class="form-group col-md-12">
                        <label class="control-label" for="cellnumber"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Cell Number</label>
                        @if(count($assets) > 0)
                            <input id="cellnumber" class="form-control input-sm col-xs-1" value="{{$assets[0]->strAssetCellContacts}}">
                        @else
                            <input id="cellnumber" class="form-control input-sm col-xs-1" value="">
                        @endif
                    </div>

                    <div class="form-group col-md-12">
                        <label class="control-label" for="area"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Area</label>
                        @if(count($assets) > 0)
                            <input id="area" class="form-control input-sm col-xs-1" value="{{$assets[0]->strAssetArea}}">
                        @else
                            <input id="area" class="form-control input-sm col-xs-1" value="">
                        @endif
                    </div>

                    <div class="form-group col-md-12">
                        <label class="control-label" for="address"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Address</label>
                        @if(count($assets) > 0)
                            <input id="address" class="form-control input-sm col-xs-1" value="{{$assets[0]->strAssetAddress}}">
                        @else
                            <input id="address" class="form-control input-sm col-xs-1" value="">
                        @endif
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label" for="placement"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Placement</label>
                        @if(count($assets) > 0)
                            <input id="placement" class="form-control input-sm col-xs-1" value="{{$assets[0]->strPlacement}}">
                        @else
                            <input id="placement" class="form-control input-sm col-xs-1" value="">
                        @endif
                    </div>

                    <div class="form-group col-md-12">
                        <label class="control-label" for="base"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Base[Location]</label>
                        @if(count($assets) > 0)
                            <input id="base" class="form-control input-sm col-xs-1" value="{{$assets[0]->strBase}}">
                        @else
                            <input id="base" class="form-control input-sm col-xs-1" value="">
                        @endif
                    </div>
                </fieldset>

            </div>
            <div class="col-lg-12" >
                <div class="form-group col-md-6">
                    <label class="control-label" for="latitude"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Latitude</label>
                    @if(count($assets) > 0)
                        <input id="latitude" class="form-control input-sm col-xs-1" value="{{$assets[0]->fltLat}}">
                    @else
                        <input id="latitude" class="form-control input-sm col-xs-1" value="">
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label" for="longitude"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Longitude</label>
                    @if(count($assets) > 0)
                        <input id="longitude" class="form-control input-sm col-xs-1" value="{{$assets[0]->fltLon}}">
                    @else
                        <input id="longitude" class="form-control input-sm col-xs-1" value="">
                    @endif
                </div>

            </div>
            <div class="col-lg-12" >
                @if(count($assets) > 0)
                <?php echo '<img style="height: 50;" src="data:image/gif;base64,' . $assets[0]->strLastImage . '" />'; ?>
                @else
                    <img src='data:image/png;base64,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' />
                @endif
            </div>
            <div class="col-lg-12">
                <button class=" btn btn-success pull-right" type="submit" id="save" >SAVE</button>

            </div>
        </div>


        <div class="col-lg-6" >
            <div class="col-lg-12" >
                <div class="form-group col-md-12">
                    <label class="control-label" for="assetname"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Asset Name</label>
                    @if(count($assets) > 0)
                        <input id="assetname" class="form-control input-sm col-xs-1" value="{{$assets[0]->strAssetName}}">
                    @else
                        <input id="assetname" class="form-control input-sm col-xs-1" value="">
                    @endif
                </div>

                <div class="form-group col-md-12">
                    <div class="form-group col-md-6">
                    <label class="control-label" for="status"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Status[ACTIVE,AVAILABLE,REPAIR,SCRAPPED]</label>
                    @if(count($assets) > 0)
                        <input id="status" class="form-control input-sm col-xs-1" value="{{$assets[0]->strAssetRef3}}">
                    @else
                        <input id="status" class="form-control input-sm col-xs-1" value="">
                    @endif
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="qty"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Qty</label>
                        @if(count($assets) > 0)
                            <input id="qty" class="form-control input-sm col-xs-1" value="{{$assets[0]->strAssetQty}}">
                        @else
                            <input id="qty" class="form-control input-sm col-xs-1" value="">
                        @endif
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label class="control-label" for="serialno"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Serial Number</label>
                    @if(count($assets) > 0)
                        <input id="serialno" class="form-control input-sm col-xs-1" value="{{$assets[0]->strAssetSerialNo}}">
                    @else
                        <input id="serialno" class="form-control input-sm col-xs-1" value="">
                    @endif
                </div>

                <div class="form-group col-md-12">

                    <div class="form-group col-md-6">
                        <label class="control-label" for="branding"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Branding</label>
                    @if(count($assets) > 0)
                        <input id="branding" class="form-control input-sm col-xs-1" value="{{$assets[0]->strAssetBranding}}">
                    @else
                        <input id="branding" class="form-control input-sm col-xs-1" value="">
                    @endif
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="model"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Model</label>
                        @if(count($assets) > 0)
                            <input id="model" class="form-control input-sm col-xs-1" value="{{$assets[0]->strAssetModel}}">
                        @else
                            <input id="model" class="form-control input-sm col-xs-1" value="">
                        @endif
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label" for="description"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Description</label>
                    @if(count($assets) > 0)
                        <input id="description" class="form-control input-sm col-xs-1" value="{{$assets[0]->strAssetDescription}}">
                    @else
                        <input id="description" class="form-control input-sm col-xs-1" value="">
                    @endif
                </div>



                <div class="form-group col-md-12">
                    <div class="form-group col-md-6">
                        <label class="control-label" for="make"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Make</label>
                        @if(count($assets) > 0)
                            <input id="make" class="form-control input-sm col-xs-1" value="{{$assets[0]->strAssetMake}}">
                        @else
                            <input id="make" class="form-control input-sm col-xs-1" value="">
                        @endif
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="purch"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Purchased Date</label>

                        @if(count($assets) > 0)
                            <input id="purch" class="form-control input-sm col-xs-1" value="{{$assets[0]->PurchOrDate}}">
                        @else
                            <input id="purch" class="form-control input-sm col-xs-1" value="">
                        @endif
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label class="control-label" for="assetlastvisisted"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Last Date Checked</label>
                    @if(count($assets) > 0)
                        <input id="assetlastvisisted" class="form-control input-sm col-xs-1" value="{{$assets[0]->dteLastVisit}}">
                    @else
                        <input id="assetlastvisisted" class="form-control input-sm col-xs-1" value="">
                    @endif
                </div>

            </div>
            <div class="col-lg-12" >
                <div class="form-group col-md-12">
                    <label class="control-label" for="assettype"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Asset Type</label>
                    @if(count($assets) > 0)
                        <input id="assettype" class="form-control input-sm col-xs-1" value="{{$assets[0]->strAssetRef2}}">
                    @else
                        <input id="assettype" class="form-control input-sm col-xs-1" value="">
                    @endif
                </div>

                <fieldset class="well">
                    <label class="control-label" for="history"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">History</label>
                    <div class="form-group col-md-12">

                        @if(count($assets) > 0)

                            <textarea id="history" style="height:60%;width: 100%;"  class="control-label" >{{$assets[0]->strAssetHistory}}
                           </textarea>
                        @else
                            <textarea id="history" style="height:60%;width: 100%;"  class="control-label" >
                           </textarea>
                        @endif
                    </div>
                </fieldset>

            </div>
        </div>
    </div>
    <div title="Asset Saved" class="col-md-6" id="assetsaved">
        <h3>Your Data Is Saved</h3>

        <div class="col-md-3">
            <button class="btn-md btn-success" id="btnsaved">Okay</button>
        </div>

    </div>
@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>

<script>
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
        $('#assetsaved').hide();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
//save

        $("#save").click(function () {
            //do here

            $.ajax({
                url: '{!! url("/saveupdateasset") !!}',
                type: "POST",
                data: {
                    customerCode: $('#customerCode').val(),
                    customerName: $('#customerName').val(),
                    contactPerson: $('#contactPerson').val(),
                    contacttel: $('#contacttel').val(),
                    cellnumber: $('#cellnumber').val(),
                    area: $('#area').val(),
                    address: $('#address').val(),
                    placement: $('#placement').val(),
                    base: $('#base').val(),
                    assetname: $('#assetname').val(),
                    status: $('#status').val(),
                    serialno: $('#serialno').val(),
                    branding: $('#branding').val(),
                    model: $('#model').val(),
                    make: $('#make').val(),
                    purch: $('#purch').val(),
                    assetlastvisisted: $('#assetlastvisisted').val(),
                    assettype: $('#assettype').val(),
                    latitude: $('#latitude').val(),
                    longitude: $('#longitude').val(),
                    history: $('#history').val(),
                    description: $('#description').val(),
                    qty: $('#qty').val(),
                    id: $('#id').val()

                },
                success: function (data) {
//console.debug(data);
                    //alert(console.debug(data));
                    showDialog('#assetsaved','35%',400);
                    $('#btnsaved').click(function(){
                        $('#assetsaved').dialog("close");
                        window.location = '{!!url("/assets")!!}'
                    });
                }
            });
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

    });
    </script>