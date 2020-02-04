<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([UsersTableSeeder::class
        ]);
        //create roles
        $role = Role::create(['name' => 'HR']);
        $role = Role::create(['name' => 'HQ']);
        $role = Role::create(['name' => 'ROD']);
        $role = Role::create(['name' => 'ZBM']);
        $role = Role::create(['name' => 'ASM']);
        $role = Role::create(['name' => 'MD']);

        //create permissions
        Permission::create(['name'=>'Can add log entry']);
        Permission::create(['name'=>'Can change log entry']);
        Permission::create(['name'=>'Can delete log entry']);
        Permission::create(['name'=>'Can add permission']);
        Permission::create(['name'=>'Can change permission']);
        Permission::create(['name'=>'Can delete permission']);

        Permission::create(['name'=>'Can add user']);
        Permission::create(['name'=>'Can change user']);
        Permission::create(['name'=>'Can delete user']);
        Permission::create(['name'=>'Can change user profile']);
        Permission::create(['name'=>'Can delete user profile']);

        Permission::create(['name'=>'Can add country']);
        Permission::create(['name'=>'Can change country']);
        Permission::create(['name'=>'Can delete country']);

        Permission::create(['name'=>'Can add region']);
        Permission::create(['name'=>'Can change region']);
        Permission::create(['name'=>'Can delete region']);

        Permission::create(['name'=>'Can add zone']);
        Permission::create(['name'=>'Can change zone']);
        Permission::create(['name'=>'Can delete zone']);

        Permission::create(['name'=>'Can add state']);
        Permission::create(['name'=>'Can change state']);
        Permission::create(['name'=>'Can delete state']);

        Permission::create(['name'=>'Can add area']);
        Permission::create(['name'=>'Can change area']);
        Permission::create(['name'=>'Can delete area']);

        Permission::create(['name'=>'Can add lga']);
        Permission::create(['name'=>'Can change lga']);
        Permission::create(['name'=>'Can delete lga']);

        Permission::create(['name'=>'Can add territory']);
        Permission::create(['name'=>'Can change territory']);
        Permission::create(['name'=>'Can delete territory']);

        Permission::create(['name'=>'Can add site']);
        Permission::create(['name'=>'Can change site']);
        Permission::create(['name'=>'Can delete site']);
        
        Permission::create(['name'=>'Can add role']);
        Permission::create(['name'=>'Can change role']);
        Permission::create(['name'=>'Can delete role']);
     
        //assign super User to HR role
        $user = User::find("123123");
        $role = Role::find(1);
        $user->assignRole($role);
        $user2 = User::find("230334");
        $role2 = Role::find(4);
        $user2->assignRole($role2);
    }
}
