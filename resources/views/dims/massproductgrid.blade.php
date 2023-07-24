<!DOCTYPE html>
<html>
<head>
    <!-- ... -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- DevExtreme themes -->
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">

    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>


    <style>
        .dx-datagrid{
            font:10px verdana;
        }

    </style>
</head>
<body class="dx-viewport" style="font-family: Sans-serif">
<h5 style="  color: white; ">Products</h5>

<div id="gridContainer">

</div>
<div class="row">
    <script type="text/javascript" charset="utf-8">
        $( document ).on( 'focus', ':input', function(){
            $( this ).attr( 'autocomplete', 'off' );
        });
        var clickTimer, lastRowClickedId;
        $(document).ready(function() {





                        $(function(){
                            $("#gridContainer").dxDataGrid({
                                dataSource:'{!!url("/productdevexpress")!!}',

                                showBorders: true,
                                allowDeleting: false,
                                filterRow: { visible: true },
                                allowColumnResizing: true,

                                columns: [


                                    {
                                        dataField: "ProductId",
                                        caption: "ProductId",
                                        width: 150
                                    },
                                    {
                                        dataField: "PastelCode",
                                        caption: "Code",
                                        width: 150
                                    },
                                    {
                                        dataField: "PastelDescription",
                                        caption: "Description",
                                        width: 300
                                    },

                                    {
                                        dataField: "theRealPickingTeam",
                                        caption: "Picking Team",
                                        width: 70

                                    },

                                    {
                                        dataField: "Binnumber",
                                        caption: "Bin Number",
                                        width: 70
                                    },
                                    "BarCode",
                                    "Margin",
                                    "QtyInStock",
                                    "salesquantity",
                                    "Available",
                                ] ,
                                onEditingStart: function(e) {
                                    console.debug("EditingStart");
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
                                },
                                onRowUpdated: function(e) {
                                    console.debug("RowUpdated");
                                },
                                onRowRemoving: function(e) {
                                    console.debug("RowRemoving");
                                },
                                onRowRemoved: function(e) {
                                    console.debug("RowRemoved");
                                },
                                onRowClick: function (e) {
                                  //  alert("testing");
                                    //OBTAIN YOUR GRID DATA HERE
                                    //var data = e.selectedRowsData;
                                    var grid = $("#gridContainer").dxDataGrid('instance');
                                    var rows = grid.getSelectedRowsData();
                                    console.debug(e.rowIndex);

                                    if (clickTimer && lastRowCLickedId === e.rowIndex) {
                                        clearTimeout(clickTimer);
                                        clickTimer = null;
                                        lastRowCLickedId = e.rowIndex;
                                        //YOUR DOUBLE CLICK EVENT HERE
                                        console.debug(e.values[0]);
                                        var ProductId = e.values[0];
                                        var code = e.values[1];
                                        window.open('{!!url("/extraProdInfoView")!!}/'+ProductId+"/"+code, 'extrainfoproducts'+ProductId,
                                            'left=100,top=100,width=800,height=400,toolbar=1,resizable=0');
                                       //alert('double clicked!');
                                    } else {
                                        clickTimer = setTimeout(function () { }, 250);
                                    }

                                    lastRowCLickedId = e.rowIndex;
                                }
                            });
                        });

        });
    </script>
</div>
</body>
</html>
