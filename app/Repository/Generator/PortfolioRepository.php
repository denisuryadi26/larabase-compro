<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Repository\Generator;

use App\Models\Generator\Portfolio;
use App\Service\Generator\PortfolioService;
use App\Repository\CoreRepository;

class PortfolioRepository extends CoreRepository
{
    protected $portfolio;

    public function __construct(Portfolio $portfolio)
    {
        $this->setModel($portfolio);
        $this->portfolio = $portfolio;
    }

    public function findWith($id, $relation)
    {
        return $this->portfolio->with("$relation")->find($id);
    }

    public function get_all(){
        return $this->portfolio->withTrashed()->get();
    }

    public function dataTable($access)
    {
        $data = new PortfolioService($this);
        return $data->loadDataTable($access);
    }

}
