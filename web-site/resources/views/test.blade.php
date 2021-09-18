<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>xDev - Bem vindo!</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>
</head>
<body>
<div id="app">
    <navbar-component></navbar-component>

    <div class="container">
        Página principal!
    </div>
</div>

<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
