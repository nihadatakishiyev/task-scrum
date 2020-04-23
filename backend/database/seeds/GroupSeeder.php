<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert(
            [
                'name'=> 'To Do',
                'place'=> 1
            ]
        );

        DB::table('groups')->insert(
            [
                'name'=> 'In Progress',
                'place'=> 2
            ]
        );

        DB::table('groups')->insert(
            [
                'name'=> 'Done',
                'place'=> 3
            ]
        );
    }
}
