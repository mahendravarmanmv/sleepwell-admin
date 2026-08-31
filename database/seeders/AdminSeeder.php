<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@sleepwell.com'],
            [
                'name' => 'SleepWell Administrator',
                'password' => 'ChangeMe@123',
                'is_active' => true,
            ]
        );
    }
}