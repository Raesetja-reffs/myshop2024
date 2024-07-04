<!doctype html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Dashboard</title>
    {{-- <link rel="icon" href="{{asset('images/1024.png')}}" type="image/icon type"> --}}
    <!-- CSS only -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- DevExtreme theme -->
    {{-- <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/22.2.3/css/dx.light.css"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.carmine.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.contrast.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.darkmoon.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.darkviolet.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.greenmist.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.blue.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.blue.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.softblue.css" rel="stylesheet"> --}}

    <!-- Select2 CSS -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"/> --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/> --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/> --}}

    <style>
        body {
            background: rgb(204,204,204) !important;
        }
        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-top: 0.5cm;
            margin-bottom: 0.5cm;
            padding: 10px;
        }
        page[size="A4"] {
            width: 21cm;
            /* height: 29.7cm;  */
        }
        #page-footer{
            bottom: 0;
        }
        /* #page-footer::before {
            counter-increment: page;
            content: "Page " counter(page);
        } */

        #page-header{
            top: 0;
        }

        #orderlines{

        }

        @media print {
            body {
                margin: 0;
            }
            #page-footer {
                position: static; /* Initially set to static */
            }
            #page-footer{
                /* position: fixed;
                bottom: 0; */
                /* page-break-before: always; */
                /* display: block !important; */
            }
            /* #page-footer {
                display: block;
            }*/

            /*#page-footer:not(:last-of-type) {
                display: none; /* Hide footer on all pages except the last one */
            /*} */
            /* #page-footer:last-of-type {
                display: block;
            } */

            /* #page-header{
                position: fixed;
                top: 0;
                page-break-after: always;
                display: block !important;
            }

            #sendtag{
                margin-top: 225px;
            }

            #orderlines{
                margin-bottom: 225px;
                display: block !important;
                height: 50%;
            }  */
        }
        table tr {
            height: 36px;
        }

        table tr td{
            font-size: 10px;
            font-weight: bold;
        }

        p {
            margin: 0px !important;
            font-weight: 700;
            font-size: 0.8rem;
        }
        h1{
            font-size: 3.5rem;
        }
        .dx-header-row {
            color: white;
            text-transform: uppercase;
        }
        .dx-datagrid-summary-item{
            color: white;
            text-transform: uppercase;
        }
        .dx-datagrid-headers{
            border-bottom: 0px;
            background-color: rgb(98, 98, 98);
        }
        .dx-datagrid-total-footer{
            background-color: rgb(98, 98, 98);
        }
        .table>:not(:first-child) {
            border-top: unset;
        }
        .border-dark {
            border-color: var(--bs-border-color) !important;
        }

    </style>
    @if (count($orderlines) <= 6)
        <style>
            @media print {
                #page-footer{
                    position: fixed;
                    bottom: 0;
                }
            }
        </style>
    @endif
</head>

