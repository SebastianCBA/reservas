@extends('layouts.app')

@section('title', 'Reservas')

@section('content')
<div class="container">
	<a href="{{ route('reservas.crear') }}" class="btn btn-info pull-right">Crear Reserva</a>
	@if(count($reservas))
	<table class="table table-striped">
		<thead>
			<th>Codigo</th>
			<th>Usuario</th>
			<th>Fecha</th>
			<th>Butacas</th>
			<th></th>
		</thead>
		<tbody>
			@foreach($reservas as $reserva)
				<tr>
					<td>{{ $reserva->codigo }}</td>
					<td>{{ $reserva->usuario->nombres }}</td>
					<td>{{ date("d/m/Y", strtotime($reserva->fecha)) }}</td>
					<td>{{ $reserva->cantidad }}</td>
					<td>
					<a href="{{ route('reservas.editar', $reserva->id) }}" title="Editar" class="btn btn-warning"> 
							<span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
					</a> 
					<a href="{{ route('reservas.destruir', $reserva->id) }}" title="Destruir" 
							onclick="return confirm('Estas seguro que quieres eliminar la reserva {{ $reserva->codigo }} {{ $reserva->usuario->apellidos }}?')" 
							class="btn btn-danger">						
							<span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>						
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	{{ $reservas->render() }}
	@else
		<div>
			<p>Aun no hay reservas</p>
		</div>		
	@endif
</div>
@endsection