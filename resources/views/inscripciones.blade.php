@extends('layout')

@section('content')
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
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection