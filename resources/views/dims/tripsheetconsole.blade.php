
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

    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" type="text/css" />
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

<table class='border' style = "width:800">
                <tbody>

<tr>
                        <td>
                            <div id="gridContainer"/>


                        </td>

                    </tr>
                </tbody>
            </table>


<script>

    var jArray = JSON.stringify({!! json_encode($consolelogs) !!});

    var Commands = $.map(JSON.parse(jArray), function (item) {
        var booleanfromitem = (item.Reviewed ==='true'); //wow that works use this as a comparator but be sure to make a string true false value in sql first
        return {
            ID:item.ID,
            Time: item.Time, //
            Command:item.Command,
            ProductDesc:item.ProductDescription,//
            ItemCode:item.ItemCode,//
            Ordered:item.Ordered,//
            Dispatched:item.Dispatched,//
            OrderId:item.OrderId,//
            Loaded:item.Loaded,
            Reviewed:booleanfromitem,
            InvoiceNo:item.InvoiceNo,
            StoreName:item.StoreName
        }

    });



        $( document ).on( 'focus', ':input', function(){

            $( this ).attr( 'autocomplete', 'off' );
        });
        var clickTimer, lastRowClickedId;
        $(document).ready(function() {


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


                            $("#gridContainer").dxDataGrid({
                                dataSource:Commands,
                                showBorders: true,
                                paging: {
                                    enabled: false
                                },
                                filterRow: { visible: true },scrolling: {
            columnRenderingMode: "virtual"
        },
        columnAutoWidth:true,
        editing: {
                                     mode: "row",
                                     refreshMode: "reshape",
                                     allowUpdating: true
                                },
                                columns: [
                                    {allowEditing:false,
                                        dataField: "ID",
                                        caption: "ID"

                                    },
                                    {allowEditing:false,
                                        dataField: "Time",
                                        caption: "Time"

                                    },{allowEditing:false,
                                        dataField: "Command",
                                        caption: "Command"

                                    }
                                    ,{allowEditing:false,
                                        dataField: "StoreName",
                                        caption: "Customer"

                                    }
                                    ,{allowEditing:false,
                                        dataField: "ProductDesc",
                                        caption: "Product Description"

                                    },{allowEditing:false,
                                        dataField: "ItemCode",
                                        caption: "Item Code"

                                    },{allowEditing:false,
                                        dataField: "Ordered",
                                        caption: "Ordered"

                                    },{allowEditing:false,
                                        dataField: "Dispatched",
                                        caption: "Dispatched"

                                    },
                                    {allowEditing:false,
                                        dataField: "InvoiceNo",
                                        caption: "Invoice No"

                                    }
                                    ,{allowEditing:false,
                                        dataField: "OrderId",
                                        caption: "Order ID"

                                    },{allowEditing:false,
                                        dataField: "Loaded",
                                        caption: "Loaded"

                                    },{
                                        dataType:"boolean",
                                        dataField: "Reviewed",
                                        caption: "Reviewed",

                                    },

                                ] ,

                                onRowUpdated: function(e) {
                                    $.ajax({
                                        url:'{!!url("/updateReviewedStatus")!!}',
                                        type: "POST",
                                        data:{
                                            ID: e.key.ID,
                                            Reviewed: e.key.Reviewed
                                        },
                                        success:function(data){

                                        }
                                    });
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

            });
    </script>
</div>
</body>
</html>
