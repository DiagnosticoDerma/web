@extends('layouts.app')
@section('content')
@include('sweetalert::alert')
<div class="row mb-2 mb-xl-3">
	<div class="col-auto d-none d-sm-block">
		<h3><strong>Cantidad de registro de datos correctos del paciente</strong></h3>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-3 mb-3">
				<label class="col-form-label">Fecha Inicio</label>
				{!! Form::date('fecha_inicio', $fecha_inicio, ['class' => 'form-control','id' => 'fecha_inicio']) !!}
			</div>
			<div class="col-md-3 mb-3">
				<label class="col-form-label">Fecha Fin</label>
				{!! Form::date('fecha_fin', $fecha_fin, ['class' => 'form-control','id' => 'fecha_fin']) !!}
			</div>
		</div>
		<div class="table-responsive">
			<table id="sintomas" class="table table-striped text-center" style="width:100%">
				<thead>
					<tr>
						<th>#</th>
						<th>Fecha</th>
						<th>NHCACC</th>
						<th>NHCA</th>
						<th>CRDCP</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
@endsection

@section('js')
<script>
	listar();

	$("#fecha_inicio").change(function() {
		listar();
	});

	$("#fecha_fin").change(function() {
		listar();
	});

	function listar(){
		let fecha_inicio = $("#fecha_inicio").val();
		let fecha_fin = $("#fecha_fin").val();

		$('#sintomas').DataTable( {
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
				"url": "{{ route('cantidad.registro.paciente.filter') }}",
				"data": {fi: fecha_inicio,ff: fecha_fin}
			},
			"iDisplayLength":10,
			dom: 'Bfrtip',
			buttons: [
			{
				extend: 'excelHtml5',
				title: 'Sistema experto - Índice de entrega a tiempo de Diagnóstico',
				className: 'btn btn-success',
				text: '<i class="far fa-file-excel"></i> EXCEL',
				exportOptions: { columns: ":not(.no-export)" }
			},
			{
				extend: 'pdfHtml5',
				title: 'Sistema experto - Índice de entrega a tiempo de Diagnóstico',
				orientation: 'landscape',
				className: 'btn btn-danger',
				text: '<i class="far fa-file-pdf"></i> PDF',
				exportOptions: { columns: ":not(.no-export)" }
			},
			],
		});
	}
</script>
@endsection