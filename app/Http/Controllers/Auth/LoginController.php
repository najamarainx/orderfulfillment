<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request, $user)
    {
        if ( $user->type  == 'team_lead' ) {// do your magic here
            $departmentId  = getUsersDepartment(Auth::user()->id);
            session(['department_id' => $departmentId->department_id]);
        }else if( $user->type  == 'screen' ){
          $departmentId  = getUsersDepartment(Auth::user()->id);
          session(['department_id' => $departmentId->department_id]);
          return redirect('worker-task-screen');
        }

    }
    public function logout(Request $request)
{
    $this->performLogout($request);
    return redirect()->route('login');
}

}
