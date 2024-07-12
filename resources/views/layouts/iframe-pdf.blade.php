<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Title</title>
    <style>
        body,
        html {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden; /* Prevents scrollbars on the html/body */
        }

        iframe {
            display: block;
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>

<body>
    {{ $slot }}
</body>

</html>