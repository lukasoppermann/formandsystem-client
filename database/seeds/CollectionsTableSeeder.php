<?php

use Illuminate\Database\Seeder;

class CollectionsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('collectionables')->truncate();
        // factory('Tests\Models\Collection', 5)->create();

		Tests\Models\Collection::first()->each(function($collection){
			for($i = rand(1,4); $i > 0; $i--){
            	$collection->collections()->save(factory('Tests\Models\Collection')->create());
			}
        });
		Tests\Models\Collection::all()->each(function($collection){
			$i = rand(0,2);
			if( $i === 2 ){
				for($i = rand(1,4); $i > 0; $i--){
					$collection->pages()->save(factory('Tests\Models\Page')->create());
				}
			}
		});
	}

}