<body>
    <page size="A4">

        <div id="page-header" class="d-flex w-100">
            <div class="col-sm-6 p-2 border border-dark rounded-start" id="left">
                <div class="d-inline-flex">
                    <div class="col-sm-12 h-100 d-flex aligns-items-center">
                        <img src="{{ $companyInfo[0]->strCompanyLogoName }}" alt="" style="width: 300px;height: 130px;/*width: 100%;height: 100%;*/"/>
                    </div>
                </div>
                <div class="d-inline-flex">
                    <div class="col-sm-12 h-100">
                        {!! $companyInfo[0]->strHtmlHeader !!}
                    </div>
                </div>
            </div>

            <div class="col-sm-6 p-2 border-top border-end border-bottom border-dark rounded-end" id="right">
                {{-- <div class="w-100 position-absolute bottom-0 end-0"> --}}
                <div class="d-inline-flex col-sm-12">
                    <div class="col-sm-6 " id="left">
                        <p class="text-start">DOCUMENT NO:</p>
                    </div>
                    <div class="col-sm-6 " id="right">
                        <p class="text-start"><strong>{{ $orderheader[0]->DocNumber }}</strong></p>
                    </div>
                </div>

                <div class="d-inline-flex col-sm-12">
                    <div class="col-sm-6 " id="left">
                        <p class="text-start">DELIVERY DATE:</p>
                    </div>
                    <div class="col-sm-6 " id="right">
                        <p class="text-start"><strong>{{ $orderheader[0]->DocDate }}</strong></p>
                    </div>
                </div>

                <div class="d-inline-flex col-sm-12">
                    <div class="col-sm-6 " id="left">
                        <p class="text-start">ORDER NO:</p>
                    </div>
                    <div class="col-sm-6 " id="right">
                        <p class="text-start"><strong>{{ $orderheader[0]->DIMS_OrderNo }}</strong></p>
                    </div>
                </div>

                <div class="d-inline-flex col-sm-12">
                    <div class="col-sm-6 " id="left">
                        <p class="text-start">USER NAME:</p>
                    </div>
                    <div class="col-sm-6 " id="right">
                        <p class="text-start"><strong>{{ $createdBy }}</strong></p>
                    </div>
                </div>
                {{-- </div> --}}
                <div id="sendtag" class="d-inline-flex col-sm-12 pt-2">
                    <div class="col-sm-6 p-2 border border-dark rounded-start">
                        <div class="col-sm-12">
                            <p class="text-start">SOLD TO:</p>
                        </div>
                        <div class="col-sm-12">
                            <p class="text-start"><strong>{{ $orderheader[0]->SoldTo }}</strong></p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-2 border-top border-end border-bottom border-dark rounded-end">
                        <div class="col-sm-12">
                            <p class="text-start">SHIPPED TO:</p>
                        </div>
                        <div class="col-sm-12">
                            <p class="text-start"><strong>{{ $orderheader[0]->ShipTo }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="orderlines" class="mt-2" style="width: 100% !important;">
            <table class="table table-bordered">
                <thead>
                    <tr class="">
                        <th class="text-left">Line</th>
                        <th class="text-left">Item</th>
                        <th>Description</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Unit</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Discount</th>
                        <th class="text-center">VAT</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderlines as $lines)
                    <tr>
                        <td class="col-1 text-left">{{ $lines->DIMS_OrderDetailID }}</td>
                        <td class="col-1 text-left">{{ $lines->PartNumber }}</td>
                        <td class="col-4">{{ $lines->PDesc }}</td>
                        <td class="col-1 text-center">{{ number_format($lines->qty, 2) }}</td>
                        <td class="col-1 text-center">{{ $lines->UnitOfMeasure }}</td>
                        <td class="col-1 text-center">{{ number_format($lines->UnitPrice, 2) }}</td>
                        <td class="col-1 text-center">{{ number_format($lines->LineDiscount, 2) }}</td>
                        <td class="col-1 text-center">{{ number_format($lines->LineTax, 2) }}</td>
                        <td class="col-1 text-right">{{ number_format($lines->LineTotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="page-footer">
            <div class="d-inline-flex w-100" style="height: 265px;">
                <div class="col-sm-8 p-2 border border-dark rounded-start" id="left">
                    {!! $companyInfo[0]->strHtmlFooter !!}
                </div>
                <div class="col-sm-4 p-2 border-top border-end border-bottom border-dark rounded-end" id="right">
                    {{-- <div class="w-100 position-absolute bottom-0 end-0"> --}}
                    <div class="d-inline-flex col-sm-12">
                        <div class="col-sm-6 " id="left">
                            <p class="text-start">SUB TOTAL:</p>
                        </div>
                        <div class="col-sm-6 " id="right">
                            <p class="text-start"><strong>{{ $orderheader[0]->strCurrency }}{{ $orderheader[0]->subtotal }}</strong></p>
                        </div>
                    </div>

                    <div class="d-inline-flex col-sm-12">
                        <div class="col-sm-6 " id="left">
                            <p class="text-start">VAT:</p>
                        </div>
                        <div class="col-sm-6 " id="right">
                            <p class="text-start"><strong>{{ $orderheader[0]->strCurrency }}{{ $orderheader[0]->tax }}</strong></p>
                        </div>
                    </div>

                    <div class="d-inline-flex col-sm-12">
                        <div class="col-sm-6 " id="left">
                            <p class="text-start">TOTAL:</p>
                        </div>
                        <div class="col-sm-6 " id="right">
                            <p class="text-start"><strong>{{ $orderheader[0]->strCurrency }}{{ $orderheader[0]->Total }}</strong></p>
                        </div>
                    </div>

                    {{-- </div> --}}
                </div>
            </div>
            <div class="d-inline-flex justify-content-center">
                <div class="col-sm-12 text-center">
                    {!! $companyInfo[0]->strDisclaimer !!}
                </div>
            </div>
        </div>

        {{-- <div id="page-footer" class="px-5 w-100" style="padding-top:1rem!important; padding-bottom:3rem!important; height: 225px;">
            {!! $footer !!}
            <img src="data:image/png;base64,{{ $Signature }}" alt="" style="height:60%; padding-top: 1rem!important"/>
            <p>{{ $Coordinates }}</p>
        </div> --}}

    </page>
</body>


</html>

<!-- jQuery -->
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script> --}}

<!-- JavaScript Bundle with Popper -->
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> --}}

