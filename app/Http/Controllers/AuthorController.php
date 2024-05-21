<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Genre;
use App\Models\Author;
use App\Models\BookGenre;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Dotenv\Exception\ValidationException;

class AuthorController extends Controller
{
    public function searchAuthors(Request $request)
    {
        $searchTerm = $request->input('fullname'); // get the name from the search

        $searchResults = Author::where('fullname',  $searchTerm)->get(); // get the account with an exact match in the name

        //check if an account was found (count would be 1 if yes because names are unique, 0 if not)
        $valid = $searchResults->count() > 0;


        //return the results in json for the ajax function in the create post js script.
        return response()->json([
            'valid' => $valid,
            'authors' => $searchResults,
        ]);
    }
    private function validateImageUpload($uploadedFile)
    {
        //accepted extentions
        $allowedExtensions = ['jpg', 'jpeg', 'png']; // Allowed image extensions

        //check if the user selected any file
        if (!$uploadedFile) {
            throw new ValidationException('Please select images to upload.');
        }


        $mediaExtension = $uploadedFile->getClientOriginalExtension(); //get the exntention
        //check with the accepted extention array
        if (!in_array($mediaExtension, $allowedExtensions)) {
            throw new ValidationException('Invalid media file type.');
        }
    }

    public function storeauthor(Request $request)
    {



        $user = User::find(auth()->user()->id); // get the logged in user



    
        $validatedData = $request->validate([
            'fullname' => 'required|string|unique:authors',
            'alias' => 'required|string|max:255',

        ]);

        $uploadedMedia  = $request->file('image');
        $this->validateImageUpload($uploadedMedia);








        if ($uploadedMedia) {
            // make unique name for the file
            $uploadedMediaName = $user->id . '-' . uniqid() . '.' . $uploadedMedia->getClientOriginalExtension();



            // determine storage path 
            $storagePath = '/uploads/authors/';

            //store the file
            $uploadedMedia->storeAs('public' . $storagePath, $uploadedMediaName);
        }





        $author = Author::create([
            'fullname' => $validatedData['fullname'],
            'alias' => $validatedData['alias'],
            'photo_addr'  => '/storage' . $storagePath . $uploadedMediaName,

        ]);



        return redirect('/add-author')->with('success', 'Author Added');
    }
}
