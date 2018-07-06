<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class Input
 * @package App\Console\Commands
 */
final class Input extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adb:input {text}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enter text when the device is ready for input.';

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
    public function handle(AdbOperator $adbOperator)
    {
        $arguments = $this->arguments();
        $text = $arguments['text'];

        $name = 'test.png';

        $adbOperator->turnOnIfDisplayPowerOff();
        $adbOperator->input($text);
        $adbOperator->screenShot($name);

        return 200;
    }
}
