<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class Back
 * @package App\Console\Commands
 */
final class Back extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adb:back';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'adb shell input keyevent back';

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
        $adbOperator->back();
        $adbOperator->screenShot($name);
    }
}
