<?php
/**
 * Created by Dibyaranjan Pradhan<dibyaranjanPradhan@globussoft.in>.
 * User: GLB-368
 * Date: 1/8/2018
 * Time: 3:13 PM
 */

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthenticationController extends Controller
{


    public function __construct()
    {
        $this->api_url = env('API_URL');
        $this->api_token = env('API_TOKEN');
    }

    public function login(Request $request)
    {
//        dd('hi hello inside api controller////');
        if($request->isMethod('post')){
//            dd('yes coming to post method of api controller........werwe..');

            return response()->json(['hello' => 'helo helo......'], 200);
//            return Response::json(['hello' => 'hello hi...'],200);
        }else{
            dd('else get request');
        }
    }
}