<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class VerifyAdminEmailSeeder extends Seeder
{
    public function run(): void
    {
        User::where('email', 'admin@ckfmotors.com')
            ->whereNull('email_verified_at')
            ->update(['email_verified_at' => now()]);

        echo "Admin email verified.\n";
    }
}
