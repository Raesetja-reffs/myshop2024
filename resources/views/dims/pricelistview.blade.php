
<!DOCTYPE html>

<html>
<head>
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet"  type='text/css'>
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ... -->
    <!-- DevExtreme themes -->
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css" />
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>



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
<h3>Price List Information</h3>

<div class="dx-field" style="display: none;">
    <div class="dx-field-label">DropDownBox with embedded DataGrid</div>
    <div class="dx-field-value">
        <div id="gridBox"></div>
    </div>
</div>

<select id="pricelist">
    <option value="">Select Price List</option>
    @foreach($pricelist as $val)
        <option value="{{$val->PriceListId}}">{{$val->PriceList}}</option>
    @endforeach
</select>
<button id="savetopdf">Save Selected To PDF</button>

    <div id="gridorders" style="height: 800px;width: 30% !important;"></div>

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
        $("#refresh").click(function () {
            location.reload();

        });
        $("#pricelist").change(function () {
            var ids = this.value;

            getpricelistinfo(ids);
        });

        $('#savetopdf').click(function(){
            var plist = $('#pricelist').val();
            if(plist.length > 1){
                window.open('{!!url("/pdfpricelist")!!}/'+$('#pricelist').val(),"Price List"+$('#pricelist').val(), "location=1,status=1,scrollbars=1, width=1200,height=850");
            }

        });



    });

    function getpricelistinfo(pricelistid){

        $.ajax({
            url: '{!!url("/getProductsMappedToThePriceList")!!}',
            type: "GET",
            data: {
                pricelistid:pricelistid
            },
            success: function (data) {
                //localStorage.routeplanner = JSON.stringify({name: "John",routeId: $('#rouTabletLoadingtesonPlanning').val(),deliveryDate: $('#deliveryDatesonPlanning').val()});

                $("#gridorders").dxDataGrid({
                    dataSource:data,
                    showBorders: true,

                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    paging: {
                        enabled: false
                    },
                    export: {
                        enabled: true,

                    },
                    onExporting(e) {
                        var pricelistnamesheet = $('#pricelist option:selected').text();
                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet(pricelistnamesheet);

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), pricelistnamesheet+'.xlsx');
                            });
                        });
                        e.cancel = true;
                    }
                    ,columnWidth:200,
                    columnAutoWidth:true,        allowColumnResizing: true,       columnResizingMode: "nextColumn",
                    columns: [
                        {
                            width: 90,
                            dataField: "PastelCode",
                            caption: "Item Code",
                            headerFilter: {
                                allowSearch: true,
                            }

                        },
                        {
                            width: 300,
                            dataField: "PastelDescription",
                            caption: "Item Description",

                        },
                        {
                            width: 80,
                            dataField: "Price",
                            caption: "Price",dataType:"number",format: "#0.##"

                        }
                    ] ,

                    onRowClick: function (e) {

                        console.debug("Rather beeeeeeeeeeeeeeeeeeeee onClick");
                        console.debug(e);
                        // getordersmappedtoproduct(e.data.orderid)

                    },
                    onCellClick: function (e) {
                        console.debug("cell beeeeeeeeeeeeeeeeeeeee double click ");
                        console.debug(e.data);
                        // Handles the "cellClick" event
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
    }
</script>
</div>
</body>
</html>
