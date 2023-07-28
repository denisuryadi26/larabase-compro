<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Service\Generator;


use App\Models\Generator\About;
use App\Repository\Generator\AboutRepository;
use Illuminate\Support\Facades\Validator;
use App\Service\CoreService;

class AboutService extends CoreService
{
    protected $aboutRepository;

    public function __construct(AboutRepository $aboutRepository)
    {
        $this->aboutRepository = $aboutRepository;
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

        if($validator->fails()){
            return [
                'status'=> 'error',
                'message' => $messages
            ];
        }
        return 0;
    }

    public function all()
    {
        return $this->aboutRepository->all();
    }

    public function find($id, $relation = null)
    {
        return $this->aboutRepository->find($id, $relation);
    }

    public function loadDataTable($access){
        $model = About::withoutTrashed()->get();
        return $this->privilageBtnDatatable($model, $access);
    }
}
