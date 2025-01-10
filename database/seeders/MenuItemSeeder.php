<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // MenuItem::factory()->count(10)->create();
        MenuItem::insert(
            [
                // Dashboard
                [
                    'name' => 'Dashboard',
                    'route' => 'dashboard',
                    'permission_name' => 'dashboard',
                    'menu_group_id' => 1,
                ],
                // Master
                [
                    'name' => 'Periode',
                    'route' => 'master-management/periode',
                    'permission_name' => 'periode.index',
                    'menu_group_id' => 2,
                ],
                [
                    'name' => 'Tingkat Kelas',
                    'route' => 'master-management/tingkat-kelas',
                    'permission_name' => 'tingkat-kelas.index',
                    'menu_group_id' => 2,
                ],
                [
                    'name' => 'Mata Pelajaran',
                    'route' => 'master-management/mata-pelajaran',
                    'permission_name' => 'mata-pelajaran.index',
                    'menu_group_id' => 2,
                ],
                [
                    'name' => 'Guru',
                    'route' => 'master-management/guru',
                    'permission_name' => 'guru.index',
                    'menu_group_id' => 2,
                ],
                [
                    'name' => 'Siswa',
                    'route' => 'master-management/siswa',
                    'permission_name' => 'siswa.index',
                    'menu_group_id' => 2,
                ],
                // Akademik Management
                [
                    'name' => 'Siswa To Kelas',
                    'route' => 'akademik-management/siswa-kelas',
                    'permission_name' => 'siswa-kelas.index',
                    'menu_group_id' => 3,
                ],
                // Users Management
                [
                    'name' => 'User List',
                    'route' => 'user-management/user',
                    'permission_name' => 'user.index',
                    'menu_group_id' => 4,
                ],
                // Role Management
                [
                    'name' => 'Role List',
                    'route' => 'role-and-permission/role',
                    'permission_name' => 'role.index',
                    'menu_group_id' => 5,
                ],
                [
                    'name' => 'Permission List',
                    'route' => 'role-and-permission/permission',
                    'permission_name' => 'permission.index',
                    'menu_group_id' => 5,
                ],
                [
                    'name' => 'Permission To Role',
                    'route' => 'role-and-permission/assign',
                    'permission_name' => 'assign.index',
                    'menu_group_id' => 5,
                ],
                [
                    'name' => 'User To Role',
                    'route' => 'role-and-permission/assign-user',
                    'permission_name' => 'assign.user.index',
                    'menu_group_id' => 5,
                ],
                // Menu Management
                [
                    'name' => 'Menu Group',
                    'route' => 'menu-management/menu-group',
                    'permission_name' => 'menu-group.index',
                    'menu_group_id' => 6,
                ],
                [
                    'name' => 'Menu Item',
                    'route' => 'menu-management/menu-item',
                    'permission_name' => 'menu-item.index',
                    'menu_group_id' => 6,
                ],
            ]
        );
    }
}
