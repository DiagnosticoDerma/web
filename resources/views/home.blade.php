@extends('layouts.app')
@section('css')
<style type="text/css">
    a:hover{
        text-decoration: unset;
    }
</style>
@endsection
@section('content')
<div class="row mb-2 mb-xl-3">
    <div class="col-auto d-none d-sm-block">
        <h3><strong>Inicio</strong></h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <a href="{{ route('user.paciente.index') }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Pacientes</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="align-middle" data-feather="users"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $pacientes }}</h1>
                </div>
            </a>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <a href="{{ route('user.medico.index') }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Médicos</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="align-middle" data-feather="users"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $medicos }}</h1>
                </div>
            </a>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <a href="{{ route('diagnostico.index') }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Diagnósticos</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="align-middle" data-feather="clipboard"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $diagnosticos }}</h1>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
