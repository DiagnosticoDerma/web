@extends('layouts.app')

@section('content')
<div class="row mb-2 mb-xl-3">
	<div class="col-auto d-none d-sm-block">
		<h3><strong>Editar síntomas para {{ $enfermedad->nombre }}</strong></h3>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<form id="form-sintomas">
			<div class="mb-3 row">
				<label class="col-form-label col-sm-2">Agregar Síntomas</label>
				<div class="col-sm-10">
					{!! Form::select('id_sintoma',$sintomas,$enfermedad_sintomas->id_sintoma, ['class' => 'form-control select2','data-validation' => 'required','id' => 'id_sintoma']) !!}
				</div>
			</div>
			<div class="mb-3 row temperatura d-none">
				<label class="col-form-label col-sm-2">Rango</label>
				<div class="col-sm-2">
					<input type="number" id="rango_min" class="form-control">
				</div>
				<label class="col-form-label col-sm-1 text-sm-center">y</label>
				<div class="col-sm-2">
					<input type="number" id="rango_max" class="form-control">
				</div>
				<label class="col-form-label col-sm-1 text-sm-end">Puntaje</label>
				<div class="col-sm-2 mb-3">
					<input type="number" id="puntaje" min="0" max="100" class="form-control">
				</div>
				<div class="col-sm-2 text-end">
					<button type="button" id="agregar" class="btn btn-primary">Agregar</button>
				</div>
			</div>
			<div class="table-responsive">
				<table id="enfermedad" class="table table-striped text-center" style="width:100%">
					<thead>
						<tr class="cabecera">
							<th>#</th>
							<th>Nombre</th>
							<th>Puntaje</th>
						</tr>
					</thead>
					<tbody id="data_sintomas">
					</tbody>
				</table>
			</div>
			<div class="mb-3 row">
				<div class="col-6">
					<a href="{{ route('enfermedad.sintomas.index',$enfermedad->id) }}" class="btn btn-danger">
						<i class="align-middle" data-feather="chevrons-left"></i>
						Cancelar
					</a>
				</div>
				<div class="col-6 text-end">
					<button type="submit" class="btn btn-primary">
						<i class="align-middle" data-feather="save"></i>
						Guardar Cambios
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection

