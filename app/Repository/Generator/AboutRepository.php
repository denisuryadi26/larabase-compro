<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Repository\Generator;

use App\Models\Generator\About;
use App\Service\Generator\AboutService;
use App\Repository\CoreRepository;

class AboutRepository extends CoreRepository
{
    protected $about;

    public function __construct(About $about)
    {
        $this->setModel($about);
        $this->about = $about;
    }

    public function findWith($id, $relation)
    {
        return $this->about->with("$relation")->find($id);
    }

    public function get_all(){
        return $this->about->withTrashed()->get();
    }

    public function dataTable($access)
    {
        $data = new AboutService($this);
        return $data->loadDataTable($access);
    }

}
