<!DOCTYPE html>
<html>
<head>
    <title>How to Generate QR Code in Laravel 8? - ItSolutionStuff.com</title>
</head>
<body>

<div class="visible-print text-center">
    {{$machine}}<br>
    {{$item}}<br>
    {!! QrCode::size(75)->generate($ID); !!}
    <br>
    {{$username}}


</div>

</body>
</html>
