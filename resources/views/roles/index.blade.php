@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Gestor de Roles</h2>
        </div>
        <div class="pull-right">
        @can('Crear rol')
            <a class="btn btn-success" href="{{ route('roles.create') }}">Crear Nuevo Rol</a>
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
     <th>Nombre</th>
     <th width="280px">Acciones</th>
  </tr>
    @foreach ($roles as $role)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $role->name }}</td>
        <td>
            <a class="btn btn-primary" href="{{ route('roles.show',$role->id) }}">Ver</a>
            @can('Editar rol')
                <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Editar</a>
            @endcan
            @can('Eliminar rol')
                {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
            @endcan
        </td>
    </tr>
    @endforeach
</table>


{!! $roles->render() !!}


@endsection