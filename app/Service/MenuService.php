<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Service;


use App\Models\Group;
use App\Models\Menu;
use App\Repository\GroupRepository;
use App\Repository\MenuRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class MenuService extends CoreService
{
    protected $menuRepository;
    protected $groupRepository;

    public function __construct(MenuRepository $menuRepository, GroupRepository $groupRepository = null)
    {
        $this->menuRepository = $menuRepository;
        $this->groupRepository = $groupRepository;
    }

    public function formValidate($request)
    {
        $rules = [
            'code' => 'required|min:1|unique:conf_menu,code,NULL,id,deleted_at,NULL'
        ];
        $messages = [
            'code.unique' => 'Kode sudah terdaftar.',
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
        return $this->menuRepository->all();
    }

    public function updateGroupAccess(Array $data){
        //remove if null checked
        unset($data['update'],$data['delete']);
        foreach ($data as $item => $value){
            if ($value['id'] != null){
                DB::table('tbl_group_menus')
                    ->where(['id'=>$value['id']])
                    ->update($value);
            }else{
                unset($value['id']);
                DB::table('tbl_group_menus')->insert(
                    $value
                );
            }
        }
    }

    public function addAccess(Menu $menu)
    {
        $dataGroup = $this->groupRepository->getAll();
        foreach ($dataGroup as $item => $value)
        {
            $value->group_menu()->save($menu,['id' => Uuid::uuid4()->toString()]);
        }
    }

    public function getParent()
    {
        $model = Menu::with('parent')->withoutTrashed()->whereNull('parent_id')->where(['is_showed' => 1])->get();
        return $model;
    }

    public function loadDataTable($access){
        $model = Menu::with('parent')->withoutTrashed()->get();
        return $this->privilageBtnDatatable($model, $access);
    }

}
