<x-app-layout>

    <x-slot name="header">
        {{ __('Group Special') }}
    </x-slot>

    <x-slot name="breadcrum">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                Home </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <!--end::Item-->

        <!--begin::Item-->
        <li class="breadcrumb-item text-dark">
            Group Special </li>
        <!--end::Item-->
    </x-slot>

    @include('dims.groupspecials.partials.searchbar')

    @include('dims.groupspecials.partials.listing')

    <div class="col-lg-12" id="afterFilter">
        <div class="col-lg-12" style="background: green;height: 80%;display:none;">
            <h4>Please start adding new products below.</h4>
            <fieldset class="well" style="display:none;">
                <legend class="well-legend">Filters</legend>
                <form>
                    <div class="form-group col-md-3 itCanHide"
                        style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="dateFrom"
                            style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date From</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="dateFrom"
                            style="font-weight: 900;    color: black;font-size: 13px;">
                    </div>
                    <div class="form-group col-md-3 " style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="dateTo"
                            style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date To</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="dateTo"
                            style="font-weight: 900;    color: black;font-size: 13px;">

                    </div>

                    <button type="button" id="createnewSpecial" class="btn-xs btn-success">Create</button>
                </form>
            </fieldset>
            <div class="col-lg-12" style="background: white;height: 60%;overflow-y: scroll">

                <button class="btn-success btn-xs" id="addLine">Add</button>
                <table id ="tblCreateNewSpecial" class="table table-bordered table-condensed">
                    <thead>
                        <tr style="font-size: 12px;">
                            <td>Code</td>
                            <td>Description</td>
                            <td>DtFrom</td>
                            <td>DtTo</td>
                            <td>Price</td>
                            <td>Cost</td>
                            <td>Current GP</td>
                            <td>Cost Created</td>
                            <td>Available</td>
                            <td>Instock</td>
                            <td>Cost Used</td>
                            <td>Actions</td>

                        </tr>
                    </thead>
                    <tbody></tbody>

                </table>

            </div>
            <div class="col-lg-12" style="background: white;">
                <button id="doneCreating" class="btn-xs btn-success">Done</button>
            </div>
        </div>
    </div>

    @include('dims.groupspecials.partials.popUpdateLine')

    <div id="updatedspecials" title="Specials Updated">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <button id="btnspecialUpdated" class="btn btn-success btn-sm">
                            OKAY
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('dims.groupspecials.partials.extedingspecial')

    @include('dims.groupspecials.partials.allscript')
</x-app-layout>
