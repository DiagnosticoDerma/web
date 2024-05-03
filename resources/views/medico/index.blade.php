@extends('layouts.app')
@section('content')
@include('sweetalert::alert')
<div class="row mb-2 mb-xl-3">
	<div class="col-auto d-none d-sm-block">
		<h3><strong>Médicos</strong></h3>
	</div>

	<div class="col-auto ms-auto text-end mt-n1">
		<a href="{{ route('user.medico.create') }}" class="btn btn-primary">Agregar Médico</a>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<table id="medicos" class="table table-striped text-center" style="width:100%">
			<thead>
				<tr>
					<th>#</th>
					<th>DNI</th>
					<th>Nombres y Apellidos</th>
					<th>Teléfono</th>
					<th>Especialidad</th>
					<th class="no-export">Acciones</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@endsection

@section('js')
<script>
	var table = $('#medicos').DataTable( {
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
			"method":"GET",
			"url": "{{ route('user.medico.lista') }}"
		},
		"iDisplayLength":10,
		dom: 'Bfrtip',
		buttons: [
		{
			extend: 'excelHtml5',
			title: 'Sistema experto - medicos',
			className: 'btn btn-success',
			text: '<i class="far fa-file-excel"></i> EXCEL',
			exportOptions: { columns: ":not(.no-export)" }
		},
		{
			extend: 'pdfHtml5',
			title: 'Sistema experto - medicos',
			orientation: 'landscape',
			className: 'btn btn-danger',
			text: '<i class="far fa-file-pdf"></i> PDF',
			exportOptions: { columns: ":not(.no-export)" }
		},
		],
	});

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
                    url: "{{URL::to('/user')}}" + "/" + id,
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