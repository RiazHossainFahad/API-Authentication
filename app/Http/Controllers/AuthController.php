<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * This function will validate a request and register an user
     *
     * @param Request $request
     * @return Response || Errors
     */
    public function register(Request $request)
    {
        /**
         * Validating the request field data before registering.
         * If not validated it will return errors automatically.
         */
        $validatedData = $request->validate([
            'name' => 'bail|required|max:150',
            'email' => 'bail|required|email|max:150|unique:users',
            'password' => 'bail|required|min:4|confirmed'
        ]);

        $validatedData['password'] = bcrypt($request->password);

        /**  Create user with validated data */
        $user = User::create($validatedData);

        /**  Create an access token for the created user */
        $accessToken = $user->createToken('authToken')->accessToken;

        /**  return response with created user data and accessToken */
        return response(['user' => $user, 'access_token' => $accessToken]);
    }

    /**
     * Validate and login an user
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        /**
         * Validating the request field data for logging in an user.
         * If not validated it will return errors automatically.
         */
        $loginCredentials = $request->validate([
            'email' => 'bail|required|email',
            'password' => 'required'
        ]);

        /** Check for right credentials. If yes login or return error */
        if (!auth()->attempt($loginCredentials)) {
            return response(['message' => 'Invalid credentials']);
        }

        /**  Create an access token for the logged in user */
        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        /**  return response with logged in user data and accessToken */
        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }
}