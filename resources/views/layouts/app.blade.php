<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Charset -->
    <meta charset="UTF-8">

    <!-- Viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Internet Explorer Compatibility -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Page Title -->
    <title>CRUD de Pessoas</title>

    <!-- Import Bootstrap -->
    <link rel="stylesheet" crossorigin="anonymous"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor">
</head>

<body>
    <h2 class="text-center bg-primary p-3">CRUD de Pessoas</h2>

    @yield('content')
</body>

</html>
