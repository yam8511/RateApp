<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    private $users = [];
    public function setUp() {
        parent::setUp();
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
            ]
        ];    

        foreach ($registers as $register) {
            $this->users[] = factory(App\User::class)->create($register)->save();
        }

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

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
            ->seePageIs('/login');
    }

    /**
     * A basic functional test login.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->visit('/login')
            ->type('zoular.li@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->seePageIs('/')
            ->dontSee('目前賠率限額')
            ->dontSee('設定賠率')
            ->see('查看下層')
            ->see('新增下層')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('hall01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->seePageIs('/')
            ->dontSee('目前賠率限額')
            ->dontSee('設定賠率')
            ->see('查看下層')
            ->see('新增下層')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('corp01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->seePageIs('/')
            ->see('目前賠率限額')
            ->see('設定賠率')
            ->see('查看下層')
            ->see('新增下層')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('agent01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->seePageIs('/')
            ->see('目前賠率限額')
            ->see('設定賠率')
            ->see('查看下層')
            ->see('新增下層')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('mem01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->seePageIs('/')
            ->see('目前賠率限額')
            ->dontSee('設定賠率')
            ->dontSee('查看下層')
            ->dontSee('新增下層')
            ->post('/logout', ['_token' => csrf_token()]);      
    }

    /**
     * A basic functional test look.
     *
     * @return void
     */
    public function testLook()
    {
        $this->visit('/login')
            ->type('zoular.li@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->click('查看下層')
            ->see('Zoular')
            ->click('廳主')
            ->see('hall01')
            ->click('股東')
            ->see('corp01')
            ->click('代理')
            ->see('agent01')
            ->click('會員')
            ->see('mem01')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('hall01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->click('查看下層')
            ->dontSee('Super')
            ->dontSee('廳主')
            ->click('股東')
            ->see('corp01')
            ->click('代理')
            ->see('agent01')
            ->click('會員')
            ->see('mem01')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('corp01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->click('查看下層')
            ->dontSee('Super')
            ->dontSee('廳主')
            ->dontSee('股東')
            ->click('代理')
            ->see('agent01')
            ->click('會員')
            ->see('mem01')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('agent01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->click('查看下層')
            ->dontSee('Super')
            ->dontSee('廳主')
            ->dontSee('股東')
            ->dontSee('代理')
            ->click('會員')
            ->see('mem01')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('mem01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->call('GET', '/lookBelow');
            $this->assertRedirectedTo('/', $with = []);
    }

    /**
     * A basic functional test add below.
     *
     * @return void
     */
    public function testAddBelow()
    {
        $this->visit('/login')
            ->type('zoular.li@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->click('查看下層')
            ->see('Zoular')
            ->click('廳主')
            ->see('hall01')
            ->click('股東')
            ->see('corp01')
            ->click('代理')
            ->see('agent01')
            ->click('會員')
            ->see('mem01')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('hall01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->click('查看下層')
            ->dontSee('Super')
            ->dontSee('廳主')
            ->click('股東')
            ->see('corp01')
            ->click('代理')
            ->see('agent01')
            ->click('會員')
            ->see('mem01')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('corp01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->click('查看下層')
            ->dontSee('Super')
            ->dontSee('廳主')
            ->dontSee('股東')
            ->click('代理')
            ->see('agent01')
            ->click('會員')
            ->see('mem01')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('agent01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->click('查看下層')
            ->dontSee('Super')
            ->dontSee('廳主')
            ->dontSee('股東')
            ->dontSee('代理')
            ->click('會員')
            ->see('mem01')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('mem01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->call('GET', '/lookBelow');
            $this->assertRedirectedTo('/', $with = []);
    }

    /**
     * A basic functional test set rate.
     *
     * @return void
     */
    public function testSetRate()
    {
        $this->visit('/login')
            ->type('zoular.li@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->click('查看下層')
            ->see('Zoular')
            ->click('廳主')
            ->see('hall01')
            ->click('股東')
            ->see('corp01')
            ->click('代理')
            ->see('agent01')
            ->click('會員')
            ->see('mem01')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('hall01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->click('查看下層')
            ->dontSee('Super')
            ->dontSee('廳主')
            ->click('股東')
            ->see('corp01')
            ->click('代理')
            ->see('agent01')
            ->click('會員')
            ->see('mem01')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('corp01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->click('查看下層')
            ->dontSee('Super')
            ->dontSee('廳主')
            ->dontSee('股東')
            ->click('代理')
            ->see('agent01')
            ->click('會員')
            ->see('mem01')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('agent01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->click('查看下層')
            ->dontSee('Super')
            ->dontSee('廳主')
            ->dontSee('股東')
            ->dontSee('代理')
            ->click('會員')
            ->see('mem01')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('mem01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->call('GET', '/lookBelow');
            $this->assertRedirectedTo('/', $with = []);
    }

    /**
     * A basic functional test set below rate.
     *
     * @return void
     */
    public function testSetBelowRate()
    {
        $this->visit('/login')
            ->type('zoular.li@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->click('查看下層')
            ->see('Zoular')
            ->click('廳主')
            ->see('hall01')
            ->click('股東')
            ->see('corp01')
            ->click('代理')
            ->see('agent01')
            ->click('會員')
            ->see('mem01')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('hall01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->click('查看下層')
            ->dontSee('Super')
            ->dontSee('廳主')
            ->click('股東')
            ->see('corp01')
            ->click('代理')
            ->see('agent01')
            ->click('會員')
            ->see('mem01')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('corp01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->click('查看下層')
            ->dontSee('Super')
            ->dontSee('廳主')
            ->dontSee('股東')
            ->click('代理')
            ->see('agent01')
            ->click('會員')
            ->see('mem01')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('agent01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->click('查看下層')
            ->dontSee('Super')
            ->dontSee('廳主')
            ->dontSee('股東')
            ->dontSee('代理')
            ->click('會員')
            ->see('mem01')
            ->post('/logout', ['_token' => csrf_token()])

            ->visit('/login')
            ->type('mem01@gmail.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->call('GET', '/lookBelow');
            $this->assertRedirectedTo('/', $with = []);
    }
}
