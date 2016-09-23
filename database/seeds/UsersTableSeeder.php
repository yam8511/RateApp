<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $registers = [
            [
                'name' => 'Zoular',
                'email' => 'zoular.li@gmail.com',
                'state' => 0
            ],
            [
                'name' => 'hall01',
                'email' => 'hall01@gmail.com',
                'state' => 1
            ],
            [
                'name' => 'corp01',
                'email' => 'corp01@gmail.com',
                'state' => 2
            ],
            [
                'name' => 'agent01',
                'email' => 'agent01@gmail.com',
                'state' => 3
            ],
            [
                'name' => 'mem01',
                'email' => 'mem01@gmail.com',
                'state' => 4
            ],
        ];

        foreach ($registers as $register) {
            factory(App\User::class)->create($register)->save();
        }    
    }
}
