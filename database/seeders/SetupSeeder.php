<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class SetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groupArr = [
            [
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'code' => 'SPRADM',
                'name' => 'Super Admin',
                'created_by' => 'SYSTEM',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by' => 'SYSTEM'
            ],
            [
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'code' => 'ADM',
                'name' => 'Admin',
                'created_by' => 'SYSTEM',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by' => 'SYSTEM'
            ],
        ];
        $group = $this->insertRecord($groupArr, 'conf_group');

        $menuParentArr = [
            [
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'parent_id' => null,
                'code' => 'DASHBOARD',
                'name' => 'Dashboard',
                'menu_order' => 1000,
                'icon' => 'feather icon-home',
                'route_name' => 'dashboard',
                'is_showed' => true,
                'created_by' => 'SYSTEM',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by' => 'SYSTEM'
            ],
            [
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'parent_id' => null,
                'code' => 'ADMININSTRATOR',
                'name' => 'Administrator',
                'menu_order' => 10000,
                'icon' => 'feather icon-settings',
                'route_name' => null,
                'is_showed' => true,
                'created_by' => 'SYSTEM',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by' => 'SYSTEM'
            ],
            [
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'parent_id' => null,
                'code' => 'PROFILE',
                'name' => 'PROFILE',
                'menu_order' => 100000,
                'icon' => '-',
                'route_name' => 'dashboard_profile',
                'is_showed' => false,
                'created_by' => 'SYSTEM',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by' => 'SYSTEM'
            ],
        ];
        $menu = $this->insertRecord($menuParentArr, 'conf_menu', true);

        $menuArr = [
            [
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'parent_id' => $menu[1],
                'code' => 'USER',
                'name' => 'User',
                'menu_order' => 11000,
                'icon' => '',
                'route_name' => 'dashboard_user',
                'is_showed' => true,
                'created_by' => 'SYSTEM',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by' => 'SYSTEM'
            ],
            [
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'parent_id' => $menu[1],
                'code' => 'GROUP',
                'name' => 'Group',
                'menu_order' => 12000,
                'icon' => '',
                'route_name' => 'dashboard_group',
                'is_showed' => true,
                'created_by' => 'SYSTEM',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by' => 'SYSTEM'
            ],
            [
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'parent_id' => $menu[1],
                'code' => 'MENU',
                'name' => 'Menu',
                'menu_order' => 13000,
                'icon' => '',
                'route_name' => 'dashboard_menu',
                'is_showed' => true,
                'created_by' => 'SYSTEM',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by' => 'SYSTEM'
            ],
            [
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'parent_id' => $menu[1],
                'code' => 'SETTING',
                'name' => 'Setting',
                'menu_order' => 15000,
                'icon' => '',
                'route_name' => 'dashboard_setting',
                'is_showed' => true,
                'created_by' => 'SYSTEM',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by' => 'SYSTEM'
            ],
        ];
        $menuChild = $this->insertRecord($menuArr, 'conf_menu', true);

        $menuId = array_merge($menu, $menuChild);
        foreach ($group as $value) {
            foreach ($menuId as $val)
            {
                $record[] =
                    [
                        'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                        'group_id' => $value,
                        'menu_id' => $val,
                        'is_addable' => true,
                        'is_editable' => true,
                        'is_viewable' => true,
                        'is_deletable' => true,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ];
            }
        }
        $this->insertRecord($record, 'conf_group_menu');

        $usersArr = [
            [
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'group_id' => $group[0],
                'fullname' => 'Super Admin',
                'username' => 'spradmin',
                'password' => Hash::make('secret'),
                'email' => 'spradmin@gmail.com',
                'created_by' => 'SYSTEM',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by' => 'SYSTEM'
            ],
            [
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'group_id' => $group[1],
                'fullname' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('secret'),
                'email' => 'admin@gmail.com',
                'created_by' => 'SYSTEM',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by' => 'SYSTEM'
            ]
        ];
        $this->insertRecord($usersArr, 'conf_users');

        $settingArr = [
            [
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'parameter' => 'super_password',
                'type' => 'text',
                'value' => 'larabase123',
                'created_by' => 'SYSTEM',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by' => 'SYSTEM'
            ],
            [
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'parameter' => 'logo',
                'type' => 'text',
                'value' => 'setting/ceca63c1baf77c9cc635fdf9af4ef331.png',
                'created_by' => 'SYSTEM',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by' => 'SYSTEM'
            ],
            [
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'parameter' => 'app_name',
                'type' => 'text',
                'value' => 'LARABASE',
                'created_by' => 'SYSTEM',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by' => 'SYSTEM'
            ],
            [
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'parameter' => 'app_name_short',
                'type' => 'text',
                'value' => 'LBase',
                'created_by' => 'SYSTEM',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by' => 'SYSTEM'
            ],
            [
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'parameter' => 'footer',
                'type' => 'text',
                'value' => '2022 © Larabase Development',
                'created_by' => 'SYSTEM',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by' => 'SYSTEM'
            ],
            [
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'parameter' => 'logo_icon',
                'type' => 'text',
                'value' => 'setting/ceca63c1baf77c9cc635fdf9af4ef331.png',
                'created_by' => 'SYSTEM',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by' => 'SYSTEM'
            ],
        ];
        $this->insertRecord($settingArr, 'conf_setting');


    }

    public function insertRecord($groupArr, $table_name, $debug = false)
    {
        foreach ($groupArr as $value) {
//            $arr[] = DB::table("$table_name")->insertGetId(
//                $value
//            );
            $insert = DB::table("$table_name")->insert(
                $value
            );
            if ($insert == true)
            {
                $arr[] = $value['id'];
            }
        }

        return $arr;
    }
}
