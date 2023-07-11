<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name'          => 'Uncategorized',
                'description'   => 'Lorem picsum',
            ],
            [
                'name'          => 'Attualità',
                'description'   => 'Lorem picsum',
            ],
            [
                'name'          => 'Cucina',
                'description'   => 'Lorem picsum',
            ],
            [
                'name'          => 'Informatica',
                'description'   => 'Lorem picsum',
            ],
            [
                'name'          => 'Scuola',
                'description'   => 'Lorem picsum',
            ],
            [
                'name'          => 'Cronaca',
                'description'   => 'Lorem picsum',
            ],
            [
                'name'          => 'Politica',
                'description'   => 'Lorem picsum',
            ],
        ];

        foreach ($types as $t) {
            Type::create($t);
        }
    }
}
