<!doctype html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>{{ $docNo }} PDF</title>
    <link rel="icon" href="{{asset('images/1024.png')}}" type="image/icon type">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

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
        }
        page[size="A4"] {
            width: 21cm;
            /* height: 29.7cm;  */
        }

        h6 {
            margin-top: 0;
            margin-bottom: 2px;
            font-size: 20px;
        }

        p {
            margin-top: 0;
            margin-bottom: 2px;
            font-size: 12px;
        }

        tr{
            font-size: 10px;
        }

        @media print {
            page[size="A4"] {
                size: A4;
                margin: auto;
            }

            table {
                width: 100%;
                height: 100%;
                page-break-before: always;
                margin-top: 2mm;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

            .border-dark{
                border: 2px solid black !important;
            }
        }
    </style>
</head>
<body>
<page size="A4">
    <table class="table table-sm table-borderless w-100 h-100">
        <thead>
            <tr>
                <th colspan="9" class="m-0 p-0 border border-dark">
                    <div id="page-header" class="d-flex w-100">
                        <div class="col-sm-6 p-2" id="left">
                            <div class="d-inline-flex w-100">
                                <div class="col-sm-12 h-100 d-flex aligns-items-center">
                                    <img src="{{ $strCompanyLogoName }}" alt="" style="width: 85%; height: auto; padding: 10px;"/>
                                </div>
                            </div>
                            <div class="d-inline-flex w-100">
                                <div class="col-sm-12 h-100">
                                    {!! $header !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 p-2" id="right">
                            <div class="d-inline-flex col-sm-12">
                                <div class="col-sm-6 " id="left">
                                    <p class="text-start">DOCUMENT NO:</p>
                                </div>
                                <div class="col-sm-6 " id="right">
                                    <p class="text-start"><strong>{{ $docNo }}</strong></p>
                                </div>
                            </div>

                            <div class="d-inline-flex col-sm-12">
                                <div class="col-sm-6 " id="left">
                                    <p class="text-start">DELIVERY DATE:</p>
                                </div>
                                <div class="col-sm-6 " id="right">
                                    <p class="text-start"><strong>{{ $deliveryDate }}</strong></p>
                                </div>
                            </div>

                            <div class="d-inline-flex col-sm-12">
                                <div class="col-sm-6 " id="left">
                                    <p class="text-start">ORDER NO:</p>
                                </div>
                                <div class="col-sm-6 " id="right">
                                    <p class="text-start"><strong>{{ $orderNumber }}</strong></p>
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

                            <div class="d-inline-flex col-sm-12">
                                <div class="col-sm-6 " id="left">
                                    <p class="text-start">Account:</p>
                                </div>
                                <div class="col-sm-6 " id="right">
                                    <p class="text-start"><strong>{{ $customerPastelCode }}</strong></p>
                                </div>
                            </div>
                            <div class="d-inline-flex col-sm-12">
                                <div class="col-sm-6 " id="left">
                                    <p class="text-start">Terms:</p>
                                </div>
                                <div class="col-sm-6 " id="right">
                                    <p class="text-start"><strong>{{ $paymentTerms }}</strong></p>
                                </div>
                            </div>

                            <div id="sendtag" class="d-inline-flex col-sm-12 pt-2">
                                <div class="col-sm-6 p-2 border border-dark rounded-start">
                                    <div class="col-sm-12">
                                        <p class="text-start">SOLD TO:</p>
                                    </div>
                                    <div class="col-sm-12">
                                        <p class="text-start"><strong>{{ $soldTo }}</strong></p>
                                    </div>
                                </div>
                                <div class="col-sm-6 p-2 border-top border-end border-bottom border-dark rounded-end">
                                    <div class="col-sm-12">
                                        <p class="text-start">SHIPPED TO:</p>
                                    </div>
                                    <div class="col-sm-12">
                                        <p class="text-start"><strong>{{ $shippedTo }}</strong></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </th>
            </tr>
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
        <tfoot>
            <tr>
                <td colspan="9" class="m-0 p-0 border border-dark">
                    <div id="page-footer" class="d-inline-flex w-100 p-2" style="height: 4.06cm;">
                        <div class="col-sm-8">
                            {!! $footer !!}
                        </div>
                        <div class="col-sm-4">
                            <div class="d-inline-flex col-sm-12">
                                <div class="col-sm-6 " id="left">
                                    <p class="text-start">SUB TOTAL:</p>
                                </div>
                                <div class="col-sm-6 " id="right">
                                    <p class="text-start"><strong>{{ $currency }}{{ $subTotal }}</strong></p>
                                </div>
                            </div>

                            <div class="d-inline-flex col-sm-12">
                                <div class="col-sm-6 " id="left">
                                    <p class="text-start">Discount:</p>
                                </div>
                                <div class="col-sm-6 " id="right">
                                    <p class="text-start"><strong>{{ $currency }}{{ $invDiscAmnt }}</strong></p>
                                </div>
                            </div>

                            <div class="d-inline-flex col-sm-12">
                                <div class="col-sm-6 " id="left">
                                    <p class="text-start">Delivery:</p>
                                </div>
                                <div class="col-sm-6 " id="right">
                                    <p class="text-start"><strong>{{ '-' }}</strong></p>
                                </div>
                            </div>

                            <div class="d-inline-flex col-sm-12">
                                <div class="col-sm-6 " id="left">
                                    <p class="text-start">VAT:</p>
                                </div>
                                <div class="col-sm-6 " id="right">
                                    <p class="text-start"><strong>{{ $currency }}{{ $vat }}</strong></p>
                                </div>
                            </div>

                            <div class="d-inline-flex col-sm-12">
                                <div class="col-sm-6 " id="left">
                                    <p class="text-start">TOTAL:</p>
                                </div>
                                <div class="col-sm-6 " id="right">
                                    <p class="text-start"><strong>{{ $currency }}{{ $total }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="9" class="text-center">
                    {!! $strDisclaimer !!}
                </td>
            </tr>
        </tfoot>
    </table>
</page>
</body>
</html>
