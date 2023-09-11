<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all(); //this will return a collection of all users

        for ($i = 0; $i < 200; $i++) {
            $user = $users->random(); //this will return a random user from the collection
            \App\Models\Event::factory()->create([
                'user_id' => $user->id,
            ]);
        }
        //
    }
}
