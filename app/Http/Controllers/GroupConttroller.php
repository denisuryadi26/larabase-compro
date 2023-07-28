<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */
namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Menu;
use App\Repository\GroupRepository;
use App\Service\GroupService;
use Illuminate\Http\Request;

class GroupConttroller extends CoreController
{
    protected $menu;
    private $settingVal;
    protected $groupRepository;
    protected $groupService;

    public function __construct(GroupRepository $groupRepository, GroupService $groupService)
    {
        $this->menu = $this->get_menu();
        $this->settingVal = $this->get_all_setting();
        $this->groupRepository = $groupRepository;
        $this->groupService = $groupService;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.contents.group.index',[
            'menu' => ($this->menu ? $this->menu : ''),
            'setting' => ( $this->settingVal ? $this->settingVal : ''),
            'access' => $this->user_access
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validate = $this->groupService->formValidate($request->all());
        if ($validate)
        {
            return response()->json(
                $validate
                ,200);
        }
        $input = $request->all();
        $group = $this->groupRepository->save($input);

        //add access when group not updated
        if (is_object($group)) $this->groupService->addAccess($group);

        return response()->json([
            'status'=> 'success',
            'message' => "Data is successfully  " . (is_object($group) == true ? 'added' : 'updated')
        ],200);
    }

    public function destroy(Request $request)
    {
        $id  = $request->only('id');
        $group = $this->groupRepository->destroy($id);
        $this->groupService->deleteAccess($group[0]);

        return response()->json([
            'status'=> 'success',
            'message' => 'Data is successfully deleted'
        ],200);
    }

    public function get(Request $request)
    {
        $id = $request->get('id');
        $data = $this->groupRepository->find($id);

        return response()->json(['data'=> $data ],200);
    }

    public function changeAccess(Request $request)
    {
        $params = $request->get('params');
        $update = $this->groupService->editAccess($params);
        if ($update == 1 ) return response()->json([
            'status'=> 'success',
            'message' => 'Access is successfully updated'
        ],200);
    }

    public function __datatable()
    {
        return $this->load_data_table($this->groupRepository);
    }

    public function __menuAccess(Request $request)
    {
        $groupId = $request->get('group_id');
        $data = Menu::withoutTrashed()->with('parent')->with('access', function ($q) use ($groupId){
            return $q->where('group_id', '=', $groupId);
        })->orderBy('menu_order','asc')->get();
        return $this->groupService->loadAccessDataTable($data);
    }


}
