<!DOCTYPE html>
<html>
<head>
    <!-- ... -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- DevExtreme themes -->
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">

    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>


    <style>
        #grid {
            height: 440px;
        }

        .options {
            padding: 20px;
            margin-top: 20px;
            background-color: rgba(191, 191, 191, 0.15);
        }

        .caption {
            margin-bottom: 10px;
            font-weight: 500;
            font-size: 18px;
        }

        .option {
            margin-bottom: 10px;
        }

        .option > span {
            position: relative;
            top: 2px;
            margin-right: 10px;
        }

        .option > .dx-widget {
            display: inline-block;
            vertical-align: middle;
        }

        #requests .caption {
            float: left;
            padding-top: 7px;
        }

        #requests > div {
            padding-bottom: 5px;
        }

        #requests > div:after {
            content: "";
            display: table;
            clear: both;
        }

        #requests #clear {
            float: right;
        }

        #requests ul {
            list-style: none;
            max-height: 100px;
            overflow: auto;
            margin: 0;
        }

        #requests ul li {
            padding: 7px 0;
            border-bottom: 1px solid #dddddd;
        }

        #requests ul li:last-child {
            border-bottom: none;
        }

    </style>
</head>
<body class="dx-viewport" style="font-family: Sans-serif">
<h5 style="  color: white; ">Products</h5>

<div id="gridContainer">

</div>
<div class="row">
    <script type="text/javascript" charset="utf-8">
        $( document ).on( 'focus', ':input', function(){
            $( this ).attr( 'autocomplete', 'off' );
        });
        var clickTimer, lastRowClickedId;
        $(document).ready(function() {

            $(function(){
                var URL = "https://js.devexpress.com/Demos/Mvc/api/DataGridWebApi";

                var ordersStore = new DevExpress.data.CustomStore({
                    key: "OrderID",
                    load: function() {
                        return sendRequest(URL + "/Orders");
                    },
                    insert: function(values) {
                        return sendRequest(URL + "/InsertOrder", "POST", {
                            values: JSON.stringify(values)
                        });
                    },
                    update: function(key, values) {
                        return sendRequest(URL + "/UpdateOrder", "PUT", {
                            key: key,
                            values: JSON.stringify(values)
                        });
                    },
                    remove: function(key) {
                        return sendRequest(URL + "/DeleteOrder", "DELETE", {
                            key: key
                        });
                    }
                });

                var dataGrid = $("#grid").dxDataGrid({
                    dataSource: ordersStore,
                    repaintChangesOnly: true,
                    showBorders: true,
                    editing: {
                        refreshMode: "reshape",
                        mode: "cell",
                        allowAdding: true,
                        allowUpdating: true,
                        allowDeleting: true
                    },
                    scrolling: {
                        mode: "virtual"
                    },
                    columns: [{
                        dataField: "CustomerID",
                        caption: "Customer",
                        lookup: {
                            dataSource: {
                                paginate: true,
                                store: new DevExpress.data.CustomStore({
                                    key: "Value",
                                    loadMode: "raw",
                                    load: function() {
                                        return sendRequest(URL + "/CustomersLookup");
                                    }
                                })
                            },
                            valueExpr: "Value",
                            displayExpr: "Text"
                        }
                    }, {
                        dataField: "OrderDate",
                        dataType: "date"
                    }, {
                        dataField: "Freight"
                    }, {
                        dataField: "ShipCountry"
                    }, {
                        dataField: "ShipVia",
                        caption: "Shipping Company",
                        dataType: "number",
                        lookup: {
                            dataSource: new DevExpress.data.CustomStore({
                                key: "Value",
                                loadMode: "raw",
                                load: function() {
                                    return sendRequest(URL + "/ShippersLookup");
                                }
                            }),
                            valueExpr: "Value",
                            displayExpr: "Text"
                        }
                    }
                    ],
                    summary: {
                        totalItems: [{
                            column: "CustomerID",
                            summaryType: "count"
                        }, {
                            column: "Freight",
                            valueFormat: "#0.00",
                            summaryType: "sum"
                        }]
                    }
                }).dxDataGrid("instance");

                $("#refresh-mode").dxSelectBox({
                    items: ["full", "reshape", "repaint"],
                    value: "reshape",
                    onValueChanged: function(e) {
                        dataGrid.option("editing.refreshMode", e.value);
                    }
                });

                $("#clear").dxButton({
                    text: "Clear",
                    onClick: function() {
                        $("#requests ul").empty();
                    }
                });

                function sendRequest(url, method, data) {
                    var d = $.Deferred();

                    method = method || "GET";

                    logRequest(method, url, data);

                    $.ajax(url, {
                        method: method || "GET",
                        data: data,
                        cache: false,
                        xhrFields: { withCredentials: true }
                    }).done(function(result) {
                        d.resolve(method === "GET" ? result.data : result);
                    }).fail(function(xhr) {
                        d.reject(xhr.responseJSON ? xhr.responseJSON.Message : xhr.statusText);
                    });

                    return d.promise();
                }

                function logRequest(method, url, data) {
                    var args = Object.keys(data || {}).map(function(key) {
                        return key + "=" + data[key];
                    }).join(" ");

                    var logList = $("#requests ul"),
                        time = DevExpress.localization.formatDate(new Date(), "HH:mm:ss"),
                        newItem = $("<li>").text([time, method, url.slice(URL.length), args].join(" "));

                    logList.prepend(newItem);
                }
            });

        });


</script>
</div>
</body></html>