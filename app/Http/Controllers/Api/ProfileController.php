<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Service\Api\ProfileService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use function App\Helpers\clearToken;
use function App\Helpers\getUserByToken;

class ProfileController extends Controller
{
    //
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index(Request $request)
    {
        $profile = $this->profileService->getProfile($request);
        if($profile) {
            return response()->json([
                'success' => true,
                'data' => $profile->getCollect(),
            ], 201);
        }

        return response()->json([
            'success' => false,
            'data' => null,
        ], 409);

//        return ProfileResource::collection($profile);
    }

    public function store(ProfileRequest $request)
    {
        $input = $request->validated();
        $user = JWTAuth::parseToken()->authenticate();


        $profile = $this->profileService->save($user, $input);

        if($profile) {
            return response()->json([
                'success' => true,
                'data' => $profile,
                'message' => 'Success update profile',
            ], 201);
        }

        return response()->json([
            'success' => false,
            'data' => null,
            'message' => 'Error update profile'
        ], 409);
    }
}
