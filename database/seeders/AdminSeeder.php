<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'gjorgji@financebuddy.mk'],
            [
                'name'     => 'Гјоргји',
                'email'    => 'gjorgji@financebuddy.mk',
                'password' => Hash::make('ChangeMe2024!'),
                'role'     => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'tamara@financebuddy.mk'],
            [
                'name'     => 'Тамара',
                'email'    => 'tamara@financebuddy.mk',
                'password' => Hash::make('ChangeMe2024!'),
                'role'     => 'editor',
            ]
        );
    }
}
