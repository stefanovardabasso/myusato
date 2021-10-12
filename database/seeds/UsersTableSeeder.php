<?php

use App\Models\Admin\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Admin\Permission;
use App\Models\Admin\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $admin = User::firstOrCreate(
            ['email' => config('main.users.admin.email')],
            [
                'name' => config('main.users.admin.name'),
                'surname' => config('main.users.admin.surname'),
                'password' => Hash::make(config('main.users.admin.password')),
                'email_verified_at' => Carbon::now(),
                'active' => 1,
            ]
        );

        $administratorRole = Role::where('name', 'Administrator')->first();

        $admin->assignRole($administratorRole);
    }
}
