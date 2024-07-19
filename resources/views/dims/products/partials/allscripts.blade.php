<script>
    $(document).ready(function() {
        let pickingTeams = ({!! json_encode($pickingTeams) !!});
        let pushedCustomers = [];
        let prohibitedCustomers = [];
        let currentProductID;

        const selectPushed = $("#selectPushed").dxTagBox({
            dataSource: {
                store: pushedCustomers,
                paginate: true,
                pageSize: 100
            },
            applyValueMode: 'useButtons',
            showSelectionControls: true,
            selectAllMode: 'allPages',
            showClearButton: true,
            searchEnabled: true,
            multiline: false,
            valueExpr: 'CustomerId',
            displayExpr: function(item) {
                return item && item.StoreName;
            },
            onSelectionChanged: function(e) {
                if (e.addedItems && e.addedItems.length === 1 && e.addedItems[0] === 'ALL') {
                    const instance = e.component;
                    instance.option('paginate', false); // disable pagination
                    instance.selectAll(); // select all rows
                    instance.option('paginate', true); // re-enable pagination
                }
            }
        }).dxTagBox("instance");

        const selectProhibited = $("#selectProhibited").dxTagBox({
            dataSource: {
                store: prohibitedCustomers,
                paginate: true,
                pageSize: 100
            },
            applyValueMode: 'useButtons',
            showSelectionControls: true,
            selectAllMode: 'allPages',
            showClearButton: true,
            searchEnabled: true,
            multiline: false,
            valueExpr: 'CustomerId',
            displayExpr: function(item) {
                return item && item.StoreName;
            },
        }).dxTagBox("instance");

        // Note from Kyle - If you add to the popup, make sure you initialize the components before the popup
        const popupPushProhibit = $("#popupPushProhibit").dxPopup({
            showTitle: true,
            title: 'Edit Pushed/Prohibited Customers',
            footer: {
                text: "Copyright © 2024 My Company",
                showCancelButton: false,
                showConfirmButton: false
            },
            onHidden: function(e) {
                selectPushed.option('value', null);
                selectProhibited.option('value', null);
            },
            hideOnOutsideClick: false,
            showCloseButton: true,
            width: 600,
            height: 'auto',
            toolbarItems: [{
                    widget: 'dxButton',
                    toolbar: 'bottom',
                    location: 'after',
                    options: {
                        type: 'default',
                        stylingMode: 'contained',
                        icon: "fa fa-plus-circle",
                        text: "Update Pushed/Prohibited",
                        onClick: function(args) {
                            var PushedList = selectPushed.option('value');
                            var ProhibitedList = selectProhibited.option('value');

                            pushAndProhibitProductForCustomers(currentProductID, PushedList.join(','), ProhibitedList.join(','))
                        },
                    },
                },
            ],
        }).dxPopup("instance");

        const gridProducts = $("#gridProducts").dxDataGrid({
            dataSource: [], //as json
            hoverStateEnabled: true,
            showBorders: true,
            filterRow: {
                visible: true
            },
            allowColumnResizing: true,
            columnAutoWidth: true,
            keyExpr: 'ProductId',
            height: '78vh',
            paging: {
                pageSize: 500,
            },
            export: {
                enabled: true
            },
            editing: {
                mode: 'batch',
                allowUpdating: true
            },
            selection: {
                mode: 'single',
            },
            onExporting(e) {
                const workbook = new ExcelJS.Workbook();
                const worksheet = workbook.addWorksheet('products');
                DevExpress.excelExporter.exportDataGrid({
                    component: e.component,
                    worksheet,
                    autoFilterEnabled: true,
                }).then(() => {
                    workbook.xlsx.writeBuffer().then((buffer) => {
                        saveAs(new Blob([buffer], {
                            type: 'application/octet-stream'
                        }), 'products.xlsx');
                    });
                });
                e.cancel = true;
            },
            columns: [{
                    dataField: "ProductId",
                    caption: "ProductID",
                    allowEditing: false,
                    visible: false
                }, {
                    dataField: "PastelCode",
                    caption: "Item Code",
                    allowEditing: false,
                }, {
                    dataField: "PastelDescription",
                    caption: "Item Description",
                    allowEditing: false,
                },
                {
                    dataField: "PickingTeamId",
                    caption: "Picking Team",
                    value: "PickingTeam",
                    lookup: {
                        dataSource: pickingTeams,
                        valueExpr: "PickingTeamId",
                        displayExpr: "PickingTeam",
                    }
                }, {
                    dataField: "strBulkUnit",
                    caption: "Bulk Unit",
                    allowEditing: true,
                }, {
                    dataField: "UnitWeight",
                    caption: "Unit Weight",
                    allowEditing: true,
                }, {
                    dataField: "MultiLineItem",
                    caption: "Multi Line Item",
                    allowEditing: false,
                }, {
                    dataField: "SoldByWeight",
                    caption: "Sold by Weight",
                    allowEditing: true,
                }, {
                    dataField: "Mass",
                    caption: "Mass",
                    allowEditing: true,
                }, {
                    dataField: "ProductMargin",
                    caption: "Product Margin",
                    allowEditing: true,
                }, {
                    dataField: "Status",
                    caption: "Status",
                    allowEditing: false,
                }, {
                    dataField: "Binnumber",
                    caption: "Bin Number",
                    allowEditing: false,
                },
            ],
            onRowUpdating: function(e) {
                // console.debug(e);
                var ProductID = e.oldData.ProductId;
                // var PickingTeamId = e.newData.PickingTeamId;
                if (typeof e.newData.PickingTeamId !== 'undefined') {
                    var PickingTeamId = e.newData.PickingTeamId;
                    console.debug("______ new " + PickingTeamId);
                } else {
                    var PickingTeamId = e.oldData.PickingTeamId;
                    console.debug("______ old " + PickingTeamId);
                }
                if (typeof e.newData.strBulkUnit !== 'undefined') {
                    var strBulkUnit = e.newData.strBulkUnit;
                    console.debug("______ new " + strBulkUnit);
                } else {
                    var strBulkUnit = e.oldData.strBulkUnit;
                    console.debug("______ old " + strBulkUnit);
                }
                if (typeof e.newData.UnitWeight !== 'undefined') {
                    var UnitWeight = e.newData.UnitWeight;
                    console.debug("______ new " + UnitWeight);
                } else {
                    var UnitWeight = e.oldData.UnitWeight;
                    console.debug("______ old " + UnitWeight);
                }

                if (typeof e.newData.SoldByWeight !== 'undefined') {
                    var SoldByWeight = e.newData.SoldByWeight;
                    console.debug("______ new " + SoldByWeight);
                } else {
                    var SoldByWeight = e.oldData.SoldByWeight;
                    console.debug("______ old " + SoldByWeight);
                }
                if (typeof e.newData.ProductMargin !== 'undefined') {
                    var ProductMargin = e.newData.ProductMargin;
                    console.debug("______ new " + ProductMargin);
                } else {
                    var ProductMargin = e.oldData.ProductMargin;
                    console.debug("______ old " + ProductMargin);
                }
                //var ProductMargin = e.newData.ProductMargin;
                $.ajax({
                    url: '{!! url('/postProductInfo') !!}',
                    type: "POST",
                    data: {
                        ProductID: ProductID,
                        PickingTeamId: PickingTeamId,
                        strBulkUnit: strBulkUnit,
                        UnitWeight: UnitWeight,
                        SoldByWeight: SoldByWeight,
                        ProductMargin: ProductMargin
                    },
                    success: function(data) {
                        //  location.reload();
                    }
                });
            },
            onRowDblClick: function(e){
                currentProductID = e.data.ProductId;
                getPushedAndProhibitedProducts(currentProductID);
            }
        }).dxDataGrid("instance");

        getProducts();

        function getProducts() {
            $.ajax({
                url: '{!! url('/getProductgriddata') !!}',
                type: "GET",
                data: {},
                success: function(data) {
                    gridProducts.option('dataSource', data);
                    gridProducts.refresh();
                }
            });
        }

        function getPushedAndProhibitedProducts(ProductId) {
            $.ajax({
                url: '{!! url('/getPushedAndProhibitedCustomers') !!}',
                type: "GET",
                data: {
                    ProductId: ProductId,
                    Type: 'Prohibit',
                },
                success: function(data) {
                    prohibitedCustomers = {
                        store: data,
                        paginate: true,
                        pageSize: 100
                    };

                    var selectedCustomerIds = data
                    .filter(function(customer) {
                        return customer.bitSelected == '1';
                    })
                    .map(function(customer) {
                        return customer.CustomerId;
                    });

                    selectProhibited.option('dataSource', prohibitedCustomers);
                    selectProhibited.option('value', selectedCustomerIds);
                }
            });

            $.ajax({
                url: '{!! url('/getPushedAndProhibitedCustomers') !!}',
                type: "GET",
                data: {
                    ProductId: ProductId,
                    Type: 'Push',
                },
                success: function(data) {
                    pushedCustomers = {
                        store: data,
                        paginate: true,
                        pageSize: 100
                    };

                    var selectedCustomerIds = data
                    .filter(function(customer) {
                        return customer.bitSelected == '1';
                    })
                    .map(function(customer) {
                        return customer.CustomerId;
                    });

                    selectPushed.option('dataSource', pushedCustomers);
                    selectPushed.option('value', selectedCustomerIds);
                }
            });

            popupPushProhibit.show();
        }

        function pushAndProhibitProductForCustomers(ProductId, PushedList, ProhibitedList) {
            $.ajax({
                url: '{!! url('/pushAndProhibitProductForCustomers') !!}',
                type: "POST",
                data: {
                    ProductId: ProductId,
                    PushedList: PushedList,
                    ProhibitedList: ProhibitedList,
                },
                success: function(data) {
                    getProducts();
                    popupPushProhibit.hide();
                }
            });
        }

    });
</script>
