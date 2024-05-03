@extends('layouts.app')

@section('content')
<div class="row mb-2 mb-xl-3">
	<div class="col-auto d-none d-sm-block">
		<h3><strong>Editar Tipo de enfermedad</strong></h3>
	</div>
</div>
<div class="card">
	<div class="card-body">
		{!! Form::model($tipo_enfermedad, ['route' => ['tipo-enfermedad.update', $tipo_enfermedad->id], 'method' => 'patch']) !!}
		@include('tipo-enfermedad.fields')		
		{!! Form::close() !!}
	</div>
</div>
@endsection