@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Inicio</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <center><h1>Bienvenido {{Auth::user()->name}}</h1></center>
                    <br>
                    <ul>
                        <li><h5>Usuarios: Podras crear, editar y eliminar Usuarios.</h5></li>
                        <li><h5>Roles: Podras crear, editar y eliminar Roles.</h5></li>
                        <li><h5>Posts: Podras crear, editar y eliminar Posts.</h5></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
