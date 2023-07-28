<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */
namespace App\Http\Controllers;

use App\Models\Menu;
use App\Repository\MenuRepository;
use App\Service\MenuService;
use Illuminate\Http\Request;

class MenuController extends CoreController
{
    protected $menu;
    private $settingVal;
    protected $menuRepository;
    protected $menuService;

    public function __construct(MenuRepository $menuRepository, MenuService $menuService)
    {
        $this->menu = $this->get_menu();
        $this->settingVal = $this->get_all_setting();
        $this->menuRepository = $menuRepository;
        $this->menuService = $menuService;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
//        $parent  = $this->menuRepository->getParent();
        return view('admin.contents.menu.index', [
            'menu' => $this->menu,
//            'parent' => $parent,
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
        $input = $request->all();
        $menu = $this->menuRepository->save($input);

        if (is_object($menu)) $this->menuService->addAccess($menu);
        return response()->json([
            'status'=> 'success',
            'message' => "Data is successfully  " . (is_object($menu) == true ? 'added' : 'updated')
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $id  = $request->only('id');
        $this->menuRepository->destroy($id);

        return response()->json([
            'status'=> 'success',
            'message' => 'Data is successfully added'
        ],200);

    }

    public function get(Request $request)
    {
        $id = $request->get('id');
        $data = $this->menuRepository->find($id);

        return response()->json(['data'=> $data ],200);
    }

    public function getParent(Request $request)
    {
        $data = $this->menuService->getParent();
        return response()->json(['data'=> $data ],200);
    }


    public function __datatable()
    {
        return $this->load_data_table($this->menuRepository);
    }
}
