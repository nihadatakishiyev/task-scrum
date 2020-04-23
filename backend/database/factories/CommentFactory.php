<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'task_id' => $faker->numberBetween(4, 33),
        'commenter_id' => $faker->numberBetween(1,30),
        'content' => $faker->text(50),
        'is_deleted' => $faker->boolean,
    ];
});
