<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder {
    /**
    * Run the database seeds.
    */

    public function run(): void {
        \App\Models\Post::create( [
            'title' => 'First Post',
            'description' => 'This is the description for the first post.',
            'detail' => 'This is the detail for the first post.'
        ] );

        \App\Models\Post::create( [
            'title' => 'Second Post',
            'description' => 'This is the description for the second post.',
            'detail' => 'This is the detail for the second post.'
        ] );
    }
}
