@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tag-editor/1.0.20/jquery.tag-editor.min.css">
@endsection
<div class="mb-3 row">
	<label class="col-form-label col-sm-3 text-sm-end">Tipo de enfermedad</label>
	<div class="col-sm-9">
		{!! Form::select('id_tipo_enfermedad',$tipo_enfermedad,null, ['class' => 'form-control select2','data-validation' => 'required']) !!}
	</div>
</div>
<div class="mb-3 row">
	<label class="col-form-label col-sm-3 text-sm-end">Nombre</label>
	<div class="col-sm-9">
		{!! Form::text('nombre', null, ['class' => 'form-control','data-validation' => 'required','maxlength' => '200']) !!}
	</div>
</div>
<div class="mb-3 row">
	<label class="col-form-label col-sm-3 text-sm-end">Descripción</label>
	<div class="col-sm-9">
		{!! Form::textarea('descripcion', null, ['class' => 'form-control','rows' => '3']) !!}
	</div>
</div>
<div class="mb-3 row align-items-center">
	<label class="col-form-label col-sm-3 text-sm-end">Puntaje de confirmación de enfermedad</label>
	<div class="col-sm-3">
		{!! Form::number('puntaje',null, ['class' => 'form-control','data-validation' => 'required','min' => '1']) !!}
	</div>
	<label class="col-form-label card-subtitle text-muted col-sm-6 text-justify">Si la evaluación es mayor o igual a esta, el paciente tendrá una probabilidad del 100% de tener esta enfermedad.</label>
</div>
<div class="mb-3 row">
	<div class="col-md-3 col-0">
	</div>
	<div class="col-md-4 col-6">
		<a href="{{ route('enfermedad.index') }}" class="btn btn-danger">
			<i class="align-middle" data-feather="chevrons-left"></i>
			Cancelar
		</a>
	</div>
	<div class="col-md-5 col-6 text-end">
		<button type="submit" class="btn btn-primary">
			<i class="align-middle" data-feather="save"></i>
			Guardar
		</button>
	</div>
</div>