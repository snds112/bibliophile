<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Genre;
use App\Models\Author;
use App\Models\Writer;
use App\Models\BookGenre;
use App\Models\Publisher;

use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;
use Dotenv\Exception\ValidationException;

class BookController extends Controller
{


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

    public function storebook(Request $request)
    {



        $user = User::find(auth()->user()->id); // get the logged in user



        //validate book request
        $validatedData = $request->validate([
            'ISBN' => 'required|string|unique:books',
            'title' => 'required|string|max:300',
            'year_of_publication' => 'required|string|size:4',
            'edition' => 'nullable|string|max:45',
            'description' => 'required|string',
            'type' => 'required|in:Hardcover,Paperback,Ebook',
            'number_of_copies' => 'required|integer|min:0',
            'publisher' => 'required|string|exists:publishers,name'
        ]);

        $uploadedMedia  = $request->file('image');
        $this->validateImageUpload($uploadedMedia);

        //validate the caption and strip tags to prevent harmful scripts

        $validatedData['description'] = strip_tags($validatedData['description']);







        if ($uploadedMedia) {
            // make unique name for the file
            $uploadedMediaName = $user->id . '-' . uniqid() . '.' . $uploadedMedia->getClientOriginalExtension();



            // determine storage path 
            $storagePath = '/uploads/covers/';

            //store the file
            $uploadedMedia->storeAs('public' . $storagePath, $uploadedMediaName);
        }



        $publisher = Publisher::where('name', $validatedData['publisher'])->first()->get();
        $publisher = $publisher[0];
        $book = Book::create([
            'ISBN' => $validatedData['ISBN'],
            'title' =>            $validatedData['title'],
            'year_of_publication' =>            $validatedData['year_of_publication'], // Ensures a valid year format (YYYY)
            'edition' =>            $validatedData['edition'], // Allow empty edition but limit length
            'description' =>            $validatedData['description'],
            'type' =>            $validatedData['type'], // Validate against defined types
            'cover_addr' =>  '/storage' . $storagePath . $uploadedMediaName, // Allow empty cover address but limit length
            'number_of_copies' =>            $validatedData['number_of_copies'],
            'publisher_id' =>  $publisher ? $publisher->id : null,

        ]);


        $genres = explode(",", $request->input("genres"));


        //add the genre links in the bgs table (to link the book to all the genres)
        if (!empty($genres)) {
            foreach ($genres as $genre) {
                if ($genre) {
                    //get the Genre
                    $genre = (Genre::Where('name', $genre)->get()->first())->id;
                    if (!empty($genre)) {
                        //check whether or not the entry in bgs already exists
                        $existingEntry = BookGenre::where('genre_id', $genre)
                            ->where('book_id', $book->id)
                            ->first();
                        //if it doesnt then enter it
                        if (!$existingEntry) {
                            BookGenre::create([
                                'book_id' => $book->id,
                                'genre_id' => $genre
                            ]);
                        }
                    }
                }
            }
        }

        $authors = explode(",", $request->input("authors"));


        //add the genre links in the bgs table (to link the book to all the authors)
        if (!empty($authors)) {
            foreach ($authors as $author) {
                if ($author) {
                    //get the author
                    $author = (Author::Where('fullname', $author)->get()->first())->id;
                    if (!empty($author)) {
                        //check whether or not the entry in bgs already exists
                        $existingEntry = Writer::where('author_id', $author)
                            ->where('book_id', $book->id)
                            ->first();
                        //if it doesnt then enter it
                        if (!$existingEntry) {
                            Writer::create([
                                'book_id' => $book->id,
                                'author_id' => $author
                            ]);
                        }
                    }
                }
            }
        }
        return redirect('/')->with('success', 'Book Added');
    }
}
