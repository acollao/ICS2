<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function username()
    {
        return config('auth.auth_user_key');
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        if (auth()->user()) {
            return redirect(route('home'));
        } else {
            return view('auth.login');
        }
    }

    public function checkLogin($username)
    {
        $res = User::where('username', $username)->get();
        if ($res) {
            return $res;
        } else {
            return null;
        }
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // $connection = ldap_connect('10.81.4.11', '389') or die("Could not connect to LDAP server.");

        // ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
        // ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
        // $username    = $request->input('username');
        // $password = $request->input('password');
       
        // if (@ldap_bind($connection, $username . "@spi-global.com", $password)) {
        //     //echo "LDAP bind successful...";
        //     DD('LDAP bind successful');
        //     $request->authenticate();
        // } else {
        //     //echo "LDAP bind failed...";
        //     DD('LDAP bind failed');
        //     $request->authenticate();
        //     // throw ValidationException::withMessages([
        //     //     'username' => trans('auth.failed'),
        //     // ]);
        // }
        // ldap_close($connection);

        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
