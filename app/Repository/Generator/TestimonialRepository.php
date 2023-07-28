<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Repository\Generator;

use App\Models\Generator\Testimonial;
use App\Service\Generator\TestimonialService;
use App\Repository\CoreRepository;

class TestimonialRepository extends CoreRepository
{
    protected $testimonial;

    public function __construct(Testimonial $testimonial)
    {
        $this->setModel($testimonial);
        $this->testimonial = $testimonial;
    }

    public function findWith($id, $relation)
    {
        return $this->testimonial->with("$relation")->find($id);
    }

    public function get_all(){
        return $this->testimonial->withTrashed()->get();
    }

    public function dataTable($access)
    {
        $data = new TestimonialService($this);
        return $data->loadDataTable($access);
    }

}
