<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\Category::create(
            [
                'name' => 'out of home',

            ],
        );
        \App\Models\Category::create(
            [
                'name' => 'print',

            ],
        );
        \App\Models\Category::create(
            [
                'name' => 'television',

            ],
        );
        \App\Models\Category::create(
            [
                'name' => 'online',

            ],
        );
    }
}
