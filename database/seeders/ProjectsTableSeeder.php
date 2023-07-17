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
        for ($i = 0; $i < 30; $i++) {
            $title = $faker->words(rand(2, 10), true);  // Il mio titolo è questo
            $slug = Project::slugger($title);         // il-mio-titolo-questo

            $projects = Project::create([
                'slug' => $slug,
                'title'     => $title,
                'url_image' => 'https://picsum.photos/id/' . rand(1, 270) . '/500/400',
                'content'   => $faker->paragraphs(rand(2, 20), true),
            ]);
            $projects->technologies()->sync($faker->randomElements($technologies, null));
        }
    }
}
