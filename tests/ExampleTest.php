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
            $user = factory(App\User::class)->create($register);
            $this->users[] = $user;
            $user->save();
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
        $this->actingAs($this->users[0])
            ->visit('/lookBelow')
            ->see('Super')
            ->click('廳主')
            ->see('hall01')
            ->click('股東')
            ->see('corp01')
            ->click('代理')
            ->see('agent01')
            ->click('會員')
            ->see('mem01');

        $this->actingAs($this->users[1])
            ->visit('/lookBelow')
            ->dontSee('Super')
            ->dontSee('廳主')
            ->click('股東')
            ->see('corp01')
            ->click('代理')
            ->see('agent01')
            ->click('會員')
            ->see('mem01');

        $this->actingAs($this->users[2])
            ->visit('/lookBelow')
            ->dontSee('Super')
            ->dontSee('廳主')
            ->dontSee('股東')
            ->click('代理')
            ->see('agent01')
            ->click('會員')
            ->see('mem01');

        $this->actingAs($this->users[3])
            ->visit('/lookBelow')
            ->dontSee('Super')
            ->dontSee('廳主')
            ->dontSee('股東')
            ->dontSee('代理')
            ->click('會員')
            ->see('mem01');

        $this->actingAs($this->users[4])
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
        $user = ['super','hall','corp', 'agent', 'mem'];
        $index = [2,2,2,2,2];
        $domain = '@gmail.com';
        for ($u=0; $u < 5; $u++) {

            $this->actingAs($this->users[$u]);

            for ($i=$u; $i < 4; $i++) { 
                if ($u > 0 && $i == $u) {
                    $this->visit('/addBelow')
                    ->type($user[$i].$index[$i], 'name')
                    ->type($user[$i].$index[$i].$domain, 'email')
                    ->type('123456', 'password')
                    ->type('123456', 'password_confirmation')
                    ->select($i+1, 'state');
                    $this->call('POST', '/addBelow', [
                        'name' => $user[$i].$index[$i],
                        'email' => $user[$i].$index[$i].$domain,
                        'password' => '123456',
                        'password_confirmation' => '123456',
                        'state' => $i + 1,
                        'up' => $u + 6,
                    ]);
                    $this->assertRedirectedTo('/addBelow', ['error' => '上層會員有誤']);
                }
                else {
                    $this->visit('/addBelow')
                    ->type($user[$i].$index[$i], 'name')
                    ->type($user[$i].$index[$i].$domain, 'email')
                    ->type('123456', 'password')
                    ->type('123456', 'password_confirmation')
                    ->select($i, 'state');
                    
                    if ($i > 1) {
                        $this->select($i, 'up');
                    } else {
                        $this->select('', 'up');
                    }
                    $this->press('新增下層')
                    ->see('新增成功')
                    ->seeInDatabase('users', [
                        'name' => $user[$i].$index[$i],
                        'email' => $user[$i].$index[$i].$domain,
                        'state' => $i
                    ]);
                }
            }

            foreach ($index as $key => $value) {
                $index[$key]++;
            }
        }
    }

    /**
     * A basic functional test set rate.
     *
     * @return void
     */
    public function testSetRate()
    {
        $this->actingAs($this->users[2])
        ->visit('/setRate')
        ->seePageIs('/setRate')
        ->type(500, 'bg')
        ->type(400, 'sg')
        ->type(300, 'bb')
        ->type(200, 'sb')
        ->press('儲存')
        ->see('設定成功')
        ->seeInDatabase('rates', [
            'id' => 3,
            'bg' => 500,
            'sg' => 400,
            'bb' => 300,
            'sb' => 200,
        ]);

        $this->actingAs($this->users[3])
        ->visit('/setRate')
        ->seePageIs('/setRate')
        ->type(400, 'bg')
        ->type(300, 'sg')
        ->type(200, 'bb')
        ->type(100, 'sb')
        ->press('儲存')
        ->see('設定成功')
        ->seeInDatabase('rates', [
            'id' => 4,
            'bg' => 400,
            'sg' => 300,
            'bb' => 200,
            'sb' => 100,
        ]);

        $this->actingAs($this->users[3])
        ->visit('/setRate')
        ->seePageIs('/setRate')
        ->type(400, 'bg')
        ->type(300, 'sg')
        ->type(200, 'bb')
        ->type(100, 'sb')
        ->press('儲存')
        ->see('設定成功')
        ->seeInDatabase('rates', [
            'id' => 4,
            'bg' => 400,
            'sg' => 300,
            'bb' => 200,
            'sb' => 100,
        ]);

        $this->actingAs($this->users[2])
        ->visit('/setRate')
        ->seePageIs('/setRate')
        ->press('同步');
        
        $this->actingAs($this->users[3])
        ->visit('/setRate')
        ->seePageIs('/setRate')
        ->see('500')
        ->see('400')
        ->see('300')
        ->see('200');
    }

    /**
     * A basic functional test set below rate.
     *
     * @return void
     */
    public function testSetBelowRate()
    {
        $this->actingAs($this->users[0])
        ->visit('/setOtherRate/4')
        ->seePageIs('/setOtherRate/4')
        ->type(400, 'bg')
        ->type(300, 'sg')
        ->type(200, 'bb')
        ->type(100, 'sb')
        ->press('儲存')
        ->see('設定成功')
        ->seeInDatabase('rates', [
            'id' => 4,
            'bg' => 400,
            'sg' => 300,
            'bb' => 200,
            'sb' => 100,
        ]);
    }
}
