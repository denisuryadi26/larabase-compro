<?php

/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Libraries\Asmanager;
use App\Libraries\Asterisk;
use App\Models\Setting;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Repository\SettingRepository;
use App\Service\SettingService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $settingRepository;
    protected $super_password;
    protected $logo;
    protected $app_name;
    private $settingVal;
    private $asterisk;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SettingRepository $settingRepository)
    {
        $this->middleware('guest')->except('logout');
        $this->settingRepository = $settingRepository;
        $this->super_password = $this->settingRepository->findOneBy(['parameter' => 'super_password']);
        $this->logo = $this->settingRepository->findOneBy(['parameter' => 'logo']);
        $this->app_name = $this->settingRepository->findOneBy(['parameter' => 'app_name']);
        $this->settingVal = $settingRepository->get_all_setting();

        // $this->asterisk = new Asterisk();
    }

    public function showLoginForm()
    {
        return view('auth.login', [
            'setting' => ($this->settingVal ? $this->settingVal : ''),
            //            'setting' => [
            //                'logo' => ($this->logo) ? $this->logo->value : '',
            //                'app_name' => ($this->app_name) ? $this->app_name->value : ''
            //            ],
            'message' => null
        ]);
    }

    public function authenticated()
    {
        return redirect()->route('dashboard');
    }


    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }


        //super password login
        if ($this->super_password) {
            if ($this->super_password->value == $request['password']) {
                $user = User::withoutTrashed()->where('email', $request['email'])->first();
                //                session(['login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d' => $user->id]);

                return $this->sendLoginResponse($request);
            }
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        } else {
            return view('auth.login', [
                'setting' => [
                    'logo' => ($this->logo) ? $this->logo->value : '',
                    'app_name' => ($this->app_name) ? $this->app_name->value : ''
                ],
                'message' => [
                    'status' => 'error',
                    'message' => "Login failed. user not found"
                ]
            ]);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        //remove queue
        // $this->asterisk->logoutQueue();

        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }


    public function username()
    {
        return 'username';
    }
}
