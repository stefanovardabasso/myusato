<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\User;
use DB;
use Illuminate\Support\Facades\Hash;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return redirect()->route('login');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $user->update(['logged' => true, 'last_activity' => \Carbon\Carbon::now()]);
        Cache::remember('last_activity_' . $user->id, 0.5, function () {
            return true;
        });
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        if(!Auth::check()) {
            return $this->loggedOut($request) ?: redirect('/');
        }
        Auth::user()->update(['logged' => false, 'last_activity' => \Carbon\Carbon::now()]);

        $this->guard()->logout();

        $request->session()->invalidate();
        return redirect()->away('https://login.cls.it/sso-auth/logoutsso/?sso='.config('session.sso_token'));
        //return 0;//$this->loggedOut($request) ?: redirect('https://login.cls.it/sso-auth/logoutsso/?sso={yourApplicationKey}');
    }

    public function userlogin(Request $request)
    {
        $ch = curl_init('http://login.cls.it//api/sso-auth/authenticate');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ['app' => 'Z9sIyQOKaLrgu6eDPCIRhSjfNMmHDRakSZOVpssqU4SHFk5kHTAoBvNVpGuOsYJLKUATTJXVuLiY36MVy5vmmDu5AiyuONKa5PsY',
            'token' => $request->get('token')]);
        $response = curl_exec($ch);
        curl_close($ch);
        $ans = json_decode($response);

         if($ans->success == '1'){

             $user = User::where('email', '=', $ans->data->email)->first();

             if(isset($user->id)){
                  $user = Auth::attempt(['email' => $user->email, 'password' => $user->email]);
                 return redirect()->route('home');
             }else{
                 $record = new User();
                 $record->name = $ans->data->name;
                 $record->surname = $ans->data->surname;
                 $record->email = $ans->data->email;
                 $record->password = Hash::make($ans->data->email);

                 $record->save();
                 $data = [
                     'role_id' => '4',
                     'model_type' => 'App\Models\Admin\User',
                     'model_id' => $record->id
                 ];

                 DB::table('model_has_roles')->insert($data);

                 Auth::attempt(['email' =>  $record->email, 'password' =>  $record->email]);

                 return redirect()->route('home');

             }

         }



    }

}
