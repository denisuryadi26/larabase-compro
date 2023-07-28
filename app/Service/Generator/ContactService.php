<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Service\Generator;


use App\Models\Generator\Contact;
use App\Repository\Generator\ContactRepository;
use Illuminate\Support\Facades\Validator;
use App\Service\CoreService;

class ContactService extends CoreService
{
    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
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
        return $this->contactRepository->all();
    }

    public function find($id, $relation = null)
    {
        return $this->contactRepository->find($id, $relation);
    }

    public function loadDataTable($access){
        $model = Contact::withoutTrashed()->get();
        return $this->privilageBtnDatatable($model, $access);
    }
}
