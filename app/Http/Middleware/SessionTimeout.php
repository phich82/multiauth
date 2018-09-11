<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\Store;

class SessionTimeout
{
    protected $session;
    protected $timeout = 10;// 1200; // seconds

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isLoggedIn = $request->path() != 'admin/logout';
        $keySession = 'lastActivityTime';

        if (!session($keySession)) {
            $this->session->put($keySession, time());
        } elseif (time() - $this->session->get($keySession) > $this->timeout) {
            $this->session->forget($keySession);
            //$cookie = cookie('intend', $isLoggedIn ? url()->current() : 'admin');
            //$email = $request->user()->email ?? null;
            auth()->guard('admin')->logout();
            return 'You had not activity in '.$this->timeout/60 .' minutes ago.';
            // return message('You had not activity in '.$this->timeout/60 .' minutes ago.', 'warning', 'login')
            //         ->withInput(compact('email'))
            //         ->withCookie($cookie);
        }
        $isLoggedIn ? $this->session->put($keySession, time()) : $this->session->forget($keySession);

        return $next($request);
    }
}
