@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tag-editor/1.0.20/jquery.tag-editor.min.css">
@endsection
<div class="mb-3 row">
	<label class="col-form-label col-sm-2 text-sm-end">Tipo de enfermedad</label>
	<div class="col-sm-10">
		{!! Form::select('id_tipo_enfermedad',$tipo_enfermedad,null, ['class' => 'form-control select2','data-validation' => 'required']) !!}
	</div>
</div>
<div class="mb-3 row">
	<label class="col-form-label col-sm-2 text-sm-end">Tipo</label>
	<div class="col-sm-10">
		{!! Form::select('tipo',['' => 'Seleccionar','1' =>'Opciones','Si/No','Valor Numérico'],null, ['class' => 'form-control','data-validation' => 'required','id' => 'tipo']) !!}
	</div>
</div>
<div class="mb-3 row">
	<label class="col-form-label col-sm-2 text-sm-end">Nombre</label>
	<div class="col-sm-10">
		{!! Form::text('nombre', null, ['class' => 'form-control','data-validation' => 'required','maxlength' => '200']) !!}
	</div>
</div>
<div class="mb-3 row opciones d-none">
	<label class="col-form-label col-sm-2 text-sm-end">Items</label>
	<div class="col-sm-10">
		{!! Form::text('items', null, ['class' => 'form-control','maxlength' => '200','data-validation' => 'required','id' => 'items']) !!}
	</div>
</div>
<div class="mb-3 row">
	<div class="col-sm-10 ms-sm-auto">
		<a href="{{ route('sintomas.index') }}" class="btn btn-danger">
			<i class="align-middle" data-feather="chevrons-left"></i>
			Cancelar
		</a>
		<button type="submit" class="btn btn-primary">
			<i class="align-middle" data-feather="save"></i>
			Guardar
		</button>
	</div>
</div>

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tag-editor/1.0.20/jquery.tag-editor.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/caret/1.3.7/jquery.caret.min.js"></script>
<script>
	tipo();
	$('#items').tagEditor();
	$("#tipo").change(function() {
		tipo();
	});

	function tipo()
	{
		const tipo = $("#tipo").val();
		if(tipo == 1){
			$(".row.opciones").removeClass("d-none");
		}else{
			$(".row.opciones").addClass("d-none");
		}
	}
</script>
@endsection