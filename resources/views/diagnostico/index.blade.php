@extends('layouts.app')
@section('content')
@include('sweetalert::alert')
<div class="row mb-2 mb-xl-3">
	<div class="col-auto d-none d-sm-block">
		<h3><strong>Diagnóstico</strong></h3>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<div class="row">
			<form class="d-sm-inline-block" id="form-diagnostico">
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
			<div class="col-sm-4 mb-4 pt-2 ps-3">
				<strong></strong>
			</div>
			<div class="col-sm-8 mb-4 text-sm-end">
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ver-auditoria">Ver auditoria</button>
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-auditoria">Auditar</button>
				<a href="#" class="btn btn-primary">Nuevo Diagnóstico</a>
			</div>
		</div>
		<div class="table-responsive">
			<table id="paciente" class="table table-striped text-center" style="width:100%">
				<thead>
					<tr>
						<th>#</th>
						<th>Fecha</th>
						<th>Doctor</th>
						<th class="no-export">Acciones</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" id="ver-auditoria" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Historia Clínica</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body m-3">
				<div class="table-responsive">
					<table id="auditoria" class="table table-striped text-center" style="width:100%">
						<thead>
							<tr>
								<th>#</th>
								<th>Estado</th>
								<th>Descripción</th>
								<th>Fecha</th>
								<th>Borrar</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="create-auditoria" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Nuevo Historia Clínica</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="historia-clinica">
				<div class="modal-body m-3">
					<div class="mb-3 row">
						<label class="col-form-label col-sm-2 text-sm-end">Estado</label>
						<div class="col-sm-10">
							{!! Form::select('estado',['' => 'Seleccionar','1' => 'Historia clínica correcta','0' => 'Historia clínica incorrecta'], null, ['class' => 'form-select','data-validation' => 'required','id' => 'estado']) !!}
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-form-label col-sm-2 text-sm-end">Descripción</label>
						<div class="col-sm-10">
							{!! Form::textarea('descripcion', null, ['class' => 'form-control','maxlength' => '200','rows' => '3','id' => 'descripcion']) !!}
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@section('js')
<script>
	var id_usuario;

	$("#form-diagnostico").submit(function(e) {
		e.preventDefault();
		let dni = $("#dni").val();
		loading("show");
		$.post("{{ route('diagnostico.search') }}", {dni: dni}, function(res) {
			loading("hide");
			if(res.result){
				$("#resultados").removeClass('d-none');
				$("#resultados strong").html(res.data.nombres+" "+res.data.apellidos);
				id_usuario = res.data.id;
				let url = "{{URL::to('/diagnostico')}}" + "/" + id_usuario + "/create";
				$("#resultados a").attr("href", url);
				lista();
				lista_auditoria();
			}else{
				$("#resultados").addClass('d-none');
				Swal.fire(res.message,'','error');
			}
		});
	});

	function lista(){
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
				"url": "{{ route('diagnostico.lista') }}",
				"data": {id_usuario: id_usuario}
			},
			"iDisplayLength":10,
			dom: 'Bfrtip',
			buttons: [
			{
				extend: 'excelHtml5',
				title: 'Sistema experto - Diagnóstico',
				className: 'btn btn-success',
				text: '<i class="far fa-file-excel"></i> EXCEL',
				exportOptions: { columns: ":not(.no-export)" }
			},
			{
				extend: 'pdfHtml5',
				title: 'Sistema experto - Diagnóstico',
				orientation: 'landscape',
				className: 'btn btn-danger',
				text: '<i class="far fa-file-pdf"></i> PDF',
				exportOptions: { columns: ":not(.no-export)" }
			},
			],
		});
	}

	function lista_auditoria(){
		$('#auditoria').DataTable( {
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
				"url": "{{ route('historia.clinica.index') }}",
				"data": {id_usuario: id_usuario}
			},
			"iDisplayLength":10
		});
	}

	function enviarCorreo(id){
		Swal.fire({
			title: '¿Enviar correo?',
			text: "",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Confirmar',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.value) {
				loading("show");
				$.get(`/diagnostico/email/${id}`, function(res) {
					loading("hide");
					if(res.result){
						Swal.fire(res.message,'','success');
					}else{
						Swal.fire(res.message,'','error');
					}
				});
			}
		});
	}

	$("#historia-clinica").submit(function(e) {
		e.preventDefault();
		let estado = $("#estado").val();
		let descripcion = $("#descripcion").val();
		let data = {
			id_usuario: id_usuario,
			estado: estado,
			descripcion: descripcion
		};
		loading("show");
		$.post("{{ route('historia.clinica.store') }}", data, function(res) {
			loading("hide");
			if(res.result){
				limpiar_campos();
				$("#create-auditoria").modal("hide");
				Swal.fire(res.message,'','success');
				lista_auditoria();
				$("#ver-auditoria").modal("show");
			}else{
				Swal.fire(res.message,'','error');
			}
		});
	});

	function limpiar_campos(){
		$("#estado").val("");
		$("#descripcion").val("");
	}

	function delete_historia_clinica(id){
		Swal.fire({
			title: '¿Esta seguro de borrar este registro?',
			text: "",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Confirmar',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.value) {
				loading("show");
				$.get(`/historia-clinica/eliminar/${id}`, function(res) {
					loading("hide");
					if(res.result){
						Swal.fire(res.message,'','success');
						lista_auditoria();
					}else{
						Swal.fire(res.message,'','error');
					}
				});
			}
		});
	}
</script>
@endsection