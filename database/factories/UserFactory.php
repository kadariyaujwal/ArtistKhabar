<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Artist::class, function (Faker $faker) {
   return [
       'name' => $faker->name,
       'address' => $faker->address,
       'birthday' => $faker->date('Y-m-d'),
       'picture' => $faker->imageUrl(),
       'cover_picture' => $faker->imageUrl(),
       'website' => $faker->url,
       'facebook' => $faker->text,
       'twitter' => $faker->text,
       'email' => $faker->email,
       'bio' => $faker->realText(500),
       'meta_desc' => $faker->text(200),
   ];
});

$factory->define(App\Event::class,function(Faker $faker){
    return [
        'location'=>$faker->address,
        'title'=>$faker->text,
        'description'=>$faker->realText(200),
        'date'=>$faker->date('Y-m-d')
    ];
});

$factory->define(App\EventPhoto::class,function(Faker $faker){
    return [
        'path'=>$faker->imageUrl(),
        'cover'=>rand(0,1)
    ];
});
