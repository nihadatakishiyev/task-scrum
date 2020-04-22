<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'owner_id' => $faker->numberBetween(1, 10),
        'assigned_to_id' => $faker->numberBetween(1, 10),
        'name' =>$faker->name,
        'description' => $faker->regexify('[A-Za-z0-9]{20}'),
        'group_id' => $faker ->numberBetween(1, 5),
        'deadline' => $faker ->dateTime(),
        'is_completed'=>$faker-> boolean,
        'priority_id'=> $faker ->numberBetween(1,5),
        'project_id'=> $faker->numberBetween(1,5),
        'label' => 'label1'
    ];
});
