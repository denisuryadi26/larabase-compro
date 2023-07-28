<?php

/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Http\Controllers\Generator;

use App\Models\Generator\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CoreController;


use App\Repository\Generator\ClientRepository;
use App\Service\Generator\ClientService;
use App\Service\UploadHandler;


class ClientController extends CoreController
{
    protected $menu;
    private $settingVal;
    protected $clientRepository;
    protected $clientService;

    public function __construct(ClientRepository $clientRepository, ClientService $clientService)
    {
        $this->menu = $this->get_menu();
        $this->clientRepository = $clientRepository;
        $this->clientService = $clientService;
        $this->settingVal = $this->get_all_setting();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.contents.client.index', [
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
        // $validate = $this->sliderService->formValidate($request->all());
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
            $image = $this->clientService->insertFiles($uploadHandler, $this->clientRepository->getModel(), $request, 'client', $id);
        } else {
            $image = $this->clientService->find($id)->image;
        }
        $input['image'] = $image;
        $client = $this->clientRepository->save($input);

        return response()->json([
            'status' => 'success',
            'message' => "Data is successfully  " . (is_object($client) == true ? 'added' : 'updated')
        ], 200);
    }

    public function destroy(Request $request)
    {
        $id  = $request->only('id');
        $client = $this->clientRepository->destroy($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Data is successfully deleted'
        ], 200);
    }

    public function get(Request $request)
    {
        $id = $request->get('id');
        $data = $this->clientRepository->find($id);

        return response()->json(['data' => $data], 200);
    }

    public function __datatable()
    {
        return $this->load_data_table($this->clientRepository);
    }
}
