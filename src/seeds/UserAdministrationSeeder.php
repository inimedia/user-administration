<?php

namespace Inimedia\UserAdministration\Seeds;

use App\User;
use Illuminate\Database\Seeder;
use Inimedia\UserAdministration\Model\Permission;
use Inimedia\UserAdministration\Model\Role;

class UserAdministrationSeeder extends Seeder
{
    protected $hakAkses = [
        // Administrasi User
        'Kelola User' => [ 'read', 'create', 'update', 'delete' ],
        'Hak Akses' => [ 'read', 'create', 'update', 'delete' ],
        'Log Aktivitas' => [ 'read' ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \Log::info('UserAdministrationSeeder...');

//        $perms = Permission::all();

        $daftar_hak_akses = [];
        foreach ($this->hakAkses as $menu => $hak_akses) {
            foreach ($hak_akses as $akses) {
                $name = $akses . ' ' . $menu;
                $desc = ucwords($name);
                $name = strtolower($name);
                $name = str_replace(' ', '-', $name);
                array_push($daftar_hak_akses, $name);
                //$this->info($name);

                $p = Permission::where('name', $name)->first();
                if ($p == null) {
                    $p = new Permission();
                    $p->name = $name;
                    $p->display_name = $menu;
                    $p->description = $desc;
                    $p->save();
                }
            }
        }

        $this->checkAndCreateRootUsers();

//        $all_permissions = Permission::all();
//        foreach($all_permissions as $permission){
//            if(!in_array($permission['name'], $daftar_hak_akses))
//                Permission::destroy($permission['id']);
//        }

//        $this->info('Creating Beyond Root Role...');
        $beyond_root_role = Role::where('name', 'Beyond Root')->first();
        if ($beyond_root_role == null) {
            $beyond_root_role = new Role();
            $beyond_root_role->name = 'Beyond Root';
            $beyond_root_role->display_name = 'Beyond Root';
            $beyond_root_role->description = 'Visible to Beyond Root User only';
            $beyond_root_role->save();
        }
//        $this->info('Assigning all permissions to Beyond Root and Root User...');
        $all_permissions = Permission::all();
        foreach ($all_permissions as $permission) {
            try {
                $beyond_root_role->attachPermission($permission);
            } catch (\Exception $e) {
            }
            $beyond_root_role->save();
        }

//        $this->info('Creating Ordinary Root Role...');
        $root_role = Role::where('name', 'Root')->first();
        if ($root_role == null) {
            $root_role = new Role();
            $root_role->name = 'Root';
            $root_role->display_name = 'Root';
            $root_role->description = 'Root User';
            $root_role->save();
        }
//        $this->info('Assigning all permissions to Beyond Root and Root User...');
        $all_permissions = Permission::all();
        foreach ($all_permissions as $permission) {
            try {
                $root_role->attachPermission($permission);
            } catch (\Exception $e) {
            }
            $root_role->save();
        }

//        $this->info('Assigning Beyond Root Role to Type-1 User...');
        $all_beyond_root = User::where('type', 'Beyond Root')->get();
        foreach ($all_beyond_root as $beyond_root) {
            try {
                $beyond_root->attachRole($beyond_root_role);
            } catch (\Exception $e) {
            }
            $beyond_root->status = 1;
            $beyond_root->save();
        }

//        $this->info('Assigning Beyond Root Role to Type-2 User...');
        $all_root = User::where('type', 'Root')->get();
        foreach ($all_root as $root) {
            try {
                $root->attachRole($root_role);
            } catch (\Exception $e) {
            }
            $root->status = 1;
            $root->save();
        }

//        $this->info('Creating Beyond Root Role...');
        $user_role = Role::where('name', 'User')->first();
        if ($user_role == null) {
            $user_role = new Role();
            $user_role->name = 'User';
            $user_role->display_name = 'User';
            $user_role->description = 'Ordinary User';
            $user_role->save();
        }
        // $this->call("OthersTableSeeder");
    }

    public function checkAndCreateRootUsers(){
        if (\DB::table('users')->where('name', 'Beyond Root')->where('email', 'beyondroot@inimedia.co.id')->first() == null) {
            \DB::table('users')->insert([
                'name' => 'Beyond Root',
                'email' => 'beyondroot@inimedia.co.id',
                'password' => bcrypt('secret'),
                'activation_code' => bcrypt('Root'),
                'type' => 'Beyond Root',
                'status' => 1,
                'phone' => '',
//                'reference_type' => '',
//                'reference_id' => 0,
            ]);
        }

        if (\DB::table('users')->where('name', 'Root')->where('email', 'root@inimedia.co.id')->first() == null) {
            \DB::table('users')->insert([
                'name' => 'Root',
                'email' => 'root@inimedia.co.id',
                'password' => bcrypt('secret'),
                'activation_code' => bcrypt('Root'),
                'type' => 'Root',
                'status' => 1,
                'phone' => '',
//                'reference_type' => '',
//                'reference_id' => 0,
            ]);
        }
    }
}
