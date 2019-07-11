<?php

use Illuminate\Database\Seeder;

class ClimbsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $route = new \App\Climb([
            'name' => 'Cannonball',
            'description' => 'Route has lots of big round holds. Follows crack up to overhang. Traverse overhang to reach anchors.',
            'length' => 70,
            'type' => 'Sport',
            'gear_needed' => '8 quickdraws',
            'rating' => '5.10a',
            'added_by' => 'Jodi',
            'location' => 'Salt Lake'
        ]);
        $route->save();

        $route = new \App\Climb([
            'name' => 'Cannonball 2',
            'description' => 'Route has lots of big round holds. Follows crack up to overhang. Traverse overhang to reach anchors.',
            'length' => 100,
            'type' => 'Sport',
            'gear_needed' => '8 quickdraws',
            'rating' => '5.10a',
            'added_by' => 'Test Dummy',
            'location' => 'Logan Canyon'
        ]);
        $route->save();
    }
}
