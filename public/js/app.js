$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function(xhr) {
            $(".general-loader").show();
        },
        complete: function(xhr, status) {
            $(".general-loader").hide();
        },
        error: function(xhr, status, error) {
            if (status !== 'abort') {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                } else if(xhr.responseText && xhr.responseText) {
                    message = xhr.responseText;
                } else {
                    message = error;
                }
                showAlert('danger', message, 10000);
            }
        }
    });
    $(document).ajaxSend(function(event, xhr, settings) {
        $(".general-loader").show();
    });

    $(document).ajaxComplete(function(event, xhr, settings) {
        $(".general-loader").hide();
    });

    //On hover, toggle the "active" class
    $(document).on("mouseenter", ".flexdatalist-results li", function() {
        $(this).addClass("active");
    });

    $(document).on("mouseleave", ".flexdatalist-results li", function() {
        $(this).removeClass("active");
    });

    $.ui.dialog.prototype.options.open = function() {
        $(".general-loader").hide();
        $(this).closest(".ui-dialog")
        .find(".ui-dialog-titlebar-close")
        .html("<span style='margin: 0px;' class='ui-icon ui-icon-circle-close' title='close'></span>");
        $(this).closest(".ui-dialog")
        .find(".ui-dialog-titlebar-close").css({"border-radius": "2px", "height": "18px", "border": "1px solid #c5c5c5"});
    };

    // Call the function initially and then update every second
    dims24_updateDateTime();
    setInterval(dims24_updateDateTime, 1000);
    $(document).on('click', 'form button[type="submit"]', function() {
        $(this).attr("data-kt-indicator", "on");
    });
});

function showAlert(type, message, timeout = 3000) {
    $("#kt_content_container").prepend(`
        <div class="alert alert-${type} d-flex align-items-center p-1 mt-5 mb-0">
            <i class="ki-outline  ki-shield-tick fs-2hx text-${type} me-2"></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-${type}">${message}</h4>
            </div>
            <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert" fdprocessedid="g4ghrt">
                <i class="ki-outline ki-cross fs-2x text-${type}"></i>
            </button>
        </div>
    `);
    setTimeout((type) => {
        if ($("#kt_content_container").find('div.alert.alert-' + type).length > 0) {
            $("#kt_content_container").find('div.alert.alert-' + type).remove();
        }
    }, timeout, type);
}
function dims24_updateDateTime() {
    var currentDateTime = new Date();
    $("#current_datetime_display span").html(dims24_formatDateToCustomFormat(currentDateTime));
}

function dims24_formatDateToCustomFormat(date) {
    var year = date.getFullYear();
    var month = (date.getMonth() + 1).toString().padStart(2, '0');
    var day = date.getDate().toString().padStart(2, '0');

    return day + '-' + month + '-' + year + ' ' + date.toLocaleTimeString();
}

function isFloatNumber(item,evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode==46)
    {
        var regex = new RegExp(/\./g)
        var count = $(item).val().match(regex).length;
        if (count > 1)
        {
            return false;
        }
    }
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
function showErrorDialog(message, showCancelButton)
{
    return Swal.fire({
        html: `<p style="color:var(--bs-danger);">${message}</p>`,
        color: '#716add',
        icon: 'error',
        buttonsStyling: false,
        showCancelButton: showCancelButton,
        confirmButtonText: 'Okay',
        cancelButtonText: 'Cancel',
        customClass: {
            confirmButton: 'btn btn-primary btn-auto-height',
            cancelButton: 'btn btn-danger btn-auto-height'
        }
    });
}
