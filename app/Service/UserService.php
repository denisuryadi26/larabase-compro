<?php

/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Service;


use App\Models\Group;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;

class UserService extends CoreService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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
        return $this->userRepository->all();
    }

    public function find($id, $relation = null)
    {
        return $this->userRepository->find($id, $relation);
    }

    public function loadDataTable($access)
    {
        $model = User::withoutTrashed()->with(['group'])->get();
        return $this->privilageBtnDatatable($model, $access);
    }



    public function insertFiles(
        $uploadHandler,
        User $user,
        Request $request,
        $directory = null,
        $userId = null
    ) {
        if ($userId) {
        } else {
        }

        if ($request->hasFile('fileUpload')) {
            $file = $request['fileUpload'];
            $filename = $directory . '/' . $this->random_string(20) . '.' . $file->extension();
            $file->storeAs("public/images/", $filename);
            return $filename;
        };
        return $user;
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
