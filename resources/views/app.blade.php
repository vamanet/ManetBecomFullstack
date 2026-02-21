<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>IsMe</title>
    <title>{{ config('app.name', 'IsMe') }}</title>

    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body class="antialiased">
    <div id="app"></div>
</body>
</html>
