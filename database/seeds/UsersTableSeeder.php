<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin
        $now = Carbon\Carbon::now();
        //DB::table('users')->truncate();
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'lindynetech@gmail.com',
            'password' => bcrypt('password'),
            'created_at' => $now,
            'updated_at' => $now

        ]);

        // Vendors
        //DB::table('vendors')->truncate();
        DB::table('vendors')->insert([
            'name' => 'Admin',
            'user_id' => 1,
            'contact' => 'lindynetech@gmail.com'
        ]);

        // Billing
        //DB::table('billing')->truncate();

        DB::table('billing')->insert([  
            'user_id' => 1,
            'status' => 'Subscribed',
        ]);


    }
}
