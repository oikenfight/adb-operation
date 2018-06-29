<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PostingScreenShots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adb:posting_screen_shot {storageDir} {localStorageDir} {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'take android screen shots and post these.';

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
     * @return void
     */
    public function handle()
    {
        $arguments = $this->arguments();
        $storageDir = $arguments['storageDir'];
        $localStorageDir = $arguments['localStorageDir'];
        $url = $arguments['url'];
        $cmd = sprintf("./app/Console/Commands/ShellScripts/screen_shot.sh %s %s %s", $storageDir, $localStorageDir, $url);

        while (true) {
            $result = shell_exec($cmd);
            print_r($result);
            sleep(3);
        }
    }
}
