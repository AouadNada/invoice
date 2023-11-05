<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class UsersRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the roles to be seeded
        $roles = ['admin', 'vendor', 'client'];

        // Find and update each user to assign a role
        foreach ($roles as $role) {
            User::where('role', $role)->update(['role' => $role]);
        }
    }
}
