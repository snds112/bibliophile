<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Genre;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\AdminRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function searchResults(Request $request)
    {

        $searchTerm = $request->searchTerm;
        $searchTerm  = strip_tags($searchTerm);
        $searchTerm = "%{$searchTerm}%";
        $users = User::where('username', 'like', "%{$searchTerm}%")->get();
        $authors = Author::with('books')
            ->where('fullname', 'like', $searchTerm)
            ->whereHas('books', function ($query) {
            })
            ->get();



        $publishers = Publisher::with('books')
            ->where('name', 'like', $searchTerm)
            ->whereHas('books', function ($query) {
            })
            ->get();

        $genres = Genre::with('books')
            ->where('name', 'like', $searchTerm)
            ->whereHas('books', function ($query) {
            })
            ->get();
        $books =  Book::where('title', 'like', "%{$searchTerm}%")->get();

        $results[] = $users;
        $results[] = $authors;
        $results[] = $publishers;
        $results[] = $genres;
        $results[] = $books;






        return view('search-results', compact('searchTerm', 'results'));
    }
    public function deleteaccount(Request $request)
    {
        User::find($request->id)->delete();
        $message = "User Deleted";
        return redirect('/')->with('success', $message);
    }
    public function requestadmin(Request $request)
    {
        $user = User::Where('username', $request->input('username'))->get()->first();
        $user->update(['admin' => 1]);
        return back();
    }
    public function modifyaccount(Request $request)
    {

        $user = User::Where('username', $request->input('currentusername'))->get()->first();

        if ($user) {

            $request->validate([
                'username' => 'nullable|string|max:255|unique:users,username,',
                'email' => 'nullable|email|max:255|unique:users,email,',
                'phone' => 'nullable|string|max:255|unique:users,phone,',
                'address' => 'nullable|string|max:511',
            ]);
            $request->validate([
                'currentpassword' => 'nullable|string',
                'newpassword' => 'nullable|string',
            ]);
            if (!is_null($request->currentpassword) && !is_null($request->newpassword)) {

                if (!Hash::check($request->currentpassword, $user->password)) {
                    $message = 'The provided password does not match your current password.';
                    return back()->with('failure', $message);
                }

                $user->update([
                    'password' => $request->newpassword,
                ]);
            } elseif (!is_null($request->newpassword)) {
                $message = "Current password must be provided with new password.";
                return back()->with('failure', $message);
            } elseif (!is_null($request->currentpassword)) {
                $message = "New password must be provided with current password.";
                return back()->with('failure', $message);
            }
            if (!is_null($request->username))
                $user->update(['username' => $request->username]);
            if (!is_null($request->phone))
                $user->update(['phone' => $request->phone]);
            if (!is_null($request->email))
                $user->update(['email' => $request->email]);
            if (!is_null($request->address))
                $user->update(['adress' => $request->address]);


            return redirect()->route('account', [$user->username]);
        } else {
            $message = "User not found....";
            return redirect('/')->with('failure', $message);
        }
    }
    public function loadmodifyaccount($username)
    {
        $user = User::Where('username', $username)->get()->first();

        if (!($user == User::find(auth()->user()->id) || $user->admin)) {

            $message = "You cannot modify another user's information!";
            return redirect('/')->with('failure', $message);
        }
        return view('modify-account', compact('user'));
    }
    public function loadaccount($username)
    {
        $user = User::Where('username', $username)->get()->first();
        $loggedIn = User::find(auth()->user()->id);

        if (($user == User::find(auth()->user()->id) || $loggedIn->admin)) {
            $returnedBorrows = $user->borrows()->wherenull('returned_at')->orderby('created_at', 'desc')->get();
            $nonreturnedBorrows = $user->borrows()->wherenotnull('returned_at')->orderby('created_at', 'desc')->get();
            $activeBorrows = [];
            foreach ($returnedBorrows as $borrow) {
                if ($borrow)
                    $activeBorrows[] = $borrow;
            }
            foreach ($nonreturnedBorrows as $borrow) {
                if ($borrow)
                    $activeBorrows[] = $borrow;
            }

            $borrowRequests = $user->borrow_requests()->orderby('created_at', 'desc')->get();


            return view('view-account', compact('user', 'activeBorrows', 'borrowRequests'));
        } else {

            $message = "You cannot view another user's information!";
            return redirect('/')->with('failure', $message);
        }
    }
    public function logout(Request $request)
    {
        auth()->logout(); // logs out the logged in user
        return redirect('/')->with('success', 'Logged out !');
    }
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
