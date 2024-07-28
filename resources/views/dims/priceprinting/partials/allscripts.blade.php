<script>



    $(document).ready(function() {
        //
        let customers = {!! json_encode($customers) !!};
        let groups = {!! json_encode($groups) !!};
        
            const inputCustomer = $("#inputCustomer").dxAutocomplete({
            dataSource: customers,
            searchExpr: ["CustomerPastelCode", "StoreName"],
            valueExpr: 'CustomerPastelCode',
            showClearButton: true,
            searchEnabled: true,
            onValueChanged: function(e) {
            },
        }).dxAutocomplete("instance");


            const inputGroup = $("#inputGroup").dxTagBox({
                dataSource: groups,
                valueExpr: 'GroupId',
                displayExpr: 'GroupName',
                applyValueMode: 'useButtons',
                showSelectionControls: true,
                showClearButton: true,
                searchEnabled: true,
                onValueChanged: function(e) {
                },
            }).dxTagBox("instance");


        $('#submitCustomerData').click(function(){

            $.ajax({
                url: '{!!url("/getAllCustomerPricesSearch")!!}',
                type: "POST",
                data: {
                    inputCustAccount:inputCustomer.option('value')
                },
                success: function (data) {
                    generateGridData(data);
                    
                                        }
                 })

                   });
                   $('#submitGroupData').click(function(){

$.ajax({
    url: '{!!url("/getGroupPricesSearch")!!}',
    type: "POST",
    data: {
        inputGroupId:inputGroup.option('value')
    },
    success: function (data) {

        generateGridData(data);
                            }
     })

       });
                   
            });
            function generateGridData(data){
                $("#gridContainer").dxDataGrid({

dataSource:data,
showBorders: true,
filterRow: { visible: true },
allowColumnResizing: true,
paging:{
    pageSize: 50,
},
export: {
    enabled: true
},
onExporting(e) {
    const workbook = new ExcelJS.Workbook();
    const worksheet = workbook.addWorksheet('prices');

    DevExpress.excelExporter.exportDataGrid({
        component: e.component,
        worksheet,
        autoFilterEnabled: true,
        customizeCell: (options) => {
            const { excelCell, gridCell } = options;

            if (gridCell.column.dataField === 'CustomDate') {
                excelCell.value = new Date().toISOString().split('T')[0];
            }
        }
    }).then(() => {
        workbook.xlsx.writeBuffer().then((buffer) => {
            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'prices.xlsx');
        });
    });
    e.cancel = true;
},

columns: [ 
    {
        dataField: "PricingType",
        caption: "Pricing Type",
        width: 125
    },
    {
        dataField: "PastelCode",
        caption: "Item Code",
        width: 125
    },{
        dataField: "PastelDescription",
        caption: "Item Description",
        width: 250
    },{
        dataField: "Price",
        caption: "Price",
        width: 125,
        dataType: 'number',
        format:{
            type: "fixedPoint",
            precision: 2
        },
    },{
    dataField: 'ExportDate',
        caption: 'Export Date',
        calculateCellValue: function() {
            // Return today's date in yyyy-mm-dd format
            return new Date().toISOString().split('T')[0];
        }
    }

] ,


});

            }

        </script>
