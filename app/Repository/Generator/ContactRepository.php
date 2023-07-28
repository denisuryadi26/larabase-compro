<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Repository\Generator;

use App\Models\Generator\Contact;
use App\Service\Generator\ContactService;
use App\Repository\CoreRepository;

class ContactRepository extends CoreRepository
{
    protected $contact;

    public function __construct(Contact $contact)
    {
        $this->setModel($contact);
        $this->contact = $contact;
    }

    public function findWith($id, $relation)
    {
        return $this->contact->with("$relation")->find($id);
    }

    public function get_all(){
        return $this->contact->withTrashed()->get();
    }

    public function dataTable($access)
    {
        $data = new ContactService($this);
        return $data->loadDataTable($access);
    }

}
