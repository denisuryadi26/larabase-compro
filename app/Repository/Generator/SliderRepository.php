<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Repository\Generator;

use App\Models\Generator\Slider;
use App\Service\Generator\SliderService;
use App\Repository\CoreRepository;

class SliderRepository extends CoreRepository
{
    protected $slider;

    public function __construct(Slider $slider)
    {
        $this->setModel($slider);
        $this->slider = $slider;
    }

    public function findWith($id, $relation)
    {
        return $this->slider->with("$relation")->find($id);
    }

    public function get_all(){
        return $this->slider->withTrashed()->get();
    }

    public function dataTable($access)
    {
        $data = new SliderService($this);
        return $data->loadDataTable($access);
    }

}
