
<!DOCTYPE html>

<html>
<head>
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ... -->
    <!-- DevExtreme themes -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

    <!-- DevExtreme theme -->
    {{-- <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/22.2.3/css/dx.light.css"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.carmine.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.contrast.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.darkmoon.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.darkviolet.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.greenmist.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.blue.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.blue.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.dark.css" rel="stylesheet"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.softblue.css" rel="stylesheet"> --}}

    <style>
        .dx-scrollbar-vertical .dx-scrollbar-hoverable {
            width: 20px !important;
            height: 100px !important;
        }

        .dx-scrollbar-vertical .dx-scrollable-scroll {
            width: 20px !important;
            height: 100px !important;
        }

        .dx-scrollbar-horizontal .dx-scrollbar-hoverable {
            height: 20px !important;
        }

        .dx-scrollbar-horizontal .dx-scrollable-scroll {
            height: 20px !important;
        }
    </style>

</head>
<!-- Body -->
<body style="font-family: Sans-serif">
<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<div class="row">
    <div class="col-md-9">
        <div id="gridContainer" ></div>

    </div>
    <div class="col-md-3">
        <div id="formContainer">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="customerid">Customer ID</label>
                            <input type="text" id="customerid" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="CustomerStorename">Customer Name</label>
                            <input type="text" id="CustomerStorename" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="pastelcode">Customer Code</label>
                            <input type="text" id="pastelcode" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="route">Customer Route</label>
                            <select id="route" name="route" class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="Email">Email Address</label>
                            <input type="text" id="Email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="ContactPerson">Contact Person</label>
                            <input type="text" id="ContactPerson" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="DocPrintOrEmail">Receives Email</label>
                            <select id="DocPrintOrEmail" class="form-control">
                                <option value="False">No</option>
                                <option value="True">Yes</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="MarkupPercentage" >Markup Percentage</label>
                            <input type = "text" id = "MarkupPercentage" class="form-control" >
                        </div>
                        <div class="form-group">
                        <hr>
                            <button class="btn btn-success w-100 my-2" id="update">Update</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="PriceListName">Price List Name</label>
                            <input type="text" id="PriceListName" name="PriceListName" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="ContactNumber">Contact Number</label>
                            <input type="text" id="ContactNumber" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="GroupName">Group Name</label>
                            <select id="GroupName" name="GroupName" class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="SalesRep">Sales Representative</label>
                            <select id="SalesRep" name="SalesRep" class="form-control">
                                <option value="">None</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="Users">DIMS User</label>
                            <select id="Users" name="Users" class="form-control">
                                <option value="">None</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="DeliverySeq">Delivery Sequence</label>
                            <input type="text" id="DeliverySeq" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="DeliveryAddress1">Delivery Address Line 1</label>
                            <input type="text" id="DeliveryAddress1" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="DeliveryAddress2">Delivery Address Line 2</label>
                            <input type="text" id="DeliveryAddress2" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="DeliveryAddress3">Delivery Address Line 3</label>
                            <input type="text" id="DeliveryAddress3" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="DeliveryAddress4">Delivery Address Line 4</label>
                            <input type="text" id="DeliveryAddress4" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="DeliveryAddress5">Delivery Address Line 5</label>
                            <input type="text" id="DeliveryAddress5" class="form-control">
                        </div>

                    </div>
                </div>
    </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- DevExtreme library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery.dialogextend.js') }}"></script>

<script>

    var jArray = JSON.stringify({!! json_encode($routes) !!});

    var Routes = $.map(JSON.parse(jArray), function (item) {
        return {
            Route: item.Route, //
            RouteId:item.Routeid,
            CustomerId:item.CustomerId,//
            StoreName:item.StoreName,//
            CustomerPastelCode:item.CustomerPastelCode,//
            Email:item.Email,
            ContactPerson:item.ContactPerson,
            ContactTel:item.ContactTel,
            PriceListName:item.PriceListName,
            PriceListId:item.PriceListId,
            GroupName:item.groupname,
            GroupId:item.GroupId,
            UserName:item.UserName,
            SalesAnalysisCode:item.SalesAnalysisCode,
            DeliverySequence:item.DeliverySequence,
            DocPrintOrEmail:item.DocPrintOrEmail,
            Discount:item.Discount,
            CreditLimit:item.CreditLimit,
            UniqueDelivery:item.UniqueDelivery,
            PriorityCustomer:item.PriorityCustomer,
            CustomerOnHold:item.CustomerOnHold,
            MarkupPercentage:item.MarkupPercentage,
            LocationName:item.locationName,
			UserID:item.UserID,
			DeliveryAddress1:item.DeliveryAddress1,
			DeliveryAddress2:item.DeliveryAddress2,
			DeliveryAddress3:item.DeliveryAddress3,
			DeliveryAddress4:item.DeliveryAddress4,
			DeliveryAddress5:item.DeliveryAddress5
        }

    });

    console.log(Routes);

    var jArrayRoutesOnly = JSON.stringify({!! json_encode($routesonly) !!});
    var RoutesOnly = $.map(JSON.parse(jArrayRoutesOnly), function (item) {
        return {
            Route: item.Route,
            RouteId:item.RouteId
        }

    });
    console.log(RoutesOnly);
    var jArrayGroupsOnly = JSON.stringify({!! json_encode($groups) !!});
    var GroupsOnly = $.map(JSON.parse(jArrayGroupsOnly), function (item) {
        return {
            Group: item.GroupName,
            GroupId:item.GroupId
        }

    });
    console.log(GroupsOnly);
	var jArrayUsersOnly = JSON.stringify({!! json_encode($users) !!});
    var UsersOnly = $.map(JSON.parse(jArrayUsersOnly), function (item) {
        return {
            UserID: item.UserID,
            UserName:item.UserName
        }

    });
    console.log(UsersOnly);
    var jArraySalesMenOnly = JSON.stringify({!! json_encode($salesmen) !!});
    var SalesMen = $.map(JSON.parse(jArraySalesMenOnly), function (item) {
        return {
            Name: item.UserName,
            SalesCode:item.strSalesmanCode
        }

    });
    console.log(SalesMen);
        $( document ).on( 'focus', ':input', function(){

            $( this ).attr( 'autocomplete', 'off' );
        });
        var clickTimer, lastRowClickedId;
        $(document).ready(function() {
            for(var index = 0; index < RoutesOnly.length;index++){
                $('#route').append('<option value="'+RoutesOnly[index].RouteId+'">'+RoutesOnly[index].Route +'</option>');

            }
            for(var index = 0; index < GroupsOnly.length;index++){
                $('#GroupName').append('<option value="'+GroupsOnly[index].GroupId+'">'+GroupsOnly[index].Group +'</option>');

            }
			for(var index = 0; index < UsersOnly.length;index++){
                $('#Users').append('<option value="'+UsersOnly[index].UserID+'">'+UsersOnly[index].UserName +'</option>');

            }
            for(var index = 0; index < SalesMen.length;index++){
                $('#SalesRep').append('<option value="'+SalesMen[index].SalesCode+'">'+SalesMen[index].Name +'</option>');

            }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
            $('#update').click(function(){

                $.ajax({
                    url: '{!!url("/updateCustomerGrid")!!}',
                    type: "Post",
                    data:{
                        customerid: $('#customerid').val(),
                        route:$('#route').val(),
                        email:$('#Email').val(),
                        contactperson:$('#ContactPerson').val(),
                        pricelist:$('#PriceListName').val(),
                        contactno:$('#ContactNumber').val(),
                        groupname:$('#GroupName').val(),
                        salesrep:$('#SalesRep').val(),
                        deliveryseq:$('#DeliverySeq').val(),
                        receivesemail:$('#DocPrintOrEmail').val(),
                        discount:$('#Discount').val(),
                        creditlim:$('#CreditLimit').val(),
                        uniquedel:$('#UniqueDelivery').val(),
                        priocust:$('#PriorityCustomer').val(),
                        onhold:$('#CustomerOnHold').val(),
                        markupperc:$('#MarkupPercentage').val(),
                        selecteduser:$('#Users').val(),
                        deladd1:$('#DeliveryAddress1').val(),
                        deladd2:$('#DeliveryAddress2').val(),
                        deladd3:$('#DeliveryAddress3').val(),
                        deladd4:$('#DeliveryAddress4').val(),
                        deladd5:$('#DeliveryAddress5').val()
                    },
                    success: function(data){
                        var result = confirm("Do you want to proceed?");

                        if (result) {
                            // The user clicked the "OK" button
                           location.reload();
                        } else {
                            // The user clicked the "Cancel" button or closed the dialog
                            alert("You clicked Cancel to make some changes.");
                        }
                    }
                });

        });

                            $("#gridContainer").dxDataGrid({
                                dataSource:Routes,
                                showBorders: true,
                                filterRow: { visible: true },
                                scrolling: {
                                    columnRenderingMode: "virtual"
                                },
                                columnWidth:200,
                                columnAutoWidth:true, 
                                paging:{
                                    pageSize: 15,
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
                                            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'customers.xlsx');
                                        });
                                    });
                                    e.cancel = true;
                                },
                                columns: [
                                    {
                                        dataField: "CustomerId",
                                        caption: "Customer ID"

                                    },
                                    {
                                        dataField: "StoreName",
                                        caption: "Customer Name"

                                    },
                                    {
                                        dataField: "CustomerPastelCode",
                                        caption: "Customer Code"

                                    },
                                    {
                                        dataField: "Route",
                                        caption: "Route"

                                    },
                                    {
                                        width:1,
                                        dataField:"RouteId",
                                        caption:"RouteId",
                                        visible:"false"
                                    },
                                    {
                                        dataField: "Email",
                                        caption: "Email Address"

                                    },{
                                        dataField: "ContactPerson",
                                        caption: "Contact Person"

                                    },{
                                        dataField: "ContactTel",
                                        caption: "Contact Number"

                                    },{
                                        dataField: "PriceListName",
                                        caption: "PriceList Name"

                                    },{
                                        dataField: "DeliveryAddress1",
                                        caption: "Delivery Address Line 1"

                                    },{
                                        dataField: "DeliveryAddress2",
                                        caption: "Delivery Address Line 2"

                                    },{
                                        dataField: "DeliveryAddress3",
                                        caption: "Delivery Address Line 3"

                                    },{
                                        dataField: "DeliveryAddress4",
                                        caption: "Delivery Address Line 4"

                                    },{
                                        dataField: "DeliveryAddress5",
                                        caption: "Delivery Address Line 5"

                                    }

                                ] ,

                        onRowClick: function (e) {
                                    console.debug("on click");
                                    console.debug(e.key);
                                    console.debug("user name");
                                    console.debug(e.key.UserName);

                            $('#customerid').val(e.key.CustomerId);
                            $('#CustomerStorename').val(e.key.StoreName);
                            $('#pastelcode').val(e.key.CustomerPastelCode);
                            $('#route').val(e.key.RouteId);
                            $('#Email').val(e.key.Email)
                            $('#ContactPerson').val(e.key.ContactPerson);
                            $('#PriceListName').val(e.key.PriceListName);
                            $('#ContactNumber').val(e.key.ContactTel);
                            $('#GroupName').val(e.key.GroupId);
                            $('#SalesRep').val(e.key.SalesAnalysisCode);
                            $('#DeliverySeq').val(e.key.DeliverySequence);
                            $('#DocPrintOrEmail').val(e.key.DocPrintOrEmail);
                            $('#Discount').val(e.key.Discount);
						//	$('#Users').val(e.key.UserID);
                            $('#Users').prepend($('<option>', {
                                value:e.key.UserID,
                                text: e.key.UserName,
                                selected: 'selected'
                            }));
                            $('#CreditLimit').val(e.key.CreditLimit);
                            $('#UniqueDelivery').val(e.key.UniqueDelivery);
                            $('#PriorityCustomer').val(e.key.PriorityCustomer);
                            $('#CustomerOnHold').val(e.key.CustomerOnHold);
                            $('#MarkupPercentage').val(e.key.MarkupPercentage);

                            $('#DeliveryAddress1').val(e.key.DeliveryAddress1);
                            $('#DeliveryAddress2').val(e.key.DeliveryAddress2);
                            $('#DeliveryAddress3').val(e.key.DeliveryAddress3);
                            $('#DeliveryAddress4').val(e.key.DeliveryAddress4);
                            $('#DeliveryAddress5').val(e.key.DeliveryAddress5);

                        },
                        onRowDblClick: function(e){
                            
                        window.open('{!!url("/massCustomerUpdate")!!}/'+e.key.CustomerId, 'mywin',
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
                                }
                        });

            });
    </script>
</div>
</body>
</html>
