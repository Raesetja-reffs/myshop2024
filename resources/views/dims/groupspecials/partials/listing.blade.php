<div class="row mt-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Current Specials</h3>
                <div class="card-toolbar">
                    <div id="specialslink"></div>
                    <button id="extend" class="btn btn-primary btn-sm mb-1 mb-sm-0 me-1">Extend Specials</button>
                    <button id="bulkediting" class="btn btn-success btn-sm mb-1 mb-sm-0 me-1">Bulk Editing</button>
                    <button id="deleteSelected" class="btn btn-danger btn-sm mb-1 mb-sm-0">Delete Selected</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive scroll h-400px">
                    <table id ="tblCreatedCustomerSpecials" class="table table-bordered table-condensed"
                        style="font-family: sans-serif;">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="checkall" class="custom-checkbox-sm" value="Check All">
                                </th>
                                <th>ID</th>
                                <th>Ref</th>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Date From</th>
                                <th>Date To</th>
                                <th>Price</th>
                                <th>Cost</th>
                                <th>Current GP</th>
                                <th style="display: none;">Cost Created</th>
                                <th>Available</th>
                                <th>Instock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#deleteSelected').hide();
        $('#checkall').on('click', function() {
            $($("input[name='checkproduct[]']")).each(function() {
                $(this).prop('checked', $('#checkall').prop('checked'));
            });
        });
        $('#deleteSelected').click(function() {
            var valuesProd = new Array();
            var groupName = $('#inputCustAcc').val();
            $.each($("input[name='checkproduct[]']:checked"),
                function() {
                    var data = $(this).parents('tr:eq(0)');
                    var codeID = data.find('td:eq(0)').text();
                    var datefrom = data.find('td:eq(4)').text();
                    var dateto = data.find('td:eq(5)').text();
                    valuesProd.push({
                        'groupName': groupName,
                        'lineid': codeID
                    });
                }
            );
            $.ajax({
                url: '{!! url('/deleteselectedgroupspeciallines') !!}',
                type: "POST",
                data: {
                    griddetails: valuesProd,
                    groupid: groupName
                },
                success: function(data) {
                    var dialog = $('<p>Done</p>').dialog({
                        height: 200,
                        width: 700,
                        modal: true,
                        containment: false,
                        buttons: {
                            "OKAY": function() {
                                location.reload(true);
                            }
                        }
                    });
                }
            });
        });
        $(document).on('click', '.remove_special_product_line', function(e) {
            var $this = $(this);
            var $thisVal = $(this).attr("value");
            $.ajax({
                url: '{!! url('/removeGroupSpecial') !!}',
                type: "POST",
                data: {
                    removeSpecial: $thisVal
                },
                success: function(data) {
                    var dialog = $('<p>Special Removed</p>').dialog({
                        height: 200,
                        width: 700,
                        modal: true,
                        containment: false,
                        buttons: {
                            "OKAY": function() {
                                $this.closest('tr').remove();
                                dialog.dialog('close');
                            }
                        }
                    });
                }
            });
        });
        $(document).on('click', '#tblCreatedCustomerSpecials tbody tr', function(e) {
            $("#tblCreatedCustomerSpecials tbody tr").removeClass('row_selected');
            $(this).addClass('row_selected');
        });
        $(document).on('dblclick', '#tblCreatedCustomerSpecials tbody tr', function(e) {
            $(".general-loader").show();
            $("#tblCreatedCustomerSpecials tbody tr").removeClass('row_selected');
            $(this).addClass('row_selected');
            $('#popUpdateLine').show();
            setTimeout(() => {
                showDialog('#popUpdateLine', '60%', 450);
            }, 50);
            var rowOnOrder = $(this).closest("tr");
            $('#specialIdUpdate').val(rowOnOrder.find('td:eq(0)').text());
            $('#itemCode').val(rowOnOrder.find('td:eq(2)').text());
            $('#itemDescription').val(rowOnOrder.find('td:eq(3)').text());
            $('#specialFrom').val(rowOnOrder.find('td:eq(4)').text());
            $('#hiddenSpecaialFrom').val(rowOnOrder.find('td:eq(4)').text());
            $('#specialTo').val(rowOnOrder.find('td:eq(5)').text());
            $('#hiddenSpecaialTo').val(rowOnOrder.find('td:eq(5)').text());
            $('#specialPrice').val(rowOnOrder.find('td:eq(6)').text());
            $('#specialCost').val(rowOnOrder.find('td:eq(7)').text());
            $('#specialGp').val(rowOnOrder.find('td:eq(8)').text());
            $('#updateTheSpecuial').click(function() {
                $.ajax({
                    url: '{!! url('/updategGroupSpecialLine') !!}',
                    type: "POST",
                    data: {
                        itemCode: $('#itemCode').val(),
                        specialIdUpdate: $('#specialIdUpdate').val(),
                        itemDescription: $('#itemDescription').val(),
                        specialFrom: $('#specialFrom').val(),
                        specialTo: $('#specialTo').val(),
                        specialPrice: $('#specialPrice').val(),
                        specialCost: $('#specialCost').val(),
                        specialGp: $('#specialGp').val()
                    },
                    success: function(data) {
                        $('#updatedspecials').show();
                        showDialog('#updatedspecials', 380, 100);
                        $('#btnspecialUpdated').click(function() {
                            $('#popUpdateLine').dialog('close');
                            $('#updatedspecials').dialog('close');
                            $('#submitFiltersOnCustSpecial').click();
                        });
                    }
                });
            });
        });
    });
</script>
