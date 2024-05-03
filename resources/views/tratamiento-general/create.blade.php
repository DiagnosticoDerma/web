@extends('layouts.app')

@section('content')
<div class="row mb-2 mb-xl-3">
	<div class="col-auto d-none d-sm-block">
		<h3><strong>Registro de tratamiento General</strong></h3>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<form id="form-tratamiento">
			<div class="mb-3 row">
				<label class="col-form-label col-sm-2">Enfermedad</label>
				<div class="col-sm-10">
					{!! Form::select('id_enfermedad',$enfermedades,null, ['class' => 'form-control select2','data-validation' => 'required']) !!}
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-form-label col-sm-2">Rango de edad</label>
				<div class="col-sm-3 mb-3">
					{!! Form::number('edad_min',null, ['class' => 'form-control','data-validation' => 'required', 'onkeypress' => 'return validaNumericos(event)']) !!}
				</div>
				<div class="col-sm-3 mb-3">
					{!! Form::number('edad_max',null, ['class' => 'form-control','data-validation' => 'required', 'onkeypress' => 'return validaNumericos(event)']) !!}
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-form-label col-sm-2">Rango de peso</label>
				<div class="col-sm-3 mb-3">
					{!! Form::number('peso_min',null, ['class' => 'form-control','data-validation' => 'required', 'onkeypress' => 'return validaNumericos(event)']) !!}
				</div>
				<div class="col-sm-3 mb-3">
					{!! Form::number('peso_max',null, ['class' => 'form-control','data-validation' => 'required', 'onkeypress' => 'return validaNumericos(event)']) !!}
				</div>
			</div>
			<div class="mb-3 row">
				<h5 class="card-title">Agregar Medicina</h5>
			</div>
			<div class="mb-3 row">
				<label class="col-form-label col-sm-2">Medicina</label>
				<div class="col-sm-10 mb-3">
					{!! Form::select('id_medicina',$medicina, null, ['class' => 'form-control select2','id' => 'id_medicina']) !!}
				</div>
				<label class="col-form-label col-sm-2">Frecuencia</label>
				<div class="col-sm-5">
					{!! Form::select('frecuencia',['' => 'Seleccionar','1 Tableta','1/2 Tableta','1 Cucharada'], null, ['class' => 'form-control','id' => 'frecuencia']) !!}
				</div>
				<div class="col-sm-5">
					{!! Form::select('repeticion',['' => 'Seleccionar','una vez al día','cada 5 horas','3 veces al día'], null, ['class' => 'form-control','id' => 'repeticion']) !!}
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-form-label col-sm-2">Cantidad Total</label>
				<div class="col-sm-10 mb-3">
					{!! Form::number('cantidad_total', null, ['class' => 'form-control','onkeypress' => 'return validaNumericos(event)','id' => 'cantidad_total']) !!}
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-form-label col-sm-2">Detalles</label>
				<div class="col-sm-10 mb-3">
					{!! Form::textarea('detalles', null, ['class' => 'form-control','rows' => '3','id' => 'detalles']) !!}
				</div>
			</div>
			<div class="mb-3 row">
				<div class="col-sm-12 mb-3 text-end">
					<button type="button" class="btn btn-primary" id="agregar">Agregar</button>
					<button type="button" class="btn btn-primary d-none" id="update">Guardar Cambios</button>
				</div>
			</div>
			<div class="mb-3 row">
				<div class="table-responsive">
					<table class="table text-center">
						<thead>
							<tr>
								<th>#</th>
								<th>Medicina</th>
								<th>Frecuencia</th>
								<th>Cantidad</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody id="data_medicina">
						</tbody>
					</table>
				</div>
			</div>
			<div class="mb-3">
				<label class="form-label">Recomendaciones</label>
				{!! Form::textarea('recomendaciones', null, ['class' => 'form-control','rows' => '3']) !!}
			</div>
			<div class="mb-3 row">
				<div class="col-sm-12 d-flex justify-content-between">
					<a href="{{ route('tratamiento.index') }}" class="btn btn-danger">
						<i class="align-middle" data-feather="chevrons-left"></i>
						Cancelar
					</a>
					<button type="submit" class="btn btn-success">
						<i class="align-middle" data-feather="save"></i>
						Guardar
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection

