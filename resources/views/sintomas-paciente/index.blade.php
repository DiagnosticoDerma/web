@extends('layouts.app')
@section('content')
@include('sweetalert::alert')
<div class="row mb-2 mb-xl-3">
	<div class="col-auto d-none d-sm-block">
		<h3><strong>Síntomas Paciente</strong></h3>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<div class="row">
			<label class="col-form-label col-sm-2">Tipo de Enfermedad</label>
			<div class="col-sm-3 mb-4">
				{!! Form::select('tipo',$tipo_enfermedad, null, ['class' => 'form-select','id' => 'tipo']) !!}
			</div>
		</div>
		<div class="table-responsive">
			<table id="sintomas" class="table table-striped text-center" style="width:100%">
				<thead>
					<tr>
						<th>#</th>
						<th>Paciente</th>
						<th>Tipo de Enfermedad</th>
						<th>Fecha</th>
						<th>Estado</th>
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
	listar();

	$("#tipo").change(function() {
		listar();
	});

	function listar(){
		var tipo_enfermedad = $("#tipo").val();

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
				"url": "{{ route('sintomas.paciente.lista') }}",
				"data": {tipo_enfermedad: tipo_enfermedad}
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
	}
</script>
@endsection