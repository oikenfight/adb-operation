<?php
declare(strict_types=1);

namespace App\Console\Commands;

/**
 * Class Operation
 * @package App\Console\Commands
 */
final class AdbOperator
{
    const SCREEN_X_SIZE = 1020;

    const SCREEN_Y_SIZE = 1900;

    const ADB_STORAGE_DIR = '/sdcard/';

    const LOCAL_STORAGE_DIR = './storage/';

    const POST_URL = 'http://127.0.0.1:8080/api/screen_shot';

    /**
     * @var int
     */
    protected $maxX;

    /**
     * @var int
     */
    protected $maxY;

    /**
     * @var int
     */
    protected $x;

    /**
     * @var int
     */
    protected $y;

    /**
     * @var int
     */
    protected $toX;

    /**
     * @var int
     */
    protected $toY;

    /**
     * @param int $maxX
     * @param int $maxY
     * @return void
     */
    public function setMaxXY(int $maxX, int $maxY)
    {
        $this->maxX = $maxX;
        $this->maxY = $maxY;
    }

    /**
     * @param $x
     * @param $y
     * @return void
     */
    public function setXY($x, $y)
    {
        $this->x = intval(($x / $this->maxX) * self::SCREEN_X_SIZE);
        $this->y = intval(($y / $this->maxY) * self::SCREEN_Y_SIZE);
    }

    /**
     * @param $toX
     * @param $toY
     * @return void
     */
    public function setToXY($toX, $toY)
    {
        $this->toX = intval(($toX / $this->maxX) * self::SCREEN_X_SIZE);
        $this->toY = intval(($toY / $this->maxY) * self::SCREEN_Y_SIZE);
    }

    /**
     * 端末の画面が Off の場合 On にする（ロックなしの場合のみ）
     *
     * @return void
     */
    public function turnOnIfDisplayPowerOff()
    {
        $cmd = 'adb shell dumpsys power | grep state=';
        exec($cmd, $output, $return_var);
        if (!strpos($output[0], 'ON')) {
            exec('adb shell input keyevent 82');
            sleep(2);
        }
    }

    /**
     * @return void
     */
    public function back()
    {
        \Log::debug('input keyevent back');
        exec('adb shell input keyevent 4');
        sleep(1);
    }

    /**
     * @return void
     */
    public function enter()
    {
        \Log::debug('input keyevent enter');
        exec('adb shell input keyevent 66');
        sleep(1);
    }

    /**
     * @return void
     */
    public function home()
    {
        \Log::debug('input keyevent home');
        exec('adb shell input keyevent 3');
        sleep(1);
    }

    /**
     * 座標 (x, y) をタップする
     *
     * @return void
     */
    public function tap()
    {
        \Log::debug('tap');
        $cmd = sprintf("adb shell input touchscreen tap %s %s", $this->x, $this->y);
        exec($cmd, $output, $return_var);
        sleep(1);
    }

    /**
     * 座標 (x, y) から 座標 (toX, toY) にスワイプする
     *
     * @return void
     */
    public function swipe()
    {
        \Log::debug('swipe');
        $cmd = sprintf("adb shell input swipe %s %s %s %s", $this->x, $this->y, $this->toX, $this->toY);
        exec($cmd, $output, $return_var);
        sleep(1);
    }

    /**
     * @return bool|int
     */
    public function checkInputShown()
    {
        \Log::debug('check input (keyboard) is shown');
        $cmd = 'adb shell dumpsys input_method | grep mInputShown';
        exec($cmd, $output, $return_var);
        return strpos($output[0], 'mInputShown=true');
    }

    /**
     * @return bool
     */
    public function setAdbKeyboard()
    {
        \Log::debug('set AdbKeyBoard');
        $cmd = 'adb shell ime set com.android.adbkeyboard/.AdbIME';
        exec($cmd, $output, $return_var);
        return $output[0] == 'Input method com.android.adbkeyboard/.AdbIME selected';
    }

    /**
     * @param string $text
     *
     * @return int
     */
    public function input(string $text)
    {
        \Log::debug('input text');
        $cmd = "adb shell am broadcast -a ADB_INPUT_TEXT --es msg '". $text ."'";
        exec($cmd, $output, $return_var);
        sleep(1);
        return $return_var;
    }

    /**
     * スクリーンショットを撮影
     *
     * @return void
     */
    public function screenShot(string $name)
    {
        $this->takeAScreenShot($name);
        $this->pullScreenShotToLocal($name);
        $this->removeUsedFile($name);
    }

    /**
     * @param string $name
     */
    protected function takeAScreenShot(string $name)
    {
        \Log::debug('screen shot');
        $adbScreenShotPath = self::ADB_STORAGE_DIR . $name;
        exec(sprintf("adb shell screencap -p %s", $adbScreenShotPath), $output, $return_var);

        return $return_var;
    }

    /**
     * @param string $name
     */
    protected function pullScreenShotToLocal(string $name)
    {
        \Log::debug('pull screen shot');
        $adbScreenShotPath = self::ADB_STORAGE_DIR . $name;
        $localScreenShotPath = self::LOCAL_STORAGE_DIR . $name;
        exec(sprintf("adb pull %s %s", $adbScreenShotPath, $localScreenShotPath), $output, $return_var);
        return $return_var;
    }

    /**
     * @param string $name
     */
    protected function removeUsedFile(string $name)
    {
        \Log::debug('remove unused screen shot');
        $adbScreenShotPath = self::ADB_STORAGE_DIR . $name;
        $localScreenShotPath = self::LOCAL_STORAGE_DIR . $name;
        // exec(sprintf("adb shell rm %s && rm %s", $adbScreenShotPath, $localScreenShotPath));
        exec(sprintf("adb shell rm %s", $adbScreenShotPath), $output, $return_var);
        return $return_var;
    }
}