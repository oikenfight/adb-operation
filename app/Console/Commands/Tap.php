<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class Tap
 * @package App\Console\Commands
 */
final class Tap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adb:tap {x} {y} {maxX} {maxY}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'tap position x, y on android device screen';

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
     * @return int
     */
    public function handle(AdbOperator $adbOperator)
    {
        $arguments = $this->arguments();
        $x = $arguments['x'];
        $y = $arguments['y'];
        $maxX = $arguments['maxX'];
        $maxY = $arguments['maxY'];

        $name = 'test.png';

        // setter
        $adbOperator->setMaxXY((int)$maxX, (int)$maxY);
        $adbOperator->setXY((int)$x, (int)$y);

        // operate
        $adbOperator->turnOnIfDisplayPowerOff();
        $adbOperator->tap();
        $adbOperator->screenShot($name);

        return 200;
    }
}
