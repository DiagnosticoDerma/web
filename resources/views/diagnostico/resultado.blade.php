@extends('layouts.app')

@section('content')
<div class="row mb-2 mb-xl-3">
	<div class="col-auto d-none d-sm-block">
		<h3><strong>Resultados de análisis</strong></h3>
	</div>
</div>
<div class="card">
	<div class="card-header">
		<h5 class="card-title">Paciente: {{ $diagnostico->paciente->nombres." ".$diagnostico->paciente->apellidos }}</h5>
		<h6 class="card-subtitle text-muted">Acontinuación se detallan  las posibles enfermedades que posee el paciente</h6>
	</div>
	<div class="card-body">
		<table class="table text-center">
			<thead>
				<tr>
					<th>#</th>
					<th>Enfermedad</th>
					<th>Probabilidad</th>
					<th>Tratamiento</th>
				</tr>
			</thead>
			<tbody>
				@foreach($enfermedades as $key => $item)
				<tr>
					<td>{{ $key+1 }}</td>
					<td>{{ $item->enfermedad->nombre }}</td>
					<td>{{ $item->probabilidad }}%</td>
					<td>
						<a href="{{ route('diagnostico.tratamiento.create',$item->id) }}" class="btn btn-primary">
							<i class="fas fa-plus"></i>
							Agregar
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection