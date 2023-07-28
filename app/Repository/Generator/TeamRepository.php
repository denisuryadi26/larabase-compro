<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Repository\Generator;

use App\Models\Generator\Team;
use App\Service\Generator\TeamService;
use App\Repository\CoreRepository;

class TeamRepository extends CoreRepository
{
    protected $team;

    public function __construct(Team $team)
    {
        $this->setModel($team);
        $this->team = $team;
    }

    public function findWith($id, $relation)
    {
        return $this->team->with("$relation")->find($id);
    }

    public function get_all(){
        return $this->team->withTrashed()->get();
    }

    public function dataTable($access)
    {
        $data = new TeamService($this);
        return $data->loadDataTable($access);
    }

}
