<x-iframe-pdf-layout>
    @php $routeParams = [
        'user_id' => auth()->guard('central_api_user')->user()->id,
        'order_id' => $ID,
        'company_id' => auth()->guard('central_api_user')->user()->company_id,
    ];
    @endphp
    @if (isset($isWithoutPrice) && $isWithoutPrice)
        @php $routeParams['is_without_price'] = $isWithoutPrice; @endphp
    @endif
    <iframe src="{{ config('custom.DIMS_REPORT_BUILDER_URL') . '?apiUrl=' . urlencode(route('order.get-pdf-data', $routeParams)) }}" title="Order"></iframe>
</x-iframe-pdf-layout>