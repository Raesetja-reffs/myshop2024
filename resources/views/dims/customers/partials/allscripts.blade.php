<script>
    $(document).ready(function() {
        let customers = {!! json_encode($customers) !!};
        let routes = {!! json_encode($routes) !!};
        let groups = {!! json_encode($groups) !!};
        let salesmen = {!! json_encode($salesmen) !!};
        let users = {!! json_encode($users) !!};
        let yesno = [
            {
                "value": "False",
                "display": "No",
            },{
                "value": "True",
                "display": "Yes",
            }
        ]

        // @php 
        //     dump($customers->toArray()) 
        //     dump($routes->toArray()) 
        //     dump($groups->toArray()) 
        //     dump($salesmen->toArray()) 
        //     dump($users->toArray()) 
        // @endphp

        $("#gridCustomers").dxDataGrid({
            dataSource: customers,
            showBorders: true,
            filterRow: {
                visible: true
            },
            scrolling: {
                rowRenderingMode: 'infinite',
            },
            columnAutoWidth: true,
            allowColumnResizing: true,
            columnResizingMode: "widget",
            paging: {
                pageSize: 10,
            },
            pager: {
                visible: true,
                allowedPageSizes: [5, 10, 20, 50, 100, 'all'],
                showPageSizeSelector: true,
                showInfo: true,
                showNavigationButtons: true,
            },
            export: {
                enabled: true
            },
            selection: {
                mode: 'single',
            },
            onExporting(e) {
                const workbook = new ExcelJS.Workbook();
                const worksheet = workbook.addWorksheet('customers');

                DevExpress.excelExporter.exportDataGrid({
                    component: e.component,
                    worksheet,
                    autoFilterEnabled: true,
                }).then(() => {
                    workbook.xlsx.writeBuffer().then((buffer) => {
                        saveAs(new Blob([buffer], {
                            type: 'application/octet-stream'
                        }), 'customers.xlsx');
                    });
                });
                e.cancel = true;
            },
            editing: {
                mode: 'batch',
                allowUpdating: true,
                selectTextOnEditStart: true,
                startEditAction: 'click',
            },
            height: '78vh',
            columns: [
                {
                    dataField: "CustomerId",
                    caption: "Customer Id",
                    allowEditing: false,
                },
                {
                    dataField: "CustomerPastelCode",
                    caption: "Customer Code",
                    allowEditing: false,
                },
                {
                    dataField: "StoreName",
                    caption: "Customer Name",
                    allowEditing: false,
                },
                {
                    dataField: "Routeid",
                    caption: "Route",
                    lookup: {
                        dataSource: {
                            store: routes,
                            paginate: true,
                            pageSize: 100
                        },
                        valueExpr: 'RouteId',
                        displayExpr: 'Route',
                    },
                },
                {
                    dataField: "Email",
                    caption: "Email",
                },
                {
                    dataField: "ContactPerson",
                    caption: "Contact Person",
                },
                {
                    dataField: "ContactTel",
                    caption: "Contact Tel.",
                },
                {
                    dataField: "PriceListName",
                    caption: "Price List",
                    allowEditing: false,
                },
                {
                    dataField: "GroupId",
                    caption: "Group",
                    lookup: {
                        dataSource: {
                            store: groups,
                            paginate: true,
                            pageSize: 100
                        },
                        valueExpr: 'GroupId',
                        displayExpr: 'GroupName',
                    },
                },
                {
                    dataField: "UserId",
                    caption: "User Name",
                    lookup: {
                        dataSource: {
                            store: users,
                            paginate: true,
                            pageSize: 100
                        },
                        valueExpr: 'UserId',
                        displayExpr: 'UserName',
                    },
                },
                {
                    dataField: "SalesAnalysisCode",
                    caption: "Sales Rep",
                    lookup: {
                        dataSource: {
                            store: salesmen,
                            paginate: true,
                            pageSize: 100
                        },
                        valueExpr: 'UserId',
                        displayExpr: function(item) {
                            if (item.strSalesmanCode) {
                                return '[' + item.strSalesmanCode + '] ' + item.UserName;
                            } else {
                                return item.UserName;
                            }
                        }
                    },
                },
                {
                    dataField: "DeliverySequence",
                    caption: "Delivery Seq.",
                },
                {
                    dataField: "DocPrintOrEmail",
                    caption: "Recieve Emails",
                    lookup: {
                        dataSource: yesno,
                        valueExpr: 'value',
                        displayExpr: 'display',
                    },
                },
                {
                    dataField: "Discount",
                    caption: "Discount",
                },
                {
                    dataField: "CreditLimit",
                    caption: "Credit Limit",
                },
                {
                    dataField: "UniqueDelivery",
                    caption: "Unique Delivery",
                    lookup: {
                        dataSource: yesno,
                        valueExpr: 'value',
                        displayExpr: 'display',
                    },
                },
                {
                    dataField: "PriorityCustomer",
                    caption: "Priority Customer",
                    lookup: {
                        dataSource: yesno,
                        valueExpr: 'value',
                        displayExpr: 'display',
                    },
                },
                {
                    dataField: "CustomerOnHold",
                    caption: "Customer On Hold",
                    lookup: {
                        dataSource: yesno,
                        valueExpr: 'value',
                        displayExpr: 'display',
                    },
                },
                {
                    dataField: "MarkupPercentage",
                    caption: "Markup Percentage",
                },
                {
                    dataField: "locationName",
                    caption: "Location Name",
                    allowEditing: false,
                },
                {
                    dataField: "DeliveryAddress1",
                    caption: "Delivery Line 1",
                }, {
                    dataField: "DeliveryAddress2",
                    caption: "Delivery Line 2",
                }, {
                    dataField: "DeliveryAddress3",
                    caption: "Delivery Line 3",
                }, {
                    dataField: "DeliveryAddress4",
                    caption: "Delivery Line 4",
                }, {
                    dataField: "DeliveryAddress5",
                    caption: "Delivery Line 5",
                },
            ],
            onRowClick: function(e) {
                console.debug("RowClick");
            },
            onRowDblClick: function(e) {
                window.open('{!! url('/massCustomerUpdate') !!}/' + e.key.CustomerId, 'mywin',
                    'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0');
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
                var CustomerId = e.data.CustomerId
                var Routeid = e.data.Routeid
                var Email = e.data.Email
                var ContactPerson = e.data.ContactPerson
                var ContactTel = e.data.ContactTel
                var GroupId = e.data.GroupId
                var SalesAnalysisCode = e.data.SalesAnalysisCode
                var DeliverySequence = e.data.DeliverySequence
                var DocPrintOrEmail = e.data.DocPrintOrEmail
                var Discount = e.data.Discount
                var CreditLimit = e.data.CreditLimit
                var UniqueDelivery = e.data.UniqueDelivery
                var PriorityCustomer = e.data.PriorityCustomer
                var CustomerOnHold = e.data.CustomerOnHold
                var MarkupPercentage = e.data.MarkupPercentage
                var UserId = e.data.UserId
                var DeliveryAddress1 = e.data.DeliveryAddress1
                var DeliveryAddress2 = e.data.DeliveryAddress2
                var DeliveryAddress3 = e.data.DeliveryAddress3
                var DeliveryAddress4 = e.data.DeliveryAddress4
                var DeliveryAddress5 = e.data.DeliveryAddress5

                updateCustomer(CustomerId, Routeid, Email, ContactPerson, ContactTel, GroupId, SalesAnalysisCode, DeliverySequence, DocPrintOrEmail, Discount, CreditLimit, UniqueDelivery, PriorityCustomer, CustomerOnHold, MarkupPercentage, UserId, DeliveryAddress1, DeliveryAddress2, DeliveryAddress3, DeliveryAddress4, DeliveryAddress5)
            }
        });

        function updateCustomer(CustomerId, Routeid, Email, ContactPerson, ContactTel, GroupId, SalesAnalysisCode, DeliverySequence, DocPrintOrEmail, Discount, CreditLimit, UniqueDelivery, PriorityCustomer, CustomerOnHold, MarkupPercentage, UserId, DeliveryAddress1, DeliveryAddress2, DeliveryAddress3, DeliveryAddress4, DeliveryAddress5){
            $.ajax({
                url: '{!! url('/updateCustomerGrid') !!}',
                type: "POST",
                data: {
                    CustomerId: CustomerId,
                    Routeid: Routeid,
                    Email: Email,
                    ContactPerson: ContactPerson,
                    ContactTel: ContactTel,
                    GroupId: GroupId,
                    SalesAnalysisCode: SalesAnalysisCode,
                    DeliverySequence: DeliverySequence,
                    DocPrintOrEmail: converToBit(DocPrintOrEmail),
                    Discount: Discount,
                    CreditLimit: CreditLimit,
                    UniqueDelivery: converToBit(UniqueDelivery),
                    PriorityCustomer: converToBit(PriorityCustomer),
                    CustomerOnHold: converToBit(CustomerOnHold),
                    MarkupPercentage: MarkupPercentage,
                    UserId: UserId,
                    DeliveryAddress1: DeliveryAddress1,
                    DeliveryAddress2: DeliveryAddress2,
                    DeliveryAddress3: DeliveryAddress3,
                    DeliveryAddress4: DeliveryAddress4,
                    DeliveryAddress5: DeliveryAddress5,
                },
                success: function(data) {
                    location.reload();
                }
            });
        }

        function converToBit(value){
            if(value == "True"){
                return 1;
            }else if(value == "False"){
                return 0;
            }else{
                return 0;
            }
        }
    });
</script>