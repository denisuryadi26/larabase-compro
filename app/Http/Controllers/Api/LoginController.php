<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use JWTAuth;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get credentials from request
        $credentials = $request->only('username', 'password');

        //if auth failed
        /*if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Error Invalid Credential'
            ], 401);
        }

        if (auth()->guard('api')->user()->approval_status !== 'APPROVE')
        {
            return response()->json([
                'success' => false,
                'message' => 'Error Waiting Approval Customer'
            ], 403);
        }

        if (auth()->guard('api')->user()->group->code !== 'CUSTOMER')
        {
            return response()->json([
                'success' => false,
                'message' => 'Error Unauthorized Access'
            ], 403);
        }

        //if auth success
        auth()->guard('api')->user()->update([
            'access_token' => $token,
            'last_login' => Carbon::now()->format('Y-m-d H:i:s'),
            'is_online' => 'Y'
        ]);
        return response()->json([
            'success' => true,
            'token' => $token
        ], 200);*/


        //Request is validated
        //Crean token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
            ], 500);
        }

        $user = User::withoutTrashed()->where(['username' =>  $credentials['username']])->first();
        if ($user->approval_status != 'APPROVE')
        {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Forbidden Access, Waiting Approval Customer'
                ]
            ,403);
        }else{
            User::withoutTrashed()->where(['username' =>  $credentials['username']])->update([
                'last_login' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            //Token created, return with success response and jwt token
            return response()->json([
                'success' => true,
                'token' => $token,
            ]);
        }



    }
}