<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ env('APP_NAME', 'Laravel') }}</title>
        <link href="/css/app.css" rel="stylesheet">
        <link href="/css/all.css" rel="stylesheet">


    </head>

    <body>
        <div id="app"></div>

        <script src="/js/app.js"></script>
    </body>
</html>
