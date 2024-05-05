$("#example").DataTable({
	responsive: true,
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
});

$.validate({
	modules: 'location, date, security, file',
	lang: 'es'
});

$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

/* Loading Ajax */
var screen = $('#loading-screen');

function loading(name){
	if(name == "show"){
		screen.fadeIn();
	}else if(name == "hide"){
		screen.fadeOut();
	}
}

$(".select2").select2();

setDecimal();

function setDecimal(){
	$('.decimal').keypress(function (event) {
		return isNumber(event, this)
	});
}

function isNumber(evt, element) {

	var charCode = (evt.which) ? evt.which : event.keyCode

	if (
		(charCode != 46 || $(element).val().indexOf('.') != -1) &&
		(charCode < 48 || charCode > 57))
		return false;

	return true;
}

function validaNumericos(event) {
	if(event.charCode >= 48 && event.charCode <= 57 || event.which == 13){
		return true;
	}
	return false;        
}