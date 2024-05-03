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
				<h5 class="card-title">Paciente: {{ $diagnostico->paciente->nombres." ".$diagnostico->paciente->apellidos }}</h5>
			</div>
			<div class="mb-3 row">
				<label class="col-form-label col-6 col-sm-2">Enfermedad:</label>
				<label class="col-form-label col-6 col-sm-7 text-end text-sm-start">{{ $diagnostico_enfermedad->enfermedad->nombre }}</label>
				<label class="col-form-label col-6 col-sm-1">Fecha:</label>
				<label class="col-form-label col-6 col-sm-2 text-end">{{ date('d/m/Y',strtotime($diagnostico->created_at)) }}</label>
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
					<button type="button" class="btn btn-primary" id="agregar"><i class="fas fa-plus"></i> Agregar</button>
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
				{!! Form::textarea('recomendaciones', null, ['class' => 'form-control','rows' => '3']) !!}
			</div>
			<div class="mb-3 row">
				<div class="col-sm-12 d-flex justify-content-between">
					<a href="{{ route('diagnostico.resultados',$diagnostico->id) }}" class="btn btn-primary">
						<i class="align-middle" data-feather="chevrons-left"></i>
						Atras
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
	let arreglo_medicina = [];
	consultarTratamientoDetalle();
	
	function consultarTratamientoDetalle(){
		let id_usuario = "{{ $diagnostico->paciente->id }}";
		let id_enfermedad = "{{ $diagnostico_enfermedad->id_enfermedad }}";
		let url = "{{ route('enfermedad.tratamiento.consultar.medicina') }}";
		loading("show");
		$.post(url,{id_usuario: id_usuario,id_enfermedad: id_enfermedad}, function(res) {
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
				let nombre_medicina = $('#id_medicina option:selected').text();		
				let data = {
					id_medicina: id_medicina,
					nombre_medicina: nombre_medicina,
					frecuencia: frecuencia,
					cantidad: cantidad_total,
					detalles: detalles
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
			data += `<td><button type="button" onclick="deleteMedicina(${index})" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></td>`;
			data += `</tr>`;
		});
		$("#data_medicina").html(data);
	}

	function deleteMedicina(i)
	{
		arreglo_medicina.splice(i,1);
		listarMedicinas();
		limpiarCampos();
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

		let id_usuario = "{{ $diagnostico->paciente->id }}";
		let id_diagnostico = "{{ $diagnostico->id }}";
		let id_enfermedad = "{{ $diagnostico_enfermedad->id_enfermedad }}";
		let fecha = "{{ date('Y-m-d',strtotime($diagnostico->created_at)) }}";
		var data = {
			id_diagnostico: id_diagnostico,
			id_enfermedad: id_enfermedad,
			id_usuario: id_usuario,
			fecha: fecha,
			recomendaciones: data_form[5]["value"],
			data_medicina: arreglo_medicina
		};
		
		loading("show");
		$.post("{{ route('diagnostico.tratamiento.store') }}", data, function(res) {
			loading("hide");
			if(res.result){
				location.reload();
			}else{
				Swal.fire("Ocurrio un error intentelo mas tarde","","error");
			}
		});
	});
</script>
@endsection