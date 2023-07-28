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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Service\CoreService;
use Tymon\JWTAuth\Facades\JWTAuth;
use function App\Helpers\clearToken;

class ProfileService extends CoreService
{
    protected $accessToken = '';

    public function __construct(Request $request)
    {
        $this->accessToken = clearToken($request->header('Authorization'));
    }

    public function getProfile($request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        return $user;
//        return User::with(['group','employee'])->where(['id' => $user->id])->get();

    }

    public function save(User $user, $input)
    {
        $dataInput = $this->reformatData($input);
//        dd($dataInput);

        try {
            $result = DB::transaction(function () use ($dataInput, $user) {
                $s = tap($user)->update($dataInput['user']);
                $e = tap($user->employee)->update($dataInput['employee']);
//                $employee = Employee::create($dataInput['employee']);
//                $user = User::create($dataInput['user']);
                $result = $s->getCollect();
                return $result;

            });
            return $result;

        } catch (\Exception $exception) {
            return false;
        }

    }

    function reformatData($input)
    {
        $user = [];
        $employee = [];
        $userArr = ['password', 'profile_picture', 'phone_number'];
        $employeeArr = [
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
                case 'profile_picture':
                    $image_path = $input["$val"]->store('image/customer', 'public');
                    $user[$val] = $image_path;
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



}
