<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Repository\Generator;

use App\Models\Generator\Category;
use App\Models\Generator\CategorySub;
use App\Service\Generator\CategoryService;
use App\Repository\CoreRepository;

class CategoryRepository extends CoreRepository
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->setModel($category);
        $this->category = $category;
    }

    public function findWith($id, $relation)
    {
        return $this->category->with("$relation")->find($id);
    }

    public function get_all(){
        return $this->category->withTrashed()->get();
    }

    public function getSub($categoryId)
    {
        return CategorySub::withoutTrashed()->where(['category_id' => $categoryId])->get();
    }

    public function dataTable($access)
    {
        $data = new CategoryService($this);
        return $data->loadDataTable($access);
    }

}
