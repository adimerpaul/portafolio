<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//
        Permission::create(['name' => 'user create']);
        Permission::create(['name' => 'user ready']);
        Permission::create(['name' => 'user update']);
        Permission::create(['name' => 'user delete']);

        Permission::create(['name' => 'materia create']);
        Permission::create(['name' => 'materia ready']);
        Permission::create(['name' => 'materia update']);
        Permission::create(['name' => 'materia delete']);

        Permission::create(['name' => 'semestre create']);
        Permission::create(['name' => 'semestre ready']);
        Permission::create(['name' => 'semestre update']);
        Permission::create(['name' => 'semestre delete']);

        Permission::create(['name' => 'documento create']);
        Permission::create(['name' => 'documento ready']);
        Permission::create(['name' => 'documento update']);
        Permission::create(['name' => 'documento delete']);

        Permission::create(['name' => 'registro create']);
        Permission::create(['name' => 'registro ready']);
        Permission::create(['name' => 'registro update']);
        Permission::create(['name' => 'registro delete']);
//        $admin = Role::create(['name' => 'admin']);
//        $admin->givePermissionTo(Permission::all());


        $user= User::create([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('admin'),
        ]);
        $user->givePermissionTo(Permission::all());
//        $role->givePermissionTo($permission);
//        $permission->assignRole($role);
    }
}
