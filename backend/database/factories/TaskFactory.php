<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'name' =>$faker->name,
        'description' => $faker->text(50),
        'label' => $faker->text(5),
        'owner_id' => $faker->numberBetween(1, 10),
        'assigned_to_id' => $faker->numberBetween(1, 30),
        'project_id'=> $faker->numberBetween(1,5),
        'priority_id'=> $faker ->numberBetween(1,5),
        'group_id' => $faker ->numberBetween(1, 3),
        'deadline' => $faker ->dateTime(),
        'is_completed'=>$faker-> boolean
    ];
});
