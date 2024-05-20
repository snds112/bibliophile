<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    { // validate the log in data
        $request->validate([
            'username_or_email' => 'required|string',
            'password' => 'required|string',
        ]);
        // get the remember me checkbox status
        $remember = $request->has('remember_me');
        // allow the user to input their username or email
        $loginField = filter_var($request->input('username_or_email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        // make an array containing the login credentials
        $loginCredentials = [
            $loginField => $request->input('username_or_email'),
            'password' => $request->input('password'),
        ];


        // enter the log in credentials and the remember me status to auth::attempt for logging in, it returns true if the credentials match and uses the remember me variable to determine whether or not the user will stay logged in after the browser is closed.
        if (Auth::attempt($loginCredentials, $remember)) {

            $request->session()->regenerate(); // log the user in

            return redirect('/')->with('success', 'Logged in successfully!');; // Redirect to intended route or dashboard
        } else {

            return
                redirect('/')->with('failure', 'Failed to log in');
        }
    }

    public function create_user(Request $request)
    {

        // validate the input data
        $validatedData = $request->validate([

            'username' => ['required', 'string', 'unique:users', 'max:30'],
            'email' => ['required', 'string', 'email', 'unique:users', 'max:255'],
            'phone' => ['required', 'string', 'unique:users', 'max:30'],
            'adress' => ['required', 'string', 'max:511'],
            'password' => ['required', 'string', 'min:2'],

        ]);
        $validatedData['adress'] = strip_tags($validatedData['adress']);
        $validatedData['email'] = strip_tags($validatedData['email']);


        // Create a new user instance
        $user = User::create([

            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'adress' => $validatedData['adress'],
            'password' => $validatedData['password'], // password is hashed by default before storing, the hashing is included in the user model

        ]);

        //log the user in and redirect to the home page
        auth()->login($user);
        return redirect('/')->with('success', 'Account Created !');
    }
}
