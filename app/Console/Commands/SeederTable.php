<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeederTable
{

    protected $command;


    public function __contruct($command)
    {
        $this->command = $command;
    }

    function seederMenu($name, $migration)
    {
        if ($migration)
        {
            $id = \Ramsey\Uuid\Uuid::uuid4()->toString();
            $arrDataSeeder = [
                'id' => $id,
                'name'=> strtoupper($name),
                'route_name' => "dashboard_".Str::plural(strtolower($name)),
                'menu_order' => 1000,
                'icon' => "",
                'code' => strtoupper($name),
                'is_showed' => 1,
                'created_by' => 'SYSTEM',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ];
            DB::table("conf_menu")->insert(
                $arrDataSeeder
            );
            $this->seederGroupMenu($id);

        }


    }

    function seederGroupMenu($menuId)
    {

        $group =  DB::table("conf_group")->get();

        if (!empty($group))
        {
            foreach ($group as $item => $value)
            {
                $arrGroupMenu = [
                    'id' =>  \Ramsey\Uuid\Uuid::uuid4()->toString(),
                    'group_id' => $value->id,
                    'menu_id' => $menuId,
                    'is_addable' => true,
                    'is_editable' => true,
                    'is_viewable' => true,
                    'is_deletable' => true,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                ];

                DB::table("conf_group_menu")->insert(
                    $arrGroupMenu
                );
            }
        }
    }

}