<?php

/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Service\Generator;


use App\Models\Generator\Service;
use App\Repository\Generator\ServiceRepository;
use Illuminate\Support\Facades\Validator;
use App\Service\CoreService;
use Symfony\Component\HttpFoundation\Request;
use Image;

class ServiceService extends CoreService
{
    protected $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function formValidate($request)
    {
        $rules = [
            //            'email' => 'required|min:1|unique:conf_users,email,NULL,id,deleted_at,NULL'
        ];
        $messages = [
            'email.unique' => 'Email sudah terdaftar.',
        ];
        $validator = Validator::make($request, $rules, $messages);

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'message' => $messages
            ];
        }
        return 0;
    }

    public function all()
    {
        return $this->serviceRepository->all();
    }

    public function find($id, $relation = null)
    {
        return $this->serviceRepository->find($id, $relation);
    }

    public function loadDataTable($access)
    {
        $model = Service::withoutTrashed()->get();
        return $this->privilageBtnDatatable($model, $access);
    }

    public function insertFiles(
        $uploadHandler,
        Service $service,
        Request $request,
        $directory = null,
        $serviceId = null
    ) {
        if ($serviceId) {
        } else {
        }

        if ($request->hasFile('image')) {
            // dd($request->file('image'));
            $file = $request['image'];
            $filename = $directory . '/' . date('Y-m-d') . '-' . $this->random_string(20) . '.' . $file->extension();

            $width = 320; // your max width
            $height = 320; // your max height
            $image = $request->file('image');
            $thumbImage = Image::make($image->getRealPath())->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $thumbPath = public_path() . '/storage/images/' . $filename;
            $thumbImage = Image::make($thumbImage)->save($thumbPath);
            return $filename;
        };
        return $service;
    }

    public function deleteFile($path)
    {
        if (\File::exists("storage/images/$path")) {
            \File::delete("storage/images/$path");
        } else {
            dd('File does not exists.');
        }
    }
}
