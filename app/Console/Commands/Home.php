<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Home extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adb:home';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'adb shell input keyevent home';

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
     * @param AdbOperator $adbOperator
     * @return void
     */
    public function handle(AdbOperator $adbOperator)
    {
        $name = 'test.png';

        $adbOperator->turnOnIfDisplayPowerOff();
        $adbOperator->home();
        $adbOperator->screenShot($name);
    }
}
