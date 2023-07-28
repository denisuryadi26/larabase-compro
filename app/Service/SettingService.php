<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Service;


use App\Models\Setting;
use App\Repository\SettingRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use UploadHandler;

class SettingService extends CoreService
{
    protected $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function formValidate($request)
    {
        $rules = [
            'parameter' => 'required|min:1|unique:conf_setting,parameter,NULL,id,deleted_at,NULL'
//            'id'  =>  'required|unique:conf_setting,id,'.$request['id']
        ];
        $messages = [
            'parameter.unique' => 'Parameter sudah terdaftar.',
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
        return $this->settingRepository->all();
    }

    public function insertFiles(
        $uploadHandler,
        Setting $setting,
        Request $request,
        $directory
    ) {
        $repository = $this->settingRepository;

        $files = collect($request->files->all())
            ->map(static function ($value) use ($uploadHandler , $setting , $repository , $request, $directory) {

                $upload = $uploadHandler->handle($value, $directory);
                $originalName =$value->getClientOriginalName();

                $setting->id = ($request->request->get('id'));
                $setting->parameter = ($request->request->get('parameter'));
                $setting->type = $request->request->get('type');
                if ($request->request->get('value') == ''){
                    $setting->value = $directory.'/'.$upload;
                }else{
                    $setting->value = $request->request->get('value');
                }
            });
        return $setting;
    }

    public function updateSettingAccess(Array $data){
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

    public function deleteFile($setting){
        if(\File::exists("upload/$setting->value")){
            \File::delete("upload/$setting->value");
        }else{
            dd('File does not exists.');
        }
    }

    public function loadDataTable($access){
        $model = Setting::withoutTrashed()->get();
        return $this->privilageBtnDatatable($model, $access);
    }

    public function get_all_setting()
    {
        $data = Setting::withoutTrashed()->whereIn('parameter',['logo','app_name','app_name_short','footer','bg_login'])->get();
        $result = [];
        foreach ($data as $val) {
            $result[$val->parameter] = $val->value;
        }

        return $result;
    }

}
