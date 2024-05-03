@extends('layouts.app')

@section('content')
<div class="row mb-2 mb-xl-3">
	<div class="col-auto d-none d-sm-block">
		<h3><strong>Editar Médico</strong></h3>
	</div>
</div>
<div class="card">
	<div class="card-body">
		{!! Form::model($user, ['route' => ['user.medico.update', $user->id], 'method' => 'patch','files' => true]) !!}
		@include('medico.fields')		
		{!! Form::close() !!}
	</div>
</div>
@endsection