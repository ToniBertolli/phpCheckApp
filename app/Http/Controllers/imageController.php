<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class imageController extends Controller
{
    public function index($path)
    {
        $image = Storage::get('/images/'.$path);
        $response = Response::make($image, 200);
        $response->header("Content-Type", "image/*");
        return $response;
    }
}
