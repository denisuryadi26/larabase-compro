<?php

/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Http\Middleware;

use App\Models\Menu;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $menu = Menu::withoutTrashed()->with('menu_access')->get();

        $user_group_id = Auth::user()->group_id;

        $actions = $request->route()->getAction();
        $action = url('/') . '/' . $actions['prefix'];

        foreach ($menu as $item => $value) {
            if ($value->parent != null) {
                if ($action == route("$value->route_name")) {
                    if ($value->menu_access[0]->pivot->is_viewable == 1) {
                        if ($value->menu_access[0]->pivot->is_updatable == 1) {
                            $update = 'true';
                        }
                        if ($value->menu_access[0]->pivot->is_deletable == 1) {
                            $delete = 'true';
                        }
                    } else {
                        return response()->view('error.forbidden');
                        //                        return abort(401, "Anda tidak mempunyai akses kehalaman ini");
                        //                    return redirect()->back();
                    }
                    return $next($request);
                }
            }
        }
        return $next($request);
    }
}
