<x-app-layout>

    <x-slot name="header">
        {{ __('Dialog Import Specials') }}
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
            Dialog Import Specials
        </li>
        <!--end::Item-->
    </x-slot>

    <div class="card mt-5" title="Please Upload Your Excel" id="uploaddocument">
        <div class="card-body">
            <form action ="{{url('importexcel')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4">
                            <div class="form-group">
                                <input type="file" name="select_file" class="form-control" />

                                <input type="hidden" name="contractIdfile" id="contractIdfile" value="{{$contractid}}" required/>
                                <input type="hidden" name="datefromfile"  id="datefromfile" value="{{$datefrom}}"/>
                                <input type="hidden" name="datetofile" id="datetofile"  value="{{$dateto}}"/>
                                <input type="hidden" name="customerIdfile" id="customerIdfile" value="{{$customerId}}"/>
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="submit" name="upload"  class="btn btn-primary btn-sm" value="Upload">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

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
</x-app-layout>
