<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Repository\Generator;

use App\Models\Generator\Client;
use App\Service\Generator\ClientService;
use App\Repository\CoreRepository;

class ClientRepository extends CoreRepository
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->setModel($client);
        $this->client = $client;
    }

    public function findWith($id, $relation)
    {
        return $this->client->with("$relation")->find($id);
    }

    public function get_all(){
        return $this->client->withTrashed()->get();
    }

    public function dataTable($access)
    {
        $data = new ClientService($this);
        return $data->loadDataTable($access);
    }

}
