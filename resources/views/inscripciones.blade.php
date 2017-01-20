@extends('layout')

@section('content')
	
	<!--Formulario-->
	{!!Form::open(['route' => 'inscripcion.index', 'method'=>'GET', 'id'=>'form-filtros', 'class'=>'form-inline' ])!!}
		{!!csrf_field()!!}
		<div class='form-group'>
			<label for='nombre'>Nombre</label>
			<input type="text" name="nombre">
		</div>
		<div class='form-group'>
			<label for='apellido'>Apellido</label>
			<input type="text" name="apellido">
		</div>
		<button>Enviar</button>
	{!!Form::close()!!}
	
	<!--Tabla registros -->
	<table class='table table-striped'>
		<thead>
			<tr>
				<th>
					Id
				</th>
				<th>
					Nombres
				</th>
				<th>
					Apellidos
				</th>
				<th>
					Titulo
				</th>
				<th>
					Tipo obra
				</th>
				<th>
					Valor venta
				</th>
				<th>
					
				</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($inscripciones as $inscripcion)
				<tr>
					<td>
						{{$inscripcion->id_inscripcion}}
					</td>
					<td>
						{{$inscripcion->nombre}}
					</td>
					<td>
						{{$inscripcion->apellido}}
					</td>
					<td>
						{{$inscripcion->titulo}}
					</td>
					<td>
						{{$inscripcion->tipo_obra}}
					</td>
					<td>
						{{$inscripcion->valor_venta}}
					</td>
					<td>
						<a href=''>Ver</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection