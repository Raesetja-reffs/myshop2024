<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js" integrity="sha512-qzgd5cYSZcosqpzpn7zF2ZId8f/8CHmFKZ8j7mU4OUXTNRd5g+ZHBPsgKEwoqxCtdQvExE5LprwwPAgoicguNg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {
        $('#btnDriversMap').click(function() {
            window.open('{!! url('/driversMap') !!}', '_blank');
        });

        $('#btnCreditReqReport').click(function() {
            window.open('{!! url('/creditRequisitionReport') !!}', '_blank');
        });

        $("#inputDeliveryDate").datepicker({
            changeMonth: true, //this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd',
        });

        $('#btnSearchPlan').click(function() {
            var newODate = $('#inputDeliveryDate').val();
            window.location.href = '{!! url('/logisticsPlan') !!}/' + newODate;
        });
        
        $("#livedrivers").tablesorter();

        $('#livedrivers').on('dblclick', 'tbody tr', function() {
            var $this = $(this);
            var row = $this.closest("tr");
            var logisticsRouteReport = row.find('td:eq(0)').text();
            var ordertype = $.trim(row.find('td:eq(1)').text());
            var routename = $.trim(row.find('td:eq(2)').text());
            window.open('{!! url('/logisticsRouteReport') !!}/' + logisticsRouteReport + "/" + ordertype + "/" +
                routename, '_blank');
        });
    });
</script>
