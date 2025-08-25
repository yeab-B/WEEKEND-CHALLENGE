<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder {
    /**
    * Run the database seeds.
    */

    public function run(): void {
        Language::updateOrCreate( [
            'code' => 'am',
        ], [
            'name' => 'Amharic',
        ] );

        Language::updateOrCreate( [
            'code' => 'en',
        ], [
            'name' => 'English',
        ] );
    }
}