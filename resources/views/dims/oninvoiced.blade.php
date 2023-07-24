<div class="col-lg-12" id="prodonInvoice" title="Products on Invoices" style="background: #97249eba">
    <form>
        <fieldset class="well" style="    background: #e8e8e8;">

            <legend class="well-legend">Search</legend>
            <div class="col-md-12">
                <div class="form-group col-md-4">
                    <label class="control-label" for="productCodeOnOrder"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Product Code</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="productCodeOnInvoice" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label" for="productDescOnOrder"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Product Desc</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="productDescOnInvoiced" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                </div>
                <div class="form-group col-md-4">
                    <button type="button" id="callSpOnInvoiced" class="btn-xs btn-success">GO</button>
                </div>
            </div>

        </fieldset>
    </form>
    <table class="table  search-table" id="tblOnInvoiced" style=" color: black;overflow-y: scroll; width: 100%;font-family: sans-serif; font-weight: 700;font-size: 36px;" tabindex=0>
        <thead>

        <tr style="font-size: 17px;">
            <th class="col-sm-1">Order Id</th>
            <th class="col-sm-1">Order Date</th>
            <th class="col-sm-1">Delivery Date</th>
            <th >Cust Code</th>
            <th class="col-md-3">Store Name</th>
            <th>Qty</th>
            <th>Prod Code</th>
            <th class="col-md-4">Prod Description</th>
            <th>Comment</th>
            <th>Nett</th>
            <th>Back Order</th>

        </tr>
        </thead>
    </table>
</div>
