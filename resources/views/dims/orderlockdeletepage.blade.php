
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
<body class="dx-viewport" style="font-family: Sans-serif">


<div id="gridContainer">


</div>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        $( document ).on( 'focus', ':input', function(){

            $( this ).attr( 'autocomplete', 'off' );
        });
        var clickTimer, lastRowClickedId;
        $(document).ready(function() {





               // console.log($('#RouteName').val());
            $.ajax({
                url: '{!!url("/getOrderLocksForDeletePageData")!!}',
                type: "GET",
                data: {
                },
                success: function (data) {
                    $(function(){

                            $("#gridContainer").dxDataGrid({

                                dataSource:data,

                                showBorders: true,
                                filterRow: { visible: true },
                                allowColumnResizing: true,
                                editing: {
                                     mode: "row",
                                     refreshMode: "reshape",
                                     allowDeleting: true
                                },
                                columns: [
                                    {
                                        allowEditing:false,
                                        dataField: "OrderId",
                                        caption: "OrderID",
                                        width: 70

                                    },
                                    {
                                        allowEditing:false,
                                        dataField: "UserName",
                                        caption: "User Name",
                                        width: 150

                                    },

                                    {
                                        allowEditing:false,
                                        dataField: "TimeStamp",
                                        caption: "Time Of Order Lock",
                                        width: 170
                                    }

                                ] ,
                                onRowRemoved: function(e) {
                                    console.log(e.key.OrderId);
                                    $.ajax({
                                        url:'{!!url("/deleteDataForOrderLockPage")!!}',
                                        type: "POST",
                                        data:{
                                            OrderId: e.key.OrderId
                                        },
                                        success:function(data){
                                            console.log(e.key.OrderId);
                                        }
                                    });


                                }
                            });
                        });
                }
            });
        });
    </script>
</div>
</body>
</html>
