@extends('layouts.app')

@section('content')
    <div class="container" style="width: 100%;">
        <div class="row">

            <input type="text"  id="dates" ><button class="btn-md btn-primary" id="get">Get</button>
            <div class="col-lg-12  visible-md visible-lg" style="    background: #32cd32;">

                <table class="table" id="callLogerTable">
                    <tr>
                        <th>col1</th>
                        <th>col2</th>
                        <th>col3</th>
                        <th>col4</th>
                        <th>Extension</th>
                        <th>Time Spent</th>
                        <th>Store Name</th>
                        <th>Link</th>

                    </tr>

                    <tbody id="searchcustomer">

                    </tbody>
                </table>
            </div>

        </div>
    </div>


@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    $(document).keydown(function(e) {
        if (e.keyCode == 27) return false;
    });
    $(document).ready(function() {
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#tabletLoadingApp').hide();
        $('#callList').hide();
        $('#copyOrdersBtn').hide();
        $('#salesOnOrder').hide();
        $('#pricingOnCustomer').hide();
        $('#salesInvoiced').hide();
        $('#posCashUp').hide();
        $("#dates").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yymmdd'
        });

        $('#get').click(function(){
            $('#searchcustomer').empty();
            $.ajax({
                url: '{!!url("/callLogger")!!}',
                type: "GET",
                data: {
                    dates: $("#dates").val()
                },
                success: function (data) {
                    var trHTML = '';
                    var theDate = $("#dates").val();

                    $.each(data, function (key, value) {
                        trHTML += '<tr  style="font-size: 25px;color:black"><td>' +
                            value.col1 + '</td><td>' +
                            value.col2 + '</td><td>' +
                            value.col3 + '</td><td>' +
                            value.col4 + '</td><td>' +
                            value.col6 + '</td><td>' +
                            value.tSpent + '</td><td>' +
                            value.StoreName + '</td><td>' +
                            '<a href={!!url("/luck")!!}/'+theDate+"/"+value.wav+' onclick="window.open(this.href, audio,left=20,top=20,width=1000,height=200,toolbar=1,resizable=0); return false;" style="font-weight: 900;color: black;" >CLICK TO PLAY AUDIO</a>'+
                            '</td></tr>';
                    });
                    $('#searchcustomer').empty();
                    $('#searchcustomer').append(trHTML);

                }
            });
        });
    });


</script>