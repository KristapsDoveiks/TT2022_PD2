<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;


class BookController extends Controller
{
	public function __construct()
{
 $this->middleware('auth');
}

    public function list()
{
 $items = Book::orderBy('name', 'asc')->get();
 return view(
 'book.list',
 [
 'title' => 'Grāmatas',
 'items' => $items
 ]
 );
}

public function create()
{
 $authors = Author::orderBy('name', 'asc')->get();
 return view(
 'book.form',
 [
 'title' => 'Pievienot grāmatu',
 'book' => new Book(),
 'authors' => $authors,
 ]
 );
}

public function put(BookRequest $request)
{
 $validatedData = $request->validate([
 'name' => 'required|min:3|max:256',
 'author_id' => 'required',
 'description' => 'nullable',
 'price' => 'nullable|numeric',
 'year' => 'numeric',
 'image' => 'nullable|image',
 'display' => 'nullable'
 ]);
 $book = new Book();
 $book->name = $validatedData['name'];
 $book->author_id = $validatedData['author_id'];
 $book->description = $validatedData['description'];
 $book->price = $validatedData['price'];
 $book->year = $validatedData['year'];
 $book->display = (bool) ($validatedData['display'] ?? false);
 $book->save();
 return redirect('/books');
}

public function update(Book $book)
{
 $authors = Author::orderBy('name', 'asc')->get();
 return view(
 'book.form',
 [
 'title' => 'Rediģēt grāmatu',
 'book' => $book,
 'authors' => $authors,
 ]
 );
}
public function patch(Book $book, BookRequest $request)
{
 $validatedData = $request->validate([
 'name' => 'required|min:3|max:256',
 'author_id' => 'required',
 'description' => 'nullable',
 'price' => 'nullable|numeric',
 'year' => 'numeric',
 'image' => 'nullable|image',
 'display' => 'nullable'
 ]);
 $book->name = $validatedData['name'];
 $book->author_id = $validatedData['author_id'];
 $book->description = $validatedData['description'];
 $book->price = $validatedData['price'];
 $book->year = $validatedData['year'];
 $book->display = (bool) ($validatedData['display'] ?? false);
 
 if ($request->hasFile('image')) {
 $uploadedFile = $request->file('image');
 $extension = $uploadedFile->clientExtension();
 $name = uniqid();
 $book->image = $uploadedFile->storePubliclyAs(
 '/',
 $name . '.' . $extension,
 'uploads'
 );
	}

 $book->save();
 return redirect('/books/update/' . $book->id);
}


private function saveBookData(Book $book, BookRequest $request)
{
 $validatedData = $request->validated();
$book->fill($validatedData);
 $book->display = (bool) ($validatedData['display'] ?? false);
 if ($request->hasFile('image')) {
 $uploadedFile = $request->file('image');
 $extension = $uploadedFile->clientExtension();
 $name = uniqid();
 $book->image = $uploadedFile->storePubliclyAs(
 '/',
 $name . '.' . $extension,
 'uploads'
 );
 }
 $book->save();
}
public function put(Request $request)
{
 $book = new Book();
 $this->saveBookData($book, $request);
 return redirect('/books');
}
public function patch(Book $book, Request $request)
{
 $this->saveBookData($book, $request);
 return redirect('/books/update/' . $book->id);
}

public function delete(Book $book)
{
 $book->delete();
 return redirect('/books');
}

}
