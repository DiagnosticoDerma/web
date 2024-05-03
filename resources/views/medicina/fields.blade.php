
<div class="mb-3 col-sm-12">
	<label class="col-form-label">Nombre</label>
	{!! Form::text('nombre', null, ['class' => 'form-control','data-validation' => 'required','maxlength' => '200']) !!}
</div>

<div class="mb-3 col-sm-12 d-flex justify-content-between">
	<a href="{{ route('medicina.index') }}" class="btn btn-danger">
		<i class="align-middle" data-feather="chevrons-left"></i>
		Cancelar
	</a>
	<button type="submit" class="btn btn-primary">
		<i class="align-middle" data-feather="save"></i>
		Guardar
	</button>
</div>