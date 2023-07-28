<?php

/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Http\Controllers\Generator;

use App\Models\Generator\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CoreController;


use App\Repository\Generator\ServiceRepository;
use App\Service\Generator\ServiceService;
use App\Service\UploadHandler;


class ServiceController extends CoreController
{
    protected $menu;
    private $settingVal;
    protected $serviceRepository;
    protected $serviceService;

    public function __construct(ServiceRepository $serviceRepository, ServiceService $serviceService)
    {
        $this->menu = $this->get_menu();
        $this->serviceRepository = $serviceRepository;
        $this->serviceService = $serviceService;
        $this->settingVal = $this->get_all_setting();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.contents.service.index', [
            'menu' => ($this->menu ? $this->menu : ''),
            'setting' => ($this->settingVal ? $this->settingVal : '')
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
        // $validate = $this->serviceService->formValidate($request->all());
        // if ($validate) {
        //     return response()->json(
        //         $validate,
        //         200
        //     );
        // }
        $input = $request->all();
        // dd($input);
        $id = $input['id'];

        if ($request->hasFile('image')) {
            $image = $this->serviceService->insertFiles($uploadHandler, $this->serviceRepository->getModel(), $request, 'service', $id);
        } else {
            $image = $this->serviceService->find($id)->image;
        }
        $input['image'] = $image;
        // dd($input);
        $service = $this->serviceRepository->save($input);

        return response()->json([
            'status' => 'success',
            'message' => "Data is successfully  " . (is_object($service) == true ? 'added' : 'updated')
        ], 200);
    }

    public function destroy(Request $request)
    {
        $id  = $request->only('id');
        $service = $this->serviceRepository->destroy($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Data is successfully deleted'
        ], 200);
    }

    public function get(Request $request)
    {
        $id = $request->get('id');
        $data = $this->serviceRepository->find($id);

        return response()->json(['data' => $data], 200);
    }

    public function __datatable()
    {
        return $this->load_data_table($this->serviceRepository);
    }
}
