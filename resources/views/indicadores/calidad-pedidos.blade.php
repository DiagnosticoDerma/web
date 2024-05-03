@extends('layouts.app')
@section('content')
@include('sweetalert::alert')
<div class="row mb-2 mb-xl-3">
	<div class="col-auto d-none d-sm-block">
		<h3><strong>Calidad de pedidos generados</strong></h3>
	</div>
</div>
<div class="card">
	<div class="card-body row">
		<div class="col-12 col-md-3 mb-3">
			<label class="form-label">Fecha Inicio</label>
			{!! Form::date('fi', $fecha_inicio, ['class' => 'form-control','id' => 'fi']) !!}
		</div>
		<div class="col-12 col-md-3 mb-3">
			<label class="form-label">Fecha Fin</label>
			{!! Form::date('ff', $fecha_fin, ['class' => 'form-control','id' => 'ff']) !!}
		</div>
		<table id="table-data" class="table table-striped text-center" style="width:100%">
			<thead>
				<tr>
					<th>#</th>
					<th>Fecha</th>
					<th>NPET</th>
					<th>NTPS</th>
					<th>CPG</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@endsection

@section('js')
<script>
	lista();
	$("#fi").change(function(event) {
		lista();
	});

	$("#ff").change(function(event) {
		lista();
	});

	function lista()
	{
		var fi = $("#fi").val();
		var ff = $("#ff").val();

		var table = $("#table-data").DataTable({
			responsive: true,
			language: {
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
			aProcessing: true,
			aServerSide: true,
			destroy:true,
			ajax:{
				"method":"GET",
				"url": "{{ route('reporte1') }}"+"?fi="+fi+"&ff="+ff
			}
		});
	}
</script>
@endsection