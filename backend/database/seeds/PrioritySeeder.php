<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('priorities')->insert(
            [
                'name'=> 'Crucial',
                'color'=> 'red'
            ]
        );

        DB::table('priorities')->insert(
            [
                'name'=> 'Optional',
                'color'=> 'green'
            ]
        );

        DB::table('priorities')->insert(
            [
                'name'=> 'Desirable',
                'color'=> 'yellow'
            ]
        );

        DB::table('priorities')->insert(
            [
                'name'=> 'Important',
                'color'=> 'orange'
            ]
        );

        DB::table('priorities')->insert(
            [
                'name'=> 'Extra',
                'color'=> 'blue'
            ]
        );

    }
}
