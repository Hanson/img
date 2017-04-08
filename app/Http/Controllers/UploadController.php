<?php

namespace App\Http\Controllers;

use Consatan\Weibo\ImageUploader\Client;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadController extends Controller
{

    public function upload(Request $request)
    {
        $weibo = new Client();
        /** @var UploadedFile $file */
        $file = $request->file;
        return $weibo->upload(fopen($file->getRealPath(), 'r'), config('services.weibo.username'), config('services.weibo.password'));
    }
}
