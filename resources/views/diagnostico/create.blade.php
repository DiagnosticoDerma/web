@extends('layouts.app')

@section('content')
<div class="row mb-2 mb-xl-3">
	<div class="col-auto d-none d-sm-block">
		<h3><strong>Paciente: {{ $user->nombres." ".$user->apellidos }}</strong></h3>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<form id="form-diagnostico">
			<div class="mb-3 row">
				<label class="col-form-label col-sm-2">Tipo de enfermedad</label>
				<div class="col-sm-10">
					{!! Form::select('id_tipo_enfermedad',$tipo_enfermedad,null, ['class' => 'form-control select2','data-validation' => 'required','id' => 'id_tipo_enfermedad']) !!}
				</div>
			</div>
			<div class="mb-3 row">
				<h5 class="card-title col-sm-12">Seleccione los síntomas del paciente, si no aplica deje en blanco</h5>	
			</div>
			<div class="results"></div>
			<div class="mb-3 row">
				<div class="col-sm-12">
					<button type="submit" id="procesar" class="btn btn-primary w-100" disabled>
						Procesar
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

	$("#id_tipo_enfermedad").change(function() {
		let id_tipo_enfermedad = $(this).val();
		var data = "";
		if(id_tipo_enfermedad){
			let url = "{{URL::to('/diagnostico')}}" + "/" + id_tipo_enfermedad + "/sintomas";
			$("#procesar").attr('disabled','disabled');
			loading("show");
			$.get(url, function(res) {
				loading("hide");
				arreglo_sintomas = res.data;
				$("#procesar").removeAttr('disabled');
				if(res.result){
					$.each(res.data, function(index, val) {
						if(val.tipo == 1){
							data += `<div class="mb-3 row">
							<label class="col-form-label col-sm-2">${index+1}. ${val.nombre}</label>
							<div class="col-sm-10">`;
							data += `<select class="form-control setChange" data-index="${index}">`;
							let items = val.items.split(',');
							data += `<option>Seleccionar</option>`;
							$.each(items, function(index_option, item_option){
								data += `<option>${item_option}</option>`;
							});
							data += `</select>`;
							data += `</div></div>`;
						}else if(val.tipo == 2){
							data += `<div class="mb-3 row">
							<label class="col-form-label col-sm-2">${index+1}. ${val.nombre}</label>
							<div class="col-sm-10 d-flex align-items-center">
							<label>
							<input name="sintoma-${index}" type="radio" class="setClick" data-validation="required" value="SI" data-index="${index}">
							SI
							</label>
							<label class="ps-3">
							<input name="sintoma-${index}" type="radio" class="setClick" data-validation="required" value="NO" data-index="${index}">
							NO
							</label>
							</div>
							</div>`;
						}else if(val.tipo == 3){
							data += `<div class="mb-4 row">
							<label class="col-form-label col-sm-2">${index+1}. ${val.nombre}</label>
							<div class="col-sm-10">`;
							data += `<input class="form-control decimal setText" data-index="${index}">`;
							data += `</div></div>`;
						}
						$(".results").html(data);
						function_setText();
						function_setChange();
						function_setClick();
					});
					setDecimal();
				}
			});
		}else{
			$("#procesar").attr('disabled','disabled');
		}
		$(".results").html(data);
	});

	function function_setText(){
		$(".setText").keyup(function() {
			let input = $(this).val();
			let index_input = this.dataset.index;			
			set_data(input,index_input);
		});
	}

	function function_setChange(){
		$(".setChange").change(function() {
			let input = $(this).val();
			let index_input = this.dataset.index;
			set_data(input,index_input);
		});
	}

	function function_setClick(){
		$(".setClick").click(function() {
			let input = $(this).val();
			let index_input = this.dataset.index;
			set_data(input,index_input);
		});
	}

	function set_data(input,index_input)
	{
		$.each(arreglo_sintomas, function(index, val){
			if(index == parseInt(index_input)){
				if(input){
					val.value = input;
				}else{
					val.value = null;
				}
			}
		});

		console.log(arreglo_sintomas);
	}

	$("#form-diagnostico").submit(function(e) {
		e.preventDefault();

		let id_paciente = "{{ $user->id }}";
		let id_tipo_enfermedad = $("#id_tipo_enfermedad").val();
		let data = {
			id_paciente: id_paciente,
			id_tipo_enfermedad: id_tipo_enfermedad,
			data_sintomas: arreglo_sintomas
		};

		loading("show");
		$.post("{{ route('diagnostico.store') }}", data, function(res) {
			loading("hide");
			if(res.result){
				location.href = "{{URL::to('/diagnostico')}}" + "/" + res.data + "/resultados";
			}
		});
	});
</script>
@endsection