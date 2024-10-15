<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        $permissions = [
            'Manage Roles',
            'Manage Permissions',
            'Manage Users',
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $superAdminRole->syncPermissions(Permission::all());
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@yourdomain.com', 
            'password' => Hash::make('demo@123'),
            'role' => 'Super Admin',
            
             
        ]);
        $user->assignRole($superAdminRole);
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        $user = User::where('email', 'superadmin@yourdomain.com')->first();
        if ($user) {
            $user->delete();
        }
        Role::where('name', 'Super Admin')->delete();
        Permission::all()->each->delete();
    }
};
