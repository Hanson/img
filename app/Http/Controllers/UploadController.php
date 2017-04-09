<?php

namespace App\Http\Controllers;

use Consatan\Weibo\ImageUploader\Client;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'file' => 'required|image'
        ]);

        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }

        $weibo = new Client();

        /** @var UploadedFile $file */
        $file = $request->file;

        try {
            $url = $weibo->upload(fopen($file->getRealPath(), 'r'), config('services.weibo.username'), config('services.weibo.password'));

            return $this->success($url);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    public function success($data = [], $code = 200)
    {
        return ['code' => $code, 'data' => $data];
    }

    public function fail($data = [], $code = 500)
    {
        return ['code' => $code, 'data' => $data];
    }
}
