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
                  <h1 class="is-title is-size-1" style="font-weight:bold; line-height: 1">Usage This Month</h1>
                  <hr>
                  <h2 class="is-subtitle is-size-6"><strong>Cumulative Recommended: @{{values.data_used}} </strong> / @{{daily_target}} GB</h2>
                  <progress :value="values.data_used" :max="daily_target" class="progress"></progress>
                  <hr>
                  <h2 class="is-subtitle is-size-6"><strong>Used this month: @{{values.data_used}} </strong> / 200 GB</h2>
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
                    <div class="level-item has-text-centered">
                      <div v-if="values.data_used">
                        <p class="heading"><span v-if="values.data_used >= daily_target" class="tag is-warning">Deficit</span><span v-else class="tag is-info">Surplus</span></p>
                        <p class="title">@{{Math.abs(Number.parseFloat(values.data_used - daily_target).toPrecision(3))}} GB</p>
                      </div>
                    </div>
                    <div class="level-item has-text-centered">
                      <div v-if="values.data_used">
                        <p class="heading">Days left at this rate</p>
                        <p class="title">@{{Number.parseFloat((200 - values.data_used)/values.actual_daily).toPrecision(3)}} days</p>
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
