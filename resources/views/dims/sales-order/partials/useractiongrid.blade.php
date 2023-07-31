<div id="userActionGrid" title="User Actions">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <i class="fa fa-refresh float-end" aria-hidden="true" id="refreshUserActionDataGrid"></i>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered table-hover cell-border fs-6" id="tableUserActions">
                        <thead>
                            <th style="width: 300px;">Message</th>
                            <th>Logged By</th>
                            <th>Computer Name</th>
                            <th>Product Desc</th>
                            <th>Product Code</th>
                            <th>Date Time</th>
                            <th>Customer Name</th>
                            <th>Customer Code</th>
                            <th>Reference</th>
                            <th>New Qty</th>
                            <th>Old Qty</th>
                            <th>New Price</th>
                            <th>Old Price</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#userActionGrid').hide();
        $('#button_user_actions').on('click', function() {
            $('#userActionGrid').show();
            showDialog('#userActionGrid', '65%', 500);
            getDataFromTblManagement();
            $('#refreshUserActionDataGrid').click(function() {
                datatableUserActions.draw();
            });
        });
    });

    function getDataFromTblManagement() {
        datatableUserActions = $('#tableUserActions').DataTable({
            "ajax": {
                url: '{!! url('/getDataFromManagementConsole') !!}',
                "type": "GET",
                data: function(data) {
                    data.orderID = $('#orderId').val();
                }
            },
            "columns": [{
                    "data": "Message",
                    "class": "",
                    "bSortable": false
                },
                {
                    "data": "LoggedBy",
                    "class": "",
                    "bSortable": false
                },
                {
                    "data": "Computer",
                    "class": "",
                    "bSortable": false
                },
                {
                    "data": "PastelDescription",
                    "class": ""
                },
                {
                    "data": "PastelCode",
                    "class": ""
                },
                {
                    "data": "dtm",
                    "class": "",
                    "bSortable": true
                },
                {
                    "data": "StoreName",
                    "class": ""
                },
                {
                    "data": "CustomerPastelCode",
                    "class": ""
                },
                {
                    "data": "ReferenceNo",
                    "class": "",
                    "bSortable": true
                },
                {
                    "data": "NewQty",
                    "class": "",
                    render: function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            return jsn.data;
                        }
                        return parseFloat(jsn).toFixed(2);

                    },
                    "bSortable": true
                },
                {
                    "data": "OldQty",
                    "class": "",
                    render: function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            return jsn.data;
                        }
                        return parseFloat(jsn).toFixed(2);

                    },
                    "bSortable": true
                },
                {
                    "data": "NewPrice",
                    "class": "",
                    render: function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            return jsn.data;
                        }
                        return parseFloat(jsn).toFixed(2);

                    },
                    "bSortable": true
                },
                {
                    "data": "OldPrice",
                    "class": "",
                    render: function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            return jsn.data;
                        }
                        return parseFloat(jsn).toFixed(2);

                    },
                    "bSortable": true
                }

            ],
            "deferRender": true,
            "scrollY": "400px",
            "scrollCollapse": true,
            searching: true,
            bPaginate: false,
            bFilter: false,
            "LengthChange": false,
            "info": false,
            "bDestroy": true,
            // dom: 'Blfrtip',
            dom: `<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>
                <'row'<'col-sm-12'tr>>
                <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>
            `,
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn-primary btn-sm',
                },
                {
                    extend: 'csv',
                    className: 'btn-primary btn-sm',
                    title: 'Dims User Actions #' + $('#orderId').val()
                },
                {
                    extend: 'excel',
                    className: 'btn-primary btn-sm',
                    title: 'Dims User Actions #' + $('#orderId').val()
                },
                {
                    extend: 'pdf',
                    className: 'btn-primary btn-sm',
                    title: 'Dims User Actions #' + $('#orderId').val(),
                    exportOptions: {
                        columns: [0, 1, 5]
                    }
                }
            ],
            // dom:
            //     "<'row'" +
            //     "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            //     "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            //     ">" +

            //     "<'table-responsive'tr>" +

            //     "<'row'" +
            //     "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            //     "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            //     ">"
        });
        //datatableOrderPattern.columns([6,8,9]).visible(false);
        $("#tableUserActions_wrapper .dt-buttons").parents("div:first").addClass("d-flex align-items-center");
        $("#tableUserActions_wrapper .dt-buttons button").removeClass('btn-secondary').addClass("me-2");
        $("#tableUserActions_wrapper .dataTables_filter input").removeClass('form-control-sm form-control-solid');
    }
</script>
