<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@example.com');
        $name = env('ADMIN_NAME', 'Administrator');
        $password = env('ADMIN_PASSWORD', 'password');

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
            ]
        );

        if (property_exists($user, 'role') || array_key_exists('role', $user->getAttributes())) {
            $user->role = 'admin';
            $user->save();
        } else {
            // Fallback in case role is not fillable yet
            $user->forceFill(['role' => 'admin'])->save();
        }
    }
}
