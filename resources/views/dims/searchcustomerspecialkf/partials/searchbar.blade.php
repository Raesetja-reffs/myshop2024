<div class="row mt-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Filters</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="customerMulti">Customers</label>
                            <select id="customerMulti" class="select" multiple>
                                @foreach($customers as $values)
                                    <option value="{{$values->CustomerId}}">
                                        {{$values->CustomerPastelCode}} - {{$values->StoreName}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="productMulti">Products</label>
                            <select id="productMulti" class="select" multiple>
                                @foreach($products as $values)
                                    <option value="{{$values->ProductId}}">
                                        {{$values->PastelCode}} - {{$values->PastelDescription}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <button type="button" id="getCustomerSpecials" class="btn btn-success btn-sm mt-md-6">
                                Get Customer Specials
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
