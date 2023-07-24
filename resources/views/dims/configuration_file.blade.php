@extends('layouts.app')

@section('content')
    <div class="col-lg-12" style="font-family: Lucida Console,Lucida Sans Typewriter,monaco,Bitstream Vera Sans Mono,monospace; background: black;color: white;" >
        [0 = NO   , 1 = YES]
        <table class="table search-table" id="aprrovedDealsPop" style="color: white;"  >

            <thead>
                <tr style="color: blue;">
                    <th>Settings</th>
                    <th>Edit This side</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Accounting Package</td>
                    <td>{{config('app.Accounting')}}</td>
                </tr>
                <tr>
                    <td>Authorise Credit Limits(This will also take in account of the balance due)</td>
                    <td>{{config('app.CreditLimitAuth')}}</td>
                </tr>
                <tr>
                    <td>Margin on Products(This will stop the user to put prices below % margin ) </td>
                    <td>{{config('app.Margin')}}</td>
                </tr>
                <tr>
                    <td>Authorise when changing price</td>
                    <td>{{config('app.PriceChangeAuth')}}</td>
                </tr>
                <tr>
                    <td>Authorise when changing route</td>
                    <td>{{config('app.RouteChangeAuth')}}</td>
                </tr>
                <tr>
                    <td>Credit On Hold </td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Has Point Of Sale (POS) </td>
                    <td>{{config('app.HasPOS')}}</td>
                </tr>
                <tr>
                    <td>Has Web Store </td>
                    <td>{{config('app.HasWebStore')}}</td>
                </tr>
                <tr>
                    <td>Has Deal App </td>
                    <td>{{config('app.HasDealApp')}}</td>
                </tr>
                <tr>
                    <td>Has Assets App </td>
                    <td>{{config('app.HasAssetsApp')}}</td>
                </tr>
            </tbody>

        </table>
    </div>
@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>

</script>