<!-- DevExtreme library -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script> --}}

<script>
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });
    // $(document).on('focus', ':input', function() {
    //     $(this).attr('autocomplete', 'off');
    // });

    // $(document).ready(function() {
    //     var headerID ='{{ $ID }}'

    //     /*$.ajax({
    //         url: '{!!url("/getOrderLines")!!}',
    //         type: "GET",
    //         data: {
    //             ID : headerID,
    //         },
    //         success: function (data) {
    //             //console.debug(data);
    //             const orderlines = $("#orderlines").dxDataGrid({
    //                 dataSource:data, //as json
    //                 showBorders: false,
    //                 showColumnLines: false,
    //                 allowColumnResizing: true,
    //                 columnAutoWidth: true,
    //                 paging: false,
    //                 // export: {
    //                 //     enabled: true,
    //                 //     formats: ['pdf'],
    //                 // },

    //                 columns: [{
    //                     width: 30,
    //                 }, {
    //                     dataField: "PartNumber",
    //                     caption: "Item Code",
    //                     width: 100,
    //                 }, {
    //                     dataField: "PDesc",
    //                     caption: "Item Name",
    //                 },
    //                 {
    //                     dataField: "qty",
    //                     caption: "Qty",
    //                     width: 70,
    //                 },
    //                 {
    //                     dataField: "UnitOfMeasure",
    //                     caption: "Unit",
    //                     width: 70,
    //                 },
    //                 {
    //                     dataField: "UnitPrice",
    //                     caption: "Unit Price",
    //                     alignment: 'center',
    //                     width: 70,
    //                     format: {
    //                         type: 'fixedPoint',
    //                         precision: 4,
    //                     },
    //                     customizeText: function (cellInfo) {
    //                     return parseFloat(cellInfo.value).toFixed(2);
    //                     },
    //                 }, {
    //                     dataField: "LineDiscount",
    //                     caption: "Discount",
    //                     alignment: 'center',
    //                     width: 70,
    //                     format: {
    //                         type: 'fixedPoint',
    //                         precision: 4,
    //                     },
    //                     customizeText: function (cellInfo) {
    //                     return parseFloat(cellInfo.value).toFixed(2);
    //                     },
    //                 }, {
    //                     dataField: "LineTax",
    //                     caption: "Vat",
    //                     alignment: 'center',
    //                     width: 70,
    //                     format: {
    //                         type: 'fixedPoint',
    //                         precision: 4,
    //                     },
    //                     customizeText: function (cellInfo) {
    //                     return parseFloat(cellInfo.value).toFixed(2);
    //                     },
    //                 }, {
    //                     dataField: 'LineTotal',
    //                     caption: 'Total',
    //                     allowEditing: false,
    //                     format: {
    //                         type: 'fixedPoint',
    //                         precision: 4,
    //                     },
    //                     customizeText: function (cellInfo) {
    //                     return parseFloat(cellInfo.value).toFixed(2);
    //                     },

    //                     width: 100,
    //                 }, {
    //                     width: 30,
    //                 },
    //                 ],
    //                 summary: {
    //                     totalItems: [{
    //                         column: "Total",
    //                         summaryType: 'sum',
    //                         displayFormat: ' '
    //                     },],
    //                 },
    //             });
    //         }
    //     });*/
    // });


</script>

