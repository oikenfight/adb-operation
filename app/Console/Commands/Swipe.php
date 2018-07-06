<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class Swipe
 * @package App\Console\Commands
 */
final class Swipe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adb:swipe {x} {y} {toX} {toY} {maxX} {maxY}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'swipe from position (x, y) to position (toX, toY) on android device screen';

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
    public function handle(Operator $operator)
    {
        $arguments = $this->arguments();
        $x = $arguments['x'];
        $y = $arguments['y'];
        $toX = $arguments['toX'];
        $toY = $arguments['toY'];
        $maxX = $arguments['maxX'];
        $maxY = $arguments['maxY'];

        $name = 'test.png';

        // setter
        $operator->setMaxXY((int)$maxX, (int)$maxY);
        $operator->setXY((int)$x, (int)$y);
        $operator->setToXY((int)$toX, (int)$toY);

        $operator->turnOnIfDisplayPowerOff();
        $operator->swipe();
        $operator->screenShot($name);

        return 200;
    }
}
