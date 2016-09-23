<?php

use Illuminate\Database\Seeder;

class RelationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $relations = [
            [
                'id' => 3,
                'up' => 2,
            ],
            [
                'id' => 4,
                'up' => 3,
            ],
            [
                'id' => 5,
                'up' => 4,
            ],
        ];

        foreach ($relations as $relation) {
            factory(App\Relation::class)->create($relation)->save();
        }
    }
}
