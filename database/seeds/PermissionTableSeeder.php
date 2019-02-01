<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\User;
use Spatie\Permission\Models\Role;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'post-list',
            'post-create',
            'post-edit',
            'post-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete'
         ];
         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
       }

               //Admin
               $admin = Role::create(['name' => 'Admin']);
               //User Basic
               $basicUser = Role::create(['name' => 'Basic User']);

               $editUser = Role::create(['name' => 'Edit User']);

               $admin->givePermissionTo([
                'role-list',
                'role-create',
                'role-edit',
                'role-delete',
                'post-list',
                'post-create',
                'post-edit',
                'post-delete',
                'user-list',
                'user-create',
                'user-edit',
                'user-delete'

                   
               ]);

               $basicUser->givePermissionTo([
                'post-list',
            ]);

            $editUser->givePermissionTo([
                'post-list',
                'post-create' 
            ]);

               //$admin->givePermissionTo('products.index');
               //$admin->givePermissionTo(Permission::all());
              

               //User Admin
               $user = User::find(1); 
               $user->assignRole('Admin');

               //User Basic
               $user = User::find(2);
               $user->assignRole('Basic User');

               $user = User::find(3);
               $user->assignRole('Edit User');
    }
}
