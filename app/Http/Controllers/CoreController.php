<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CoreController extends Controller
{
    protected $user_access;
    protected $user_group_id;

    protected function __construct()
    {
        $this->middleware('auth');
    }

    public function get_all_setting()
    {
        $data = Setting::withoutTrashed()->whereIn('parameter', ['logo', 'app_name', 'app_name_short', 'footer', 'logo_icon'])->get();
        //        $data = Setting::withoutTrashed()->whereIn('parameter',['logo','app_name','footer','logo_icon'])->get();
        $result = [];
        foreach ($data as $val) {
            $result[$val->parameter] = $val->value;
        }

        return $result;
    }

    protected function get_menu()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->user_access = $this->set_user_access($this->user);
            return $next($request);
        });

        $menu = Menu::withTrashed()->whereNull('parent_id')->with('access')->with('childs.access')->orderBy('menu_order', 'ASC')->get();
        $m_url = url()->current();
        $url = explode('/', $m_url);
        unset($url[0], $url[1], $url[2]);

        // dd($m_url);
        $breadrumbs = get_breadcrumbs($m_url);
        return ['parentMenu' => $menu, 'breadcrumbs' => $breadrumbs];
    }

    protected function load_data_table($repository, $filter = null)
    {
        $user = Auth::user();
        //call to set user_access
        $access = $this->set_user_access($user);
        $activeUrl = explode('/datatable.json', url('/') . \Request::getRequestUri());
        if (!empty($this->user_access)) {
            //clear array access
            $access = array();
            foreach ($this->user_access as $item => $value) {
                //FOR CHILD MENU
                if ($value->parent_id != null) {
                    if ($activeUrl[0] == route("$value->route_name")) {
                        array_push($access, $value);
                    }
                }
                //FOR PARENT MENU IF HAS ROUTE VALUE
                else {
                    if ($value->route_name != null) {
                        if ($activeUrl[0] == route("$value->route_name")) {
                            array_push($access, $value);
                        }
                    }
                }
            }
        }
        return $repository->dataTable($access[0], $filter);
    }

    protected function set_user_access($user)
    {
        $this->user_group_id = $user->group_id;
        $this->user_access = DB::table('conf_group_menu as gp')->join('conf_menu as m', 'gp.menu_id', '=', 'm.id')
            ->select('*')->whereNull('gp.deleted_at')->where('gp.group_id', $this->user_group_id)->get();
        $activeUrl = url('/') . \Request::getRequestUri();

        if (!empty($this->user_access)) {
            foreach ($this->user_access as $item => $value) {

                //FOR CHILD
                if ($value->parent_id != null) {
                    if ($activeUrl == route("$value->route_name")) {
                        return $value;
                    }
                }
                //FOR PARENT MENU IF HAS ROUTE VALUE
                else {
                    if ($value->route_name != null) {
                        if ($activeUrl[0] == route("$value->route_name")) {
                            array_push($access, $value);
                        }
                    }
                }
            }
        } else {
            return null;
        }
    }
}
