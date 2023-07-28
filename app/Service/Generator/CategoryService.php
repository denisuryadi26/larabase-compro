<?php

/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Service\Generator;


use App\Models\Generator\Category;
use App\Repository\Generator\CategoryRepository;
use Illuminate\Support\Facades\Validator;
use App\Service\CoreService;

class CategoryService extends CoreService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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
        return $this->categoryRepository->all();
    }

    public function find($id, $relation = null)
    {
        return $this->categoryRepository->find($id, $relation);
    }

    public function loadDataTable($access)
    {
        $model = Category::withoutTrashed()->get();
        return $this->privilageBtnDatatable($model, $access);
    }
}
