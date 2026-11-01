<!doctype html>
<html class="bg-white dark:bg-gray-950 scheme-light dark:scheme-dark">
    <head>
        <meta charset="UTF-8" name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />

        <title>Zarządzanie</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        @include('partials.navbar')
                        <div class="m-5 pt-20 mt-0">
                @yield('content')
            </div>
    </body>
</html>