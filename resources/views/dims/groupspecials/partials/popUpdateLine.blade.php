<div id="popUpdateLine" title="Please Update">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="specialIdUpdate">Special Id</label>
                    <input id="specialIdUpdate" class="form-control" readonly>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="itemCode">Code</label>
                    <input id="itemCode" class="form-control" readonly>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="itemDescription">Description</label>
                    <input id="itemDescription" class="form-control" readonly>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="specialFrom">Date From</label>
                    <input id="specialFrom" class="form-control">
                    <input type="hidden" id="hiddenSpecaialFrom">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="specialTo">Date To</label>
                    <input id="specialTo" class="form-control">
                    <input type="hidden" id="hiddenSpecaialTo">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="specialPrice">Special Price</label>
                    <input id="specialPrice" class="form-control">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="specialCost">Special Cost</label>
                    <input id="specialCost" class="form-control" readonly>
                </div>
                <div class="col-md-12 mb-6">
                    <label for="specialGp">GP</label>
                    <input id="specialGp" class="form-control" readonly>
                </div>
                <div class="col-md-12">
                    <button id="updateTheSpecuial" class="btn btn-success btn-sm">Update the Specials</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(document).on('click', '#updateTheSpecuial', function(e) {
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
                    showDialog('#updatedspecials', 380, 120);
                    $('#btnspecialUpdated').click(function() {
                        $('#popUpdateLine').dialog('close');
                        $('#updatedspecials').dialog('close');
                        $('#submitFiltersOnCustSpecial').click();
                    });
                }
            });
        });
    });
</script>
