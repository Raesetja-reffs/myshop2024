<div id="extedingspecial" title="Extending Group Specials">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="specialFrom">Date From</label>
                    <input id="specialdateext" class="form-control">
                </div>
                <div class="col-md-12 mb-6">
                    <label for="specialTo">Date To</label>
                    <input id="specialdateextTo" class="form-control">
                </div>
                <div class="col-md-12">
                    <button id="doneext" class="btn btn-success btn-sm">Done Extending</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#extedingspecial').hide();
        $('#extend').click(function() {
            $('#extedingspecial').show();
            showDialog('#extedingspecial', '50%', 250);
        });
        $('#doneext').click(function() {
            var groupName = $('#inputCustAcc').val();
            var valuesProd = new Array();
            $.each($("input[name='checkproduct[]']:checked"), function() {
                var data = $(this).parents('tr:eq(0)');
                var codeID = data.find('td:eq(0)').text();
                var datefrom = $('#specialdateext').val();
                var dateto = $('#specialdateextTo').val();
                console.debug("Date from **************************************" + datefrom);
                valuesProd.push({
                    'groupName': groupName,
                    'lineid': codeID,
                    'datefrom': dateReturn(datefrom),
                    'dateto': dateReturn(dateto)
                });
            });
            $.ajax({
                url: '{!! url('/doneextendinggroupspecials') !!}',
                type: "POST",
                data: {
                    groupId: groupName,
                    griddetails: valuesProd
                },
                success: function(data) {
                    location.reload(true);
                }
            });
        });
    });
</script>
