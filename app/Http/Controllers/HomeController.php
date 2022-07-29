<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
     public function  home(){
         $path = storage_path() . "/app/json/banner.json";
         $json = json_decode(file_get_contents($path));
         return view('home',['banners'=>$json]);
     }
}
