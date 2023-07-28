<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Repository;


use App\Models\User;
use App\Service\GroupService;
use App\Service\UserService;
use Illuminate\Support\Facades\Auth;

class UserRepository extends CoreRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->setModel($user);
        $this->user = $user;
    }

    public function findWith($id, $relation)
    {
        return $this->user->with("$relation")->find($id);
    }

    public function get_all(){
        return $this->user->withTrashed()->get();
    }

    public function get_user_group(){
        return $this->user->withTrashed()->with('group')->get();
    }

    public function dataTable($access)
    {
        $data = new UserService($this);
        return $data->loadDataTable($access);
    }

}
