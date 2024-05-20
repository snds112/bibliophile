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
}
