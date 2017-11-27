<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use File;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')
            ->except('index','show');
    }

    public function index(){
        $books = Book::orderBy('created_at','desc')
            ->get(['name','image','id']);

        return response()
            ->json([
                'books' => $books
            ]);
    }
    public function create(){
        $form = Book::form();


        return response()
            ->json(['form' => $form]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required|max:3000',
            'image' => 'required|image',
            'text' => 'required|max:3000'
        ]);

        if (!$request->hasFile('image') && !$request->file('image')->isValid()){
            return abort(404,'Image not uploaded');
        }
        $filename = $this->getFileName($request->image);
        $request->image->move(base_path('public/images'),$filename);

        $book = new Book($request->all());
        $book->image = $filename;
        $request->user()
            ->books()->save($book);

        return response()
            ->json([
                'saved'=>true,
                'id'=>$book->id,
                'message' =>'You have successfully created recipe!'
            ]);
    }
    protected function getFileName($file){
        return str_random(32).'.'.$file->extension();
    }
    public function show($id){
        $book = Book::with(['user'])->findOrFail($id);
        return response()
            ->json([
                'book' => $book
            ]);
    }
    public function edit($id, Request $request){
        $form = $request->user()->books()
            ->findOrFail($id,[
                'id','name','description','image','text'
            ]);
        return response(['form' => $form]);
    }
    public function update($id, Request $request){
        $this->validate($request,[
            'name' => 'required|max:255',
            'description' => 'required|max:3000',
            'image' => 'image',
            'text' => 'required'
        ]);
        $book = $request->user()->books()
            ->findOrFail($id);

        $book->name = $request->name;
        $book->description = $request->description;
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $filename = $this->getFileName($request->image);
            $request->image->move(base_path('public/images'),$filename);

             File::delete(base_path('public/images/'.$book->image));
            $book->image=$filename;
        }
        $book->text = $request->text;
        $book->save();
        return response()
            ->json([
                'saved' =>true,
                'id'=> $book->id,
                'message' => 'You have sucecfully updated recipe!'
            ]);
    }
    public function destroy($id, Request $request){
       $book = $request->user()->books()
            ->findOrFail($id);
       //$book = Book::find($id);

        File::delete(base_path('public/images/'.$book->image));
        $book->delete();

        return response()
            ->json([
                'deleted'=> true
            ]);
    }
}
