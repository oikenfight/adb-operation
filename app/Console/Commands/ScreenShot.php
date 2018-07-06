<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ScreenShot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adb:screen_shot {storageDir} {localStorageDir} {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'take a android screen shot and post it.';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $storagePath;

    /**
     * @var string
     */
    protected $localStoragePath;

    /**
     * @var string
     */
    protected $url;

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
     * @param array $arguments
     *
     * @return void
     */
    protected function setConstant(array $arguments)
    {
        $this->name = date('Ymd_His') . '.png';
        $this->storagePath = $arguments['storageDir'] . $this->name;
        $this->localStoragePath = $arguments['localStorageDir'] . $this->name;
        $this->url = $arguments['url'];
    }

    /**
     * 端末の画面をオンにする（ロックなしの場合）
     *
     * @return void
     */
    protected function adbKeyCodeMenu()
    {
        shell_exec('adb shell input keyevent 82');
    }

    /**
     * スクリーンショットを撮影
     *
     * @return void
     */
    protected function screenShot()
    {
        shell_exec(sprintf("adb shell screencap -p %s", $this->storagePath));
    }

    /**
     * @return void
     */
    protected function pullScreenShotToLocal()
    {
        // TASK Controller からコマンドを呼んで実行するとローカルの /storage へのパスが見えないため pull できない

        // shell_exec(sprintf("adb pull %s %s", $this->storagePath, $this->localStoragePath));
        shell_exec(sprintf("adb pull %s %s", $this->storagePath, './'));
    }

    protected function postScreenShot()
    {
        // shell_exec(sprintf("curl POST -F image=@%s -F date=%s %s", $this->localStoragePath, date("Ymd"), $this->url));
    }

    protected function removeUsedFile()
    {
        // shell_exec(sprintf("adb shell rm %s && rm %s", $this->storagePath, $this->localStoragePath));
        shell_exec(sprintf("adb shell rm %s && rm %s", $this->storagePath, $this->name));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        // TASK: php から adb コマンドを叩いて post できるようにする

        // $this->setConstant($this->arguments());
        // $this->adbKeyCodeMenu();
        // \Log::debug('key code menu');
        // $this->screenShot();
        // \Log::debug('screen shot');
        // $this->pullScreenShotToLocal();
        // \Log::debug('pull screen shot');
        // $this->postScreenShot();
        // \Log::debug('post screen shot');
        // $this->removeUsedFile();
        return 0;
    }
}
