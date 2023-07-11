<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnologiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $technologies = [
            [
                'name'  => 'Php',
            ],
            [
                'name'  => 'JavaScript',
            ],
            [
                'name'  => 'Vue',
            ],
            [
                'name'  => 'Css',
            ],
            [
                'name'  => 'Sass',
            ],
            [
                'name'  => 'React',
            ],
            [
                'name'  => 'Laravel',
            ],
            [
                'name'  => 'Java',
            ],
            [
                'name'  => 'C++',
            ],
            [
                'name'  => 'Rust',
            ],
            [
                'name'  => 'Angular',
            ],
            [
                'name'  => 'Bootstrap',
            ],
            [
                'name'  => 'Blade',
            ],
            [
                'name'  => 'C#',
            ],
        ];

        foreach ($technologies as $technology) {
            Technology::create($technology);
        }
    }
}
