<?php
namespace Seeds\Tenant;

use App\Zen\Setting\Model\Counterparty;
use App\Zen\User\Model\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class Counterparty_UsersTableSeeder extends Seeder
{
     public
            function run() {
        
        $counterpartyIds = Counterparty::orderBy('id')->lists('id');
        $userIds = User::orderBy('id')->lists('id');
 
           DB::table('counterparty_user')->insert(
                [
                    
                    'counterparty_id' => $counterpartyIds[3],
                    'user_id'=>$userIds[5]
        ]);
            DB::table('counterparty_user')->insert(
                [
                    
                    'counterparty_id' => $counterpartyIds[5],
                    'user_id'=>$userIds[5]
        ]);
             DB::table('counterparty_user')->insert(
                [
                    
                    'counterparty_id' => $counterpartyIds[6],
                    'user_id'=>$userIds[5]
        ]);
           
          
    }
}