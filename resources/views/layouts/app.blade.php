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

<body class="vh-100">
    <div class="h-100 d-flex flex-column">
        <div class="d-flex px-3 py-2 bg-primary justify-content-between align-items-center">
            <h3 class="text-white m-0">CRUD de Pessoas</h3>

            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/create') }}">Nova Pessoa</a>
                </li>
            </ul>
        </div>

        <div class="flex-fill overflow-auto p-2">
            @yield('content')
        </div>

        @yield('footer')
    </div>

    <!-- JavaScript Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
</body>

</html>
