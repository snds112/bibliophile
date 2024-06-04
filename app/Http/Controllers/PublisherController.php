<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function deletepublisher(Request $request)
    {
        $publisher = publisher::find($request->id);


        $publisher->delete();
        $message = "Publisher Deleted";
        return redirect('/')->with('success', $message);
    }
    public function modifypublisher(Request $request)
    {

        $publisher = publisher::find($request->input('publisherid'));

        if ($publisher) {

            $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255|unique:publishers,email,',
                'phone' => 'nullable|string|max:255|unique:publishers,phone,',
            ]);

            if (!is_null($request->phone))
                $publisher->update(['phone' => $request->phone]);
            if (!is_null($request->email))
                $publisher->update(['email' => $request->email]);
            if (!is_null($request->name))
                $publisher->update(['name' => $request->name]);



            return redirect()->route('publisher-card', [$publisher->id]);
        } else {
            $message = "Error....";
            return redirect('/')->with('failure', $message);
        }
    }
    public function loadmodifypublisher($publisherId)
    {
        $publisher = publisher::Find($publisherId);

        $user = User::find(auth()->user()->id);
        if (!($user->admin)) {

            $message = "You cannot modify publisher information!";
            return redirect('/')->with('failure', $message);
        }
        return view('modify-publisher', compact('publisher'));
    }
    public function showsinglepublisher($publisherId)
    {
        $publisher = publisher::find($publisherId);
        return view('publisher-card', compact('publisher'));
    }
    public function storepublisher(Request $request)
    {

        $user = User::find(auth()->user()->id); // get the logged in user



        $validatedData = $request->validate([
            'name' => 'required|string|unique:publishers|max:30',
            'email' => ['required', 'string', 'email', 'unique:publishers', 'max:255'],
            'phone' => ['required', 'string', 'unique:publishers', 'max:30'],

        ]);





        $publisher = Publisher::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],

        ]);



        return redirect('/add-publisher')->with('success', 'Publisher Added');
    }
}
