<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirect users after login based on their role.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $role = auth()->user()->role;

        switch ($role) {
            case 'admin':
                return '/admin/dashboard';
            case 'fotografer':
                return '/fotografer/fotografer/fotografi';
            case 'customer':
                return '/';
            default:
                return '/';
        }
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
