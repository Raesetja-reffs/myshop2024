<!DOCTYPE html>
<html>
<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />

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
<div class="col-md-12" style="background: black;color:white;height: 1500px;">

    <div class="col-md-8">
        <h3>Age Analysis</h3>
        <div id="myGrid" style="height: 150px;width:95%;" class="ag-theme-balham"></div>
    <table class="table" id="livepickingtable">
        <thead>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">DATE</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">NOTE</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Actions</th>
        </thead>
        <tbody style="font-family: sans-serif;color:white;">
        @foreach($customerNotes as $val)
                <tr style="background: green;color: black;" >
                    <td>{{$val->dteCreatedDate}}</td>
                    <td><textarea class="notestoedit"> {{$val->strCustomerNote}}</textarea></td>
                    <td>
                        <button class="btn-md btn-primary update"   value="{{$val->intAutoNoteId}}" >UPDATE</button>
                        <button class="btn-md btn-danger delete"  value="{{$val->intAutoNoteId}}" >DELETE</button>
                    </td>
                </tr>
         @endforeach
        </tbody>
    </table>
    </div>
    <div class="col-md-4">
<input id="customerid" type="hidden" value=" {{$customerid}}">
        <textarea  class="form-control" id="notes_to_add"  rows="20" style="color:black;">

        </textarea><br>
        <button class="btn-md btn-success"   id="submitnewnote">Submit New Note</button>
    </div>
</div>

<script type="text/javascript" charset="utf-8">
    var gridOptions = {};
    $(document).ready(function() {
        var customerid =$('#customerid').val();
        fetch('{!!url("getAgeAnalysis")!!}/'+customerid,{'tableName': 'Tables'} ).then(function (response) {
            return response.json();
        }).then(function (data) {

            var columnDefs = [];
            $.each(data[0], function(k, v) {
                //display the key and value pair
                console.log(k + ' is ' + v);
                columnDefs.push({
                    "headerName": k,
                    "field": k,
                    "width": 130
                });
            });
            console.debug(columnDefs);
            var gridDiv = document.querySelector('#myGrid');
            gridOptions = {
                columnDefs: columnDefs,
                floatingFilter: true,
                enableSorting: true,
                enableFilter: true,
                enableColResize: true
            };
            new agGrid.Grid(gridDiv, gridOptions);

            gridOptions.api.setRowData(data);


        });


    });



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      $(".update").click(function(){
          var id = $(this).val();
          var notesToEdit = $(this).closest('tr').find('.notestoedit').text();
      //    var notesToEdit = $(this).closest('tr').find('.update').text();
         // alert(id);
          $.ajax({
              url: '{!!url("/customernoteshistoryupdate")!!}',
              type: "POST",
              data: {
                  newNote: notesToEdit,
                  noteid: id

              },
              success: function (data) {
                  if (data[0].Results == 'UPDATED NOTE')
                  {
                      //location.reload(true);
                  }

              }
          });
      });
      $("#submitnewnote").click(function(){
          var customerId = $('#customerid').val();
          var notes_to_add = $('#notes_to_add').val();

          console.log(notes_to_add);
          console.log(customerId);
          $.ajax({
              url: '{!!url("/customernoteshistoryinsert")!!}',
              type: "POST",
              data: {
                  newNote: notes_to_add,
                  customerid: customerId

              },
              success: function (data) {
                  if (data[0].Results == 'NOTE INSERTED')
                  {
                      location.reload(true);
                  }

              }
          });
      });



</script>
</body>
</html>