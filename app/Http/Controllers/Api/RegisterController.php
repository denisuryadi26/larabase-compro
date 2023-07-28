<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CheckNIKRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\RegisterResource;
use App\Models\User;
use App\Service\Api\RegisterService;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    protected $registerService;


    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;

    }
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $input = $request->validated();
        $register =  $this->registerService->registerCustomer($input);

        if($register) {
            return response()->json([
                'success' => true,
                'data' => $register,
                'message' => 'Success register agent',
            ], 201);
        }

        return response()->json([
            'success' => false,
            'data' => null,
            'message' => 'Error register agent'
        ], 409);
    }


    public function checkNIK(CheckNIKRequest $request)
    {
        $input = $request->validated();
        return response()->json([
            'success' => true,
            'message' => 'NIK available',
        ], 200);

    }

    public function UploadImage(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);
        dd($request->file('image'));
        $image_path = $request->file('image')->store('image/customer', 'public');
        dd($image_path);

//        $data = Image::create([
//            'image' => $image_path,
//        ]);

//        return response($data, Response::HTTP_CREATED);


    }



}