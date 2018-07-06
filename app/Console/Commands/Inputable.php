<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class Inputable
 * @package App\Console\Commands
 */
final class Inputable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adb:inputable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check whether the device is ready for input.';

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
     *
     * @return int
     */
    public function handle(AdbOperator $adbOperator)
    {
        $adbOperator->turnOnIfDisplayPowerOff();
        if (!$adbOperator->checkInputShown()) {
            return 400;
        }
        if (!$adbOperator->setAdbKeyboard()) {
            return 400;
        }
        return 200;
    }
}
