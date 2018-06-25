<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data;

class SurplusOrDeficitChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:checksurplusordeficit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $d = Data::gather();
        #return var_dump($d);
        $used_so_far = $d['data_used'];
        // return $used_so_far;
        $recommended_so_far = $d['recommended_daily'] * $d['today'];
        $difference = $recommended_so_far - $used_so_far ;
        if ($difference >= 0) {
            echo ':arrow_up: ';
        } else {
            echo ':arrow_down: ';
        };
        echo abs($difference) . ' GB';
        if ($difference >= 0) {
            echo ' | color=green';
        } else {
            echo ' | color=red ';
        };

        echo PHP_EOL;
        echo '---';
        echo PHP_EOL;
        echo 'last checked: ' . $d['last_updated'];
    }
}
