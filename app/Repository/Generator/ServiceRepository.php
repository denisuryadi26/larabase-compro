<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Repository\Generator;

use App\Models\Generator\Service;
use App\Service\Generator\ServiceService;
use App\Repository\CoreRepository;

class ServiceRepository extends CoreRepository
{
    protected $service;

    public function __construct(Service $service)
    {
        $this->setModel($service);
        $this->service = $service;
    }

    public function findWith($id, $relation)
    {
        return $this->service->with("$relation")->find($id);
    }

    public function get_all(){
        return $this->service->withTrashed()->get();
    }

    public function dataTable($access)
    {
        $data = new ServiceService($this);
        return $data->loadDataTable($access);
    }

}
