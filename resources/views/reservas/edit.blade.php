@extends('layouts.app')

@section('title', 'Editar Usuario '.$usuario->nombres.' '.$usuario->apellidos)

@section('content')

<div class="container">

{!! Form::open(['route' => ['usuarios.actualizar', $usuario], 'method' => 'POST', 'files' => false]) !!}
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">
                <strong>Nombres</strong>
                {!! Form::text('nombres', $usuario->nombres, ['class' => 'form-control', 'placeholder' => 'Nombres', 'required']) !!}
            </div>
            
            <div class="form-group">        
                <strong>Apellidos:</strong>
                {!! Form::text('apellidos', $usuario->apellidos, ['class' => 'form-control', 'placeholder' => 'Apellidos', 'required']) !!}
            </div>             

                {!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
        
    </div>


{!! Form::close() !!}
</div>

@endsection

