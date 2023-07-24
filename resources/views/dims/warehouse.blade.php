<!DOCTYPE html>
<html>
<head>
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
</head>
<body>
<h1>On Order Data Grid</h1>

<div id="myGrid" style="height: 700px;width:90%;" class="ag-theme-balham"></div>

<script type="text/javascript" charset="utf-8">
    // specify the columns
    var columnDefs = [
        {headerName: "OrderId", field: "OrderId"},
        {headerName: "PCode", field: "PastelCode"},
        {headerName: "Description", field: "PastelDescription"},
        {headerName: "Qty", field: "Qty",filter: 'agNumberColumnFilter'},
        {headerName: "CustomerPastelCode", field: "CustomerPastelCode"},
        {headerName: "StoreName", field: "StoreName"},
        {headerName: "Comment", field: "Comment"},
        {headerName: "DeliveryDate", field: "DeliveryDate"},
        {headerName: "OrderDate", field: "OrderDate"},
        {headerName: "Route", field: "Route"},
        {headerName: "OrderType", field: "OrderType"},
        {headerName: "Available", field: "Available"},
        {headerName: "Instock", field: "Instock"}
    ];

    // let the grid know which columns and what data to use
    var gridOptions = {
        columnDefs: columnDefs,
        floatingFilter: true,
        enableSorting: true,
        enableFilter: true
    };


    // lookup the container we want the Grid to use
    var eGridDiv = document.querySelector('#myGrid');

    // create the grid passing in the div to use together with the columns & data we want to use
    new agGrid.Grid(eGridDiv, gridOptions);

    fetch('{!!url("/onOrderAdvanced")!!}').then(function(response) {
        return response.json();
    }).then(function(data) {
        gridOptions.api.setRowData(data);
    })

</script>
</body>
</html>