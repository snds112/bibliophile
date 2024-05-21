<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function searchGenres(Request $request)
    {
        $searchTerm = $request->input('name'); // get the name from the search

        $searchResults = Genre::where('name',  $searchTerm)->get(); // get the account with an exact match in the name

        //check if an account was found (count would be 1 if yes because names are unique, 0 if not)
        $valid = $searchResults->count() > 0;


        //return the results in json for the ajax function in the create post js script.
        return response()->json([
            'valid' => $valid,
            'genres' => $searchResults,
        ]);
    }

    public function storegenre(Request $request)
    {

        $user = User::find(auth()->user()->id); // get the logged in user



        $validatedData = $request->validate([
            'name' => 'required|string|unique:genres|max:30',
            'description' => 'required|string',

        ]);
        $validatedData['description'] = strip_tags($validatedData['description']);




        $genre = Genre::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],

        ]);



        return redirect('/add-genre')->with('success', 'Genre Added');
    }
}
