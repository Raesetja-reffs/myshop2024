<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @yield('title', env('APP_NAME')) </title>
    <link rel="icon" href="{{asset('images/dimslogo.png')}}" type="image/icon type">

    <!-- Bootstrap CSS  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>

    <!-- Bootstrap Select2 Theme CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

    <!-- DevExtreme theme Light-->
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/23.1.6/css/dx.material.blue.light.compact.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <style>
        .map-icon-label i {
            font-size: 24px;
            color: #FFFFFF;
            line-height: 55px;
            text-align: center;
            white-space: nowrap;
        }

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent dark background */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Ensure it's above other content */
            color: white;
        }

        :root {
            --point-color: White;
            --size: 5px;
        }

        .loader {
            background-color: var(--main-color);
            overflow: hidden;
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0; left: 0;
            display: flex;
            align-items: center;
            align-content: center; 
            justify-content: center;  
            z-index: 100000;
        }

        .loader__element {
            border-radius: 100%;
            border: var(--size) solid var(--point-color);
            margin: calc(var(--size)*1);
        }

        .loader__element:nth-child(1) {
            animation: preloader .6s ease-in-out alternate infinite;
        }
        .loader__element:nth-child(2) {
            animation: preloader .6s ease-in-out alternate .2s infinite;
        }

        .loader__element:nth-child(3) {
            animation: preloader .6s ease-in-out alternate .4s infinite;
        }

        @keyframes preloader {
            100% { transform: scale(1.3); }
        }
    </style>

</head>

<body class="vh-100 h-100">
    <div id="overlay" hidden>
        <div class="loader d-flex">
            <span class="loader__element"></span>
            <span class="loader__element"></span>
            <span class="loader__element"></span>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true" style="z-index: 9999 !important;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-3 border-danger">
                <div class="modal-header">
                    <h5 class="modal-title" id="authModalLabel">Special below margin, please authorize.</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeauthModal"></button>
                </div>
                <div class="modal-body">
                    <form id="AuthForm">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" placeholder="Enter username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter password">
                        </div>
                        <button type="submit" class="btn btn-danger mt-2">Authorize</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (Auth::guest())
        <script type="text/javascript">
            window.location = '{!!url("/")!!}';
        </script>
    @else
        @yield('page')
    @endif
</body>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

<!-- Jquery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>

<!-- DevExtreme library -->
<script type="text/javascript" src="https://cdn3.devexpress.com/jslib/23.1.6/js/dx.all.js"></script>

<!-- Select 2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!-- Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>

<!-- File Saver -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>

<!-- jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.0.0/jspdf.umd.min.js"></script>


<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('focus', ':input', function() {
        $(this).attr('autocomplete', 'off');
    });

    function authorize(userRole) {
        return new Promise(function(resolve, reject) {

            if (userRole !== "Admin") {
                // Show the login modal
                $('#authModal').modal('show');

                // Handle login form submission
                $('#AuthForm').submit(function(e) {
                    e.preventDefault(); // Prevent form submission

                    // Get entered username and password
                    var UserName = $('#username').val();
                    var Password = $('#password').val();

                    // Perform AJAX request to verify credentials
                    $.ajax({
                        url: '{!!url("/verifyAuthOnAdmin")!!}',
                        type: "POST",
                        data: {
                            userName: UserName,
                            userPassword: Password,
                        },
                        success: function(data) {
                            if ($.isEmptyObject(data)) {
                                alert("Wrong Credentials Or You don't have permissions, Please Try Again Or Talk to your manager!");
                                $('#authModal').modal('hide');
                                $('#username').val('');
                                $('#password').val('');
                                resolve(0); // Resolve with 0
                            } else {
                                $('#authModal').modal('hide');
                                $('#username').val('');
                                $('#password').val('');
                                resolve(1); // Resolve with 1
                            }
                        },
                        error: function() {
                            reject(new Error("AJAX request failed")); // Reject with an error
                        }
                    });
                });
            } else {
                resolve(approved); // Resolve with 0
            }
        });
    };

</script>


@yield('scripts')

</html>
