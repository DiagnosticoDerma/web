@extends('layouts.app')
@section('content')
@include('sweetalert::alert')
<div class="row mb-2 mb-xl-3">
	<div class="col-auto d-none d-sm-block">
		<h3><strong>Tratamiento General</strong></h3>
	</div>

	<div class="col-auto ms-auto text-end mt-n1">
		<a href="{{ route('tratamiento.create') }}" class="btn btn-primary">Nuevo Tratamiento</a>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<div class="row">
			<label class="col-form-label col-sm-2">Enfermedad</label>
			<div class="col-sm-3 mb-4">
				{!! Form::select('id_enfermedad',$enfermedades,null, ['class' => 'form-control select2','id' => 'id_enfermedad']) !!}
			</div>
		</div>
		<div class="table-responsive">
			<table id="tratamientos" class="table table-striped text-center" style="width:100%">
				<thead>
					<tr>
						<th>#</th>
						<th>Enfermedad</th>
						<th>Edad</th>
						<th>Peso</th>
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
	lista();

	$("#id_enfermedad").change(function() {
		lista();
	});

	function lista(){
		let id_enfermedad = $("#id_enfermedad").val();
		$('#tratamientos').DataTable( {
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
				"url": "{{ route('tratamiento.lista') }}",
				"data": {id_enfermedad: id_enfermedad}
			},
			"iDisplayLength":10,
			dom: 'Bfrtip',
			buttons: [
			{
				extend: 'excelHtml5',
				title: 'Sistema experto - Tratamiento General',
				className: 'btn btn-success',
				text: '<i class="far fa-file-excel"></i> EXCEL',
				exportOptions: { columns: ":not(.no-export)" }
			},
			{
				extend: 'pdfHtml5',
				title: 'Sistema experto - Tratamiento General',
				orientation: 'landscape',
				className: 'btn btn-danger',
				text: '<i class="far fa-file-pdf"></i> PDF',
				exportOptions: { columns: ":not(.no-export)" }
			},
			],
		});
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
					url: "{{URL::to('/tratamiento-general')}}" + "/" + id,
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
</script>
@endsection