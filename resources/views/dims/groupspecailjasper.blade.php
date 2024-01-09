<!doctype html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="icon" href="{{ asset('images/1024.png') }}" type="image/icon type">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.softblue.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <style>
        body {
            background: rgb(204, 204, 204) !important;
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

        #page-footer {
            bottom: 0;
        }

        #page-header {
            top: 0;
        }

        #orderlines {}

        @media print {
            body {
                margin: 0;
            }

            #page-footer {
                position: fixed;
                bottom: 0;
                /* page-break-before: always; */
                /* display: block !important; */
            }

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

        table tr td {
            font-size: 10px;
            font-weight: bold;
        }

        p {
            margin: 0px !important;
            font-weight: 700;
            font-size: 0.8rem;
        }

        h1 {
            font-size: 3.5rem;
        }

        .dx-header-row {
            color: white;
            text-transform: uppercase;
        }

        .dx-datagrid-summary-item {
            color: white;
            text-transform: uppercase;
        }

        .dx-datagrid-headers {
            border-bottom: 0px;
            background-color: rgb(98, 98, 98);
        }

        .dx-datagrid-total-footer {
            background-color: rgb(98, 98, 98);
        }
    </style>

</head>

<body>
    <page size="A4">
        <div id="page-header" class="d-flex w-100 pt-4 px-4" style="margin-bottom: 10px;">
            <div class="col-sm-6 p-2 border border-dark rounded-start" id="left">
                {!! $companyDetails['Header'] !!}
                <br />
                {!! $companyDetails['Banking Details'] !!}
            </div>

            <div class="col-sm-6 p-2 border-top border-end border-bottom border-dark rounded-end" id="right">
                <span style="font-weight: bold;">Entity:</span> {{ $entityName ?? '' }}
            </div>
        </div>

        <div id="orderlines" class="d-flex w-100 pt-4 px-4">
            <div class="border border-dark rounded-start w-100" style="margin-bottom: 20px;">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Item Code</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($groupSpecialData)
                            @foreach ($groupSpecialData as $data)
                                <tr>
                                    <td>
                                        {{ $data->PastelCode }}
                                    </td>
                                    <td>
                                        {{ $data->PastelDescription }}
                                    </td>
                                    <td>
                                        {{ $data->Price }}
                                    </td>
                                    <td>
                                        {{ $data->contractDateFrom }}
                                    </td>
                                    <td>
                                        {{ $data->contractDateTo }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">No Record(s) Found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </page>
</body>


</html>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
</script>

<!-- DevExtreme library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script>

