<?php

namespace App\Http\Controllers\Auth;

use App\Models\Admin\User;
use App\Notifications\Auth\AccountActivationLink;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class AccountActivationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function requestActivationLink()
    {
        return view('auth.accounts.activation');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendActivationLink()
    {
        $this->validate(\request(), [
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', \request('email'))->first();

        $user->notify( new AccountActivationLink() );

        return redirect()->route('login')
            ->with(['success' => __("To complete your account activation, please click the dedicated button inside the verification email we've just sent to you.")]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function activationForm()
    {
        $this->validateUser();

        return view('auth.accounts.reset', ['token' => request('token')]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function activate()
    {
        $user = $this->validateUser();

        $this->validate(request(), [
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($user->active) {
            return redirect()->route('login')
                ->withErrors(['account_already_activated' => [__('Account is already active! Please login')]]);
        }

        $user->update([
            'password' => request('password'),
            'active' => true,
        ]);

        Auth::login($user);

        return redirect()->route('admin.home');
    }

    /**
     * @return mixed
     */
    private function validateUser()
    {
        try {
            $token = Crypt::decrypt(request('token'));
        }catch (\Exception $exception) {
            abort(404);
        }

        $user = User::where('email', $token)->firstOrFail();

        return $user;
    }
}
