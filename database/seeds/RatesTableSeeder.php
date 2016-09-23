<?php

use Illuminate\Database\Seeder;

class RatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rates = [
            [
                'id' => 3,
                'bg' => 500,
                'sg' => 400,
                'bb' => 300,
                'sb' => 200,
            ],
        ];

        foreach ($rates as $rate) {
            factory(App\Rate::class)->create($rate)->save();
        }
    }
}
