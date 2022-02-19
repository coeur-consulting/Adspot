<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubcategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Subcategory::create(
            [
                'category_id' => 1,
                'name' => 'billboards',

            ],
        );
        \App\Models\Subcategory::create(
            [
                'category_id' => 1,
                'name' => 'bus shelters',

            ],
        );
        \App\Models\Subcategory::create(
            [
                'category_id' => 1,
                'name' => 'lamp posts',

            ],
        );
        \App\Models\Subcategory::create(
            [
                'category_id' => 1,
                'name' => 'bus branding',

            ],
        );
        \App\Models\Subcategory::create(
            [
                'category_id' => 1,
                'name' => 'airports',

            ],
        );
        \App\Models\Subcategory::create(
            [
                'category_id' => 1,
                'name' => 'shopping malls',

            ],
        );

        \App\Models\Subcategory::create(
            [
                'category_id' => 4,
                'name' => 'blogs/websites',

            ],
        );
        \App\Models\Subcategory::create(
            [
                'category_id' => 4,
                'name' => 'influencers',

            ],
        );
    }
}
