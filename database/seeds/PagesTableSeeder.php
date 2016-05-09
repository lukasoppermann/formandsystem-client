<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pageables')->truncate();
        // factory('Tests\Models\Page', 20)->create();

        // Connect to pages

        Tests\Models\Page::all()->each(function($page){
            $i = rand(0,2);
            if( $i === 2 ){
                $page->pages()->save(Tests\Models\Page::all()->random(1));
                $page->pages()->save(Tests\Models\Page::all()->random(1));
                Tests\Models\Collection::all()->random(2)->each(function($collection) use ($page){
                    $collection->pages()->save($page);
                });
            }
            if( $i === 1 ){
                $page->collections()->save(factory('Tests\Models\Collection')->create());
                Tests\Models\Collection::all()->random()->pages()->save($page);
            }
        });
    }
}
