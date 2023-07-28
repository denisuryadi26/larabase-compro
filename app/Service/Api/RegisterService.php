<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Service\Api;


use App\Models\Generator\Aux;
use App\Models\Generator\Employee;
use App\Models\Group;
use App\Models\User;
use App\Repository\Generator\AuxRepository;
use App\Service\UploadHandler;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Service\CoreService;
use Illuminate\Support\Str;

class RegisterService extends CoreService
{

    public function registerCustomer($input)
    {
        $dataInput = $this->reformatData($input);
        $group = Group::withoutTrashed()->where(['code' => 'CUSTOMER'])->first();

        try {
            $result = DB::transaction(function () use ($dataInput, $group) {
                $employee = Employee::create($dataInput['employee']);
                $dataInput['user']['group_id'] = $group->id;
                $dataInput['user']['employee_id'] = $employee->id;
                $user = User::create($dataInput['user']);
                $result = $user->getCollect();
                return $result;

            });
            return $result;

        } catch (\Exception $exception) {
            return false;
        }
    }

    function reformatData($input)
    {
//        dd($input);
        $user = [];
        $employee = [];
        $userArr = ['username', 'password', 'profile_picture', 'phone_number','approval_status'];
        $employeeArr = [
            'nik',
            'name',
            'age',
            'gender',
            'date_of_birth',
            'place_of_birth',
            'religion'
        ];

        foreach ($userArr as $item => $val) {
            switch ($val) {
                case 'password':
                    $user[$val] = Hash::make($input["$val"]);
                    break;
                case 'approval_status':
                    $user[$val] = "WAIT";
                    break;
                case 'profile_picture':
                    $file = $input["$val"];
                    $filename = 'images/customer/'.date('Y-m-d').'-'.$this->random_string(20).'.'.$file->extension();
                    $file->storeAs("public/", $filename);
                    $user[$val] = $filename;
                    break;
                default :
                    $user[$val] = $input["$val"];
            }
        }
        foreach ($employeeArr as $key => $value) {
            $employee[$value] = $input["$value"];
        }

        return [
            'user' => $user,
            'employee' => $employee
        ];
    }

    public function UploadImage($request)
    {
//        dd($request);
//        dd($request->file('image'));
        if ($request) {
            $this->validate($request, ['image' => 'required|image|mimes:jpg,png,jpeg,gif,svg']);
            $image_path = $request->file('image')->store('image/customer', 'public');

            $this->validate($request, ['photo' => 'required|file|image|mimes:jpeg,png,gif,svg']);
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName() . "." . $file->getClientOriginalExtension();
            $response = Storage::putFileAs('images', $file, Str::slug($filename));
            return $response;
//            response()->json([ 'message'=>'File uploaded', 'data'=> ['file'=>$response] ]);
        } else {
            $name = Str::random(15) . '.png';
            $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->input('photo')));
            Storage::put($name, $file);
            Storage::put($name, $file);

            $file = new File(public_path($name));
            $response = Storage::disk('s3')
                ->putFileAs('images', $file, $name);
            if ($response) {
                Storage::delete($name);
                return $response;
//                return response()->json(
//                    [
//                        'message'=>'File uploaded',
//                        'data'=> ['file'=> $response]
//                    ]);
            } else {
                return '';
//                return response()->json(['message'=>'Error uploading File',
//                    'data'=> ['file'=> $response]], 400);
            }
        }
    }

}
