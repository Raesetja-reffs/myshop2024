<!DOCTYPE html>
<html>
<head>

    <script src="{{ asset('js/ag_grid.js') }}"></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />
    <link href="{{ asset('css/excel-bootstrap-table-filter-style.css') }}" rel="stylesheet"  type='text/css'>
    <style>
        .rag-red {
            background-color: lightcoral;
        }
        .rag-green {
            background-color: lightgreen;
        }
        .rag-amber {
            background-color: lightsalmon;
        }

        .rag-red-outer .rag-element {
            background-color: lightcoral;
        }

        .rag-green-outer .rag-element {
            background-color: lightgreen;
        }

        .rag-amber-outer .rag-element {
            background-color: lightsalmon;
        }

    </style>
</head>
<body>
<div class="col-md-12" style="background: black;color:white;height: 100%;width:100%">
    <a href='{!!url("/officemap")!!}' onclick="window.open(this.href, 'massc',
'left=20,top=20,width=1000,height=1000,toolbar=1,resizable=0'); return false;" >MAP</a>
<a href='{!!url("/driverreq_report")!!}' onclick="window.open(this.href, 'massc',
'left=20,top=20,width=1000,height=1000,toolbar=1,resizable=0'); return false;" style="    padding: 20px;
    background: white;
    color: black;
    font-weight: 900;" >Drivers Report</a>
    <br>
	<?php $amountTotal = 0; ?>
    <input id="deliverydate" value="{{$delDate}}" style="color:black;font-weight: 900;"><button class="btn-success" id="lplan"> SUBMIT</button>
    <table class="table" id="livedrivers">
        <thead>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Routing ID</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Route</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Area</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">DriverName</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Assistant</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">TruckName</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Inv<i style="color:red">Ret</i></th>
		 <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Stops</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Dispatch Area</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Time Spent</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Amount</th>
       
        

        </thead>
        <tbody style="font-size: 16px;font-family: sans-serif;font-weight: 900;">
        @foreach($performance as $val)

                <tr style="background: red;color: black">

                    <td>{{$val->DeliveryDateRoutingID}}   </td>
                    <td>{{trim($val->OrderType)}}</td>
                    <td>{{trim($val->Route)}}</td>
                    <td>{{$val->DriverName}}</td>
                    <td>{{$val->ASSIS}}</td>
                    <td>{{$val->TruckName}}</td>
                    <td>{{$val->stopsDelv}} <i style="color:red">{{$val->cReq}}</i></td>
                    <td>{{$val->NoOfStops}}</td>
                    <td>{{$val->strDoorName}}</td>
                    <td>{{$val->Travelling}}</td>
                    <td>{{$val->routeAmaount}}</td>
                    <?php $amountTotal = $amountTotal + $val->routeAmaount ; ?>
                </tr>
          @endforeach
                @foreach($planned as $val2)

				@if($val2->doneBusy =="done")
                        <tr style="color: black;background:green;">
					@else
						<tr style="color: white">
					@endif
                            <td>{{$val2->DeliveryDateRoutingID}}   </td>
                            <td>{{trim($val2->OrderType)}}</td>
                            <td>{{trim($val2->Route)}}</td>
                            <td>{{$val2->DriverName}}</td>
                            <td>{{$val2->ASSIS}}</td>
                            <td>{{$val2->TruckName}}</td>
                            <td>{{$val2->stopsDelv}}<i style="color:red">{{$val2->cReq}}</i></td>
                            <td>{{$val2->NoOfStops}}</td>
                            <td>{{$val2->strDoorName}}</td>
                            <td>{{$val2->Travelling}}</td>
                            <td>{{$val2->routeAmaount}}</td>
							<?php $amountTotal = $amountTotal + $val2->routeAmaount ; ?>
                            
                        </tr>

                        @endforeach
						<tr style="color: white">
                            <td>   </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="color: green;">{{$amountTotal}}</td>
							
                            
                        </tr>
        </tbody>
    </table>

</div>
<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js" integrity="sha512-qzgd5cYSZcosqpzpn7zF2ZId8f/8CHmFKZ8j7mU4OUXTNRd5g+ZHBPsgKEwoqxCtdQvExE5LprwwPAgoicguNg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" charset="utf-8">

    $(document).ready(function() {

        $("#deliverydate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd',

        });
		 $("#livedrivers").tablesorter();
        $('#lplan').click(function(){
            var newODate = $('#deliverydate').val();
            window.open('{!!url("/ligisticsplan")!!}/'+newODate, 'SAMPLEV', "location=1,status=1,scrollbars=1, width=1500,height=850");
        });
        $('#livedrivers').on('dblclick', 'tbody tr', function () {


            var $this = $(this);
            var row = $this.closest("tr");
            var LogisticsInsertMapRoute = row.find('td:eq(0)').text();
            var ordertype = $.trim(row.find('td:eq(1)').text());
            var routename = $.trim(row.find('td:eq(2)').text());
            console.debug("ordertype"+ordertype);
            console.debug("routename"+routename);
            window.open('{!!url("/LogisticsInsertMapRoute")!!}/'+LogisticsInsertMapRoute+"/"+ordertype+"/"+routename, 'LogisticsInsertMapRoute', "location=1,status=1,scrollbars=1, width=1200,height=850");

        });
    });
</script>
</body>
</html>