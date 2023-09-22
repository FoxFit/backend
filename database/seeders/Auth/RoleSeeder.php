<?php

namespace Database\Seeders\Auth;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use App\Support\UserRole;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->seedRoles();
        $this->seedResourceSettings();
    }

    /**
     * Seed default roles and assign to default admin.
     */
    public function seedRoles(): void
    {
        $roles = Role::all()->toArray();
        if (empty($roles)) {
            $data = [];
            foreach (UserRole::ROLES as $name) {
                $data[] = ['name' => $name, 'guard_name' => 'api', 'is_special' => 1];
            }
            Role::query()->insert($data);
        }
    }

    public function seedResourceSettings(): void
    {
        $resourceSettings = config('resources');

        if (empty($resourceSettings)) {
            return;
        }

        foreach ($resourceSettings as $entityType => $settings) {
            if (empty($settings) || !is_string($entityType)) {
                continue;
            }

            foreach ($settings as $permissionName => $roles) {
                $params = [
                    'name'        => sprintf('%s.%s', $entityType, $permissionName),
                    'guard_name'  => Role::DEFAULT_GUARD,
                ];

                $permission = Permission::query()->where($params)->first();

                if (!$permission) {
                    $permission = new Permission();
                }

                $permission->fill($params);
                $permission->save();

                if (!empty($roles)) {
                    $permission->assignRole($roles);
                }
            }
        }
    }
}
