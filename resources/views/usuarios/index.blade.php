@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
<div class="container">
	<a href="{{ route('usuarios.crear') }}" class="btn btn-info pull-right">Crear Usuario</a>
	
	<table class="table table-striped">
		<thead>
			<th>Id</th>
			<th>Nombres</th>
			<th>Apellidos</th>
			<th></th>
		</thead>
		<tbody>
			@foreach($usuarios as $usuario)
				<tr>
					<td>{{ $usuario->id }}</td>
					<td>{{ $usuario->nombres }}</td>
					<td>{{ $usuario->apellidos }}</td>
					<td>
					<a href="{{ route('usuarios.editar', $usuario->id) }}" title="Editar" class="btn btn-warning"> 
							<span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
					</a> 
					<a href="{{ route('usuarios.destruir', $usuario->id) }}" title="Destruir" 
							onclick="return confirm('Estas seguro que quieres eliminar el usuario {{ $usuario->nombres }} {{ $usuario->apellidos }} y todas sus reservas?')" 
							class="btn btn-danger">						
							<span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>						
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	{{ $usuarios->render() }}

</div>
@endsection