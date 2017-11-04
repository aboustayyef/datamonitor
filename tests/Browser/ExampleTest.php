<?php

namespace Tests\Browser;

use App\Data;
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
            $browser->assertSee('Duration');

        });
    }
}
