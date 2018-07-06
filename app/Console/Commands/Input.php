<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Input extends Command
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
        if ($adbOperator->findKeyboard()) {
            $adbOperator->input($text);
        } else {
            return 400;
        };
        $adbOperator->screenShot($name);

        return 200;
    }
}
