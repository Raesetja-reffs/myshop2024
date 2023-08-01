<div id="listOfDelivAdress" title="Delivery Address" style="background-color: #F1F1F2;">
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="generalRouteForNewDeliveryAddress">Route</label>
                    <select id="generalRouteForNewDeliveryAddress" class="form-control form-select generalRouteForNewDeliveryAddress">
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="address1" >Address 1</label>
                    <input class="form-control" id="address1" name="address1">
                </div>
                <div class="col-md-4">
                    <label for="address2">Address 2</label>
                    <input class="form-control" id="address2" name="address2">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="address3">Address 3</label>
                    <input class="form-control" id="address3" name="address3">
                </div>
                <div class="col-md-4">
                    <label for="address4">Address 4</label>
                    <input class="form-control" id="address4" name="address4">
                </div>
                <div class="col-md-4">
                    <label for="address5">Address 5</label>
                    <input class="form-control" id="address5" name="address5">
                    <input type="hidden" id="deliveryAddressIdOnPopUp" name="deliveryAddressIdOnPopUp" value="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="salesPerson">SalesPerson</label>
                    <select class="form-control form-select" id="salesPerson">
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="button" id="doneCustomAddress" class="btn btn-success btn-sm mt-md-6 doneCustomAddress">Done</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <input type='text' id='txtList' onkeyup="filter(this)" class="form-control"
                        placeholder="Please search address here..." />
                    <hr style="margin-top: 15px;margin-bottom: 15px;border: 0;border-top: 5px solid #00ff00;" />
                    <div>
                        <ul id="listaddresses" style="font-size: 9px;list-style-type: none;overflow-y: auto;height:300px">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row" id="dynamicaddress" style="background: #f8f8f8;">
                <div class="col-md-12">
                    <form>
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <td>
                                    <label class="control-label">Route</label>
                                    <select name="AddressAddSelect" id="AddressAddSelect" class="form-control form-select">
                                    </select>
                                </td>
                                <td>
                                    <label class="control-label">&nbsp;</label>
                                    <input name="Address1Add" id="Address1Add" class="form-control" placeholder="Please type address1 ">
                                </td>
                                <td>
                                    <label class="control-label">&nbsp;</label>
                                    <input name="Address2Add" id="Address2Add" class="form-control" placeholder="Please type address2 ">
                                </td>
                                <td>
                                    <label class="control-label">&nbsp;</label>
                                    <input name="Address3Add" id="Address3Add" class="form-control" placeholder="Please type address3 ">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input name="Address4Add" id="Address4Add" class="form-control" placeholder="Please type address4 ">
                                </td>
                                <td>
                                    <input name="Address5Add" id="Address5Add" class="form-control" placeholder="Please type address5 ">
                                </td>
                                <td>
                                    <select name="salesPersonOnDynamic" id="salesPersonOnDynamic" placeholder="Sales Person" class="form-control form-select">
                                    </select>
                                </td>
                                <td>
                                    <button type="button" id="AddressAddMakeNew" class="btn btn-warning btn-sm">
                                        Add
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="generateDynamicAddress" style="background: #f5e5e5;">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Route</th>
                                <th>Address1</th>
                                <th>Address2</th>
                                <th>Address3</th>
                                <th>Address4</th>
                                <th>Address5</th>
                                <th>Sales Person</th>
                                <th></th>
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

