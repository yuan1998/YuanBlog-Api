<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();

        $user = [
            'username' => 'yuan1998',
            'password' => bcrypt('3322123aa'),
            'email' => 'chizhiyueshu@gmail.com',
            'phone' => 18592071704,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        User::insert($user);
        
        //
    }
}
