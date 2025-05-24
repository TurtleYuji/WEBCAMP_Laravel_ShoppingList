<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TempAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admin_users')->insert([
            'login_id' => 'test', 
            'password' => Hash::make('test'), 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}