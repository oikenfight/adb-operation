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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tap(Request $request)
    {
        $result = Artisan::call('adb:tap', [
            'x' => $request->input('x'),
            'y' => $request->input('y'),
            'maxX' => $request->input('maxX'),
            'maxY' => $request->input('maxY'),
        ]);

        if ($result == 200) {
            return response()->json([
                'status' => 'success',
                'message' => 'タップしました。',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'タップに失敗しました。リロードしてからもう一度試してください。',
            ], 400);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function swipe(Request $request)
    {
        $result = Artisan::call('adb:swipe', [
            'x' => $request->input('x'),
            'y' => $request->input('y'),
            'toX' => $request->input('toX'),
            'toY' => $request->input('toY'),
            'maxX' => $request->input('maxX'),
            'maxY' => $request->input('maxY'),
        ]);

        if ($result == 200) {
            return response()->json([
                'status' => 'success',
                'message' => 'スワイプしました。',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'スワイプに失敗しました。リロードしてからもう一度試してください。',
            ], 400);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function inputable()
    {
        \Log::debug('here is inputable in contoller');
        $result = Artisan::call('adb:inputable');
        if ($result == 400) {
            return response()->json([
                'status' => 'error',
                'message' => '入力が可能な状態ではありません。操作し直してください。'
            ], 400);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'キーボード入力が可能です。'
        ],200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function input(Request $request)
    {
        $result = Artisan::call('adb:input', [
            'text' => $request->input('text'),
        ]);

        if ($result == 200) {
            return response()->json([
                'status' => 'success',
                'message' => 'テキストを入力しました。',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'テキストの入力に失敗しました。キーボード入力画面が表示されているか確認してください。',
            ], 400);
        }
    }
    
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
