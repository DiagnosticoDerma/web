<ul class="sidebar-nav">
    <li class="sidebar-item {{ Request::is('home') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('home') }}">
            <i class="align-middle" data-feather="sliders"></i>
            <span class="align-middle">Inicio</span>
        </a>
    </li>
    @if(Auth::user()->id_perfil == 1)
    <li class="sidebar-item {{ Request::is('user/paciente*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('user.paciente.index') }}">
            <i class="align-middle" data-feather="users"></i> <span class="align-middle">Pacientes</span>
        </a>
    </li>
    <li class="sidebar-item {{ Request::is('user/medico*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('user.medico.index') }}">
            <i class="align-middle" data-feather="users"></i> <span class="align-middle">Médicos</span>
        </a>
    </li>
    @endif
    <li class="sidebar-item {{ Request::is('sintomas*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('sintomas.index') }}">
            <i class="align-middle" data-feather="git-pull-request"></i> <span class="align-middle">Sintomas</span>
        </a>
    </li>
    <li class="sidebar-item {{ Request::is('medicina*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('medicina.index') }}">
            <i class="align-middle" data-feather="git-branch"></i> <span class="align-middle">Medicina</span>
        </a>
    </li>
    <li class="sidebar-item {{ Request::is('tipo-enfermedad*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('tipo-enfermedad.index') }}">
            <i class="align-middle" data-feather="git-branch"></i> <span class="align-middle">Tipo de enfermedad</span>
        </a>
    </li>
    <li class="sidebar-item {{ Request::is('enfermedad*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('enfermedad.index') }}">
            <i class="align-middle" data-feather="activity"></i> <span class="align-middle">Enfermedades</span>
        </a>
    </li>
    <li class="sidebar-item {{ Request::is('tratamiento-user*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('tratamiento.user.index') }}">
            <i class="align-middle" data-feather="share-2"></i> <span class="align-middle">Tratamiento por usuario</span>
        </a>
    </li>
    <li class="sidebar-item {{ Request::is('tratamiento-general*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('tratamiento.index') }}">
            <i class="align-middle" data-feather="share-2"></i> <span class="align-middle">Tratamiento General</span>
        </a>
    </li>
    <li class="sidebar-item {{ Request::is('diagnostico*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('diagnostico.index') }}">
            <i class="align-middle" data-feather="clipboard"></i> <span class="align-middle">Diagnostico</span>
        </a>
    </li>
    <li class="sidebar-item {{ Request::is('paciente-sintomas*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('sintomas.paciente.index') }}">
            <i class="align-middle" data-feather="git-pull-request"></i> <span class="align-middle">Sintomas Paciente</span>
        </a>
    </li>
    <li class="sidebar-item {{ Request::is('entrega-tiempo-diagnostico') ||  Request::is('cantidad-registro-paciente') ||  Request::is('porcentaje-pacientes-satisfechos') ? 'active' : '' }}">
        <a data-bs-target="#reportes" data-bs-toggle="collapse" class="sidebar-link {{ Request::is('entrega-tiempo-diagnostico') ||  Request::is('cantidad-registro-paciente') ||  Request::is('porcentaje-pacientes-satisfechos') ? '' : 'collapsed' }}">
            <i class="align-middle" data-feather="database"></i> <span class="align-middle">Reportes</span>
        </a>
        <ul id="reportes" class="sidebar-dropdown list-unstyled collapse {{ Request::is('entrega-tiempo-diagnostico') ||  Request::is('cantidad-registro-paciente') ? 'show' : '' }}" data-bs-parent="#sidebar">
            <li class="sidebar-item {{ Request::is('entrega-tiempo-diagnostico') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('entrega.tiempo.diagnostico.index') }}">IETD</a>
            </li>
            <li class="sidebar-item {{ Request::is('cantidad-registro-paciente') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('cantidad.registro.paciente.index') }}">CRDCP</a>
            </li>
            <li class="sidebar-item {{ Request::is('porcentaje-pacientes-satisfechos') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('porcentaje.pacientes.satisfechos.index') }}">% PACIENTES SATISFECHOS</a>
            </li>
        </ul>
    </li>
</ul>