<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Genre;
use App\Models\Author;
use App\Models\BookGenre;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Dotenv\Exception\ValidationException;

class AuthorController extends Controller
{
    public function deleteauthor(Request $request)
    {
        $author = Author::find($request->id);

        $books = $author->books()->get();

        $filePath = $author->photo_addr;

        if (File::exists(public_path($filePath))) {

            File::delete(public_path($filePath));
        }


        foreach ($books as $book) {
            if (count($book->authors()->get()) == 1) {
                $filePath = $book->cover_addr;

                if (File::exists(public_path($filePath))) {

                    File::delete(public_path($filePath));
                }
                $book->delete();
            }
        }
        $author->delete();
        $message = "Author Deleted";
        return redirect('/')->with('success', $message);
    }
    public function modifyauthor(Request $request)
    {

        $author = Author::find($request->input('authorid'));
        $user = User::find(auth()->user()->id);
        if ($author) {

            $request->validate([
                'fullname' => 'nullable|string|max:255',
                'alias' => 'nullable|string|max:255',
                'biography' => 'nullable|string|max:500',

                'photo' => 'nullable'

            ]);

            if (!is_null($request->biography))
                $author->update(['bio' => strip_tags($request->biography)]);
            if (!is_null($request->fullname))
                $author->update(['fullname' => $request->fullname]);
            if (!is_null($request->alias))
                $author->update(['alias' => $request->alias]);
            if (!is_null($request->file('photo')))
                try {
                    $uploadedMedia = $request->file('photo');
                    $this->validateImageUpload($uploadedMedia);
                    if ($uploadedMedia) {
                        $filePath = $author->photo_addr;

                        if (File::exists(public_path($filePath))) {

                            File::delete(public_path($filePath));
                        }
                        $uploadedMediaName = $user->id . '-' . uniqid() . '.' . $uploadedMedia->getClientOriginalExtension();

                        $storagePath = '/uploads/covers/';

                        $uploadedMedia->storeAs('public' . $storagePath, $uploadedMediaName);
                        $author->update([
                            'photo_addr' =>  '/storage' . $storagePath . $uploadedMediaName,
                        ]);
                    }
                } catch (ValidationException $e) {
                    return back()->with('failure', $e->getMessage())->withInput($request->input());
                }


            return redirect()->route('author-card', [$author->id]);
        } else {
            $message = "Error....";
            return redirect('/')->with('failure', $message);
        }
    }
    public function loadmodifyauthor($authorId)
    {
        $author = Author::Find($authorId);

        $user = User::find(auth()->user()->id);
        if (!($user->admin)) {

            $message = "You cannot modify genre information!";
            return redirect('/')->with('failure', $message);
        }
        return view('modify-author', compact('author'));
    }
    public function showsingleauthor($authorId)
    {
        $author = Author::find($authorId);
        return view('author-card', compact('author'));
    }
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

        try {
            $uploadedMedia = $request->file('image');

            $this->validateImageUpload($uploadedMedia);
        } catch (ValidationException $e) {
            return back()->with('failure', $e->getMessage())->withInput($request->input());
        }








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
