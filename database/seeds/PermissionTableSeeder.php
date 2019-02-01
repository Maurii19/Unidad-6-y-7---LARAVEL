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
            'Listar rol',
            'Crear rol',
            'Editar rol',
            'Eliminar rol',
            'Listar post',
            'Crear post',
            'Editar post',
            'Eliminar post',
            'Listar usuario',
            'Crear usuario',
            'Editar usuario',
            'Eliminar usuario'
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
                'Listar rol',
                'Crear rol',
                'Editar rol',
                'Eliminar rol',
                'Listar post',
                'Crear post',
                'Editar post',
                'Eliminar post',
                'Listar usuario',
                'Crear usuario',
                'Editar usuario',
                'Eliminar usuario',

                   
               ]);

               $basicUser->givePermissionTo([
                'Listar post',
            ]);

            $editUser->givePermissionTo([
                'Listar post',
                'Crear post',
                'Editar post',
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
