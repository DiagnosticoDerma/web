@extends('layouts.app')

@section('content')
<div class="row mb-2 mb-xl-3">
	<div class="col-auto d-none d-sm-block">
		<h3><strong>Síntomas para {{ $enfermedad->nombre }}</strong></h3>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<form id="form-sintomas">
			<div class="mb-3 row">
				<label class="col-form-label col-sm-2">Agregar Síntomas</label>
				<div class="col-sm-10">
					{!! Form::select('id_sintoma',$sintomas,null, ['class' => 'form-control select2','data-validation' => 'required','id' => 'id_sintoma']) !!}
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
	var arreglo_sintomas = [];

	$("#id_sintoma").change(function() {
		let id_sintoma = $(this).val();
		if(id_sintoma){
			loading("show");
			$.get("{{URL::to('/enfermedad/consultar_sintoma')}}" + "/" + id_sintoma, function(res) {
				loading("hide");
				let data_table = "";
				let cabecera = $('.cabecera');
				if(res.data.tipo == 1){
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
					$(".temperatura").addClass('d-none');
					cabecera.find('.acciones').remove();
				}else if(res.data.tipo == 2){
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
					arreglo_sintomas = [{index: 1,nombre: "SI", puntaje: null},{index: 2,nombre: "NO", puntaje: null}];
					$(".temperatura").addClass('d-none');
					cabecera.find('.acciones').remove();
				}else if(res.data.tipo == 3){
					arreglo_sintomas = [];
					$(".temperatura").removeClass('d-none');
					if(cabecera.find('.acciones').length===0){
						cabecera.append($('<th class="acciones">Borrar</th>'));
					}
				}
				$("#data_sintomas").html(data_table);
				function_puntaje();
			});
		}else{
			$("#data_sintomas").html("");
		}
	});

	$("#agregar").click(function() {
		let rango_min = $("#rango_min").val();
		let rango_max = $("#rango_max").val();
		let puntaje = $("#puntaje").val();

		if(rango_min && rango_max && puntaje){
			let nombre = "Entre "+rango_min+" a "+rango_max;
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
			data += `<td><button type="button" onclick="deleteSintoma(${index})" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></td>`;
			data += `</tr>`;
		});
		$("#data_sintomas").html(data);
	}

	function deleteSintoma(i)
	{
		arreglo_sintomas.splice(i,1);
		listarSintomas();
	}

	$("#form-sintomas").submit(function(e) {
		e.preventDefault();
		let id_sintoma = $("#id_sintoma").val();
		var data = {
			id_sintoma: id_sintoma,
			data_sintomas: arreglo_sintomas
		};

		url = "{{ route('enfermedad.sintomas.store',$enfermedad->id) }}";
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
			
			$.each(arreglo_sintomas, function(index, val){
				if(val.index == parseInt(index_input)){
					val.puntaje = puntaje;
				}
			});
		});
	}
</script>
@endsection