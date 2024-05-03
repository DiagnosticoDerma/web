@extends('layouts.app')
@section('content')
@include('sweetalert::alert')
<div class="row mb-2 mb-xl-3">
	<div class="col-auto d-none d-sm-block">
		<h3><strong>Tratamientos</strong></h3>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<div class="row">
			<form class="d-sm-inline-block" id="form-paciente">
				<div class="col-sm-12 mb-4">
					<div class="input-group input-group-navbar">
						<input type="text" class="form-control" id="dni" placeholder="Ingrese DNI del paciente" aria-label="Search" maxlength="8" onkeypress="return validaNumericos(event)">
						<button class="btn" type="button">
							<i class="align-middle" data-feather="search"></i>
						</button>
					</div>
				</div>
			</form>
		</div>
		<div id="resultados" class="row d-none">
			<div class="col-sm-8 mb-4 pt-2 ps-3">
				<strong></strong>
			</div>
			<div class="col-sm-4 mb-4 text-sm-end">
				<a href="#" class="btn btn-primary">Nuevo Tratamiento</a>
			</div>
			<div class="row">
				<div class="col-sm-3 mb-4">
					<select id="tipo" class="form-select">
						<option value="">Todos los tratamientos</option>
						<option value="1">Por Fecha</option>
						<option value="2">Por Enfermedad</option>
					</select>
				</div>
				<div class="col-sm-3 mb-4 fecha d-none">
					<select id="fecha" class="form-control select2"></select>
				</div>
				<div class="col-sm-3 mb-4 enfermedad d-none">
					<select id="enfermedades" class="form-control select2"></select>
				</div>
			</div>
		</div>
		<div class="table-responsive">
			<table id="paciente" class="table table-striped text-center" style="width:100%">
				<thead>
					<tr>
						<th>#</th>
						<th>Enfermedad</th>
						<th>Fecha</th>
						<th class="no-export">Acciones</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
@endsection

@section('js')
<script>
	var id_usuario = null;
	var fecha = null;
	var enfermedades = null;
	var tipo = 1;
	var nombre_usuario= null;

	function lista(){
		listaDataTable();
		$.post("{{ route('tratamiento.user.filtros') }}", {id_usuario: id_usuario}, function(res) {
			if(res.result){
				$('#fecha').empty();
				$('#fecha').prepend("<option value>Todas las fechas</option>");
				$.each(res.data.fechas, function (i, item) {
					$('#fecha').append($('<option>', { 
						value: item.fecha,
						text : formato(item.fecha)
					}));
				});

				$('#enfermedades').empty();
				$('#enfermedades').prepend("<option value>Todas las enfermedades</option>");
				$.each(res.data.enfermedades, function (i, item) {
					$('#enfermedades').append($('<option>', { 
						value: item.id_enfermedad,
						text : item.nombre
					}));
				});
				$(".select2").select2();
			}
		});
	}

	function listaDataTable(){
		$('#paciente').DataTable( {
			"language": {
				"lengthMenu": "Ver los _MENU_ Primeros Registros",
				"info": "_END_ de _TOTAL_ registros",
				"infoEmpty": "No se encontraron registros",
				"infoFiltered": "(Filtrado de _MAX_ total entradas)",
				"loadingRecords": "Cargando...",
				"processing": "Procesando...",
				"sSearch": "BUSCAR:",
				"sZeroRecords": "No se encontraron resultados",
				"sEmptyTable": "Ningún dato disponible en esta tabla",
				"oPaginate": {
					"sFirst": "Primero",
					"sLast": "Último",
					"sNext": "Siguiente",
					"sPrevious": "Anterior"
				},
				"fnInfoCallback": null
			},
			"aProcessing": true,
			"aServerSide": true,
			"destroy":true,
			"ajax":{
				"method":"POST",
				"url": "{{ route('tratamiento.user.lista') }}",
				"data": {
					id_usuario: id_usuario,
					fecha: fecha,
					id_enfermedad: enfermedades,
					tipo: tipo
				}
			},
			"iDisplayLength":10,
			dom: 'Bfrtip',
			buttons: [
			{
				extend: 'excelHtml5',
				title: `Sistema experto - Tratamiento (${nombre_usuario})`,
				className: 'btn btn-success',
				text: '<i class="far fa-file-excel"></i> EXCEL',
				exportOptions: { columns: ":not(.no-export)" }
			},
			{
				extend: 'pdfHtml5',
				title: `Sistema experto - Tratamiento (${nombre_usuario})`,
				orientation: 'landscape',
				className: 'btn btn-danger',
				text: '<i class="far fa-file-pdf"></i> PDF',
				exportOptions: { columns: ":not(.no-export)" }
			},
			],
		});
	}

	function formato(texto){
		return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
	}

	var params = new window.URLSearchParams(window.location.search);
	var id_usuario = params.get('id_user')
	if(id_usuario){
		consultarUsuario();
	}

	function deleteRegister(id){
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
					url: "{{URL::to('/tratamiento-user')}}" + "/" + id,
					type: 'DELETE'
				})
				.done(function(res) {
					if(res.result){
						lista();
						Swal.fire(res.message,"","success");
					}else{
						Swal.fire("Ocurrio un error","","error");
					}
				});

			}
		})
	}

	$("#form-paciente").submit(function(e) {
		e.preventDefault();
		id_usuario = null;
		consultarUsuario();
	});

	function consultarUsuario()
	{
		let dni = $("#dni").val();
		loading("show");
		$.post("{{ route('diagnostico.search') }}", {dni: dni,id_usuario: id_usuario}, function(res) {
			loading("hide");
			if(res.result){
				$("#resultados").removeClass('d-none');
				nombre_usuario = res.data.nombres+" "+res.data.apellidos;
				$("#resultados strong").html(nombre_usuario);
				id_usuario = res.data.id;
				let url = "{{URL::to('/tratamiento-user')}}" + "/" + id_usuario + "/create";
				$("#resultados a").attr("href", url);
				lista();
			}else{
				$("#resultados").addClass('d-none');
				Swal.fire(res.message,'','error');
			}
		});
	}

	$("#tipo").change(function() {
		let tipo_search = $(this).val();
		if(tipo_search == 1){
			$("#fecha").val("");
			$(".fecha").removeClass('d-none');
			$(".enfermedad").addClass('d-none');
			$(".select2").select2();
			fecha = null;
			tipo = 1;
		}else if(tipo_search == 2){
			$("#enfermedades").val("");
			$(".fecha").addClass('d-none');
			$(".enfermedad").removeClass('d-none');
			$(".select2").select2();
			enfermedades = null;
			tipo = 2;
		}else{
			$(".fecha").addClass('d-none');
			$(".enfermedad").addClass('d-none');
		}
		listaDataTable();
	});

	$("#fecha").change(function() {
		fecha = $(this).val();
		tipo = 1;
		listaDataTable();
	});

	$("#enfermedades").change(function() {
		enfermedades = $(this).val();
		tipo = 2;
		listaDataTable();
	});
</script>
@endsection