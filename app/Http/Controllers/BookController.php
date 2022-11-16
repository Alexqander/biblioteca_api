<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with(['category', 'editorial', 'authors'])->get();

        return $this->getResponse200($books);
    }
    public function store(Request $request)
    {
        try {
            $isbn = preg_replace('/\s+/', '\u0020', $request->isbn);
            $existsIsbn = Book::where('isbn', $isbn)->exists();
            if (!$existsIsbn) {
                $book = new Book();
                $book->isbn = $isbn;
                $book->title = $request->title;
                $book->description = $request->description;
                $book->published_date = Carbon::now();
                $book->category_id = $request->category["id"];
                $book->editorial_id = $request->editorial["id"];
                $book->save();
                foreach ($request->authors as $author) {
                    $book->authors()->attach($author);
                }
                return $this->getResponse201('book', 'created', $book);
            } else {
                return $this->getResponse500(['The isbn field must be unique']);
            }
        } catch (Exception $e) {
            return $this->getResponse500([$e->getMessage()]);
        }
    }
    public function show($id)
    {
        $bookExists = Book::findOrFail($id);
        $bookExists->category;
        $bookExists->editorial;
        $bookExists->authors;
        return $this->getResponse200($bookExists);
    }
    public function update(Request $request, $id)
    {
        $bookExists = Book::findOrFail($id);
        try {
            //code...
            $bookExists->isbn = $request->isbn;
            $bookExists->title = $request->title;
            $bookExists->description = $request->description;
            $bookExists->published_date = $request->published_date;
            $bookExists->category_id = $request->category_id;
            $bookExists->editorial_id = $request->editorial_id;
            $bookExists->update();
            $idsAuthors = [];
            foreach ($request->authors as $author) {
                array_push($idsAuthors, $author['id']);
            }
            $bookExists->authors()->sync($idsAuthors);
            return $this->getResponse201('book', 'updated', $bookExists);
        } catch (Exception $e) {
            return $this->getResponse500($e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $bookExists = Book::findOrFail($id);
            $bookExists->category_id = null;
            $bookExists->editorial_id = null;
            foreach ($bookExists->authors as $author) {
                $bookExists->authors()->detach($author['id']);
            }
            $bookExists->delete();
            return $this->getResponse201('book', 'deleted', $id);
        } catch (Exception $e) {
            return $this->getResponse500($e->getMessage());
        }
    }
    public function addBookReview(Request $request, $book_id)
    {
        $validator = Val::make($request->all(), ['comment' => 'required']);
    }
}
