<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Repository;


use App\Service\GroupService;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;

class GroupRepository extends CoreRepository
{
    protected $group;

    public function __construct(Group $group)
    {
        $this->setModel($group);
    }

    public function dataTable($access)
    {
        $data = new GroupService($this);
        return $data->loadDataTable($access);
    }

    public function getAll()
    {
        return $this->all();
    }
}
