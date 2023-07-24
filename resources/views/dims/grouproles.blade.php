<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />
    <style>
        .rag-red {
            background-color: #f00f0c;
        }
        .rag-green {
            background-color: lightgreen;
        }
        .rag-amber {
            background-color: lightsalmon;
        }
        .rag-yellow {
            background-color: #f6ff23;
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


        .notdone {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .notdone td, .notdone th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .notdone tr:nth-child(even){background-color: #f2f2f2;}

        .notdone tr:hover {background-color: #ddd;}

        .notdone th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #bb1523;
            color: white;
        }
        .scroll{
            height: 750px;
            overflow-y: scroll;
        }
    </style>
</head>
<body style="font-family: Sans-serif">
<h2 style="text-align: center;">Group Roles</h2>
<div style="display:flex ">

    <div class="notdone btncurrentroles"  style="width: 30%">

        <select id="groups" class="form-control" style="width: 100%">
        <option value="-99">Select a group</option>
            @foreach($usergroups as $val)
                <option value="{{$val->GroupId}}">{{$val->GroupName}}</option>
             @endforeach
        </select>
        <h4>Current Roles</h4>
        <input  id="groupidselect">
       <div class=" scroll">

           <table class="notdone">
               <thead>
               <tr>
                   <th>Select</th>
                   <th>Role</th>
               </tr>
               </thead>
               <tbody id="currentroles" >

               </tbody>
           </table>
       </div>
    </div>
    <div class="today"  style="width: 60%;float: right;margin-left: 80px;">
        <h4>System Roles</h4>
        <h5>To assign you selected group with the new roles please select roles below and click Update.</h5>
        <div class="scroll">
            <table class="notdone scroll">
                <thead>
                <tr>
                    <th>Select</th>
                    <th>Role</th>
                </tr>
                </thead>
                <tbody id="listofsystemroles" >

                </tbody>
            </table>
        </div>

    </div>

</div>





<script type="text/javascript" charset="utf-8">
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#groups").change(function(){
            var status = this.value; $('#groupidselect').val(status);
            //alert(status);
            $.ajax({
                url: '{!!url("/systemrolesandgrouproles")!!}',
                type: "POST",
                data: {
                    groupid: status

                },
                success: function (data) {

                    var trHTML = '';

                    $('#listofsystemroles').empty();
                    $('#currentroles').empty();
                    $('today').empty();
                    $('btncurrentroles').empty();
                    $.each(data.userroles, function (key, value) {
                        trHTML += '<tr class="fast_remove"  style="font-size: 15px;color:black"><td><input type="checkbox" name="checkcurrentroles[]" value ="'+value.OptionDesc+'" style="height:18px !important;width:30px"></td><td>' +
                            value.OptionDesc+'</td></tr>';
                    });
                    $('#currentroles').append(trHTML);
                    var trHTML = '';
                    $.each(data.systemroles, function (key, value) {
                        trHTML += '<tr class="fast_remove"  style="font-size: 15px;color:black"><td><input type="checkbox" name="checksystemroles[]" value ="'+value.OptionDesc+'" style="height:18px !important;width:30px"></td><td>' +
                            value.OptionDesc +'</td></tr>';

                    });
                    $('#listofsystemroles').append(trHTML);
                    $('.today').append("<button id='addrole' class='btn-success btn-lg' style='background: darkblue;color: white;float: right;    padding: 13px;\n" +
                        "    border: 1px solid darkblue;\n" +
                        "    border-radius: 5px;\n" +
                        "    margin-top: 13px;\n" +
                        "}'>Update Roles</button>");
                    $('.btncurrentroles').append("<button id='removeroles' class='danger btn-lg' style='background: darkred;color: white;float: left;    padding: 13px;\n" +
                        "    border: 1px solid darkred;\n" +
                        "    border-radius: 5px;\n" +
                        "    margin-top: 13px;\n" +
                        "}'>Update Roles</button>");
                    $('#addrole').click(function(){

                        var rolenamesadd = new Array();
                        $.each($("input[name='checksystemroles[]']:checked"),
                            function () {
                                var data = $(this).parents('tr:eq(0)');

                                var description = data.find('td:eq(1)').text();
                                rolenamesadd.push({'description':description});
                            });

                        $.ajax({
                            url: '{!!url("/updateremoverole")!!}',
                            type: "POST",
                            data: {
                                groupid: $("#groupidselect").val(),
                                statement: "ADD",
                                theRole:rolenamesadd

                            },
                            success: function (data) {
                                location.reload();
                            }
                        });
                    });

                    $('#removeroles').click(function(){
                        var rolenamesremove = new Array();
                        $.each($("input[name='checkcurrentroles[]']:checked"),
                            function () {
                                var data = $(this).parents('tr:eq(0)');

                                var description = data.find('td:eq(1)').text();
                                rolenamesremove.push({'description':description});
                            });
                        $.ajax({
                            url: '{!!url("/updateremoverole")!!}',
                            type: "POST",
                            data: {
                                groupid: $("#groupidselect").val(),
                                statement: "REMOVE",
                                theRole:rolenamesremove
                            },
                            success: function (data) {
                                location.reload();
                            }
                        });
                    });

                }
            });

        });


    });


</script>
</body>
</html>
