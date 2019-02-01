<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:Listar post');
         $this->middleware('permission:Crear post', ['only' => ['create','store']]);
         $this->middleware('permission:Editar post', ['only' => ['edit','update']]);
         $this->middleware('permission:Eliminar post', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->paginate(5);
        return view('posts.index',compact('posts'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required',
        ],
        [
            'title.required' => 'Introduce el titulo',
            'body.required' => 'Introduce el cuerpo del post'

        ]);


        Post::create($request->all());


        return redirect()->route('posts.index')
                        ->with('success','El post ha sido creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required',
        ],
        [
            'title.required' => 'Introduce el titulo',
            'body.required' => 'Introduce el cuerpo del post'

        ]);


        $post->update($request->all());


        return redirect()->route('posts.index')
                        ->with('success','El post ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();


        return redirect()->route('posts.index')
                        ->with('success','El post ha sido eliminado');
    }
}
