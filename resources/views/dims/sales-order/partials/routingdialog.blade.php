<div id="routingdialog" title="Choose Route" style="background: #ffa65d;">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <label>Route</label>
                </div>
                <div class="col-md-12 mb-3">
                    <select id="changetcurrentrouteonorder" class="form-control form-select">
                        @foreach ($routesNames as $value)
                            <option value="{{ $value->Routeid }}">{{ $value->Route }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <p>BY CLICKING SUBMIT YOU ARE AUTHORISING THE ROUTE CHANGE ON THIS ORDER</p>
                </div>
                <div class="col-md-12">
                    <button id="auththisrouteontheorder" class="btn btn-success btn-sm">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#routingdialog').hide();
        $('#routeonabutton').click(function() {
            $('#routingdialog').show();
            showDialog('#routingdialog', '40%', 300);
            $('#auththisrouteontheorder').click(function() {
                $.ajax({
                    url: '{!! url('/changerouteonorder') !!}',
                    type: "POST",
                    data: {
                        routeId: $('#changetcurrentrouteonorder').val(),
                        OrderId: $('#orderId').val(),
                    },
                    success: function(data) {
                        //console.debug(data);
                        $('#routeonabutton').val(data);
                        $('#routingdialog').dialog('close');
                    }
                });
            });
        });
    });
</script>
