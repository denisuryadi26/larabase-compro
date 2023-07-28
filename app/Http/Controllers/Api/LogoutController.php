<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;


class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        //remove token
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

//        dd($removeToken);
        if ($removeToken) {
            User::withoutTrashed()->where(['access_token' => JWTAuth::getToken()])->update([
                'access_token' => null
            ]);
            //return response JSON
            return response()->json([
                'success' => true,
                'message' => 'Logout Success!',
            ]);
        }
    }
}