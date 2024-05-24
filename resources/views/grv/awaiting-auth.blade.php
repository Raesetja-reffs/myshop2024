<x-app-layout>
    <x-slot name="header">
        {{ __('GRV') }}
    </x-slot>
    <x-slot name="breadcrum">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                Home </a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('grv.dashboard') }}" class="text-muted text-hover-primary">
                Dashboard
            </a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-dark">
            Awaiting Auth
        </li>
    </x-slot>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex rounded">
                        <ul class="nav nav-tabs nav-pills border-0 flex-row flex-md-column me-5 mb-3 mb-md-0 fs-6">
                            @if ($pos)
                                @foreach ($pos as $index => $item)
                                    <li class="nav-item w-md-200px me-0">
                                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_{{ $index }}">
                                            {{ $item['name'] }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>

                        <div class="tab-content flex-grow-1 d-flex justify-content-center" id="myTabContent">
                            <div class="align-self-center no_selected_pos">
                                <span class="fs-1">
                                    No PO Selected
                                </span>
                            </div>
                            @if ($pos)
                                @foreach ($pos as $index => $item)
                                    <div class="tab-pane fade show d-none" role="tabpanel" id="kt_tab_pane_{{ $index }}">
                                        <div class="table-responsive scroll h-400px">
                                            <table id="POSTable" class="table table-striped table-bordered gy-7 gs-7">
                                                <thead>
                                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                        <th>Item</th>
                                                        <th>Receiver A Qty</th>
                                                        <th>Receiver B Qty</th>
                                                        <th>Final</th>
                                                        <th>Variance</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($item['items'] as $itemVal)
                                                        <tr>
                                                            <td>
                                                                {{ $itemVal['item_code'] }}
                                                            </td>
                                                            <td>
                                                                {{ $itemVal['receiver_a_qty'] }}
                                                            </td>
                                                            <td>
                                                                {{ $itemVal['receiver_b_qty'] }}
                                                            </td>
                                                            <td class="final_quantity">
                                                                {{ $itemVal['final'] }}
                                                            </td>
                                                            <td>
                                                                {{ $itemVal['variance'] }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="button" class="btn btn-primary btn-sm approve_po">Approve</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.nav-link').click(function(event) {
                $("#myTabContent").removeClass('d-flex justify-content-center');
                $(".tab-pane" + $(this).attr('href')).removeClass('d-none');
                $(".no_selected_pos").hide();
            });
            $('.approve_po').click(function(event) {
                $(".general-loader").show();
                var isAllow = true;
                $(this).parents('.tab-pane:first').find('.final_quantity').each(function() {
                    if ($(this).text().trim() == '') {
                        isAllow = false;
                    }
                });
                if (isAllow) {
                    location.reload();
                }
            });
        });
    </script>
</x-app-layout>
