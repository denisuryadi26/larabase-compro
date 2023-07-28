<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Repository;


use App\Service\SettingService;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class SettingRepository extends CoreRepository
{
    protected $setting;

    public function __construct(Setting $setting)
    {
        $this->setModel($setting);
    }

    public function saveAccess(array $data)
    {
        $service = new SettingService($this);
        return $service->updateSettingAccess($data);
    }

    public function dataTable($access)
    {
        $data = new SettingService($this);
        return $data->loadDataTable($access);
    }

    public function getAll()
    {
        return $this->all();
    }

    public function get_all_setting()
    {
        $data = Setting::withoutTrashed()->whereIn('parameter',['logo','app_name','app_name_short','footer','logo_icon'])->get();
//        $data = Setting::withoutTrashed()->whereIn('parameter',['logo','app_name','footer','logo_icon'])->get();
        $result = [];
        foreach ($data as $val) {
            $result[$val->parameter] = $val->value;
        }

        return $result;
    }
}
