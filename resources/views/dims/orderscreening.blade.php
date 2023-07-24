@extends('layouts.app')
@section('content')

    <div class="container">
        <h2>Order Screening</h2>
        <div class="container">
            <!--Search-->
            <div class="col-lg-4"> <input type="text"  class="form-control input-sm col-xs-1" id="myInputs" onkeyup="myOrder()" placeholder="Search Order Number">
            </div>
            <div class="col-lg-8"><label for="date">Date:</label>
                <input type="date" id="myInput" name="date">
                <input  id="myInput" onclick="myFunction()" type="submit"></div>
            <br><br>
        </div>



        <div class=" tableFixHead"  >
            <table id="table"  class="table font-family: sans-serif; tableFixHead">
                <thead style="background: lavender;">
                <tr >



                    <th >OrderDate</th>
                    <th >OrderNumber</th>

                    <th>Notes</th>
                    <th>DimsOrderID</th>
                    <th>intUserID</th>
                    <th>DeliveryAddress</th>
                    <th>CustomerContactCellphone</th>
                    <th>CustomerContactEmail</th>
                    <th>Bit Completed</th>



                </tr>
                </thead>
                <tbody id="scrollArea" class="clusterize-scroll" style="font-size: 12px;">
                @foreach ($orderScrn as $orders)
                    <tr style="background:{{$orders->bColor}}" >

                    <?php $adv =  substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(13/strlen($x)) )),1,20); ?>
                    <!--<td><button type="button" id="deleteaLine"  class="getOrderDetailLine btn-warning" value="" >Delete</button></td>
                       OrderDate,OrderNumber,Notes,DimsOrderID,intUserID,DeliveryAddress,CustomerContactCellphone,CustomerContactEmail-->

                        <td  >{{$orders->OrderDate}}</td>

                        <td> {{$orders->OrderNumber}}</td>
                        <td >{{$orders->Notes}}</td>
                        <td>{{$orders->DimsOrderID}}</td>
                        <td> {{$orders->intUserID}}</td>
                        <td >{{$orders->DeliveryAddress}}</td>
                        <td >{{$orders->CustomerContactCellphone}}</td>
                        <td >{{$orders->CustomerContactEmail}}</td>

                        <td> {{$orders->bitCompleted}}</td>

                    </tr>
                @endforeach

                </tbody>
            </table>

        </div>
    </div>

@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>

<style>


    .tableFixHead {

        width: 100%;
        overflow: auto;
        height: 80%;

    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
    }


    .tablesorter thead tr .header {
        background-image:url({{asset('images/bg.gif')}});
        background-repeat: no-repeat;
        background-position: center right;
        cursor: pointer;
    }

    .tablesorter thead tr .headerSortDown {
        background-image: url({{asset('images/asc.gif')}});
    }
    .tablesorter thead tr .headerSortDown {
        background-image: url({{asset('images/desc.gif')}});
    }


    /* max-height - the only parameter in this file that needs to be edited.
 * Change it to suit your needs. The rest is recommended to leave as is.
 */
    .clusterize-scroll{
        max-height: 600px;
        overflow: auto;
    }

    /**
     * Avoid vertical margins for extra tags
     * Necessary for correct calculations when rows have nonzero vertical margins
     */
    .clusterize-extra-row{
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }

    /* By default extra tag .clusterize-keep-parity added to keep parity of rows.
     * Useful when used :nth-child(even/odd)
     */
    .clusterize-extra-row.clusterize-keep-parity{
        display: none;
    }

    /* During initialization clusterize adds tabindex to force the browser to keep focus
     * on the scrolling list, see issue #11
     * Outline removes default browser's borders for focused elements.
     */
    .clusterize-content{
        outline: 0;
        counter-reset: clusterize-counter;
    }

    /* Centering message that appears when no data provided
     */
    .clusterize-no-data td{
        text-align: center;
    }
    .table td, .table th {
        padding: 0;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }
</style>
<script>

    //search function
    function myFunction() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("scrollArea");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];//column name index
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    //search function for order number
    function myOrder() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInputs");
        filter = input.value.toUpperCase();
        table = document.getElementById("scrollArea");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];//column name index
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }


    //jquery to save data

    $(document).ready(function() {
        //add this post header
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });







    });
</script>
