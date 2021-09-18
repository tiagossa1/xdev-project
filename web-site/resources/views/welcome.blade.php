<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>
    <script type="module" src="{{ mix('js/app.js') }}"></script>
</head>
<body>
<div id="app">
    <NavbarComponent></NavbarComponent>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                Laravel
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    import NavbarComponent from "../js/components/NavbarComponent";

    export default {
        components: {NavbarComponent}
    }
</script>
