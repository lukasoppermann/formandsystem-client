<?php

use Illuminate\Database\Seeder;

class MetadetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('metadetailables')->truncate();
        // factory('Tests\Models\Metadetail', 50)->create();

        Tests\Models\Page::all()->each(function($page){
            if( rand(0,2) !== 0 ){
                Tests\Models\Metadetail::all()->random(rand(2,5))->each(function($metadetails) use ($page){
                    $metadetails->ownedByPages()->save($page);
                });
            }
        });
    }
}
