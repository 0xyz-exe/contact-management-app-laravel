<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create(['name' => 'Test User', 'email' => 'test@example.com']);

        $contacts = [
            ['name' => 'Alice Johnson', 'email' => 'alice@example.com', 'phone' => '555-0101', 'company' => 'Acme Corp', 'job_title' => 'CEO', 'group' => 'Work', 'is_favorite' => true],
            ['name' => 'Bob Smith', 'email' => 'bob@example.com', 'phone' => '555-0102', 'company' => 'Tech Inc', 'job_title' => 'Developer', 'group' => 'Work'],
            ['name' => 'Carol White', 'email' => 'carol@example.com', 'phone' => '555-0103', 'group' => 'Family', 'is_favorite' => true],
            ['name' => 'David Brown', 'email' => 'david@example.com', 'phone' => '555-0104', 'company' => 'Design Co', 'job_title' => 'Designer', 'group' => 'Work'],
            ['name' => 'Emma Davis', 'email' => 'emma@example.com', 'phone' => '555-0105', 'group' => 'Friends'],
            ['name' => 'Frank Miller', 'phone' => '555-0106', 'group' => 'Family'],
            ['name' => 'Grace Lee', 'email' => 'grace@example.com', 'company' => 'Startup XYZ', 'job_title' => 'Founder', 'group' => 'Work', 'notes' => 'Met at conference 2024'],
            ['name' => 'Henry Wilson', 'email' => 'henry@example.com', 'phone' => '555-0108', 'group' => 'Friends'],
        ];

        foreach ($contacts as $c) {
            $user->contacts()->create($c);
        }
    }
}
