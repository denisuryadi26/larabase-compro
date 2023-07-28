<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Repository;


use App\Service\MenuService;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class MenuRepository extends CoreRepository
{
    protected $menu;

    public function __construct(Menu $menu)
    {
        $this->setModel($menu);
    }

    public function saveAccess(array $data)
    {
        $service = new MenuService($this);
        return $service->updateGroupAccess($data);
    }

    public function dataTable($access)
    {
        $data = new MenuService($this);
        return $data->loadDataTable($access);
    }

    public function getAll()
    {
        return $this->all();
    }

    public function getParent()
    {
        return Menu::withoutTrashed()->where('parent_id', null)->get();
    }
}
