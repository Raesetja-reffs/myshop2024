<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/grid.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" type="text/css" />
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.select.min.js') }}"></script>

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

    </style>
</head>
<body style="font-family: Sans-serif">
    <div   style="font-family: sans-serif;">
        <a href='{!!url("/viewUserRole")!!}' style="    padding: 21px;
    font-weight: 900;
    text-decoration: underline;">View User Groups</a>
        <h2>All Users </h2>


            <div class="  clusterize-scroll table-container"  style="display: flex;" >
                <div  style="width: 100%;" >


                    <div style="padding-bottom: 4px;">
                        <label>
                            File Name:
                            <input type="text" id="fileName"/>
                        </label>
                        <label style="margin-left: 20px;">
                            Separator
                            <input type="text" style="width: 20px;" id="columnSeparator" value=","/>
                        </label>
                        <label style="margin-left: 20px;">
                            <button onclick="onBtExport()" style="background: #10f310;">Export to CSV</button>
                        </label>
                    </div>

                    <table style="display:none">
                        <tr>
                            <td valign="top">
                                <label style="margin-right: 20px;">
                                    <input type="checkbox" id="columnGroups"/>
                                    Column groups
                                </label>
                                <br/>
                                <label style="margin-right: 20px;">
                                    <input type="checkbox" id="useSpecificColumns"/>
                                    Specify Columns
                                </label>
                                <br/>
                                <label style="margin-right: 20px;">
                                    <input type="checkbox" id="allColumns"/>
                                    All Columns
                                </label>
                                <br/>
                                <label style="margin-right: 20px;">
                                    <input type="checkbox" id="onlySelected"/>
                                    Only Selected
                                </label>
                            </td>
                            <td valign="top">
                                <label style="margin-right: 20px;">
                                    <input type="checkbox" id="customHeader"/>
                                    Custom Header
                                </label>
                                <br/>
                                <label style="margin-right: 20px;">
                                    <input type="checkbox" id="customFooter"/>
                                    Custom Footer
                                </label>
                                <br/>
                                <label style="margin-right: 20px;">
                                    <input type="checkbox" id="skipHeader"/>
                                    Skip Header
                                </label>
                                <br/>
                                <label style="margin-right: 20px;">
                                    <input type="checkbox" id="skipFooters"/>
                                    Skip Footers
                                </label>
                            </td>
                            <td valign="top">
                                <label style="margin-right: 20px;">
                                    <input type="checkbox" id="useCellCallback"/>
                                    Use Cell Callback
                                </label>
                                <br/>
                                <label style="margin-right: 20px;">
                                    <input type="checkbox" id="suppressQuotes"/>
                                    Suppress Quotes
                                </label>
                                <br/>
                                <label style="margin-right: 20px;">
                                    <input type="checkbox" id="skipGroups"/>
                                    Skip Groups
                                </label>
                                <br/>
                                <label style="margin-right: 20px;">
                                    <input type="checkbox" id="skipGroupR"/>
                                    Skip Group R
                                </label>
                            </td>
                            <td valign="top">
                                <label style="margin-right: 20px;">
                                    <input type="checkbox" id="processHeaders"/>
                                    Format Headers
                                </label>
                                <br/>
                                <label style="margin-right: 20px;">
                                    <input type="checkbox" id="skipPinnedTop"/>
                                    Skip Pinned Top
                                </label>
                                <br/>
                                <label style="margin-right: 20px;">
                                    <input type="checkbox" id="skipPinnedBottom"/>
                                    Skip Pinned Bottom
                                </label>
                            </td>
                        </tr>
                    </table>


                    <div id="myGrid" style="height: 700px;width:95%;" class="ag-theme-balham"></div>
                </div>
                <div class="col-lg-4" >
                    <fieldset>
                        <legend style="border-bottom: 1px solid #0e0e0e;">User Info Update Screen</legend>
                    <label for="UserId">UserId</label><br>
                    <input type="text" id="UserId" name="UserId"  readonly><br>
                        <label for="UserName">User Name</label><br>
                    <input type="text" id="UserName" name="UserName"  ><br>
                    <label for="userRole">User Role</label><br>
                    <input type="text" id="userRole" name="userRole" style="background: red;color:white;font-weight: 900" readonly> <input type="hidden" id="userroleId" name="userroleId" ><br>
                        <label for="pincode">Loading/Picking Pin Code</label><br>
                        <input type="number" id="pincode" name="pincode" ><br><br>
                        <button class="btn-primary" id="updatepicode">Save User Info Changes</button>
                    </fieldset>

                    <fieldset>
                        <legend style="border-bottom: 1px solid #0e0e0e;">Password Update Screen</legend>
                    <label for="newpass">New Password</label><br>
                    <input type="text" id="newpass" name="newpass" ><br><br>
                    <button class="btn-primary" id="updatedatapass">Save Password</button>
                    </fieldset>
                </div>
            </div>
        </div>
    <div id="userroles" title="User Roles">
        <div class="col-lg-12">
            <div class="col-lg-4">
            <select name="selectedrole"  id="selectedrole">
                @foreach($group as $val)
                    <option value="{{$val->GroupId}}">{{$val->GroupName}}</option>
                @endforeach
            </select>
                <button class="btn-primary" id="updateroles">Update User Role</button>
            </div>
            <div class="col-lg-8">
                <h2>
                    Roles Explanations
                </h2>
                <table id="table_id" class="display">
                    <thead>
                    <tr>
                        <th>GroupID</th>
                        <th>GroupName</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($CustGrid as $val)
                    <tr>
                        <td>{{$val->GroupID}}</td>
                        <td>{{$val->GroupName}}</td>
                        <td>{{$val->OptionDesc}}</td>

                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<style>
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
        /*max-height: 600px;*/
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
        table = document.getElementById("table");
        tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[2];//column name index
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
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#pricingOnCustomer').hide();
        $('#callList').hide();
        $('#tabletLoadingApp').hide();
        $('#copyOrdersBtn').hide();
        $('#salesOnOrder').hide();
        $('#salesInvoiced').hide();
        $('#posCashUp').hide();
        $('#userroles').hide();
        //$('#table_id').DataTable();

       // $("#myGrid").empty();
      //  $('#myGrid').show();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        fetch('{!!url("/jsonGetUsers")!!}' , {'tableName': 'Tables'}).then(function (response) {
            return response.json();
        }).then(function (data) {

            var columnDefs = [];
            $.each(data[0], function (k, v) {
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
                enableColResize: true,
                onRowDoubleClicked: doSomething
            };
            new agGrid.Grid(gridDiv, gridOptions);

            gridOptions.api.setRowData(data);



        });

        //add this post header
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#table tbody').on('dblclick', 'tr', function () {
            // var productCode = $(this).find(".foo").val();
            var $this = $(this);
            var row = $this.closest("tr");

            var userName  = row.find(".userName").val();//
            var userId  = row.find(".userId ").val();//
            var group  = row.find(".group ").val();//
            var pinCode  = row.find(".pinCode ").val();//
            var groupid  = row.find(".groupid ").val();//

            $('#UserName').val(userName);
            $('#pincode').val(pinCode);
            $('#userRole').val(group);
            $('#UserId').val(userId);
            $('#userroleId').val(groupid);

        });

        $('#updatedatapass').click(function(){
            //newpass
            $.ajax({
                url: '{!!url("/updateuserpassword")!!}',
                type: "POST",
                data: {
                    userpass: $('#newpass').val(),
                    UserId: $('#UserId').val()
                },
                success: function (data) {
                    if(data == "true" || data == 1) {
                        var dialog = $('<p>Password Changed</p>').dialog({
                            height: 200, width: 700, modal: true, containment: false,
                            buttons: {
                                "OKAY": function () {
                                    dialog.dialog('close');
                                    location.reload(true);
                                }
                            }
                        });
                    }
                }
            });
        });
        //For User Info
        $('#updatepicode').click(function(){
                    //newpass
                    $.ajax({
                        url: '{!!url("/updateuserinfo")!!}',
                        type: "POST",
                        data: {
                            UserName: $('#UserName').val(),
                            UserId: $('#UserId').val(),
                            pincode: $('#pincode').val(),
                            groupid: $('#userroleId').val(),
                        },
                        success: function (data) {
                            // location.reload(true);
                            if(data == "true" || data == 1)
                            {
                                 $('#UserName').val("");
                                 $('#userId').val("");
                                 $('#pincode').val("");
                                 $('#userRole').val("");
                                 $('#userroleId').val("");
                                var dialog = $('<p>Data Saved.</p>').dialog({
                                    height: 200, width: 700, modal: true, containment: false,
                                    buttons: {
                                        "OKAY": function () {

                                            dialog.dialog('close');
                                            location.reload(true);

                                        }
                                    }
                                });
                            }
                        }
                    });
        });

        $('#updatefiltered').on('click',function() {
            alert('Click Ok to save');
            var valuesProd = new Array();
            $('#table > tbody  > tr').each(function() {
                // var Prodcost = $(data).find('.hiddenChanged_').val();
                //var codeID = $(this).find('#area_'+$(data).find('td:eq(0)').text()).val();
                valuesProd.push({
                    'userId':$(this).find('.userId').val(),
                    'password':$(this).find('.password').val(),
                    'userName':$(this).find('.userName').val(),
                    'pinCode':$(this).find('.pinCode').val(),
                    'admin':$(this).find('.admin').val(),
                    'pteam':$(this).find('.pteam').val(),
                    'loaders':$(this).find('.loaders').val(),
                    'group':$(this).find('.group').val(),
                });
            });
            $.ajax({
                url: '{!!url("/updateUsers")!!}',
                type: "POST",
                data: {
                    grid_Users: valuesProd
                },
                success: function (data) {
                    // location.reload(true);
                }
            });
        });
        //delete
        $('#table').on('click', 'button', function (e) {
            alert('Click Ok to Delete');
            var $this = $(this);
            var row_index = $this.closest('tr').index();
            var row_closestTrColumns = $this.closest('tr');
            // var orderLineID = $this.attr("value");
            var userVal = row_closestTrColumns.find('.UserID').val();
            $.ajax({
                url: '{!!url("/updateUser")!!}',
                type: "POST",
                data: {
                    UserID: userId
                },
                success: function (data) {
                    // location.reload(true);
                }
            });
        });

        $('#userRole').click(function(){
           if(($('#userRole').val()).length > 2) {
               $('#userroles').show();
               $("#userroles").dialog({
                   height: 600,
                   width: 900, containment: false
               }).dialogExtend({
                   "closable": true, // enable/disable close button
                   "maximizable": false, // enable/disable maximize button
                   "minimizable": true, // enable/disable minimize button
                   "collapsable": true, // enable/disable collapse button
                   "dblclick": "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
                   "titlebar": false, // false, 'none', 'transparent'
                   "minimizeLocation": "right", // sets alignment of minimized dialogues
                   "icons": { // jQuery UI icon class
                       "close": "ui-icon-circle-close",
                       "maximize": "ui-icon-circle-plus",
                       "minimize": "ui-icon-circle-minus",
                       "collapse": "ui-icon-triangle-1-s",
                       "restore": "ui-icon-bullet"
                   },
                   "load": function (evt, dlg) {
                   }, // event
                   "beforeCollapse": function (evt, dlg) {
                   }, // event
                   "beforeMaximize": function (evt, dlg) {
                   }, // event
                   "beforeMinimize": function (evt, dlg) {
                   }, // event
                   "beforeRestore": function (evt, dlg) {
                   }, // event
                   "collapse": function (evt, dlg) {
                   }, // event
                   "maximize": function (evt, dlg) {
                   }, // event
                   "minimize": function (evt, dlg) {
                   }, // event
                   "restore": function (evt, dlg) {
                   } // event
               });

               $('#updateroles').click(function () {
                   var selectedText = $("#selectedrole option:selected").html();
                   $('#userRole').val(selectedText);
                   $('#userroleId').val($("#selectedrole").val());
                   $('#userroles').dialog('close');

               });


           }

        });

        function doSomething(row){


            var userName  =row.data.UserName;
            var userId  = row.data.UserID;//
            var group  = row.data.GroupName;//
            var pinCode  = row.data.PinCode;//
            var groupid  = row.data.GroupID;//

            $('#UserName').val(userName);
            $('#pincode').val(parseInt(pinCode));
            $('#userRole').val(group);
            $('#UserId').val(userId);
            $('#userroleId').val(groupid);

           // window.open('{!!url("/customernoteshistory")!!}/'+customer, customer, "location=1,status=1,scrollbars=1, width=1500,height=850");

        }
    });
</script>
</body>
</html>
