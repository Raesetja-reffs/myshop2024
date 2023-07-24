@extends('layouts.app')

@section('content')

    <div class="col-lg-12" >

        <div class="form-group col-md-2 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="dateFromFilter"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date From</label>
            <input type="text" class="form-control input-sm col-xs-1" id="dateFromFilter" style="font-weight: 900;    color: black;font-size: 13px;" value="{{$dateFromFilter}}">
        </div>
        <div class="form-group col-md-2 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="dateToFilter"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date To</label>
            <input type="text" class="form-control input-sm col-xs-1" id="dateToFilter" style="font-weight: 900;    color: black;font-size: 13px;" value="{{$dateToFilter}}">
        </div>
        <div class="form-group col-md-2 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="marginfilterless"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Margin(Less than or equal to)</label>
            <input type="text" class="form-control input-sm col-xs-1" id="marginfilterless" style="font-weight: 900;    color: black;font-size: 13px;" value="{{$marginfilterless}}">
        </div>
        <div class="form-group col-md-2 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="marginfiltergreater"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Margin(Greater than or equal to)</label>
            <input type="text" class="form-control input-sm col-xs-1" id="marginfiltergreater" style="font-weight: 900;    color: black;font-size: 13px;" value="{{$marginfiltergreater}}">
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
        <div class="form-group col-md-2 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="marginfiltergreater"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">FILTER PRICE USING THE MARGIN BELOW.</label>
            <input type="text" class="form-control input-sm col-lg-1" id="filtermarg" style="font-weight: 900; color: black;font-size: 13px;background: red;">
        </div>
        <button type="button" id="submitFilter" class="btn-xs btn-primary">Submit</button>

    </div>

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

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#submitFilter').click(function(){
                $.ajax({
                    url: '{!!url("/increasePriceUsingMargin")!!}',
                    type: "POST",
                    data: {
                        dateFromFilter: $('#dateFromFilter').val(),
                        dateToFilter: $('#dateToFilter').val(),
                        marginfilterless: $('#marginfilterless').val(),
                        marginfiltergreater: $('#marginfiltergreater').val(),
                        filtermarg: $('#filtermarg').val(),
                    },
                    success: function (data) {

                        //console.debug(data);
                        alert(data)
                        //location.reload(true);

                    }
                });
            });


            });


        </script>