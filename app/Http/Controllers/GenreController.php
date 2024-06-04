<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function deletegenre(Request $request)
    {
        $genre = Genre::find($request->id);


        $genre->delete();
        $message = "Genre Deleted";
        return redirect('/')->with('success', $message);
    }
    public function modifygenre(Request $request)
    {

        $genre = Genre::find($request->input('genreid'));

        if ($genre) {

            $request->validate([
                'name' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:500',
            ]);

            if (!is_null($request->description))
                $genre->update(['description' => strip_tags($request->description)]);
            if (!is_null($request->name))
                $genre->update(['name' => $request->name]);



            return redirect()->route('genre-card', [$genre->id]);
        } else {
            $message = "Error....";
            return redirect('/')->with('failure', $message);
        }
    }
    public function loadmodifygenre($genreId)
    {
        $genre = Genre::Find($genreId);

        $user = User::find(auth()->user()->id);
        if (!($user->admin)) {

            $message = "You cannot modify genre information!";
            return redirect('/')->with('failure', $message);
        }
        return view('modify-genre', compact('genre'));
    }
    public function showsinglegenre($genreId)
    {
        $genre = Genre::find($genreId);
        return view('genre-card', compact('genre'));
    }
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
