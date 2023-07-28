<?php

/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Http\Controllers\Generator;

use App\Models\Generator\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CoreController;


use App\Repository\Generator\TeamRepository;
use App\Service\Generator\TeamService;
use App\Service\UploadHandler;


class TeamController extends CoreController
{
    protected $menu;
    private $settingVal;
    protected $teamRepository;
    protected $teamService;

    public function __construct(TeamRepository $teamRepository, TeamService $teamService)
    {
        $this->menu = $this->get_menu();
        $this->teamRepository = $teamRepository;
        $this->teamService = $teamService;
        $this->settingVal = $this->get_all_setting();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.contents.team.index', [
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
            $image = $this->teamService->insertFiles($uploadHandler, $this->teamRepository->getModel(), $request, 'team', $id);
        } else {
            $image = $this->teamService->find($id)->image;
        }
        $input['image'] = $image;
        $team = $this->teamRepository->save($input);

        return response()->json([
            'status' => 'success',
            'message' => "Data is successfully  " . (is_object($team) == true ? 'added' : 'updated')
        ], 200);
    }

    public function destroy(Request $request)
    {
        $id  = $request->only('id');
        $team = $this->teamRepository->destroy($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Data is successfully deleted'
        ], 200);
    }

    public function get(Request $request)
    {
        $id = $request->get('id');
        $data = $this->teamRepository->find($id);

        return response()->json(['data' => $data], 200);
    }

    public function __datatable()
    {
        return $this->load_data_table($this->teamRepository);
    }
}
