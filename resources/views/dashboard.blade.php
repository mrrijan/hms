<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HMS</title>
    @vite('resources/css/app.css')
</head>
<body class="sidebar-mini layout-fixed sidebar-collapse">
<div id="app"></div>
@vite('resources/js/src/main.js')
</body>
</html>

