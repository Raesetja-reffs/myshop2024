<script>
    $(document).ready(function() {
        const selectDeliveryDate = $("#selectDeliveryDate").dxDateBox({
            type: "date",
            label: "Date and time",
            displayFormat: 'yyyy-MM-dd',
            onValueChanged: function(e) {
                console.log(e.value);
                console.log(e.previousValue);
            },
        }).dxDateBox("instance");

        const selectRoute = $("#selectRoute").dxSelectBox({
            dataSource: [],
            valueExpr: "ID",
            displayExpr: "Name",
            label: "Route",
        });

        const selectType = $("#selectType").dxSelectBox({
            dataSource: [],
            valueExpr: "ID",
            displayExpr: "Name",
            label: "Type",
        });
        
        const popupGetStops = $("#popupGetStops").dxPopup({
            showTitle: true,
            title: 'Get Stops',
            footer: {
                text: "Copyright © 2024 My Company",
                showCancelButton: false,
                showConfirmButton: false
            },
            onHidden: function(e) {
                // selectPushed.option('value', null);
                // selectProhibited.option('value', null);
            },
            hideOnOutsideClick: false,
            showCloseButton: true,
            width: 600,
            height: 'auto',
            toolbarItems: [{
                    widget: 'dxButton',
                    toolbar: 'bottom',
                    location: 'after',
                    options: {
                        type: 'default',
                        stylingMode: 'contained',
                        icon: "fa fa-plus-circle",
                        text: "Get Stops",
                        onClick: function(args) {
                            console.log(args);
                        },
                    },
                },
            ],
        }).dxPopup("instance");

        const gridRoutes = $("#gridRoutes").dxDataGrid({
            dataSource: [], //as json
            showBorders: true,
            keyExpr: 'sequence',
            hoverStateEnabled: true,
            height: '78vh',
            filterRow: {
                visible: true
            },
            filterPanel: {
                visible: true
            },
            headerFilter: {
                visible: true
            },
            allowColumnResizing: true,
            columnAutoWidth: true,
            scrolling: {
                mode: 'virtual', // Enable infinite scrolling
            },
            paging: {
                pageSize: 10,
            },
            editing: {
                mode: 'row',
                allowUpdating: true,
            },
            columns: [{
                    type: 'buttons',
                    width: 50,
                    buttons: ['edit'],
                    fixed: true,
                },
                {
                    dataField: 'OrderId',
                    caption: 'ID',
                    visible: false,
                    allowEditing: false,
                },
                {
                    dataField: 'sequence',
                    caption: 'Seq',
                    allowEditing: false,
                },
                {
                    dataField: 'id',
                    caption: 'Store',
                    allowEditing: false,
                },
                {
                    dataField: 'lat',
                    caption: 'Latitude',
                    // visible: false,
                },
                {
                    dataField: 'lng',
                    caption: 'Longitude',
                    // visible: false,
                },
                {
                    dataField: 'latlng',
                    caption: 'LatLng',
                    visible: false,
                    calculateCellValue: function(data) {
                        return data.lat + ', ' + data.lng;
                    }
                },
                {
                    dataField: 'estimatedArrival',
                    caption: 'Estimated Arrival',
                    visible: false,
                },
                {
                    dataField: 'estimatedDeparture',
                    caption: 'Estimated Departure',
                    visible: false,
                },
            ],
            onEditingStart: function(e) {
                if (e.key == 0 || e.key == e.component.totalCount() - 1) {
                    e.cancel = true;
                    alert('Cannot Edit company details');
                } else {
                    gridRoute.columnOption('lat', 'visible', false);
                    gridRoute.columnOption('lng', 'visible', false);
                    gridRoute.columnOption('latlng', 'visible', true);
                }
            },
            onRowUpdating: function(e) {
                const newValues = e.newData;
                const latLngString = newValues
                    .latlng; // Assuming that you'll provide latitude and longitude as a single comma-separated string in this field
                const latLngArray = latLngString.split(', ');

                // Set latitude and longitude separately
                newValues.lat = latLngArray[0];
                newValues.lng = latLngArray[1];
            },
            onRowUpdated: function(e) {
                gridRoute.columnOption('lat', 'visible', true);
                gridRoute.columnOption('lng', 'visible', true);
                gridRoute.columnOption('latlng', 'visible', false);

                DevExpress.ui.dialog.confirm("Would you like to update the customer coordinates?",
                    "Confirmation").then((result) => {
                    if (result) {
                        $.ajax({
                            url: '{!! url('/updateCustomerGeoCoordinates') !!}',
                            type: "POST",
                            data: {
                                OrderId: e.data.OrderId,
                                lat: e.data.lat,
                                lng: e.data.lng

                            }, // No need to send data in the request body
                            success: function(response) {
                                DevExpress.ui.notify(
                                    'Customer Location Updated');
                            },
                            error: function(xhr, status, error) {
                                DevExpress.ui.notify(
                                    'Failed To Update Customer Location')
                            }
                        });
                    }
                });
            },
            onRowPrepared: function(e) {
                // Check if it's the first or last row by row index
                if (e.rowIndex === 0 || e.rowIndex === e.component.totalCount() - 1) {
                    // Add a custom CSS class to style the row
                    e.rowElement.addClass("non-draggable-row");

                    // Get the column drag handle elements
                    const dragHandles = e.rowElement.find(".dx-datagrid-drag-action");

                    // Disable column drag for this row by canceling the dragstart event
                    dragHandles.on("dragstart", function(event) {
                        event.preventDefault();
                    });
                }
            },
            onToolbarPreparing: function(e) {
                e.toolbarOptions.items.push({
                    location: 'before',
                    widget: "dxButton",
                    options: {
                        icon: "fa fa-plus-circle",
                        text: "Get Stops",
                        type: 'default',
                        stylingMode: 'contained',
                        onClick: function(args) {
                            popupGetStops.show();
                        },
                    },
                });
            }
        }).dxDataGrid('instance');

        var map = $('#mapRoutes').dxMap({
            center: {
                lat: -29.775910766803545,
                lng: 30.850251458392737
            },
            zoom: 17,
            EnableScrolling: false,
            EnableZooming: false,
            EnablePanning: false,
            provider: 'google',
            width: '100%',
            height: '78vh',
            apiKey: {
                google: "{{ env('GOOGLE_MAPS_API', 'NONE') }}",
            },
            // markers: markersData.map(marker => ({
            //     location: marker.location,
            //     iconSrc: 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" height="35" width="35" viewBox="0 0 384 512" fill="'+marker.color+'"><path d="M384 192c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192z"/><text x="50%" y="240" fill="white" font-size="200" font-family="Arial" font-weight="bold" text-anchor="middle" alignment-baseline="middle">'+marker.label+'</text></svg>',
            // })),
            // routes: routeData,
        }).dxMap('instance');
    });
</script>
