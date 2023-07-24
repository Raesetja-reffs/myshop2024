@extends('layouts.app')

@section('content')



<div class="col-md-4" title="Please Upload Your Excel" id="uploaddocument">
                    <form action ="{{url('importexcel')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class = "form-group" style ="float:right">
                            <input type="file" name="select_file" />

                            <input type="hidden" name="contractIdfile" id="contractIdfile" value="{{$contractid}}" required/>
                            <input type="hidden" name="datefromfile"  id="datefromfile" value="{{$datefrom}}"/>
                            <input type="hidden" name="datetofile" id="datetofile"  value="{{$dateto}}"/>
                            <input type="hidden" name="customerIdfile" id="customerIdfile" value="{{$customerId}}"/>


                            <input type="submit" name="upload"  class="btn-xs btn-primary" value="Upload">

                        </div>
                    </form>
                </div>


@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>

<script>
    $(document).ready(function(){
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
        $('#returns').hide();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#saveplanNickName').val('');
        $('#nameyourplan').show();
        $('#nameyourplan').dialog({
            height: 800, width: 700, modal: true, containment: false
        });

        $('#savethisnickname').click(function(){

            $.ajax({
                url: '{!!url("/pickingNickName")!!}',
                type: "POST",
                data: {
                    referenceno: $('#referenceno').val(),
                    nickname: $('#saveplanNickName').val()
                },
                success: function (data) {
                    let new_window = open(location, '_self');
                    // Close this window
                    new_window.close();

                }
            });

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


</script>
