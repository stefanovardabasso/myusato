<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Administrator' => ['en' => 'Administrator', 'it' => 'Amministratore', 'bg' => 'Администратор'],
            'User' => ['en' => 'User', 'it' => 'Utente', 'bg' => 'Потребител'],
            'Help' => ['en' => 'Help', 'it' => 'Assistenza', 'bg' => 'Помощ'],
            'Basic' => ['en' => 'Basic', 'it' => 'Base', 'bg' => 'Основен'],
        ];

        foreach ($roles as $name => $role) {

            if (Role::where('name', $name)->count() > 0) {
                continue;
            }

            $roleRow = null;
            foreach ($role as $locale => $transName) {
                app()->setLocale($locale);
                if (!$roleRow) {
                    $roleRow = Role::createTranslated(['name' => $name, 'role_name' => $transName]);
                } else {
                    $roleRow->updateTranslated(['role_name' => $transName]);
                }
            }
        }
    }
}
