<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Admin User', 'password' => Hash::make('password')]
        );

        $user = User::where('email', 'test@example.com')->first();
        if ($user && ! $user->ownedTeams()->exists()) {
            $user->ownedTeams()->create([
                'name' => explode(' ', $user->name, 2)[0]."'s Team",
                'personal_team' => true,
            ]);
        }

        $this->call([
            SiteSettingSeeder::class,
            PageSectionSeeder::class,
            PageSeeder::class,
            TeamMemberSeeder::class,
            TestimonialSeeder::class,
            ServiceSeeder::class,
            BlogPostSeeder::class,
            PropertySeeder::class,
            NavItemSeeder::class,
        ]);
    }
}
