<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>{{ 'Diagnóstico - '.$diagnostico->paciente->nombres." ".$diagnostico->paciente->apellidos }}</title>
	<style type="text/css">
		@font-face {
			font-family: "roboto-light";
			src: url({{ storage_path('fonts/Roboto-Light.ttf') }}) format("truetype");
		}
		@font-face {
			font-family: "roboto-regular";
			src: url({{ storage_path('fonts/Roboto-Regular.ttf') }}) format("truetype");
		}
		@font-face {
			font-family: "roboto-medium";
			src: url({{ storage_path('fonts/Roboto-Medium.ttf') }}) format("truetype");
		}
		.cabecera{
			display: inline-flex;
			justify-content: space-between;
			align-items: center;
			position: relative;
		}
		.cabecera>img{
			width: 60px;
			height: 60px;
		}
		.cabecera>p.title{
			font-family: "roboto-medium";
			font-size: 20px;
			padding-left: 14rem;
			margin: 0;
		}
		.cabecera>p.fecha{
			position: absolute;
			right: 0;
			font-family: "roboto-medium";
			font-size: 12px;
			margin: 0;
			padding-top: 8px;
		}
		table{
			width: 100%;
		}
		tbody>tr.header{

		}
		thead{
			border-style:double none double none;
			border-width: 3px;
			position: relative;
		}
		thead>tr>td{
			font-family: "roboto-medium";
			font-size: 10px;
			line-height: 3px;		
			text-transform: uppercase;
			padding-bottom: 0;
			margin-bottom: 0;
			position: absolute;
			padding-top: 10px;
		}
		thead.center>tr>td{
			text-align: center;
		}
		tbody{
			padding-top: 1rem;
		}
		tbody>tr>td{
			font-family: "roboto-regular";
			font-size: 11px;
			line-height: 9px;
		}
		tbody.text-min>tr>td{
			font-size: 10px;
		}
		.text-end{
			text-align: right;
		}
		.p-t{
			padding-top: 5px;
		}
		div.recomendaciones{
			border: 2px solid;
			margin-top: 1rem;
		}
		div.recomendaciones p{
			font-family: "roboto-regular";
			font-size: 11px;
			margin: 0;
			padding: 2px 1rem 7px;
		}
	</style>
</head>
<body>
	<div class="cabecera">
		<img src="{{asset('assets/img/logo.png')}}">
		<p class="title">Sistema Experto</p>
		<p class="fecha">{{ date('d/m/Y',strtotime($diagnostico->created_at)) }}</p>
	</div>
	<table>
		<thead class="center">
			<tr>
				<td colspan="2">
					Diagnóstico
				</td>
			</tr>
		</thead>
	</table>
	<table class="p-t">
		<tbody class="text-min">
			<tr>
				<td>NOMBRES</td>
				<td style="text-transform: uppercase;">{{ $diagnostico->paciente->nombres." ".$diagnostico->paciente->apellidos }}</td>
			</tr>
			<tr>
				<td>DNI</td>
				<td style="text-transform: uppercase;">{{ $diagnostico->paciente->dni }}</td>
			</tr>
			<tr>
				<td>TALLA</td>
				<td>{{ $diagnostico->paciente->talla }}</td>
			</tr>
			<tr>
				<td>PESO</td>
				<td>{{ $diagnostico->paciente->peso }}KG</td>
			</tr>
			<tr>
				<td>TELEFONO</td>
				<td>{{ $diagnostico->paciente->telefono }}</td>
			</tr>
		</tbody>
	</table>
	<table>
		<thead>			
			<tr class="header">
				<td width="15%">#</td>
				<td width="60%">ENFERMEDAD</td>
				<td width="25%">PROBABILIDAD</td>
			</tr>
		</thead>
	</table>
	<table class="p-t">
		<tbody>
			@foreach($diagnostico_enfermedad as $key => $item)
			<tr>
				<td width="15%">{{ $key+1 }}</td>
				<td width="60%">{{ $item->enfermedad->nombre }}</td>
				<td class="text-end" width="25%">{{ $item->probabilidad }}%</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>