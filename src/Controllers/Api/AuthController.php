<?php

namespace Rudivdme\BearContent\Controllers\Api;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Requests;
use Rudivdme\BearContent\Controllers\BearController;
use Auth;

class AuthController extends BearController
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

}
