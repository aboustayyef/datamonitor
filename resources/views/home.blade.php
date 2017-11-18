<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <link rel="stylesheet" type="text/css" href="/css/app.css">
        <title>Data Monitor</title>
    </head>

    <body>
        <div class="section">
            <script type="text/javascript" src="/js/app.js"></script>
            <div class="container">
                <h1 class="is-title is-size-1">Usage This Month</h1>
                <h2 class="is-subtitle is-size-6">Updated {{$usage['last_updated'] }}</h2>
                <hr>
                <h2 class="is-subtitle is-size-6"><strong>Data: </strong>{{$usage['data_used']}} / 200 GB</h2>
                <progress value="{{$usage['data_used']}}" max="200" class="progress is-{{$usage['data_status']}}"></progress>
                <h2 class="is-subtitle is-size-6"><strong>Days in month: </strong>{{$usage['today']}} / {{$usage['days_in_month']}}</h2>
                <progress value="{{$usage['today']}}" max="{{$usage['days_in_month']}}" class="progress"></progress>

                <nav class="level">
                  <div class="level-item has-text-centered">
                    <div>
                      <p class="heading">Recommended Daily</p>
                      <p class="title">{{ $usage['recommended_daily'] }} GB</p>
                    </div>
                  </div>
                  <div class="level-item has-text-centered">
                    <div>
                      <p class="heading">Actual Daily</p>
                      <p class="title @if ($usage['actual_daily'] > $usage['recommended_daily']) has-text-danger @endif">{{$usage['actual_daily'] }} GB</p>
                    </div>
                  </div>
                </nav>
            </div>
        </div>
        <div class="section">

          <div class="container">
          @include('tabs')
            <canvas id="myChart" width="400" height="400"></canvas>
            <script>
              var unit = '{{request()->get('timeframe')}}' == 'today' ? 'hour' : 'day';
              console.log('unit is: ' + unit);
              var ctx = document.getElementById("myChart");
              ctx.height = 200;
              var myChart = new Chart(ctx, {
                  type: 'line',
                  data: {
                      labels: {!!App\Data::hourlyDataSet(request()->get('timeframe'))['labels']->toJson()!!},
                      datasets: [{
                          label: 'Hourly Usage',
                          data: {{App\Data::hourlyDataSet(request()->get('timeframe'))['values']->toJson()}},
                      }]
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero:true
                              }
                          }],
                          xAxes: [{
                            type: 'time',
                            time: {
                              unit: unit,
                              tooltipFormat: 'MMM D, hA'
                            }
                          }]
                      }
                  }
              });
            </script>
          </div>
        </div>
    </body>
</html>
