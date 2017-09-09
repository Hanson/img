<?php

namespace App\Http\Controllers;

use Hanson\Face\Foundation\Face;
use Illuminate\Http\Request;

class FaceController extends Controller
{

    private $face;

    public function __construct()
    {
        $this->face = new Face();
    }

    public function index(Request $request)
    {
        $type = $request->get('faceType', 'score');

        switch ($type) {
            case 'score':
                return $this->face->score->get($request->get('url'));
            case 'bill':
                return $this->face->bill->get($request->get('url'));
            case 'popular':
                return $this->face->popular->get($request->get('url'));
            case 'relation':
                return $this->face->relation->get($request->get('url'));
            case 'clothing':
                return $this->face->clothing->get($request->get('url'));
            case 'poem':
                return $this->face->poem->get($request->get('url'));
        }
    }
}
