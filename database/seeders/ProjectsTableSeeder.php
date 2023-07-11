<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use Faker\Generator as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $technologies = Technology::all()->pluck('id');
        for ($i = 0; $i < 10; $i++) {

            $projects = Project::create([
                'title'     => $faker->words(rand(2, 10), true),
                'url_image' => 'https://picsum.photos/id/' . rand(1, 270) . '/500/400',
                'content'   => $faker->paragraphs(rand(2, 20), true),
            ]);
            $projects->technologies()->sync($faker->randomElements($technologies, null));
        }
    }
}
