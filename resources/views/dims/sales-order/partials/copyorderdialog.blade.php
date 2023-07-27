<div id="copyOrderDialog" title="Copying Order">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <form>
                    <div class="col-md-12 mb-3">
                        <label for="copyDeliveryDate">Delivery Date</label>
                        <input type="text" class="form-control" id="copyDeliveryDate">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="inputOrderId">Delivery Type</label>
                        <select class="form-control form-select" id="CopyorderType"></select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <input type="hidden" class="form-control" id="copyCustCode" style="font-size: 10px;">
                        <input type="hidden" class="form-control" id="copyRouteID" style="height:15px;font-size: 10px;">
                        <button type="button" id="submitCopyOrder" class="btn btn-success btn-sm">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
