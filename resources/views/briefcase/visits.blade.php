
<!DOCTYPE html>

<html>
<head>
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet"  type='text/css'>
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ... -->
    <!-- DevExtreme themes -->
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">

    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>


    <style>
        .dx-datagrid{
            font:10px verdana;
        }

    </style>
</head>
<body style="font-family: Sans-serif">
<h3>Visists</h3>
<a href='{!!url("/visualvisits")!!}' onclick="window.open(this.href, 'visualvisits',
'left=20,top=20,width=1650,height=900,toolbar=1,resizable=0'); return false;" style="font-size: 16px;text-decoration: underline;float: right">Visual Visits</a>
<div class="dx-field" style="display: none;">
    <div class="dx-field-label">DropDownBox with embedded DataGrid</div>
    <div class="dx-field-value">
        <div id="gridBox"></div>
    </div>
</div>

From<input type="date" id="from"> - To<input type="date" id="to"> <button class="" id="getdata">Submit</button>
<div id="gridContainer" style="height: 800px;width: 100% !important;"/>

<script>

    $( document ).on( 'focus', ':input', function(){

        $( this ).attr( 'autocomplete', 'off' );
    });

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#getdata').click(function(){
        $.ajax({
            url: '{!!url("/jsonVisistsBriefcase")!!}',
            type: "GET",
            data: {
                datefrom: $('#from').val(),
                dateto: $('#to').val()
            },
            success: function (data) {
                localStorage.removeItem('briefcasemap');
                //localStorage.routeplanner = JSON.stringify({name: "John",routeId: $('#rouTabletLoadingtesonPlanning').val(),deliveryDate: $('#deliveryDatesonPlanning').val()});
                localStorage.setItem('briefcasemap', JSON.stringify({deliveryDate: $('#from').val(),
                    deliveryDateTo: $('#to').val()  }));
                $("#gridContainer").dxDataGrid({
                    dataSource:data,
                    showBorders: true,
                    selection: {
                        mode: 'multiple',
                    },

                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    paging: {
                        enabled: true
                    }
                    ,
                    editing: {
                        mode: "cell",
                        allowUpdating: true,
                        selectTextOnEditStart: true,
                        startEditAction: 'click',
                        allowDeleting: false,
                        confirmDelete: false
                    }
                    ,columnWidth:200,
                    columnAutoWidth:true,        allowColumnResizing: true,       columnResizingMode: "nextColumn",
                    columns: [
                        {
                            width: 90,
                            dataField: "UserName",
                            caption: "Rep Name",
                            headerFilter: {
                                allowSearch: true,
                            }

                        },
                        {
                            width: 1,
                            dataField: "Lat",
                            caption: "Lat",
                             visible:false

                        },
                        {
                            width: 1,
                            dataField: "Lon",
                            caption: "Lon",
                            visible:false

                        },
                        {
                            width: 80,
                            dataField: "strCustomerCode",
                            caption: "strCustomerCode",
                            headerFilter: {
                                allowSearch: true,
                            }

                        },
                        {
                            width:75,
                            dataField: "UserName",
                            groupIndex: 0,
                            caption: "User name",

                            headerFilter: {
                                allowSearch: true,
                            }

                        },
                        {
                            width:160,
                            dataField: "StoreName",
                            caption: "Customer Name",
                            headerFilter: {
                                allowSearch: true,
                            }

                        },

                        {
                            width: 150,
                            dataField: "dtmVisit",
                            caption: "Time Visited",
                            headerFilter: {
                                allowSearch: true,
                            }

                        }, {
                            dataField: "dteNextVist",
                            caption: "Expected Next Visit", width: 80,

                        }
                        ,{
                            width: 300,
                            dataField: "strCatchupMesssage",
                            caption: "Next meeting catch notes"

                        }
                        ,
                        {
                            width:300,
                            dataField: "strMessage",
                            caption: "Visits Notes",


                        }

                    ] ,
                    onRowClick: function (e) {



                    },


                    onInitNewRow: function(e) {
                        console.debug("InitNewRow");
                    },
                    onRowInserting: function(e) {
                        console.debug("RowInserting");
                    },
                    onRowInserted: function(e) {
                        console.debug("RowInserted");
                    },
                    onRowUpdating: function(e) {
                        console.debug("RowUpdating");
                    }
                });

            }
        });

        });
    });

</script>
</div>
</body>
</html>