@section('js')
<script>
	var tipo=1;
	var arreglo_medicina = [];
	var index_medicina;

	$("#agregar").click(function() {
		let id_medicina = $("#id_medicina").val();
		let index_frecuencia = $("#frecuencia").val();
		let index_repeticion = $("#repeticion").val();
		let frecuencia = $("#frecuencia option:selected").text();
		let repeticion = $("#repeticion option:selected").text();
		let cantidad_total = $("#cantidad_total").val();
		let detalles = $("#detalles").val();

		if(id_medicina && frecuencia && repeticion && cantidad_total){
			let validar = true;
			$.each(arreglo_medicina, function(index, val) {
				if(val.id_medicina == id_medicina){
					validar=false;
				}   
			});
			if(validar){
				frecuencia = frecuencia+" "+repeticion;
				let nombre_medicina = $('#id_medicina option:selected').text();		
				let data = {
					id_medicina: id_medicina,
					nombre_medicina: nombre_medicina,
					frecuencia: frecuencia,
					cantidad: cantidad_total,
					detalles: detalles,
					index_frecuencia: index_frecuencia,
					index_repeticion: index_repeticion
				};
				arreglo_medicina.push(data);
				listarMedicinas();
				limpiarCampos();
			}else{
				Swal.fire("Medicina ya está registrado","","error");
			}
		}else{
			Swal.fire("Campos incompletos","","error");
		}
	});

	function listarMedicinas()
	{
		data="";
		var c = 1;
		$.each(arreglo_medicina, function(index, val) {
			data += `<tr>`;
			data += `<td>${c++}</td>`;
			data += `<td>${val.nombre_medicina}</td>`;
			data += `<td>${val.frecuencia}</td>`;
			data += `<td>${val.cantidad}</td>`;
			data += `<td><button type="button" onclick="editarMedicina(${index})" class="btn btn-warning" data-toggle="tooltip" title="Editar"><i class="fas fa-pen"></i></button>
			<button type="button" onclick="deleteMedicina(${index})" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></td>`;
			data += `</tr>`;
		});
		$("#data_medicina").html(data);
	}

	function deleteMedicina(i)
	{
		arreglo_medicina.splice(i,1);
		listarMedicinas();
		limpiarCampos();
		tipo = 1;
		setButtonSave();
	}

	function editarMedicina(i)
	{
		tipo = 2;
		index_medicina = i;
		setButtonSave();
		let = arr = arreglo_medicina[i];
		limpiarCampos();
		$("#id_medicina").val(arr.id_medicina);
		$("#frecuencia").val(arr.index_frecuencia);
		$("#repeticion").val(arr.index_repeticion);
		$("#cantidad_total").val(arr.cantidad);
		$("#detalles").val(arr.detalles);
		$(".select2").select2();
	}

	$("#update").click(function(){
		let id_medicina = $("#id_medicina").val();
		let validar = true;
		$.each(arreglo_medicina, function(index, val) {
			if(val.id_medicina == id_medicina && index != index_medicina){
				validar=false;
			}   
		});
		if(validar){
			let index_frecuencia = $("#frecuencia").val();
			let index_repeticion = $("#repeticion").val();
			let frecuencia = $("#frecuencia option:selected").text();
			let repeticion = $("#repeticion option:selected").text();
			let cantidad_total = $("#cantidad_total").val();
			let detalles = $("#detalles").val();
			let nombre_medicina = $('#id_medicina option:selected').text();
			frecuencia = frecuencia+" "+repeticion;

			let data = {
				id_medicina: id_medicina,
				nombre_medicina: nombre_medicina,
				frecuencia: frecuencia,
				cantidad: cantidad_total,
				detalles: detalles,
				index_frecuencia: index_frecuencia,
				index_repeticion: index_repeticion
			};

			arreglo_medicina[index_medicina] = data;
			tipo = 1;
			limpiarCampos();
			setButtonSave();
			listarMedicinas();
		}else{
			Swal.fire("Medicina ya está registrado","","error");
		}
	});

	function limpiarCampos(){
		$("#id_medicina").val("");
		$("#frecuencia").val("");
		$("#repeticion").val("");
		$("#cantidad_total").val("");
		$("#detalles").val("");
		$(".select2").select2();
	}

	function setButtonSave(){
		if(tipo == 1){
			$("#agregar").removeClass('d-none');
			$("#update").addClass('d-none');
		}else if(tipo == 2){
			$("#agregar").addClass('d-none');
			$("#update").removeClass('d-none');
		}
	}

	$("#form-tratamiento").submit(function(e) {
		e.preventDefault();

		var data_form = $(this).serializeArray();
		
		var data = {
			id_enfermedad: data_form[0]["value"],
			edad_min: data_form[1]["value"],
			edad_max: data_form[2]["value"],
			peso_min: data_form[3]["value"],
			peso_max: data_form[4]["value"],
			recomendaciones: data_form[10]["value"],
			data_medicina: arreglo_medicina
		};

		loading("show");
		$.post("{{ route('tratamiento.store') }}", data, function(res) {
			loading("hide");
			if(res.result){
				location.href="{{ route('tratamiento.index') }}";
			}else{
				Swal.fire(res.message,"","error");
			}
		});		
	});
</script>
@endsection