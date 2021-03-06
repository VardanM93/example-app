<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class TagsSeeder
 * @package Database\Seeders
 * */
class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 10; $i++)
        {
            DB::table('tags')->insert([
                'name' => Str::random(10),
            ]);
        }
    }
}
