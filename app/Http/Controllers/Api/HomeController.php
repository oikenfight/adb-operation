<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Events\UploadScreenShot;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;

/**
 * Class ScreenShotController
 *
 * @package App\Http\Controllers
 */
final class HomeController extends Controller
{
    const SCREEN_SHOTS_PREFIX = 'public/';

    /**
     * @return array
     */
    public function index()
    {
        try {
            $paths = Storage::directories(self::SCREEN_SHOTS_PREFIX);
        } catch (FileNotFoundException $e) {
            \Log::debug('catch the error');
            \Log::debug($e->getMessage());
            $paths = [];
        }

        $dates = [];
        foreach ($paths as $path) {
            $dates[] = str_replace(self::SCREEN_SHOTS_PREFIX, '', $path);
        }

        return [
            'dates' => array_reverse($dates),
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function list(Request $request)
    {
        $date = $request->route('date');

        try {
            $paths = Storage::files(sprintf("%s%s/", self::SCREEN_SHOTS_PREFIX, $date));
        } catch (FileNotFoundException $e) {
            \Log::debug('catch the error');
            \Log::debug($e->getMessage());
            $paths = [];
        }

        $images = [];
        foreach ($paths as $path) {
            $image = str_replace(sprintf('%s%s/', self::SCREEN_SHOTS_PREFIX, $date), '', $path);
            $images[] = str_replace('.png', '', $image);
        }

        return [
            'images' => array_reverse($images),
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function show(Request $request)
    {
        $image = $request->route('image');
        $date = substr($image, 0, 8);

        $imagePath = sprintf("%s/%s.png", $date, $image);
        if (!Storage::exists(  self::SCREEN_SHOTS_PREFIX.$imagePath)) {
            $imagePath = '';
        }

        return [
            'imagePath' => $imagePath,
        ];
    }

    /**
     * @param Request $request
     * @return int
     */
    public function upload(Request $request)
    {
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