@section('js')
<script>
	setSintoma();
	var arreglo_sintomas = [];
	var tipo_sintoma = 1;

	$("#id_sintoma").change(function() {
		setSintoma();
	});

	function setSintoma(){
		let id_sintoma = $("#id_sintoma").val();
		if(id_sintoma){
			loading("show");
			$.get("{{URL::to('/enfermedad/consultar_sintoma')}}" + "/" + id_sintoma, function(res) {				
				let data_table = "";
				let cabecera = $('.cabecera');
				let tipo = "{{ $enfermedad_sintomas->sintomas->tipo }}";
				if(res.data.tipo == 1){
					if(res.data.tipo == tipo){						
						loading("show");
						$.get("{{ route('enfermedad.sintomas.detalle',$enfermedad_sintomas->id) }}", function(res) {
							arreglo_sintomas = res.data;
							tipo_sintoma = 2;
							$.each(res.data, function(index, val){
								data_table+= `<tr>`;
								data_table+= `<td>${index+1}</td>`;
								data_table+= `<td>${val.nombre}</td>`;
								data_table+= `<td>
								<div>
								<input type="number" class="form-control decimal puntaje" data-index="${val.id}" min="0" max="100" required value="${val.puntaje}">
								</div>
								</td>`;
								data_table+= `</tr>`;
							});
							$("#data_sintomas").html(data_table);
							function_puntaje();
						});
					}else{
						tipo_sintoma = 1;
						var items = res.data.items.split(',');
						arreglo_sintomas = [];
						$.each(items, function(index, val) {
							data_table+= `<tr>`;
							data_table+= `<td>${index+1}</td>`;
							data_table+= `<td>${val}</td>`;
							data_table+= `<td>
							<div>
							<input type="number" class="form-control decimal puntaje" data-index="${index}" min="0" max="100" required>
							</div>
							</td>`;
							data_table+= `</tr>`;
							let data = {index: index,nombre: val, puntaje: null};
							arreglo_sintomas.push(data);
						});
					}
					$(".temperatura").addClass('d-none');
					cabecera.find('.acciones').remove();
				}else if(res.data.tipo == 2){
					if(res.data.tipo == tipo){
						loading("show");
						$.get("{{ route('enfermedad.sintomas.detalle',$enfermedad_sintomas->id) }}", function(res) {
							arreglo_sintomas = res.data;
							tipo_sintoma = 2;
							$.each(res.data, function(index, val) {
								data_table+= `<tr>`;
								data_table+= `<td>${index+1}</td>`;
								data_table+= `<td>${val.nombre}</td>`;
								data_table+= `<td>
								<div>
								<input type="number" class="form-control decimal puntaje" data-index="${val.id}" min="0" max="100" value="${val.puntaje}" required>
								</div>
								</td>`;
								data_table+= `</tr>`;
							});
							$("#data_sintomas").html(data_table);
							function_puntaje();
						});
					}else{
						tipo_sintoma = 1;
						data_table+= `<tr>`;
						data_table+= `<td>1</td>`;
						data_table+= `<td>SI</td>`;
						data_table+= `<td>
						<div>
						<input type="number" class="form-control decimal puntaje" data-index="1" min="0" max="100" required>
						</div>
						</td>`;
						data_table+= `</tr>`;
						data_table+= `<tr>`;
						data_table+= `<td>2</td>`;
						data_table+= `<td>NO</td>`;
						data_table+= `<td>
						<div>
						<input type="number" class="form-control decimal puntaje" data-index="2" min="0" max="100" required>
						</div>
						</td>`;
						data_table+= `</tr>`;
					}
					arreglo_sintomas = [{index: 1,nombre: "SI", puntaje: null},{index: 2,nombre: "NO", puntaje: null}];
					$(".temperatura").addClass('d-none');
					cabecera.find('.acciones').remove();
				}else if(res.data.tipo == 3){
					arreglo_sintomas = [];
					if(res.data.tipo == tipo){
						loading("show");
						$.get("{{ route('enfermedad.sintomas.detalle',$enfermedad_sintomas->id) }}", function(res) {
							arreglo_sintomas = res.data;
							tipo_sintoma = 2;
							listarSintomas();
						});
					}else{
						tipo_sintoma = 1;
					}
					$(".temperatura").removeClass('d-none');
					if(cabecera.find('.acciones').length===0){
						cabecera.append($('<th class="acciones">Borrar</th>'));
					}
				}
				loading("hide");
				$("#data_sintomas").html(data_table);
				function_puntaje();
			});
		}else{
			$("#data_sintomas").html("");
		}
	}

	$("#agregar").click(function() {
		let rango_min = $("#rango_min").val();
		let rango_max = $("#rango_max").val();
		let puntaje = $("#puntaje").val();

		if(rango_min && rango_max && puntaje){
			let nombre = "Entre "+rango_min+" a "+rango_max;
			if(tipo_sintoma == 1){
				let validar = true;
				$.each(arreglo_sintomas, function(index, val) {
					if(val.nombre == nombre){
						validar=false;
					}   
				});
				if(validar){
					let data = {nombre: nombre, puntaje: puntaje};
					arreglo_sintomas.push(data);
					listarSintomas();
					limpiarInputsRango();
				}else{
					Swal.fire("Nombre ya existe","","error");
				}
			}else if(tipo_sintoma == 2){
				let id_enfermedad_sintomas = "{{ $enfermedad_sintomas->id }}";
				let data = {
					id_enfermedad_sintomas: id_enfermedad_sintomas,
					nombre: nombre,
					puntaje: puntaje
				};
				loading("show");
				$.post("{{ route('enfermedad.consultar.sintoma.detalle') }}", data, function(res) {
					loading("hide");
					if(res.result){
						arreglo_sintomas.push(res.data);
						listarSintomas();
						limpiarInputsRango();
					}else{
						Swal.fire(res.message,"","error");
					}
				});
			}
		}else{
			Swal.fire("Campos incompletos","","error");
		}
	});

	function limpiarInputsRango(){
		$("#rango_min").val("");
		$("#rango_max").val("");
		$("#puntaje").val("");
		$("#rango_min").focus();
	}

	function listarSintomas()
	{
		data="";
		var c = 1;
		$.each(arreglo_sintomas, function(index, val) {
			data += `<tr>`;
			data += `<td>${c++}</td>`;
			data += `<td>${val.nombre}</td>`;
			data += `<td>${val.puntaje}</td>`;
			if(tipo_sintoma == 1){
				data += `<td><button type="button" onclick="deleteSintoma(${index})" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></td>`;
			}else if(tipo_sintoma == 2){
				data += `<td><button type="button" onclick="deleteSintomaBD(${index},${val.id})" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></td>`;
			}
			data += `</tr>`;
		});
		$("#data_sintomas").html(data);
	}

	function deleteSintoma(i)
	{
		arreglo_sintomas.splice(i,1);
		listarSintomas();
	}

	function deleteSintomaBD(i,id)
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
				$.ajax({
					url: "{{URL::to('/enfermedad')}}" + "/" + id + "/sintomas_detalle",
					type: 'DELETE'
				})
				.done(function(res) {
					if(res.result){
						arreglo_sintomas.splice(i,1);
						Swal.fire(res.message,"","success");
						listarSintomas();
					}else{
						Swal.fire(res.message,"","error");
					}
				});

			}
		});		
	}

	$("#form-sintomas").submit(function(e) {
		e.preventDefault();
		let id_sintoma = $("#id_sintoma").val();
		let id_enfermedad_sintomas = "{{ $enfermedad_sintomas->id }}";
		var data = {
			id: id_enfermedad_sintomas,
			id_sintoma: id_sintoma,
			tipo_sintoma: tipo_sintoma,
			data_sintomas: arreglo_sintomas
		};
		
		url = "{{ route('enfermedad.sintomas.update',$enfermedad->id) }}";
		loading("show");
		$.post(url, data, function(res) {
			loading("hide");
			if(res.result){
				location.href = "{{ route('enfermedad.sintomas.index',$enfermedad->id) }}";
			}else{
				Swal.fire(res.message,"","error");
			}
		});
	});

	function function_puntaje(){
		$(".puntaje").keyup(function() {
			let puntaje = $(this).val();
			let index_input = this.dataset.index;
			if(tipo_sintoma == 1){
				$.each(arreglo_sintomas, function(index, val){
					if(val.index == parseInt(index_input)){
						val.puntaje = puntaje;
					}
				});
			}else if(tipo_sintoma == 2){
				$.each(arreglo_sintomas, function(index, val){
					if(val.id == parseInt(index_input)){
						val.puntaje = parseFloat(puntaje);
					}
				});
			}
		});
	}
</script>
@endsection