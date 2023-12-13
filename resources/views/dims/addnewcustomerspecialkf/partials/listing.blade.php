<div class="row mt-3" id="afterFilter">
    <div class="col-lg-12">
        <div class="card smaller-card">
            <div class="card-header p-5">
                <h3 class="card-title">Customer Specials</h3>
                <div class="card-toolbar">
                    <button id="getContractDetails" class="btn btn-primary btn-sm mb-1 mb-sm-0 me-1">
                        Get Contract Details
                    </button>
                    <button id="copyContractIntoLines" class="btn btn-info btn-sm mb-1 mb-sm-0 me-1">
                        Copy Contract
                    </button>
                    <div id="hidebeforesubmit">
                        <button class="btn btn-primary btn-sm mb-1 mb-sm-0" id="addnewline">
                            Add Line
                        </button>
                        <button id="importexcel" class="btn btn-primary btn-sm mb-1 mb-sm-0">
                            Import Excel
                        </button>
                        <button id="exportexcel" class="btn btn-primary btn-sm mb-1 mb-sm-0">
                            Export Excel
                        </button>
                        <button id="deletelines" class="btn btn-danger btn-sm mb-1 mb-sm-0">
                            Delete All - Lines
                        </button>
                        <button id="deleteall" class="btn btn-danger btn-sm mb-1 mb-sm-0">
                            Delete Contract
                        </button>
                        <button id="doneCreating" class="btn btn-primary btn-sm mb-1 mb-sm-0">
                            Update Data
                        </button>
                        <button id="savenewspecials" class="btn btn-primary btn-sm mb-1 mb-sm-0">
                            Save Data
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive scroll h-400px">
                    <table id ="tblCreateNewSpecial" class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Date From</th>
                                <th>Date To</th>
                                <th>Price</th>
                                <th>Cost</th>
                                <th>GP</th>
                                <th>Cost Created</th>
                                <th>C.S Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end">
                        <button id="SaveNewSpecial" class="btn btn-success btn-sm me-3">Top Up Special</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
