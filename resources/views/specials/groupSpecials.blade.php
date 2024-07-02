@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Group Specials')


@section('page')

<!-- Flexdatalist -->
<link href="{{ asset('css/jquery.flexdatalist.css') }}" rel="stylesheet"  type='text/css'>  

<style>

    #gridGroupSpecials{
        height: calc(100vh);
        max-height: calc(100vh);
    }

    .customPadding {
        padding: 0px !important;
    }

    .tr {
        height: 10px !important;
    }
</style>

<div id="gridGroupSpecials" class="p-2"></div>

<!-- modalAddGroupSpecial -->
<div class="modal fade" id="modalAddGroupSpecial" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAddGroupSpecialLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalAddGroupSpecialLabel">CREATE GROUP SPECIALS</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closemodalAddGroupSpecial"></button>
            </div>
            <div class="modal-body">
                <div class="border bg-light p-3 h-100">
                    <div class="row">
                        <div class="col-6 mb-1">
                            <label class="fw-bold" for="inputGroupId">GROUP</label>
                            <select class="form-select" id="selectGroup">
                                <option value=" "></option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->GroupId }}">{{ $group->GroupName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 mb-1">
                            <label class="fw-bold" for="inputDealName">DEAL NAME</label>
                            <input class="form-control inputs" id="inputDealName"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-1">
                            <label class="fw-bold" for="inputDateFrom">DATE FROM</label>
                            <input type="date" class="form-control" id="inputDateFrom"/>
                        </div>

                        <div class="col-6 mb-1">
                            <label class="fw-bold" for="inputDateTo">DATE TO</label>
                            <input type="date" class="form-control" id="inputDateTo"/>
                        </div>
                    </div>

                    <div class="form-group mb-1">
                        <div class="col-lg-12">
                            <table id ="tblCreateNewSpecial" class="table">
                                <thead>
                                    <tr style="font-size: 12px;">
                                        <td>Code</td>
                                        <td>Description</td>
                                        <td>DtFrom</td>
                                        <td>DtTo</td>
                                        <td>Price</td>
                                        <td>Cost</td>
                                        <td>Current GP</td>
                                        {{-- <td>Cost Created</td> --}}
                                        <td>Actions</td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <button class="btn btn-success btn-xs" id="addLine">Add Line</button>
                            <button id="addGroupSpecial" class="btn btn-xs btn-success">Done</button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <div class="" id="btnaddGroupSpecial"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<!-- Flexdatalist -->  
