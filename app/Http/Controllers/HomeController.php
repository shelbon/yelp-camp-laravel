<?php

namespace App\Http\Controllers;


use ErrorException;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{

    public function home()
    {
        set_error_handler(
            function ($severity, $message, $file, $line) {
                throw new ErrorException($message, $severity, $severity, $file, $line);
            }
        );

         $banners=[];
        try {
            $json =  Storage::disk("public")->get('data/banners.json');
            $banners=array_merge($banners, json_decode($json, false, 512, JSON_THROW_ON_ERROR));
        } catch (\ErrorException|\JsonException  $e) {

        }
        return view('home', ['banners' => $banners]);
    }
}
