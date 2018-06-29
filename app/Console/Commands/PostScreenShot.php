<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PostScreenShot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adb:post_screen_shot {screenShotStoragePath} {tmpStoragePath} {postUrl}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'take a android screen shot and post it.';

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
        $arguments = $this->arguments();
        $cmd = sprintf("./app/Console/Commands/shell_scripts/post_screen_shot.sh %s %s %s", $arguments['screenShotStoragePath'], $arguments['tmpStoragePath'], $arguments['postUrl']);
        shell_exec($cmd);
        return;
    }
}
