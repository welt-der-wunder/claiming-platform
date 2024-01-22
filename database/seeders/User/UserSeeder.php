<?php

namespace Database\Seeders\User;

use App\Factories\User\AccountSettingsFactory;
use App\Models\User;
use App\Util\UserRoles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'email' => 'admin@milc.com',
            'password' => '12345678',
            'role' => 'Admin',
            'is_verified' => 1,
            'email_verified_at' => new \DateTime(),
        ]);
    }
}
