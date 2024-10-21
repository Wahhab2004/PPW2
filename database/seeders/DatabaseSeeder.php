<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Publisher;
use App\Models\Book;
use App\Models\Member;
use App\Models\Borrower;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // php artisan db:seed
        Publisher::factory()->count(5)->create();
        Book::factory()->count(100)->create();
        Member::factory()->count(20)->create();
        Borrower::factory()->count(200)->create();
    }
}
