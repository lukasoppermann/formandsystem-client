<?php

use Illuminate\Database\Seeder;

class FragmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fragmentables')->truncate();
        // create content fragments
        // factory('Tests\Models\Fragment', 50)->create();
        // // create section fragments
        // factory('Tests\Models\Fragment', 'section', 20)->create();

        // connect sections with content fragments
        Tests\Models\Fragment::where('type', 'section')->get()->slice(rand(1,5))->each(function($section) {
            // connect this section to 1 to 5 pages
            for( $i = rand(0,5); $i > 0; $i--) {
                Tests\Models\Page::all()->random()->fragments()->save($section);
            }
            // get content fragments and connect to section
            $fragmentCollection = Tests\Models\Fragment::where('type', '!=', 'section');
            $fragmentCollection->get()->random(rand(2,5))->each(function($fragment) use ($section){
                $section->fragments()->save($fragment);
            });
        });
        // add collections to some fragments
        Tests\Models\Fragment::where('type', 'collection')->get()->each(function($fragment){
            Tests\Models\Collection::all()->random(rand(1,3))->each(function($collection) use ($fragment){
                $fragment->collections()->save($collection);
            });
        });
    }
}
