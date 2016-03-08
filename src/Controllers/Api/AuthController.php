<?php

namespace Rudivdme\BearContent\Controllers\Api;

use Illuminate\Http\Request;

use Rudivdme\BearContent\Models\User;
use App\Http\Requests;
use Rudivdme\BearContent\Controllers\ApiController;
use Auth;

class AuthController extends ApiController
{
    /**
     * Log a new user in.
     *
     * @return json
     */
    public function login(Request $request)
    {
        $this->validate($request, ['email' => 'required', 'password' => 'required']);

        $re = Auth::attempt(array_merge($request->only(['email', 'password']), ['status' => 'active']));

        if ($re)
        {
            return ['result' => true, 'msg' => 'Awesome!', 'url' => url('/')];
        }

        return ['result' => false, 'msg' => 'Oops, try again.'];
    }

    /**
     * Log the current user out.
     *
     * @return json
     */
    public function logout()
    {
        \Auth::logout();

        return ['result' => true, 'msg' => 'Cheers.', 'url' => url('/')];
    }

    /**
     * Generate a password reset code and send by email.
     *
     * @return json
     */
    public function reset(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $email = $request->input('email');

        $user = User::where('email', '=', $email)->first();

        if ($user)
        {
            $user->secret_token = str_random(10);
            $user->save();

            $data = [
                'user' => $user,
            ];

            \Mail::send('bear::emails.password', $data, function ($m) use ($email) {
                $m->to($email)->subject("Reset your password!");
            });

            return ['result' => true, 'msg' => 'Check your email!'];
        }

        return ['result' => false, 'msg' => 'Wrong email, got a different one?'];
    }

    /**
     * Change password.
     *
     * @return json
     */
    public function change(Request $request)
    {
        $this->validate($request, ['code' => 'required|size:10', 'password' => 'required|confirmed']);

        $token = $request->input('code');

        $user = User::where('secret_token', '=', $token)->first();

        if ($user)
        {
            $user->password = bcrypt($request->input('password'));
            $user->save();
        }

        return ['result' => true, 'msg' => 'Whoohoo! Now use your new password.'];
    }

}
