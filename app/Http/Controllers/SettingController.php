<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */
namespace App\Http\Controllers;

use App\Models\Setting;
use App\Repository\SettingRepository;
use App\Service\SettingService;
use App\Service\UploadHandler;
use Illuminate\Http\Request;

class SettingController extends CoreController
{
    protected $menu;
    protected $settingRepository;
    private $settingVal;
    protected $settingService;

    public function __construct(SettingRepository $settingRepository, SettingService $settingService)
    {
        $this->menu = $this->get_menu();
        $this->settingVal = $this->get_all_setting();
        $this->settingRepository = $settingRepository;
        $this->settingService = $settingService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
//        dd($this->settingVal);
        return view('admin.contents.setting.index',[
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
    public function store(Request $request, UploadHandler $uploadHandler)
    {
        $validate = $this->settingService->formValidate($request->all());
        if ($validate)
        {
            return response()->json(
                $validate
                ,200);
        }
        $input = $request->all();
        $files = $request->files->all();

        if ($files) {
            $setting = $this->settingService->insertFiles($uploadHandler , $this->settingRepository->getModel() , $request, 'setting');
        }else{
            if ($input['type'] == 'upload')
            {
                unset($input['value']);
            }
        }

        $setting = $this->settingRepository->save(($files ? $setting->getAttributes() : $input));
        return response()->json([
            'status'=> 'success',
            'message' => "Data is successfully  " . (is_object($setting) == true ? 'added' : 'updated')
        ],200);
    }

    public function destroy(Request $request)
    {
        $id  = $request->only('id');
        $setting = $this->settingRepository->destroy($id);

        if ($setting[0]->type == 'upload')
        {
            $this->settingService->deleteFile($setting[0]);
        }

        return response()->json([
            'status'=> 'success',
            'message' => 'Data is successfully added'
        ],200);
    }
    public function get(Request $request)
    {
        $id = $request->get('id');
        $data = $this->settingRepository->find($id);

        return response()->json(['data'=> $data ],200);
    }

    public function __datatable()
    {
        return $this->load_data_table($this->settingRepository);
    }


}
