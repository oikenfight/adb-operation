<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Events\UploadScreenShot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

/**
 * Class OperationsController
 * @package App\Http\Controllers\Api
 */
final class OperationsController extends Controller
{
    const STORAGE_PATH = 'sdcard/';

    const LOCAL_STORAGE_PATH = './storage/images/';

    const POST_URL = 'http://127.0.0.1:8080/api/screen_shot';

    /**
     * @return int
     */
    public function screenShot()
    {
        $statusCode = Artisan::call('adb:screen_shot', [
            'storageDir' => self::STORAGE_PATH,
            'localStorageDir' => self::LOCAL_STORAGE_PATH,
            'url' => self::POST_URL,
        ]);

        return $statusCode == 0 ? 200 : 500;
    }

    /**
     * @param Request $request
     * @return int
     */
    public function uploadScreenShot(Request $request)
    {
        \Log::debug('here is uploadScreenShot method');
        $this->validate($request, [
            'image' => [
                'required',
                'file',
            ],
            'date' => [
                'required',
                'string',
                'size:8'
            ]
        ]);

        if ($request->file('image')->isValid()) {
            \Log::debug('valid');
            $filename = $request->file('image')->getClientOriginalName();
            $date = $request->input('date');

            $request->file('image')->storeAs('public/'.$date, $filename);
        } else {
            \Log::debug('invalid');
            \Log::debug($request);
            return 400;
        }

        // Websocket で upload された image をブラウザに表示
        event(new UploadScreenShot(str_replace('.png', '', $filename)));

        return 200;
    }
}
