<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Service;


use App\Models\Group;
use App\Repository\GroupRepository;
use App\Repository\MenuRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Ramsey\Uuid\Uuid;


class GroupService extends CoreService
{
    protected $groupRepository;
    protected $menuRepository;

    public function __construct(GroupRepository $groupRepository, MenuRepository $menuRepository = null)
    {
        $this->groupRepository = $groupRepository;
        $this->menuRepository = $menuRepository;
    }

    public function formValidate($request)
    {
        $rules = [
            'code' => 'required|min:1|unique:conf_group,code,NULL,id,deleted_at,NULL'
//            'id'  =>  'required|unique:conf_group,id,'.$request['id']
            ];
            $messages = [
                'code.unique' => 'Kode sudah terdaftar.',
            ];
            $validator = Validator::make($request, $rules, $messages);

        if (empty($request['id']))
        {
            if($validator->fails()){
                return [
                    'status'=> 'error',
                    'message' => $messages
                ];
            }
        }
        return 0;

    }

    public function all()
    {
        return $this->groupRepository->all();
    }

    public function addAccess(Group $group)
    {
        $dataMenu = $this->menuRepository->getAll();
        foreach ($dataMenu as $item => $value)
        {
            $value->access()->save($group,['id' => Uuid::uuid4()->toString()]);
        }
    }

    public function deleteAccess(Group $group)
    {
        $dataMenu = $this->menuRepository->getAll();
        foreach ($dataMenu as $item => $value)
        {
            $value->access()->detach($group,['id' => Uuid::uuid4()->toString()]);
        }
    }

    public function editAccess(array $param)
    {
        $pivot_id = $param['pivot_id'];
        $update = [$param['type'] => $param['value']];
        $data = DB::table('conf_group_menu')
            ->where(['id'=>$pivot_id],['deleted_at'=>null])
            ->update($update);
        return $data;
    }

    public function loadDataTable($access){
        $model = Group::withoutTrashed()->get();
        return $this->privilageBtnDatatable($model, $access);
    }

    public function loadAccessDataTable($data){
        $dataTable = Datatables::of($data)->addIndexColumn()
            ->addColumn('access_data', function($q) use($data) {
                $pivot = (count($q->access) > 0 ? json_decode($q->access[0]->pivot, TRUE) : []);
                return $pivot;
            })
            ->make(true);
        return $dataTable;
    }



}