<script src="{{ asset('js/jquery.flexdatalist.js') }}"></script>

    <script>

        window.jsPDF = window.jspdf.jsPDF

        $(document).ready(function() {
            var today = new Date();
            var formattedDate = today.toISOString().split('T')[0];
            $('#inputDateFrom').val(formattedDate);

            var oneMonthLater = new Date(today.getFullYear(), today.getMonth() + 1, today.getDate());
            var formattedOneMonthLater = oneMonthLater.toISOString().split('T')[0];
            $('#inputDateTo').val(formattedOneMonthLater);

            let massData = [];
            let formattedFrom = '';
            let formattedTo = '';
            let groupId = '';
            let dealName = '';

            var products = {!! json_encode($products) !!};
            var groups = {!! json_encode($groups) !!};

            const GroupsStore = {
                store: new DevExpress.data.CustomStore({
                    key: "GroupId",
                    loadMode: "raw",
                    load: function () {
                        return {!!json_encode($groups) !!};
                    }
                }),
                paginate: true,
            };

            var productsList = $.map(products, function (item) {
                return {
                    PastelCode: item.PastelCode,
                    PastelDescription: item.PastelDescription,
                    CostPrice: item.Cost
                };
            });

            $('#selectGroup').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#modalAddGroupSpecial'),
            });

            const gridGroupSpecials = $("#gridGroupSpecials").dxDataGrid({
                dataSource: massData,
                showBorders: true,
                showRowLines: true,
                showColumnLines: true,
                rowAlternationEnabled: true,
                filterRow: { visible: true },
                filterPanel: { visible: true },
                headerFilter: { visible: true },
                editing: {
                    mode: 'row',
                    allowUpdating: true,
                    allowDeleting: true,
                },
                export: {
                    enabled: true,
                    formats: ['pdf', 'excel'],
                },
                onExporting(e) {
                    if (e.format == 'excel'){
                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet('Group Specials');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Group Specials '+formattedFrom+' - '+formattedTo+'.xlsx');
                            });
                        });
                        e.cancel = true;

                    }else if (e.format == 'pdf'){
                        const doc = new jsPDF({
                            orientation: "landscape",
                            unit: "mm",
                        });

						DevExpress.pdfExporter.exportDataGrid({
							jsPDFDocument: doc,
							component: e.component,
							keepColumnWidths: false
						}).then(() => {
							addFooter(doc); // Add footer to every page
							doc.save('Group Specials ' + formattedFrom + ' - ' + formattedTo + '.pdf');
						});
                    }
                },
                paging: {
                    enabled: false
                },
                selection: {
                    mode: "single",
                },
                columnFixing: {
                    enabled: true,
                },
                columnAutoWidth:true,
                allowColumnResizing: true,
                columnResizingMode: "nextColumn",
                columnChooser: {
                    enabled: true,
                    mode: 'select',
                    position: {
                        my: 'right top',
                        at: 'right bottom',
                        of: '.dx-datagrid-column-chooser-button',
                    },
                    search: {
                        enabled: true,
                        editorOptions: { placeholder: 'Search column' },
                    },
                    selection: {
                        recursive: true,
                        selectByClick: true,
                        allowSelectAll: true,
                    },
                },
                columns: [
                    {
                        dataField: "GroupId",
                        caption: "Group",
                        allowEditing: false,
                        groupIndex: 0,
                        lookup: {
                            dataSource: groups,
                            valueExpr: "GroupId",
                            displayExpr: "GroupName",
                        },
                        groupCellTemplate: function(container, options) {
                            // Create a container for the displayed group name
                            var groupNameDiv = $('<div>').text(options.text).css({
                                'display': 'inline-block',  // Display inline-block
                                'vertical-align': 'middle'  // Align vertically middle
                            }).appendTo(container);
                            
                            // Create the button with the specified properties
                            $("<div>").dxButton({
                                width: 35,
                                icon: "fa fa-clone",
                                text: "",
                                onClick: function(e) {
                                    copyGroupSpecial(options.data.items);
                                }
                            }).appendTo(container);  // Append the button to the container
                        }
                    },
                    {
                        dataField: "strDealName",
                        caption: "DealName",
                        allowEditing: false,
                        // groupIndex: 0,
                    },
                    {
                        dataField: "SpecialGroupid",
                        caption: "ID",
                        allowEditing: false,
                    },
                    {
                        dataField: "SpecialHeaderId",
                        caption: "Ref",
                        allowEditing: false,
                        visible: false,
                    },
                    {
                        dataField: "PastelCode",
                        caption: "Item Code",
                        allowEditing: false,
                    },
                    {
                        dataField: "PastelDescription",
                        caption: "Item Name",
                        allowEditing: false,
                    },
                    {
                        dataField: "CostPrice",
                        caption: "Cost",
                        dataType: "number",
                        format: {
                            type: "fixedPoint",
                            precision: 2
                        },
                        allowEditing: false,
                    },
                    {
                        dataField: "Price",
                        caption: "Price",
                        dataType: "number",
                        format: {
                            type: "fixedPoint",
                            precision: 2
                        },
                    },
                    {
                        dataField: "Date",
                        caption: "Date From",
                        dataType: "date",
                        format: 'yyyy-MM-dd',
                    },
                    {
                        dataField: "DateTo",
                        caption: "Date To",
                        dataType: "date",
                        format: 'yyyy-MM-dd',
                    },
                    {
                        dataField: "GP",
                        caption: "Margin",
                        dataType: "number",
                        format: {
                            type: "fixedPoint",
                            precision: 2
                        },
                        allowEditing: false,
                    },
                ],
                onRowUpdated: function(e) {

                    var gp = 100 - (e.data.CostPrice / e.data.Price) * 100;

                    var check = 0;
                    if (gp < 5){
                        check = 1;
                    }

                    var userRole = "Not Admin";

                    if (check != 1){
                        $.ajax({
                            url: '{!!url("/updateGroupSpecial")!!}',
                            type: "POST",
                            data: {
                                specialLineId: e.data.SpecialGroupid,
                                price: e.data.Price,
                                dateFrom: e.data.Date,
                                dateTo: e.data.DateTo,
                            },
                            success: function (data) {
                                getOverallGroupSpecials();
                            }
                        });
                    }else{
                        authorize(userRole).then(function(approved) {
                            if (approved == 1) {
                                $.ajax({
                                    url: '{!!url("/updateGroupSpecial")!!}',
                                    type: "POST",
                                    data: {
                                        specialLineId: e.data.SpecialGroupid,
                                        price: e.data.Price,
                                        dateFrom: e.data.Date,
                                        dateTo: e.data.DateTo,
                                    },
                                    success: function (data) {
                                        getOverallGroupSpecials();
                                    }
                                });
                            }
                        }).catch(function(error) {
                            console.error("Error:", error);
                        });
                    }

                    
                },
                onRowRemoved: function(e) {
                    
                    $.ajax({
                        url: '{!!url("/removeGroupSpecial")!!}',
                        type: "POST",
                        data: {
                            removeSpecial: e.data.SpecialGroupid,
                        },
                        success: function (data) {
                            getOverallGroupSpecials();
                        }
                    });
                },
                onToolbarPreparing: function (e) {
                    // Create a custom header on the left side
                    e.toolbarOptions.items.unshift(
                        {
                            location: 'before',
                            template: function () {
                                return $('<h3>').text('GROUP SPECIALS');
                            }
                        }
                    );

                    e.toolbarOptions.items.push(
                        {
                            location: 'after',
                            widget: "dxDateRangeBox",
                            options: {
                                width: 300,
                                id: "dateRange",
                                displayFormat: 'yyyy-MM-dd',
                                showClearButton: true,
                                value: [formattedFrom, formattedTo],
                                onValueChanged: function (e) {
                                    var dateFrom = e.value[0];
                                    var dateTo = e.value[1];

                                    if(dateFrom){
                                        dateFrom = new Date(dateFrom);
                                        dateFrom.setTime(dateFrom.getTime() + (2 * 60 * 60 * 1000));
                                        formattedFrom = dateFrom.toISOString().slice(0, 10);
                                    }else{
                                        formattedFrom = '';
                                    }

                                    if(dateTo){
                                        dateTo = new Date(dateTo);
                                        dateTo.setTime(dateTo.getTime() + (2 * 60 * 60 * 1000));
                                        formattedTo = dateTo.toISOString().slice(0, 10);
                                    }else{
                                        formattedTo = '';
                                    }
                                }
                            }
                        }
                    );

                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxSelectBox",
                        options: {
                            dataSource: GroupsStore,
                            valueExpr: 'GroupId',
                            searchEnabled: true,
                            showClearButton: true,
                            width: 200,
                            displayExpr: function (item) {
                                return item && item.GroupId + ' - ' + item.GroupName;
                            },
                            onValueChanged: function (e) {
                                groupId =  e.value;
                            }
                        }
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxTextBox",
                        options: {
                            showClearButton: true,
                            width: 200,
                            label:  "Deal Name",
                            value: dealName,
                            onValueChanged: function (e) {
                                dealName =  e.value;
                            }
                        }
                    });

                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa-solid fa-search",
                            text: "SEARCH",
                            onClick: function (args) {
                                getOverallGroupSpecials();
                            },
                        },
                    });

                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa-solid fa-plus",
                            text: "ADD",
                            onClick: function (args) {
                                $('#modalAddGroupSpecial').modal('show');
                            },
                        },
                    });

                    
                }
            }).dxDataGrid('instance');

            // Function to add footer to every page
			function addFooter(doc) {
				const totalPages = doc.internal.getNumberOfPages();
				for (let i = 1; i <= totalPages; i++) {
					doc.setPage(i);
					doc.setFontSize(10);
					doc.text('Page ' + i + ' of ' + totalPages, doc.internal.pageSize.width - 50, doc.internal.pageSize.height - 10);
					const now = new Date();
					const printedDate = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate();
					doc.text('Date Printed: ' + printedDate, 10, doc.internal.pageSize.height - 10);
				}
			}

            $('#addLine').click(function(){
                addNewLine();
            });

            $('#tblCreateNewSpecial').on('click', 'button', function (e) {
                var $this = $(this);
                $this.closest('tr').remove();
            });

            function addNewLine(){
                var contractFrom = $('#inputDateFrom').val();
                var contractTo = $('#inputDateTo').val();

                var tokenId=Math.floor(Math.pow(10, 9-1) + Math.random() * 9 * Math.pow(10, 9-1));
                var $row = $(
                    '<tr id="row_'+tokenId+'" >' 
                        +'<td contenteditable="false" hidden>'
                            +'<input value="'+tokenId+'" class="token">'
                        +'</td>' 

                        +'<td contenteditable="false" class="col-2 p-1">'
                            +'<input name="theProductCode" id="productCode_'+tokenId+'" class="productCode col-12 form-control inputs">'
                        +'</td>' 

                        +'<td contenteditable="false" class="col-3 p-1">'
                            +'<input name="prodDescription_" id="productDescription_'+tokenId+'" class="productDescription col-12 form-control inputs">'
                        +'</td>' 

                        +'<td  contenteditable="false" class="col-2 p-1">'
                            +'<input type="date" name="dateFrom" id="dateFrom_'+tokenId+'" value="'+contractFrom+'" class="dateFrom col-12 form-control inputs" readonly>'
                        +'</td>' 

                        +'<td contenteditable="false" class="col-2 p-1">'
                            +'<input type="date" name="dateTo" id="dateTo_'+tokenId+'" value="'+contractTo+'" class="dateTo col-12 form-control inputs" readonly>'
                        +'</td>' 

                        +'<td contenteditable="false" class="col-1 p-1">'
                            +'<input type="text" name="prodPrice_" id="prodPrice_'+tokenId+'" class="productPrice col-12 form-control inputs" >'
                        +'</td>' 

                        +'<td contenteditable="false" class="col-1 p-1">'
                            +'<input type="text" name="cost_" id="costPrice_'+tokenId+'" class="costPrice col-12 form-control inputs" readonly>'
                        +'</td>' 

                        +'<td contenteditable="false" class="col-1 p-1">'
                            +'<input type="text" name="gp_" id="gp_'+tokenId+'" class="gp col-12 form-control inputs" readonly>'
                        +'</td>' 

                        // +'<td contenteditable="false" class="col-1 p-1">'
                        //     +'<input type="text" name="costCreated_" id="costCreated_'+tokenId+'" class="costCreated col-12 form-control inputs" >'
                        // +'</td>'

                        +'<td contenteditable="false"  class="p-1">'
                            +'<button type="button" name="'+tokenId+'" id="btnCancelLine" class="btn btn-danger"> X </button>'
                        +'</td>'
                    +'</tr>'
                );

                $('#tblCreateNewSpecial tbody')
                    .append( $row )
                    .trigger('addRows', [ $row, false ]);
                if(!$('.lst').is(":focus"))
                {
                    $('#productCode_' + tokenId).focus();

                    if ($('#checkboxDescription').is(':checked')) {
                        $('#productDescription_' + tokenId).focus();
                    }
                }


                var productCode = $('#productCode_'+tokenId).flexdatalist({
                    minLength: 1,
                    valueProperty: '*',
                    selectionRequired: true,
                    focusFirstResult: true,
                    searchContain:true,
                    visibleProperties: ["PastelCode", "PastelDescription", "CostPrice"],
                    searchIn: ["PastelCode","PastelDescription"],
                    data: productsList
                });

                productCode.on('select:flexdatalist', function (event, data) {
                    $('#productCode_'+tokenId).flexdatalist('value', data.PastelCode);
                    $('#productDescription_'+tokenId).flexdatalist('value', data.PastelDescription);
                    $('#costPrice_'+tokenId).val(parseFloat(data.CostPrice).toFixed(2));
                });

                var productDescription = $('#productDescription_'+tokenId).flexdatalist({
                    minLength: 1,
                    valueProperty: '*',
                    selectionRequired: true,
                    focusFirstResult: true,
                    searchContain:true,
                    visibleProperties: ["PastelCode","PastelDescription", "CostPrice"],
                    searchIn: ["PastelCode","PastelDescription"],
                    data: productsList
                });

                productDescription.on('select:flexdatalist', function (event, data) {
                    $('#productCode_'+tokenId).flexdatalist('value', data.PastelCode);
                    $('#productDescription_'+tokenId).flexdatalist('value', data.PastelDescription);
                    $('#costPrice_'+tokenId).val(parseFloat(data.CostPrice).toFixed(2));
                });
            };

            $(document).on('keyup', '.productPrice', function(e) {
                var costing = $(this).closest("tr").find(".costPrice").val();
                var prodPriceVal =  $(this).closest("tr").find(".productPrice").val();
                var token_number =  $(this).closest("tr").find(".token").val();

                $(this).closest("tr").find(".gp").val( parseFloat( marginCalculator(costing,prodPriceVal)).toFixed(2));
            });

            function marginCalculator(cost, price){
                return (100-((cost/price))*100);
            }

            $('#addGroupSpecial').click(function(){
                var productsLinesOnPicking = new Array();
                $('#tblCreateNewSpecial > tbody  > tr').each(function() {
                    if (($(this).closest('tr').find('.productCode').val()).length > 0 && ($(this).closest('tr').find('.productDescription').val()).length > 0 ) {
                        productsLinesOnPicking.push({
                            'productCode': $(this).closest('tr').find('.productCode').val(),
                            'price': $(this).closest('tr').find('.productPrice').val(),
                            'dateFrom':  $(this).closest('tr').find('.dateFrom').val() ,
                            'dateTo': $(this).closest('tr').find('.dateTo').val(),
                            'cost_': $(this).closest('tr').find('.costPrice').val(),
                            'gp_': $(this).closest('tr').find('.gp').val(),
                            'costCreated_': 0,
                        });
                    }
                });

                var check = checkMarginsAuth(productsLinesOnPicking);
                var userRole = "Not Admin";

                if (check != 1){
                    postLines(productsLinesOnPicking);
                }else{
                    authorize(userRole).then(function(approved) {
                        if (approved == 1) {
                            postLines(productsLinesOnPicking);
                        }
                    }).catch(function(error) {
                        console.error("Error:", error);
                    });
                }

            });

            function getOverallGroupSpecials(){
                if (formattedFrom == '' && formattedTo == '' && groupId == '' && dealName == ''){
                    DevExpress.ui.notify({
                        message: 'Choose at least one filter above and press search to display specials.',
                        type: 'info',// 'error', 'warning', 'success'
                        displayTime: 3500,
                    });
                }else{
                
                    $('#overlay').prop('hidden', false);
                    $.ajax({
                        url: '{!!url("/getOverallGroupSpecials")!!}',
                        type: "GET",
                        data: {
                            dateFrom: formattedFrom,
                            dateTo: formattedTo,
                            groupId: groupId,
                            dealName: dealName,
                        },
                        success: function(data) {
                            $('#overlay').prop('hidden', true);
                            gridGroupSpecials.option('dataSource', data);
                            gridGroupSpecials.refresh();
                        }
                    });
                }
            };

            function copyGroupSpecial(groupData){
                
                $.each(groupData, function(index, row) {
                    var tokenId=Math.floor(Math.pow(10, 9-1) + Math.random() * 9 * Math.pow(10, 9-1));

                    $("#inputDateFrom").val(row.Date);
                    $("#inputDateTo").val(row.DateTo);

                    var $row = $(
                    '<tr id="row_'+tokenId+'" >' 
                        +'<td contenteditable="false" hidden>'
                            +'<input value="'+tokenId+'" class="token">'
                        +'</td>' 

                        +'<td contenteditable="false" class="col-2 p-1">'
                            +'<input name="theProductCode" id="productCode_'+tokenId+'" class="productCode col-12 form-control inputs" value="'+row.PastelCode+'">'
                        +'</td>' 

                        +'<td contenteditable="false" class="col-3 p-1">'
                            +'<input name="prodDescription_" id="productDescription_'+tokenId+'" class="productDescription col-12 form-control inputs" value="'+row.PastelDescription+'">'
                        +'</td>' 

                        +'<td  contenteditable="false" class="col-2 p-1">'
                            +'<input type="date" name="dateFrom" id="dateFrom_'+tokenId+'" class="dateFrom col-12 form-control inputs" value="'+row.Date+'" readonly>'
                        +'</td>' 

                        +'<td contenteditable="false" class="col-2 p-1">'
                            +'<input type="date" name="dateTo" id="dateTo_'+tokenId+'" class="dateTo col-12 form-control inputs" value="'+row.DateTo+'" readonly>'
                        +'</td>' 

                        +'<td contenteditable="false" class="col-1 p-1">'
                            +'<input type="text" name="prodPrice_" id="prodPrice_'+tokenId+'" class="productPrice col-12 form-control inputs">'
                        +'</td>' 

                        +'<td contenteditable="false" class="col-1 p-1">'
                            +'<input type="text" name="cost_" id="costPrice_'+tokenId+'" class="costPrice col-12 form-control inputs" value="'+row.CostPrice+'" readonly>'
                        +'</td>' 

                        +'<td contenteditable="false" class="col-1 p-1">'
                            +'<input type="text" name="gp_" id="gp_'+tokenId+'" class="gp col-12 form-control inputs" readonly>'
                        +'</td>' 

                        // +'<td contenteditable="false" class="col-1 p-1">'
                        //     +'<input type="text" name="costCreated_" id="costCreated_'+tokenId+'" class="costCreated col-12 form-control inputs" >'
                        // +'</td>'

                        +'<td contenteditable="false"  class="p-1">'
                            +'<button type="button" name="'+tokenId+'" id="btnCancelLine" class="btn btn-danger"> X </button>'
                        +'</td>'
                    +'</tr>'
                    );

                    $('#tblCreateNewSpecial tbody')
                        .append( $row )
                        .trigger('addRows', [ $row, false ]);
                });
                $('#modalAddGroupSpecial').modal('show');
            };

            $("#closemodalAddGroupSpecial").click(function() {
                $('#selectGroup').val(' ');
                $('#tblCreateNewSpecial tbody').empty();
                $('#modalAddGroupSpecial').modal('hide');
            });

            $("#inputDateFrom").on("change", function() {
                // Get the new value of inputDateFrom
                var newValue = $(this).val();
                
                // Update the value of all elements with class dateFrom
                $(".dateFrom").each(function() {
                    $(this).val(newValue);
                });
            });

            $("#inputDateTo").on("change", function() {
                // Get the new value of inputDateFrom
                var newValue = $(this).val();
                
                // Update the value of all elements with class dateFrom
                $(".dateTo").each(function() {
                    $(this).val(newValue);
                });
            });

            
            function checkMarginsAuth(lines){
                let checkGP = 5;
                let requireAuth = 0;
                $.each(lines, function(index, row) {
                    if (row.gp_ < checkGP) {
                        requireAuth = 1;
                    }
                });

                return requireAuth;
            };

            function postLines(lines){
                $.ajax({
                    url: '{!!url("/createGroupSpecials")!!}',
                    type: "POST",
                    data: {
                        customerCode: $('#selectGroup').val(),
                        orderDetails: lines,
                        contractDateFrom:$('#inputDateFrom').val(),
                        contractDateTo:$('#inputDateTo').val(),
                        dealName: $('#inputDealName').val(),
                    },
                    success: function (data) {
                        $('#selectGroup').val(' ');
                        $('#inputDealName').val('');
                        $('#tblCreateNewSpecial tbody').empty();
                        $('#modalAddGroupSpecial').modal('hide');

                        DevExpress.ui.notify({
                            message: 'SUCCESS',
                            type: 'success',// 'info', 'success', 'warning'
                            displayTime: 3500,
                        });

                        getOverallGroupSpecials();
                    }
                });
            };
        });
    </script>

@endsection