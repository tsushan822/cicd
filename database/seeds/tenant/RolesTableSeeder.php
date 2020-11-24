<?php

namespace Seeds\Tenant;

use App\Zen\User\Model\Role;
use App\Zen\User\Model\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Laravel\Spark\Spark;

//not used for anything
class RolesTableSeeder extends Seeder
{

    public function run()
    {
        DB ::table('roles') -> truncate();

        $role1 = Role ::create([
            'name' => 'super',
            'label' => 'Super administrator',
        ]);
        $role1 -> attachPermission([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24,
            25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50,
            51, 52, 53, 54, 55]);

        $role2 = Role ::create([
            'name' => 'admin',
            'label' => 'Administrator',
        ]);
        $role2 -> attachPermission([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24,
            25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50,
            51, 52, 53, 54, 55]);

        $role3 = Role ::create([
            'name' => 'dealer',
            'label' => 'Front office',
        ]);
        $role3 -> attachPermission([1, 2, 3, 4, 5, 6, 8, 9, 10, 11, 12, 13, 14, 15, 17, 18, 19, 20, 21, 22]);

        $role4 = Role ::create([
            'name' => 'middle',
            'label' => 'Middle office',
        ]);
        $role4 -> attachPermission([3, 4, 26, 27, 29, 30, 38, 39, 40, 41, 54]);

        $role5 = Role ::create([
            'name' => 'back',
            'label' => 'Back office',
        ]);
        $role5 -> attachPermission([3, 4, 15, 16, 35, 36, 48, 49, 50]);


        //Add developers to each account
        $emails = Spark ::$developers;
        $users = User :: whereIn('email', $emails) -> get();
        foreach($users as $user) {
            $user -> assign('super');
        }
    }

}
