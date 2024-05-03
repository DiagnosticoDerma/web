@extends('layouts.app')

@section('content')
<div class="row mb-2 mb-xl-3">
	<div class="col-auto d-none d-sm-block">
		<h3><strong>Nueva Medicina</strong></h3>
	</div>
</div>
<div class="card">
	<div class="card-body row">
		{!! Form::open(['route' => 'medicina.store']) !!}
		@include('medicina.fields')		
		{!! Form::close() !!}
	</div>
</div>
@endsection