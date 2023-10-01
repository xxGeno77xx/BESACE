<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\Classes;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use App\Support\Classes\PermissionsClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    const SuperAdmin='Super administrateur';

    public function run(): void
    {
        // $permissions = PermissionsClass::toValues();

        // foreach ($permissions as $key => $name) {
        //     Permission::firstOrCreate([
        //         'name' => $name,
        //     ]);
        // }
        
//==================Users====================================

        $superAdminUser  = User::firstOrCreate([
            "email" => "superadministrateur@laposte.tg",
            'password' => Hash::make('11111111'),
            'name' => 'Super_administrateur',
        ]);
    }
}