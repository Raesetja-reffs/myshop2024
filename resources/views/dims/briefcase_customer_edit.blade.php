@extends('layouts.app')

@section('content')
    <div class="container" style="width: 100%;">

            <div class="col-lg-12" >
                <button  class="submitEdits btn-success btn-md">Submit</button>
                <table>
                    <thead>
                        <th>Customer Code</th>
                        <th>Customer Name</th>
                        <th>Period Of Visit</th>
                        <th>Address</th>
                        <th>Last Visit</th>
                        <th>Margin</th>

                    </thead>
                    <tbody>
                    @foreach($customeredit as $val)
                        <tr>
                          <td>{{$val->CustomerCode}} </td>
                          <td>{{$val->CustomerStoreName}} </td>
                          <td><input type="period" name='period[]' class="period form-control"  value="{{$val->intVisitPeriod}}" >

                            <td>{{$val->CustomerAddress1}} </td>
                          <td>{{$val->dteLastVisit}} </td>
                          <td>{{$val->margin}} </td>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button  class="submitEdits btn-success btn-md">Submit</button>
            </div>
    </div>
@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#QuoteDetails').hide();
        $('#extraInfo').hide();
        $('#salesQEmail').hide();
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#callList').hide();
        $('#copyOrdersBtn').hide();
        $('#tabletLoadingApp').hide();
        $('#pricingOnCustomer').hide();
        $('#salesOnOrder').hide();
        $('#posCashUp').hide();
        $('#dropdown').hide();
        $('#editDriver').hide();
        $('#salesInvoiced').hide();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.submitEdits').on('click', function () {
            var $this = $(this);
            var row = $this.closest("tr");

            var valuesProd = new Array();
            $.each($("input[name='period[]']"),
                function () {
                    var data = $(this).parents('tr:eq(0)');
                    var period = $(data).find('.period').val();

                    console.debug("------" + period);


                    if (period.length > 0) {
                        valuesProd.push({
                            'code': $(data).find('td:eq(0)').text(),
                            'period': period
                        });
                    }

                });

            console.debug(valuesProd);
            if (valuesProd.length === 0) {
                alert("There is nothing to submit");
            }

            else {

                $.ajax({
                    url: '{!! url("/updatevisits") !!}',
                    type: "POST",
                    data: {
                        items: valuesProd,

                    },
                    success: function (data) {
                        window.location = '{!!url("/brifcaseCustomerEdits")!!}';
                    }
                });
            }
        });
    });
    </script>