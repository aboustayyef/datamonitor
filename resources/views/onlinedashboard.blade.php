<!doctype html>
<html lang="@{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="@{{csrf_token()}}">
        <link rel="stylesheet" type="text/css" href="/css/app.css">
        <title>Data Monitor</title>
    </head>

    <body>
        
        <style>
          [v-cloak] > * { display:none }
          [v-cloak]::before { content: "loading…" }
        </style>

        <div id="app">
          <div class="section" v-cloak>
              <div class="container">
                <span v-if="status == 'loading' "><a class="button is-large is-white is-loading"></a></span>
                  <h1 class="is-title is-size-1">Usage This Month</h1>
                  <hr>
                  <h2 class="is-subtitle is-size-6"><strong>Data: @{{values.data_used}} </strong> / 200 GB</h2>
                  <progress :value="values.data_used" max="200" class="progress"></progress>
                  <h2 class="is-subtitle is-size-6"><strong>Days in month: </strong> @{{values.days_passed}}/@{{values.days_in_months}} </h2>
                  <progress :value="values.days_passed" :max="values.days_in_months" class="progress"></progress>

                  <nav class="level">
                    <div class="level-item has-text-centered">
                      <div>
                        <p class="heading">Recommended Daily</p>
                        <p class="title">@{{values.recommended_daily}} GB</p>
                      </div>
                    </div>
                    <div class="level-item has-text-centered">
                      <div>
                        <p class="heading">Actual Daily</p>
                        <p class="title">@{{values.actual_daily}} GB</p>
                      </div>
                    </div>
                  </nav>
                  <h2 class="is-subtitle is-size-6">Updated: @{{values.last_updated}} </h2>
              </div>
          </div>
        </div>
        <script type="text/javascript" src="/js/online.js"></script>
        
    </body>
</html>
