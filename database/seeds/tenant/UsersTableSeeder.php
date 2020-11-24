<?php
namespace Seeds\Tenant;

use App\Zen\User\Model\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public
    function run()
    {
        User::truncate();
        $user = User ::create([
            'name' => 'SuperAdmin',
            'email' => 'info@zentreasury.com',
            'password' => bcrypt('1234'),
            'verified' => 1,
            'must_change_password' => 1,
        ]);
    }
}