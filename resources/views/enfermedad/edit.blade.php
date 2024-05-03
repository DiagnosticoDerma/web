@extends('layouts.app')

@section('content')
<div class="row mb-2 mb-xl-3">
	<div class="col-auto d-none d-sm-block">
		<h3><strong>Editar Enfermedad</strong></h3>
	</div>
</div>
<div class="card">
	<div class="card-body">
		{!! Form::model($enfermedad, ['route' => ['enfermedad.update', $enfermedad->id], 'method' => 'patch','files' => true]) !!}
		@include('enfermedad.fields')		
		{!! Form::close() !!}
	</div>
</div>
@endsection