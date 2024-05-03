
<div class="mb-3 row">
	<label class="col-form-label col-sm-2 text-sm-end">DNI</label>
	<div class="col-sm-10">
		{!! Form::number('dni', null, ['class' => 'form-control','data-validation' => 'required length alphanumeric','maxlength' => '8', 'data-validation-length' => '8']) !!}
	</div>
</div>
<div class="mb-3 row">
	<label class="col-form-label col-sm-2 text-sm-end">Nombres</label>
	<div class="col-sm-10">
		{!! Form::text('nombres', null, ['class' => 'form-control','data-validation' => 'required','maxlength' => '200']) !!}
	</div>
</div>
<div class="mb-3 row">
	<label class="col-form-label col-sm-2 text-sm-end">Apellidos</label>
	<div class="col-sm-10">
		{!! Form::text('apellidos', null, ['class' => 'form-control','data-validation' => 'required','maxlength' => '200']) !!}
	</div>
</div>
<div class="mb-3 row">
	<label class="col-form-label col-sm-2 text-sm-end">Teléfono</label>
	<div class="col-sm-10">
		{!! Form::number('telefono', null, ['class' => 'form-control','data-validation' => 'required length alphanumeric','maxlength' => '9', 'data-validation-length' => '9']) !!}
	</div>
</div>
<div class="mb-3 row">
	<label class="col-form-label col-sm-2 text-sm-end">Correo electrónico</label>
	<div class="col-sm-10">
		{!! Form::email('email', null, ['class' => 'form-control','data-validation' => 'required email','maxlength' => '30']) !!}
	</div>
</div>
@if(isset($user))
<div class="mb-3 row">
	<label class="col-form-label col-sm-2 text-sm-end">Contraseña</label>
	<div class="col-sm-10">
		{!! Form::password('password', ['class' => 'form-control','data-validation' => 'required','minlength' => '6']) !!}
	</div>
</div>
@endif
<div class="mb-3 row">
	<label class="col-form-label col-sm-2 text-sm-end">Fecha de Nacimiento</label>
	<div class="col-sm-10">
		{!! Form::date('fecha_nacimiento', null, ['class' => 'form-control','data-validation' => 'required']) !!}
	</div>
</div>

<div class="mb-3 row">
	<label class="col-form-label col-sm-2 text-sm-end">Especialidad</label>
	<div class="col-sm-10">
		{!! Form::select('id_especialidad',$lista_especialidad,null, ['class' => 'form-control select2','data-validation' => 'required']) !!}
	</div>
</div>

<div class="mb-3 row">
	<div class="col-sm-10 ms-sm-auto">
		<a href="{{ route('user.medico.index') }}" class="btn btn-danger">
			<i class="align-middle" data-feather="chevrons-left"></i>
			Cancelar
		</a>
		<button type="submit" class="btn btn-primary">
			<i class="align-middle" data-feather="save"></i>
			Guardar
		</button>
	</div>
</div>