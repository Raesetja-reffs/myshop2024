<script>
    window.jsPDF = window.jspdf.jsPDF

    $(document).ready(function() {
        let massData = [];
        let formattedFrom = '';
        let formattedTo = '';
        let customerId = '';
        let productId = '';
        let dealName = '';
        let isAddMode = true;
        let isEditMode = false;
        let updateDeal = 0;

        var customers = {!! json_encode($customers) !!};
        var products = {!! json_encode($products) !!};
        var deals = {!! json_encode($deals) !!};

        var productsList = $.map(products, function(item) {
            return {
                PastelCode: item.PastelCode,
                PastelDescription: item.PastelDescription,
                CostPrice: item.Cost
            };
        });

        const inputDealName = $("#inputDealName").dxAutocomplete({
            dataSource: deals,
            valueExpr: 'strDealName',
            showClearButton: true,
            searchEnabled: true,
            onValueChanged: function(e) {
                checkDeal();
                refreshPopup();
            },
        }).dxAutocomplete("instance");

        const selectCustomers = $("#selectCustomers").dxTagBox({
            dataSource: {
                store: customers,
                paginate: true,
                pageSize: 100
            },
            disabled: !isAddMode,
            valueExpr: 'CustomerId',
            applyValueMode: 'useButtons',
            showSelectionControls: true,
            showClearButton: true,
            searchEnabled: true,
            valueExpr: 'CustomerId',
            displayExpr: function(item) {
                return item && '[' + item.CustomerPastelCode + '] ' + item.StoreName;
            },
        }).dxTagBox("instance");

        const selectDateRange = $("#selectDateRange").dxDateRangeBox({
            displayFormat: 'yyyy-MM-dd',
            showClearButton: true,
            value: [formattedFrom, formattedTo],
            onValueChanged: function(e) {
                if (e.value.length > 1 && e.value[0] != null && e.value[1] != null) {
                    formattedFrom = formatDate(e.value[0])
                    formattedTo = formatDate(e.value[1])
                    updateDateRange(formattedFrom, formattedTo)
                }
            }
        }).dxDateRangeBox("instance");

        const gridProducts = $("#gridProducts").dxDataGrid({
            dataSource: [],
            showBorders: true,
            showRowLines: true,
            showColumnLines: true,
            rowAlternationEnabled: true,
            filterRow: {
                visible: true
            },
            filterPanel: {
                visible: true
            },
            headerFilter: {
                visible: true
            },
            editing: {
                mode: 'cell',
                allowUpdating: true,
                allowDeleting: true,
                allowAdding: true,
                newRowPosition: 'last',
            },
            paging: {
                enabled: false
            },
            selection: {
                mode: "single",
            },
            columnFixing: {
                enabled: true,
            },
            columnAutoWidth: true,
            allowColumnResizing: true,
            columnResizingMode: "widget",
            columns: [{
                    dataField: "ProductId",
                    caption: "Product",
                    lookup: {
                        dataSource: {
                            store: products,
                            paginate: true,
                            pageSize: 100 // Specify the number of items per page
                        },
                        valueExpr: 'ProductId',
                        displayExpr: function(item) {
                            return item && '[' + item.PastelCode + '] ' + item.PastelDescription;
                        },
                    },
                },
                {
                    dataField: "dteFrom",
                    caption: "From",
                    allowEditing: false,
                },
                {
                    dataField: "dteTo",
                    caption: "To",
                    allowEditing: false,
                },
                {
                    dataField: "mnyPrice",
                    caption: "Price",
                    dataType: "number",
                    format: {
                        type: "fixedPoint",
                        precision: 2
                    },
                },
                {
                    dataField: "mnyCost",
                    caption: "Cost",
                    allowEditing: false,
                    dataType: "number",
                    format: {
                        type: "fixedPoint",
                        precision: 2
                    },
                },
                {
                    dataField: "mnyMargin",
                    caption: "Min Margin",
                    allowEditing: false,
                    // visible: false,
                    dataType: "number",
                    format: {
                        type: "fixedPoint",
                        precision: 2
                    },
                },
                {
                    dataField: "mnyGP",
                    caption: "Current GP",
                    allowEditing: false,
                    dataType: "number",
                    format: {
                        type: "fixedPoint",
                        precision: 2
                    },
                    calculateDisplayValue: function(e) {
                        gp = marginCalculator(e.mnyCost, e.mnyPrice)
                        return gp;
                    },
                },

            ],
            onRowInserting: function(e) {
                e.data.dteFrom = formattedFrom;
                e.data.dteTo = formattedTo;
            },
            onCellPrepared: function(e) {
                if (e.rowType === "data" && e.column.dataField === "mnyPrice" && e.isEditing) {
                    let dataGrid = e.component;
                    let lastRowIndex = dataGrid.getVisibleRows().length - 1;

                    $(e.cellElement).on('keydown', function(event) {
                        if ((event.key === "Enter" || event.key === "Tab") && e.row.rowIndex === lastRowIndex) {
                            setTimeout(function() {
                                dataGrid.addRow().done(function() {
                                    let newRowIndex = dataGrid.getVisibleRows().length - 1;
                                    dataGrid.editCell(newRowIndex, "ProductId");
                                });
                            }, 100);
                        }
                    });
                }
            },
            onEditorPrepared: function(e) {
                if (e.parentType === 'dataRow' && e.dataField === 'ProductId') {
                    var selectBoxInstance = e.editorElement.dxSelectBox('instance');
                    selectBoxInstance.option('onValueChanged', function(args) {
                        e.setValue(args.value);
                        // Find the corresponding product
                        var selectedProduct = products.find(product => product.ProductId == args.value);
                        if (selectedProduct) {
                            var rowIndex = e.row.rowIndex;
                            gridProducts.cellValue(rowIndex, "dteFrom", formattedFrom);
                            gridProducts.cellValue(rowIndex, "dteTo", formattedTo);
                            gridProducts.cellValue(rowIndex, "mnyCost", selectedProduct.Cost);
                            gridProducts.cellValue(rowIndex, "mnyMargin", selectedProduct.Margin);

                            gridProducts.editCell(rowIndex, "mnyPrice");
                        }
                    });
                }
            },
            onToolbarPreparing: function(e) {
                // Create a custom header on the left side
                e.toolbarOptions.items.unshift({
                    location: 'before',
                    template: function() {
                        return $('<h6>').text('Products');
                    }
                });
            }
        }).dxDataGrid('instance');

        // Note from Kyle - If you add to the popup, make sure you initialize the components before the popup
        const popupSpecials = $("#popupSpecials").dxPopup({
            showTitle: true,
            title: isAddMode? 'Create New Customer Special':'Edit Customer Special',
            footer: {
                text: "Copyright © 2024 My Company",
                showCancelButton: false,
                showConfirmButton: false
            },
            onHidden: function(e){
                inputDealName.option('value', null);
                selectCustomers.option('value', null);
                selectDateRange.option('value', [null,null]);
                gridProducts.option('dataSource', []);
                isAddMode = true;
                isEditMode = false;
                selectCustomers.option('disabled', !isAddMode);
                inputDealName.option('disabled', !isAddMode);
                
                refreshPopup();
            },
            hideOnOutsideClick: true,
            showCloseButton: true,
            width: 1200,
            height: 600,
            toolbarItems: [
                {
                    widget: 'dxButton',
                    toolbar: 'bottom',
                    location: 'after',
                    options: {
                        type: 'default',
                        stylingMode: 'contained',
                        icon: "fa fa-plus-circle",
                        text: "ADD SPECIAL",
                        disabled: !isAddMode,
                        onClick: function(args) {
                            var plannedLines = gridProducts.option('dataSource');
                            var customersSelected = selectCustomers.option('value');

                            var custIds = customersSelected.join(',');
                            var dteFrom = formatDate(selectDateRange.option('value')[0]);
                            var dteTo = formatDate(selectDateRange.option('value')[1]);
                            var dealName = inputDealName.option('value');
                            updateDeal = 0;

                            var specialLines = [];

                            $.each(plannedLines, function(index, line) {
                                specialLines.push({
                                    'ProductId': line.ProductId,
                                    'mnyPrice': line.mnyPrice,
                                    'mnyCost': line.mnyCost,
                                    'mnyMargin': marginCalculator(line.mnyCost, line.mnyPrice),
                                    'mnyMinMargin': line.mnyMargin,
                                });
                            });

                            // console.log(specialLines);

                            postLines(custIds, dteFrom, dteTo, specialLines, dealName, updateDeal)
                            
                        },
                    },
                },
                {
                    widget: 'dxButton',
                    toolbar: 'bottom',
                    location: 'after',
                    options: {
                        type: 'default',
                        stylingMode: 'contained',
                        icon: "fa fa-plus-circle",
                        text: "EDIT SPECIAL",
                        disabled: !isEditMode,
                        onClick: function(args) {
                            var plannedLines = gridProducts.option('dataSource');
                            var customersSelected = selectCustomers.option('value');

                            var custIds = customersSelected.join(',');
                            var dteFrom = formatDate(selectDateRange.option('value')[0]);
                            var dteTo = formatDate(selectDateRange.option('value')[1]);
                            var dealName = inputDealName.option('value');
                            updateDeal = 1;

                            var specialLines = [];

                            $.each(plannedLines, function(index, line) {
                                specialLines.push({
                                    'ProductId': line.ProductId,
                                    'mnyPrice': line.mnyPrice,
                                    'mnyCost': line.mnyCost,
                                    'mnyMargin': marginCalculator(line.mnyCost, line.mnyPrice),
                                });
                            });

                            // console.log(specialLines);

                            postLines(custIds, dteFrom, dteTo, specialLines, dealName, updateDeal)
                            
                        },
                    },
                }
            ],
        }).dxPopup("instance");

        const gridCustomerSpecials = $("#gridCustomerSpecials").dxDataGrid({
            dataSource: massData,
            showBorders: true,
            showRowLines: true,
            showColumnLines: true,
            rowAlternationEnabled: true,
            filterRow: {
                visible: true
            },
            filterPanel: {
                visible: true
            },
            headerFilter: {
                visible: true
            },
            editing: {
                mode: 'row',
                allowDeleting: true,
            },
            export: {
                enabled: true,
                formats: ['pdf', 'excel'],
            },
            onExporting(e) {
                if (e.format == 'excel') {
                    const workbook = new ExcelJS.Workbook();
                    const worksheet = workbook.addWorksheet('Customer Specials');

                    DevExpress.excelExporter.exportDataGrid({
                        component: e.component,
                        worksheet,
                        autoFilterEnabled: true,
                    }).then(() => {
                        workbook.xlsx.writeBuffer().then((buffer) => {
                            saveAs(new Blob([buffer], {
                                    type: 'application/octet-stream'
                                }), 'Customer Specials ' + formattedFrom + ' - ' +
                                formattedTo + '.xlsx');
                        });
                    });
                    e.cancel = true;

                } else if (e.format == 'pdf') {
                    const doc = new jsPDF({
                        orientation: "landscape",
                        unit: "mm",
                    });

                    DevExpress.pdfExporter.exportDataGrid({
                        jsPDFDocument: doc,
                        component: e.component,
                        keepColumnWidths: false
                    }).then(() => {
                        addFooter(doc); // Add footer to every page
                        doc.save('Customer Specials ' + formattedFrom + ' - ' + formattedTo +
                            '.pdf');
                    });
                }
            },
            paging: {
                enabled: false
            },
            selection: {
                mode: "single",
            },
            columnFixing: {
                enabled: true,
            },
            columnAutoWidth: true,
            allowColumnResizing: true,
            columnResizingMode: "widget",
            columnChooser: {
                enabled: true,
                mode: 'select',
                position: {
                    my: 'right top',
                    at: 'right bottom',
                    of: '.dx-datagrid-column-chooser-button',
                },
                search: {
                    enabled: true,
                    editorOptions: {
                        placeholder: 'Search column'
                    },
                },
                selection: {
                    recursive: true,
                    selectByClick: true,
                    allowSelectAll: true,
                },
            },
            columns: [{
                    dataField: "CustomerPastelCode",
                    caption: "Customer Code",
                    allowEditing: false,
                    // groupIndex: 0,
                },
                {
                    dataField: "strDealName",
                    caption: "DealName",
                    allowEditing: false,
                    // groupIndex: 0,
                },
                {
                    dataField: "StoreName",
                    caption: "Customer Name",
                    allowEditing: false,
                    groupIndex: 0,
                },
                {
                    dataField: "SpecialHeaderId",
                    caption: "Special Header ID",
                    // visible: false,
                    groupIndex: 0,
                    groupCellTemplate: function(container, options) {
                        var groupNameDiv = $('<div>').text(options.text).css({
                            'display': 'inline-block',
                            'vertical-align': 'middle'
                        }).appendTo(container);

                        $("<div>").dxButton({
                            icon: "fa fa-clone",
                            text: "",
                            elementAttr: {
                                class: "action-icon-button"
                            },
                            onClick: function(e) {
                                copyCustomerSpecial(options.data.items);
                            }
                        }).appendTo(container);

                        $("<div>").dxButton({
                            icon: "fa fa-edit",
                            text: "",
                            elementAttr: {
                                class: "action-icon-button"
                            },
                            onClick: function(e) {
                                editCustomerSpecial(options.data.items);
                            }
                        }).appendTo(container);
                    }
                },
                {
                    dataField: "CustomerSpecial",
                    caption: "Special ID",
                    visible: false,
                },
                {
                    dataField: "PastelCode",
                    caption: "Item Code",
                    allowEditing: false,
                },{
                    dataField: "ProductId",
                    caption: "ProductId",
                    allowEditing: false,
                    visible: false,
                },
                {
                    dataField: "PastelDescription",
                    caption: "Item Name",
                    allowEditing: false,
                },
                {
                    dataField: "mnyCost",
                    caption: "Cost",
                    dataType: "number",
                    format: {
                        type: "fixedPoint",
                        precision: 2
                    },
                    allowEditing: false,
                },
                {
                    dataField: "mnyDealPrice",
                    caption: "Deal Price",
                    dataType: "number",
                    allowEditing: false,
                    format: {
                        type: "fixedPoint",
                        precision: 2
                    },
                },
                {
                    dataField: "mnyPrice",
                    caption: "Special Price",
                    dataType: "number",
                    format: {
                        type: "fixedPoint",
                        precision: 2
                    },
                },
                {
                    dataField: "dteFrom",
                    caption: "Date From",
                    dataType: "date",
                    format: 'yyyy-MM-dd',
                },
                {
                    dataField: "dteTo",
                    caption: "Date To",
                    dataType: "date",
                    format: 'yyyy-MM-dd',
                },
                {
                    dataField: "mnyMargin",
                    caption: "Margin",
                    dataType: "number",
                    format: {
                        type: "fixedPoint",
                        precision: 2
                    },
                    allowEditing: false,
                },
            ],
            onRowRemoved: function(e) {
                $.ajax({
                    url: '{!! url('/removeCustomerSpecial') !!}',
                    type: "POST",
                    data: {
                        removeSpecial: e.data.CustomerSpecial,
                    },
                    success: function(data) {
                        if (data.deletedId != 'FAILED') {
                            getOverallCustomerSpecials();
                        } else {
                            // alert('failed to delete special');
                            DevExpress.ui.notify({
                                message: 'failed to delete special',
                                type: 'error', // 'info', 'success', 'warning'
                                displayTime: 3500,
                            });
                        }
                    }
                });
            },
            onToolbarPreparing: function(e) {
                e.toolbarOptions.items.push({
                    location: 'before',
                    widget: "dxDateRangeBox",
                    options: {
                        width: 250,
                        id: "dateRange",
                        displayFormat: 'yyyy-MM-dd',
                        showClearButton: true,
                        value: [formattedFrom, formattedTo],
                        onValueChanged: function(e) {
                            var dateFrom = e.value[0];
                            var dateTo = e.value[1];

                            if (dateFrom) {
                                dateFrom = new Date(dateFrom);
                                dateFrom.setTime(dateFrom.getTime() + (2 * 60 * 60 *
                                    1000));
                                formattedFrom = dateFrom.toISOString().slice(0, 10);
                            } else {
                                formattedFrom = '';
                            }

                            if (dateTo) {
                                dateTo = new Date(dateTo);
                                dateTo.setTime(dateTo.getTime() + (2 * 60 * 60 * 1000));
                                formattedTo = dateTo.toISOString().slice(0, 10);
                            } else {
                                formattedTo = '';
                            }
                        }
                    }
                });
                e.toolbarOptions.items.push({
                    location: 'before',
                    widget: "dxSelectBox",
                    options: {
                        dataSource: {
                            store: customers,
                            paginate: true,
                            pageSize: 100
                        },
                        valueExpr: 'CustomerId',
                        searchEnabled: true,
                        showClearButton: true,
                        width: 250,
                        displayExpr: function(item) {
                            return item && '[' + item.CustomerPastelCode + '] ' + item.StoreName;
                        },
                        onValueChanged: function(e) {
                            customerId = e.value;
                        }
                    }
                });
                e.toolbarOptions.items.push({
                    location: 'before',
                    widget: "dxSelectBox",
                    options: {
                        dataSource: {
                            store: products,
                            paginate: true,
                            pageSize: 100
                        },
                        valueExpr: 'ProductId',
                        searchEnabled: true,
                        showClearButton: true,
                        width: 250,
                        displayExpr: function(item) {
                            return item && '[' + item.PastelCode + '] ' + item.PastelDescription;
                        },
                        onValueChanged: function(e) {
                            productId = e.value;
                        }
                    }
                });
                e.toolbarOptions.items.push({
                    location: 'before',
                    widget: "dxAutocomplete",
                    options: {
                        dataSource: deals,
                        valueExpr: 'strDealName',
                        showClearButton: true,
                        width: 150,
                        label: "Deal Name",
                        value: dealName,
                        onValueChanged: function(e) {
                            dealName = e.value;
                        }
                    }
                });
                e.toolbarOptions.items.push({
                    location: 'before',
                    widget: "dxButton",
                    options: {
                        icon: "fa fa-search",
                        text: "SEARCH",
                        type: 'default',
                        stylingMode: 'contained',
                        onClick: function(args) {
                            getOverallCustomerSpecials();
                        },
                        elementAttr: {
                            class: "menu-button"
                        },
                    },
                });
                e.toolbarOptions.items.push({
                    location: 'after',
                    widget: "dxButton",
                    options: {
                        icon: "fa fa-plus-circle",
                        text: "ADD",
                        type: 'default',
                        stylingMode: 'contained',
                        onClick: function(args) {
                            // $('#modalAddCustomerSpecial').modal('show');
                            popupSpecials.show();
                        },
                    },
                });
            }
        }).dxDataGrid('instance');

        // Function to add footer to every page
        function addFooter(doc) {
            const totalPages = doc.internal.getNumberOfPages();
            for (let i = 1; i <= totalPages; i++) {
                doc.setPage(i);
                doc.setFontSize(10);
                doc.text('Page ' + i + ' of ' + totalPages, doc.internal.pageSize.width - 50, doc.internal
                    .pageSize.height - 10);
                const now = new Date();
                const printedDate = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate();
                doc.text('Date Printed: ' + printedDate, 10, doc.internal.pageSize.height - 10);
            }
        }

        // Get Data using filters
        function getOverallCustomerSpecials() {
            if (formattedFrom == '' && formattedTo == '' && customerId == '' && productId == '' && dealName ==
                '') {
                DevExpress.ui.notify({
                    message: 'Choose at least one filter above and press search to display specials.',
                    type: 'info', // 'error', 'warning', 'success'
                    displayTime: 3500,
                });
            } else {
                $('#overlay').prop('hidden', false);
                $.ajax({
                    url: '{!! url('/getOverallCustomerSpecials') !!}',
                    type: "GET",
                    data: {
                        dateFrom: formattedFrom,
                        dateTo: formattedTo,
                        customerId: customerId,
                        productId: productId,
                        dealName: dealName,
                    },
                    success: function(data) {
                        gridCustomerSpecials.option('dataSource', data);
                        gridCustomerSpecials.refresh();
                        $('#overlay').prop('hidden', true);
                    }
                });
            }
        }

        // Updates the date range on the products grid
        function updateDateRange(from, to) {
            var datasource = gridProducts.option('dataSource');
            if (gridProducts && datasource && datasource.length > 0) {
                // Iterate through each row
                for (var i = 0; i < datasource.length; i++) {
                    var row = datasource[i];
                    if (!row.hasOwnProperty('dteFrom')) {
                        row.dteFrom = from;
                    } else {
                        row.dteFrom = from;
                    }

                    if (!row.hasOwnProperty('dteTo')) {
                        row.dteTo = to;
                    } else {
                        row.dteTo = to;
                    }
                }
            }
            gridProducts.option('dataSource', datasource);
            gridProducts.refresh();
        }

        // copies an existing special to create for a new customer
        function copyCustomerSpecial(groupData) {
            selectDateRange.option('value', [new Date(groupData[0]['dteFrom']), new Date(groupData[0]['dteTo'])]);
            inputDealName.option('value', groupData[0]['strDealName']);

            var lines = groupData.map(function(item) {
                return {
                    ProductId: item.ProductId,
                    mnyPrice: item.mnyPrice,
                    mnyCost: item.mnyCost,
                    dteFrom: item.dteFrom,
                    dteTo: item.dteTo,
                };
            });

            checkDeal();
            refreshPopup();

            gridProducts.option('dataSource', lines);
            gridProducts.refresh();

            popupSpecials.show();

        }

        // copies an existing special to create for a new customer
        function editCustomerSpecial(groupData) {
            selectDateRange.option('value', [new Date(groupData[0]['dteFrom']), new Date(groupData[0]['dteTo'])]);
            inputDealName.option('value', groupData[0]['strDealName']);

            var custDets = customers.find(customer => customer.CustomerPastelCode == groupData[0]['CustomerPastelCode']);

            selectCustomers.option('value', [parseInt(custDets.CustomerId)]);


            var lines = groupData.map(function(item) {
                return {
                    ProductId: item.ProductId,
                    mnyPrice: item.mnyPrice,
                    mnyCost: item.mnyCost,
                    dteFrom: item.dteFrom,
                    dteTo: item.dteTo,
                };
            });

            gridProducts.option('dataSource', lines);
            gridProducts.refresh();

            isAddMode = false;
            isEditMode = true;

            checkDeal();
            
            selectCustomers.option('disabled', !isAddMode);
            inputDealName.option('disabled', !isAddMode);
            refreshPopup();

            popupSpecials.show();

        }

        function refreshPopup() {
            // Update the title
            popupSpecials.option('title', isAddMode ? 'Create New Customer Special' : 'Edit Customer Special');

            // Update the button text in toolbarItems
            var toolbarItems = popupSpecials.option('toolbarItems');
            if (toolbarItems && toolbarItems.length > 0) {
                var btnAdd = toolbarItems[0].options;
                btnAdd.disabled = !isAddMode;
                toolbarItems[0].options = btnAdd;

                var btnEdit = toolbarItems[1].options;
                btnEdit.disabled = !isEditMode;
                toolbarItems[1].options = btnEdit;
                popupSpecials.option('toolbarItems', toolbarItems);
            }

            // Optionally repaint the popup if needed
            popupSpecials.repaint();
        }

        // checks margin auth
        function checkMarginsAuth(lines) {
            let requireAuth = 0;
            $.each(lines, function(index, row) {
                console.log('Margin: ' + row.mnyMargin + ' MinMargin: '+ row.mnyMinMargin)
                if (row.mnyMargin < row.mnyMinMargin) {
                    requireAuth = 1;
                }
            });

            return requireAuth;
        };

        // calculates margin
        function marginCalculator(cost, price) {
            return parseFloat((100 - ((cost / price)) * 100).toFixed(2));
        }

        // check if deal name already exists
        function checkDeal() {
            dealName = inputDealName.option('value') || '';
            isEditMode = deals.some(deal => deal.strDealName === dealName);
        }

        // posts lines to create special
        function postLines(custIds, dteFrom, dteTo, lines, dealName, updateDeal) {
            var reqAuth = checkMarginsAuth(lines);

            alert(reqAuth);
            
            // $.ajax({
            //     url: '{!! url('/XmlCreateCustomerSpecials') !!}',
            //     type: "POST",
            //     data: {
            //         lines: lines,
            //         CustomerIds: custIds,
            //         dteFrom: dteFrom,
            //         dteTo: dteTo,
            //         DealName: dealName,
            //         updateDeal: updateDeal,
            //     },
            //     success: function(data) {
            //         console.log(data);
            //         if (data.result != "SUCCESS") {
            //             // alert(data.result);
            //             DevExpress.ui.notify({
            //                 message: data.result,
            //                 type: 'error', // 'info', 'error', 'warning'
            //                 displayTime: 3500,
            //             });

            //         } else {
            //             DevExpress.ui.notify({
            //                 message: data.result,
            //                 type: 'success', // 'info', 'error', 'warning'
            //                 displayTime: 3500,
            //             });

            //             popupSpecials.hide();

            //             getOverallCustomerSpecials();
            //         }


            //     }
            // });
        };

    });
</script>