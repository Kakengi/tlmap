<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    //
    public function download($filename)
    {
        $path = public_path('storage/books/' . $filename);
        return $this->content($path);
    }
    private function content($path)
    {
        if (!File::exists($path)) {;
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
}
