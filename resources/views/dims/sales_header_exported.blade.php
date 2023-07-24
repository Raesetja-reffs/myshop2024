<div class="col-lg-12" title="Products on Sales Order">
    <table id="tablePalladiumDimsStatus" class="table table-bordered table-condensed" style="font-family: sans-serif;color:black;">
        <thead>
        <tr>
            <th>Document Number</th>
            <th >Doc Date</th>
            <th>Customer Number</th>
            <th class="col-md-3">Ship To</th>
            <th class="col-md-3">Sold To</th>
            <th>Total</th>
            <th class="col-md-3">Error Message</th>

            <th class="col-md-1">Status</th>
            <th class="col-md-1">Change Status</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script>
    $.ajax({
        url: '{!!url("/salesHeaderExported")!!}',
        type: "GET",
        success: function (data) {
            var trHTML = '';
            //console.debug("combined special" + data);
            //'DocNumber','DocDate','CustomerNumber','SoldTo','ShipTo','Total','intFlag','ErrorMessage'
            $.each(data, function (key, value) {
                trHTML += '<tr class="fast_remove" style="font-size: 9px;color:black"><td>' +
                    value.DocNumber + '</td><td>' +
                    value.DocDate + '</td><td>' +
                    value.CustomerNumber + '</td><td>' +
                    value.ShipTo + '</td><td>' +
                    value.SoldTo + '</td><td>' +
                    parseFloat(value.Total).toFixed(5) + '</td><td>' +
                    value.ErrorMessage + '</td><td>' +
                    value.intFlag + '</td><td><select id="intFlag"><option value="0">0</option> <option value="1">1</option> <option value="2">2</option> <option value="3">3</option>' +
                    '</select></td></tr>';
            });
            $('#tablePalladiumDimsStatus').append(trHTML);
        }
    });
</script>