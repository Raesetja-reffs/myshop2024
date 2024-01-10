<div class="row mt-3" id="afterFilter">
    <div class="col-lg-12">
        <div class="card smaller-card">
            <div class="card-header p-5">
                <h3 class="card-title">Current Specials</h3>
                <div class="card-toolbar">
                    <div id="specialslink"></div>
                    <button id="extend" class="btn btn-primary btn-sm mb-1 mb-sm-0 me-1">Extend Specials</button>
                    <button id="bulkediting" class="btn btn-success btn-sm mb-1 mb-sm-0 me-1">Bulk Editing</button>
                    <button id="deleteSelected" class="btn btn-danger btn-sm mb-1 mb-sm-0">Delete (<span class="deleteselectedcount">0</span>) Selected</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive scroll h-400px">
                    <table id ="tblCreatedCustomerSpecials" class="table table-bordered table-condensed">
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
        $(document).on('change', 'input[name="checkproduct[]"]', function(e) {
            setCheckboxSelectedCount();
        });
        $(document).on('click', '#checkall', function(e) {
            $($("input[name='checkproduct[]']")).each(function() {
                $(this).prop('checked', $('#checkall').prop('checked'));
            });
            setCheckboxSelectedCount();
        });
        $(document).on('click', '#deleteSelected', function(e) {
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
                            OKAY: {
                                text: "OKAY",
                                class: "btn btn-success btn-sm",
                                click: function() {
                                    location.reload(true);
                                }
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
                            OKAY: {
                                text: "OKAY",
                                class: "btn btn-success btn-sm",
                                click: function() {
                                    $this.closest('tr').remove();
                                    dialog.dialog('close');
                                }
                            }
                        }
                    });
                }
            });
        });
        $(document).on('click', '#tblCreatedCustomerSpecials tbody tr', function(e) {
            if (clickeventExcludeOnSomeTd(e)) {
                return true;
            }
            $("#tblCreatedCustomerSpecials tbody tr").removeClass('row_selected');
            $(this).addClass('row_selected');
        });
        $(document).on('dblclick', '#tblCreatedCustomerSpecials tbody tr', function(e) {
            if (clickeventExcludeOnSomeTd(e)) {
                return true;
            }
            $(".general-loader").show();
            $("#tblCreatedCustomerSpecials tbody tr").removeClass('row_selected');
            $(this).addClass('row_selected');
            $('#popUpdateLine').show();
            setTimeout(() => {
                showDialog('#popUpdateLine', '60%', 620);
            }, 50);
            var rowOnOrder = $(this).closest("tr");
            $('#specialIdUpdate').val(rowOnOrder.find('td:eq(1)').text());
            $('#itemCode').val(rowOnOrder.find('td:eq(3)').text());
            $('#itemDescription').val(rowOnOrder.find('td:eq(4)').text());
            $('#specialFrom').val(rowOnOrder.find('td:eq(5)').text());
            $('#hiddenSpecaialFrom').val(rowOnOrder.find('td:eq(5)').text());
            $('#specialTo').val(rowOnOrder.find('td:eq(6)').text());
            $('#hiddenSpecaialTo').val(rowOnOrder.find('td:eq(6)').text());
            $('#specialPrice').val(rowOnOrder.find('td:eq(7)').text());
            $('#specialCost').val(rowOnOrder.find('td:eq(8)').text());
            $('#specialGp').val(rowOnOrder.find('td:eq(9)').text());
        });
    });
    function setCheckboxSelectedCount()
    {
        $('.deleteselectedcount').text($('input[name="checkproduct[]"]:checked').length);
    }
    function clickeventExcludeOnSomeTd(e)
    {
        if ($(e.target).closest('td.excluded-td').length) {
            return true;
        }

        return false;
    }
</script>
