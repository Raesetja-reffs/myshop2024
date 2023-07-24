<!DOCTYPE html>
<html>
<head>
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
</head>
<body>
<h1>Customer Special Filter Grid</h1>

<div id="myGrid" style="height: 700px;width:90%;" class="ag-theme-balham"></div>

<script type="text/javascript" charset="utf-8">
    // specify the columns
    var columnDefs = [
        {headerName: "Rep Code", field: "strSalesmanCode"},
        {headerName: "CustomerPastelCode", field: "CustomerPastelCode"},
        {headerName: "StoreName", field: "StoreName"},
        {headerName: "DateTo", field: "DateTo",filter: 'agDateColumnFilter'},
        {headerName: "PastelCode", field: "PastelCode"},
        {headerName: "PastelDescription", field: "PastelDescription"},
        {headerName: "Price", field: "Price"},
        {headerName: "CostPrice", field: "CostPrice"},
        {headerName: "a", field: "a",filter: 'agNumberColumnFilter'}

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

    fetch('{!!url("/advancedcustomerspecialsJson")!!}').then(function(response) {
        return response.json();
    }).then(function(data) {
        gridOptions.api.setRowData(data);
    })

</script>
</body>
</html>