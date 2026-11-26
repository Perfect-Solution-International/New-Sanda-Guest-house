<?php

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $admins = [
            [
                'name' => 'Shelini Senevirathna (Super Admin)',
                'email' => 'shelinim.senevirathna@gmail.com',
                'password' => 'admin123',
                'phone' => '+94 77 987 6543',
                'role' => 'admin',
            ],
            [
                'name' => 'Sanda Administrator',
                'email' => 'admin@sandaresort.com',
                'password' => 'admin123',
                'phone' => '+94 77 987 6543',
                'role' => 'admin',
            ],
            [
                'name' => 'Sanda Guest House Admin',
                'email' => 'admin@sandaguesthouse.lk',
                'password' => 'admin123',
                'phone' => '+94 77 987 6543',
                'role' => 'admin',
            ],
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@pos.lk',
                'password' => 'admin123',
                'phone' => '+94 77 987 6543',
                'role' => 'admin',
            ],
        ];

        foreach ($admins as $item) {
            $user = User::updateOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'],
                    'phone' => $item['phone'],
                    'role' => $item['role'],
                    'password' => Hash::make($item['password']),
                ]
            );

            if (Schema::hasTable('admins')) {
                Admin::updateOrCreate(
                    ['email' => $item['email']],
                    [
                        'user_id' => $user->id,
                        'name' => $item['name'],
                        'password' => Hash::make($item['password']),
                        'phone' => $item['phone'],
                        'role' => 'super_admin',
                        'is_active' => true,
                    ]
                );
            }
        }
    }

    public function down(): void
    {
        // No down operation needed
    }
};
