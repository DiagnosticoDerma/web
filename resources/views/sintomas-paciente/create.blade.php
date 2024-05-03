@extends('layouts.app')
@section('content')
@include('sweetalert::alert')
<div class="row mb-2 mb-xl-3">
	<div class="col-auto d-none d-sm-block">
		<h3><strong>Síntomas del paciente</strong></h3>
	</div>
	@if($usuario_diagnostico->estado == 0)
	<div class="col-auto ms-auto text-end mt-n1">
		<a href="{{ route('sintomas.paciente.procesar',$usuario_diagnostico->id) }}" class="btn btn-primary">Procesar Síntomas</a>
	</div>
	@endif
</div>
<div class="card">
	<div class="card-header">
		@if($usuario_diagnostico->estado == 1)
		<div class="card-actions float-end">
			<div class="badge bg-success">ATENDIDO</div>			
		</div>
		@endif
		<h5 class="card-title">Paciente: {{ $usuario_diagnostico->usuario->nombres." ".$usuario_diagnostico->usuario->apellidos }}</h5>
	</div>
	<div class="card-body">
		<table class="table text-center" id="sintomas" style="width:100%">
			<thead>
				<tr>
					<th>#</th>
					<th>Síntoma</th>
					<th>Resultado</th>
					@if($usuario_diagnostico->estado == 0)
					<th>Acciones</th>
					@endif
				</tr>
			</thead>
		</table>
	</div>
</div>
@endsection

@section('js')
<script>
	let id_usuario_diagnostico = "{{ $usuario_diagnostico->id }}";
	let table = $('#sintomas').DataTable( {
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
			"url": "{{ route('sintomas.paciente.lista.detalle') }}",
			"data": {id_usuario_diagnostico: id_usuario_diagnostico}
		},
		"iDisplayLength":10,
		dom: 'Bfrtip',
		buttons: [
		{
			extend: 'excelHtml5',
			title: 'Sistema experto - Sintomas Paciente',
			className: 'btn btn-success',
			text: '<i class="far fa-file-excel"></i> EXCEL',
			exportOptions: { columns: ":not(.no-export)" }
		},
		{
			extend: 'pdfHtml5',
			title: 'Sistema experto - Sintomas Paciente',
			orientation: 'landscape',
			className: 'btn btn-danger',
			text: '<i class="far fa-file-pdf"></i> PDF',
			exportOptions: { columns: ":not(.no-export)" }
		},
		],
	});

	function eliminarSintoma(id){
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
					url: "{{URL::to('/paciente-sintomas')}}" + "/" + id,
					type: 'DELETE'
				})
				.done(function(res) {
					if(res.result){
						table.ajax.reload();
						Swal.fire(res.message,"","success");
					}else{
						Swal.fire("Ocurrio un error","","error");
					}
				});

			}
		})
	}
</script>
@endsection