<?php

namespace Tests\Browser;

use App\Data;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://192.168.8.1/html/home.html')
                    ->press('#logout_span')
                    ->type('#username','admin')
                    ->type('#password', 'mm000741')
                    ->press('#pop_login')
                    ->waitForText('Log Out')
                    ->press('#statistic')
                    ->waitForText('Duration');
            $value = $browser->text('#month_used_value');
            $v = new Data;
            $v->value = (float) $value;
            $v->save();

            // Update Firebase
            $usage = Data::gather();
            $usageJson = collect([
                'last_updated'  =>  $usage['last_updated_absolute']->format('d/m/y H:i'),
                'data_used' =>  $usage['data_used'], // how many gbs have already been used (out of 200)
                'days_passed'   =>  $usage['today'], // numeric value of current day of month. Example 4
                'days_in_months'    =>  $usage['days_in_month'], // how many days this month has
                'recommended_daily' =>  $usage['recommended_daily'], // How much GB allowance per day is recommended
                'actual_daily'  =>  $usage['actual_daily']
            ])->toJson();

            // Do the Guzzle Stuff
            $client = new Client([
                'headers' => [ 'Content-Type' => 'application/json' ]
            ]);

            $response = $client->put('https://internet-balance-at-home.firebaseio.com/usage.json',
                ['body' => $usageJson]
            );

            $browser->assertSee('Duration');

        });
    }
}
