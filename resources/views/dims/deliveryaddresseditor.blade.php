
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

    var jArray = JSON.stringify({!! json_encode($deliveryaddress) !!});

    var deliveryaddinfo = $.map(JSON.parse(jArray), function (item) {
        return {
            DeliveryAddressId:item.DeliveryAddressId,
            CustomerCode: item.CustomerCode, //
            CustomerDescription:item.CustomerDescription,
            DAddress1:item.DAddress1,//
            DAddress2:item.DAddress2,//
            DAddress3:item.DAddress3,//
            DAddress4:item.DAddress4,//
            DAddress5:item.DAddress5,//
            Route:item.Route
        }

    });

    var jArrayRoute = JSON.stringify({!! json_encode($routes) !!});
    var routeinfo = $.map(JSON.parse(jArrayRoute), function (item) {
        return {
            RoutePost:item.Route
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
                                dataSource:deliveryaddinfo,
                                showBorders: true,
                                paging: {
                                    enabled: true,
                                    pageSize:100
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
                                        dataField: "DeliveryAddressId",
                                        caption: "DeliveryAddressId",
                                        visible:false

                                    },
                                    {allowEditing:false,
                                        dataField: "CustomerCode",
                                        caption: "CustomerCode"

                                    },{allowEditing:false,
                                        dataField: "CustomerDescription",
                                        caption: "CustomerDescription"

                                    }
                                    ,{allowEditing:true,
                                        dataField: "DAddress1",
                                        caption: "Delivery Address Line 1"

                                    }
                                    ,{allowEditing:true,
                                        dataField: "DAddress2",
                                        caption: "Delivery Address Line 2"

                                    },{allowEditing:true,
                                        dataField: "DAddress3",
                                        caption: "Delivery Address Line 3"

                                    },{allowEditing:true,
                                        dataField: "DAddress4",
                                        caption: "Delivery Address Line 4"

                                    },{allowEditing:true,
                                        dataField: "DAddress5",
                                        caption: "Delivery Address Line 5"

                                    },
                                    {allowEditing:false,
                                        dataField: "Route",
                                        caption: "Current Route"

                                    },
                                    {
               dataField: "RoutePost",
               caption: "Routes",
               width: 250,
               setCellValue: function(rowData, value) {
                   rowData.RoutePost = value.RoutePost;
                   },
               lookup: {
                       dataSource: routeinfo,
                       displayExpr:'RoutePost',
                       valueExpr:'RoutePost',
                   },

           },

                                ] ,

                                onRowUpdated: function(e) {
                                    $.ajax({
                                        url:'{!!url("/updateDeliveryAddressesGrid")!!}',
                                        type: "POST",
                                        data:{
                                            ID: e.key.DeliveryAddressId,
                                            DAddress1: e.key.DAddress1,
                                            DAddress2: e.key.DAddress2,
                                            DAddress3: e.key.DAddress3,
                                            DAddress4: e.key.DAddress4,
                                            DAddress5: e.key.DAddress5,
                                            Route: e.key.RoutePost
                                        },
                                        success:function(data){

                                        }
                                    });
                                },
                                onEditorPreparing: function(e){
                                    console.log(e);
                                  if(e.parentType === "dataRow" && e.dataField === "RoutePost"){
                                   e.editorOptions.onValueChanged = function(ev){
                                    console.log(ev);
                                  let selectedItem = ev.component.option('selectedItem');
                                e.setValue(selectedItem);
                                }
                                }

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
