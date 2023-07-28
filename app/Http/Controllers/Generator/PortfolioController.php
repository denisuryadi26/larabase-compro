<?php

/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Http\Controllers\Generator;

use App\Models\Generator\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CoreController;


use App\Repository\Generator\PortfolioRepository;
use App\Service\Generator\PortfolioService;
use App\Service\UploadHandler;


class PortfolioController extends CoreController
{
    protected $menu;
    private $settingVal;
    protected $portfolioRepository;
    protected $portfolioService;

    public function __construct(PortfolioRepository $portfolioRepository, PortfolioService $portfolioService)
    {
        $this->menu = $this->get_menu();
        $this->portfolioRepository = $portfolioRepository;
        $this->portfolioService = $portfolioService;
        $this->settingVal = $this->get_all_setting();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.contents.portfolio.index', [
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
            $image = $this->portfolioService->insertFiles($uploadHandler, $this->portfolioRepository->getModel(), $request, 'portfolio', $id);
        } else {
            $image = $this->portfolioService->find($id)->image;
        }
        $input['image'] = $image;
        $portfolio = $this->portfolioRepository->save($input);

        return response()->json([
            'status' => 'success',
            'message' => "Data is successfully  " . (is_object($portfolio) == true ? 'added' : 'updated')
        ], 200);
    }

    public function destroy(Request $request)
    {
        $id  = $request->only('id');
        $portfolio = $this->portfolioRepository->destroy($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Data is successfully deleted'
        ], 200);
    }

    public function get(Request $request)
    {
        $id = $request->get('id');
        $data = $this->portfolioRepository->find($id);

        return response()->json(['data' => $data], 200);
    }

    public function __datatable()
    {
        return $this->load_data_table($this->portfolioRepository);
    }
}
