@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')

<div class="container">
{!! Form::open(['route' => 'usuarios.guardar', 'method' => 'POST']) !!}
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">
                <strong>Nombres</strong>
                {!! Form::text('nombres', null, ['class' => 'form-control', 'placeholder' => 'Nombres', 'required']) !!}
            </div>
            
            <div class="form-group">        
                <strong>Apellidos:</strong>
                {!! Form::text('apellidos', null, ['class' => 'form-control', 'placeholder' => 'Apellidos', 'required']) !!}
            </div>             

                {!! Form::submit('Agregar', ['class' => 'btn btn-primary']) !!}
        
    </div>


{!! Form::close() !!}
</div>

@endsection
