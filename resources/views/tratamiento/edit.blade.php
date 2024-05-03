@extends('layouts.app')

@section('content')
<div class="row mb-2 mb-xl-3">
	<div class="col-auto d-none d-sm-block">
		<h3><strong>Registro de tratamiento</strong></h3>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<form id="form-tratamiento">
			<div class="mb-3 row">
				<h5 class="card-title">Paciente: {{ $enfermedad_tratamiento->usuario->nombres." ".$enfermedad_tratamiento->usuario->apellidos }}</h5>
			</div>
			<div class="mb-3 row">
				<label class="col-form-label col-sm-2">Enfermedad</label>
				<div class="col-sm-4 mb-3">
					{!! Form::select('id_enfermedad',$enfermedades,$enfermedad_tratamiento->id_enfermedad, ['class' => 'form-control select2','data-validation' => 'required','id' => 'id_enfermedad']) !!}
				</div>
				<label class="col-form-label col-sm-2">Fecha</label>
				<div class="col-sm-4 mb-3">
					{!! Form::date('fecha',$enfermedad_tratamiento->fecha, ['class' => 'form-control','data-validation' => 'required']) !!}
				</div>
			</div>
			<div class="mb-3 row">
				<h5 class="card-title">Agregar Medicina</h5>
			</div>
			<div class="mb-3 row">
				<label class="col-form-label col-sm-2">Medicina</label>
				<div class="col-sm-10 mb-3">
					{!! Form::select('medicina',$medicina, null, ['class' => 'form-control select2', 'id' => 'id_medicina']) !!}
				</div>
				<label class="col-form-label col-sm-2">Frecuencia</label>
				<div class="col-sm-5">
					{!! Form::select('frecuencia',['' => 'Seleccionar','1 Tableta','1/2 Tableta','1 Cucharada'], null, ['class' => 'form-control','id' => 'frecuencia']) !!}
				</div>
				<div class="col-sm-5">
					{!! Form::select('repeticion',['' => 'Seleccionar','Una vez al día','Cada 5 horas','3 veces al día'], null, ['class' => 'form-control','id' => 'repeticion']) !!}
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
						<tbody id="data_medicina"></tbody>
					</table>
				</div>
			</div>
			<div class="mb-3">
				<label class="form-label">Recomendaciones</label>
				{!! Form::textarea('recomendaciones', $enfermedad_tratamiento->recomendaciones, ['class' => 'form-control','rows' => '3']) !!}
			</div>
			<div class="mb-3 row">
				<div class="col-sm-12 d-flex justify-content-between">
					<a href="{{ route('tratamiento.pdf',$enfermedad_tratamiento->id) }}" target="_blank" class="btn btn-primary">
						<i class="align-middle" data-feather="printer"></i>
						Imprimir
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
	let id_enfermedad_tratamiento = "{{ $enfermedad_tratamiento->id }}";
	consultarTratamientoDetalle();
	var arreglo_medicina = [];

	function consultarTratamientoDetalle(){
		let url = `/enfermedad-tratamiento/${id_enfermedad_tratamiento}/detalle`;
		loading("show");
		$.get(url, function(res) {
			loading("hide");
			if(res.result){
				arreglo_medicina = res.data;
				listarMedicinas();
			}
		});
	}

	$("#agregar").click(function() {
		let id_medicina = $("#id_medicina").val();
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
				let data = {
					id_enfermedad_tratamiento: id_enfermedad_tratamiento,
					id_medicina: id_medicina,
					frecuencia: frecuencia,
					cantidad: cantidad_total,
					detalles: detalles
				};
				let url = "{{ route('enfermedad.tratamiento.detalle.store') }}";
				loading("show");
				$.post(url, data, function(res) {
					loading("hide");
					if(res.result){
						arreglo_medicina = res.data;
						listarMedicinas();
						limpiarCampos();
						Swal.fire("Medicina agregado correctamente","","success");
					}					
				});
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
			data += `<td><button type="button" onclick="deleteMedicina(${val.id})" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></td>`;
			data += `</tr>`;
		});
		$("#data_medicina").html(data);
	}

	function deleteMedicina(id)
	{
		Swal.fire({
			title: 'Esta seguro de eliminar este registro?',
			text: "",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Confirmar',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.value) {
				let url = `/enfermedad-tratamiento/${id}/deteleDetalle`;
				loading("show");
				$.get(url, function(res) {
					loading("hide");
					if(res.result){
						arreglo_medicina = res.data;				
						listarMedicinas();
						limpiarCampos();
						Swal.fire("Medicina eliminado correctamente","","success");
					}		
				});
			}
		});		
	}

	function limpiarCampos(){
		$("#id_medicina").val("");
		$("#frecuencia").val("");
		$("#repeticion").val("");
		$("#cantidad_total").val("");
		$("#detalles").val("");
		$(".select2").select2();
	}

	$("#form-tratamiento").submit(function(e) {
		e.preventDefault();

		var data_form = $(this).serializeArray();
		let id_usuario = "{{ $enfermedad_tratamiento->id_usuario }}";
		
		var data = {
			id_enfermedad: data_form[0]["value"],
			id_usuario: id_usuario,
			fecha: data_form[1]["value"],
			recomendaciones: data_form[7]["value"]
		};
		let url = `/tratamiento-user/update/${id_enfermedad_tratamiento}`;
		loading("show");
		$.post(url, data, function(res) {
			loading("hide");
			if(res.result){
				location.href="{{ route('tratamiento.user.index') }}" + "?id_user=" + id_usuario;
			}else{
				Swal.fire(res.message,"","error");
			}
		});		
	});
</script>
@endsection