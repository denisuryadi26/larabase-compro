<?php

/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Http\Controllers\Generator;

use App\Models\Generator\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CoreController;


use App\Repository\Generator\TestimonialRepository;
use App\Service\Generator\TestimonialService;
use App\Service\UploadHandler;


class TestimonialController extends CoreController
{
    protected $menu;
    private $settingVal;
    protected $testimonialRepository;
    protected $testimonialService;

    public function __construct(TestimonialRepository $testimonialRepository, TestimonialService $testimonialService)
    {
        $this->menu = $this->get_menu();
        $this->testimonialRepository = $testimonialRepository;
        $this->testimonialService = $testimonialService;
        $this->settingVal = $this->get_all_setting();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.contents.testimonial.index', [
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
            $image = $this->testimonialService->insertFiles($uploadHandler, $this->testimonialRepository->getModel(), $request, 'testimonial', $id);
        } else {
            $image = $this->testimonialService->find($id)->image;
        }
        $input['image'] = $image;
        $testimonial = $this->testimonialRepository->save($input);

        return response()->json([
            'status' => 'success',
            'message' => "Data is successfully  " . (is_object($testimonial) == true ? 'added' : 'updated')
        ], 200);
    }

    public function destroy(Request $request)
    {
        $id  = $request->only('id');
        $testimonial = $this->testimonialRepository->destroy($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Data is successfully deleted'
        ], 200);
    }

    public function get(Request $request)
    {
        $id = $request->get('id');
        $data = $this->testimonialRepository->find($id);

        return response()->json(['data' => $data], 200);
    }

    public function __datatable()
    {
        return $this->load_data_table($this->testimonialRepository);
    }
}
