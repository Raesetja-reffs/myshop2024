
<script>
var clickTimer, lastRowClickedId;
        $(document).ready(function() {



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