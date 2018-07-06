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
    public function handle(Operator $operator)
    {
        $arguments = $this->arguments();
        $text = $arguments['text'];

        $name = 'test.png';

        $operator->turnOnIfDisplayPowerOff();
        if ($operator->findKeyboard()) {
            $operator->input($text);
        } else {
            return 400;
        };
        $operator->screenShot($name);

        return 200;
    }
}
