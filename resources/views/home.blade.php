<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/css/app.css">
        <title>Data Monitor</title>
    </head>

    <body>
        <div class="section">
            <div class="container">
                <h1 class="is-title is-size-1">Usage This Month</h1>
                <hr>
                <h2 class="is-subtitle is-size-6">{{$usage}} / 200 GB</h2>
                <progress value="{{$usage}}" max="200" class="progress is-info">
            </div>
        </div>
    </body>
</html>
