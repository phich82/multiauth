<?php

namespace Tests\Unit;

use App\Admin;
use Tests\TestCase;
use Tests\Unit\Timeout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminLoginControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLockedTimeWhenUnsuccessfulLogginOverMaxAttempts()
    {
        // $this->be(Admin::find(1));
        // $response = $this->get(route('admin.login'));
        // $headerValue = $response->headers->get('X-Ratelimit-Limit');
        // $this->assertEquals(60, $headerValue);
        // $this->be(Admin::find(1));
        // //$this->withoutMiddleware();
        // $a = 1;
        // while ($a <= 5) {
        //     $result = exec('http --follow --auth test@mail.com:test123 http://admin/login');
        //     $a++;
        // };
        // $this->assertContains('Too Many Attempts.', $result);

        // $user = Admin::find(1);
        // $this->withoutMiddleware();
        // $this->be($user);
        // $params = ['email' => $user->email, 'password' => 1234567, '_token' => csrf_token()];

        // $a = 1;
        // while ($a < 61) {
        //     $this->be(Admin::find(1));
        //     $this->post(route('admin.login.submit'), $params);
        //     $a++;
        // }
        // $response = $this->post(route('admin.login.submit'), $params)
        // ->followRedirects()
        // ->assertSee('Too Many Attempts');
    }

    public function testDatabaseDisconnected()
    {
        $user = Admin::find(1);
        $params = ['email' => $user->email, 'password' => 1234567, '_token' => csrf_token()];

        DB::disconnect();
        config(['database.default' => 'test']); // set database not exist

        $this->post(route('admin.login.submit'), $params)->assertStatus(500);
    }

    public function testSessionExpired()
    {
        config(['session.lifetime' => 0]);

        $this->post(route('admin.login.submit'), ['email' => 'jhphich82@gmail.com', 'password' => '123456'])
             ->followRedirects()
             ->assertSee('You are logged in as <strong>ADMIN</strong>!');

        sleep(5);

        $this->get(route('admin.index'))->assertSee('Admin Dashboard');

        //$this->get(route('admin.index'))->assertSee('Admin Dashboard');
             //->followRedirects()
             //->assertSee('Admin Login');
        //dd(\Auth::guard('admin')->check());
        //$this->get(route('admin.index'))->assertSee('You are logged in as <strong>ADMIN</strong>!');
        //sleep(8);
        // config(['session.lifetime' => 0.1]);
        // echo config('session.lifetime')."\n";

        // session()->put('test', [1, 2, 3]);
        // session()->put('test_lifetime', time());
        // print_r(session()->all());
        // sleep(5);
        // if (time() - session()->get('test_lifetime') > config('session.lifetime')*60) {
        //     echo 'Session expired';
        // }
    }

    private function setTimeout($cb, $time, ...$args)
    {
        static $count = 0;
        $id = "timeout$count";
        $GLOBALS[$id] = new Timeout($cb, $time, $args);
        $GLOBALS[$id]->start();
        $count++;
    }
}
