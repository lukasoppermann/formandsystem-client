<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    // tables below will be:
    // 1. truncated / deleted
    // 2. seeded
    protected $tables = [
        'collections',
        'pages',
        'fragments',
        'images',
        'metadetails',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        // empty tables
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        foreach ($this->tables as $table) {
            DB::table($table)->truncate();
        }
        // seed DB
        factory('Tests\Models\Collection', 5)->create();
        factory('Tests\Models\Page', 20)->create();
        factory('Tests\Models\Metadetail', 50)->create();
        factory('Tests\Models\Fragment', 50)->create();
        factory('Tests\Models\Fragment', 'section', 20)->create();
        factory('Tests\Models\Image', 50)->create();

        // run seeders for relationships
        foreach ($this->tables as $table) {
            $this->call(ucfirst($table).'TableSeeder');
        }

        Model::reguard();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
