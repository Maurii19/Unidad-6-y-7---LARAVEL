@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Posts</h2>
            </div>
            <div class="pull-right">
                @can('post-create')
                <a class="btn btn-success" href="{{ route('posts.create') }}"> Crear nuevo post.</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Titulo</th>
            <th>Descripcion</th>
            <th width="280px">Acciones</th>
        </tr>
	    @foreach ($posts as $post)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $post->title }}</td>
	        <td>{{ $post->body }}</td>
	        <td>
                <form action="{{ route('posts.destroy',$post->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('posts.show',$post->id) }}">Ver</a>
                    @can('post-edit')
                    <a class="btn btn-primary" href="{{ route('posts.edit',$post->id) }}">Editar</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('post-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $posts->links() !!}


@endsection