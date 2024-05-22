<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
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
