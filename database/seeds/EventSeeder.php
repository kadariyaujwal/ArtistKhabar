<?php

use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Event::class,10)->create()->each(function($event){
            $photos = factory(App\EventPhoto::class,4)->make();
            $event->photos()->saveMany($photos);
        });
    }
}
