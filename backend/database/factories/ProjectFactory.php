<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'owner_id' => $faker->numberBetween(1, 10),
        'name' =>$faker->name,
        'description' => $faker->text(50),
        'color_code' => $faker ->numberBetween(1, 5),
        'is_completed'=>$faker-> boolean,
        'deadline' => $faker ->dateTime()
    ];
});
