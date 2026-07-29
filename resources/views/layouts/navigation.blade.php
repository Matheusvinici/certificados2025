<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'user' || Auth::user()->role == 'formador')
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>{{ __('Painel Inicial') }}</p>
            </a>
        </li>
        @endif

        @if(Auth::user()->role == 'admin')
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>{{ __('Servidores') }}</p>
            </a>
        </li>
        @endif

        @if(Auth::user()->role == 'admin')
        <li class="nav-item">
            <a href="{{ route('secretarias.index') }}" class="nav-link">
                <i class="nav-icon fas fa-building"></i>
                <p>{{ __('Secretarias') }}</p>
            </a>
        </li>
        @endif

        @if(Auth::user()->role == 'admin')
        <li class="nav-item">
            <a href="{{ route('cursos.index') }}" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>{{ __('Cursos') }}</p>
            </a>
        </li>
        @endif

        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'user')
        <li class="nav-item">
            <a href="{{ route('inscricoes.index') }}" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>{{ __('Inscrições') }}</p>
            </a>
        </li>
        @endif

        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'user')
        <li class="nav-item">
            <a href="{{ route('certificados.index') }}" class="nav-link">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>
                    @if(Auth::user()->role == 'admin')
                        {{ __('Certificados') }}
                    @else
                        {{ __('Meus Certificados') }}
                    @endif
                </p>
            </a>
        </li>
        @endif

        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'formador')
        <li class="nav-item">
            <a href="{{ route('relatorios.avaliacoes') }}" class="nav-link">
                <i class="nav-icon fas fa-star-half-alt"></i>
                <p>{{ __('Relatório de Avaliações') }}</p>
            </a>
        </li>
        @endif

        @if(Auth::user()->hasAnyRole(['leitor-frequencia', 'super-admin']) || Auth::user()->role == 'admin')
        <li class="nav-item">
            <a href="{{ route('leitor-frequencia.index') }}" class="nav-link">
                <i class="nav-icon fas fa-qrcode"></i>
                <p>{{ __('Leitor de Frequência') }}</p>
            </a>
        </li>
        @endif

        @if(Auth::user()->hasRole('super-admin') || Auth::user()->role == 'admin')
        <li class="nav-header text-uppercase text-xs mt-3" style="color: #aaa;">Administração</li>
        <li class="nav-item">
            <a href="{{ route('roles.index') }}" class="nav-link">
                <i class="nav-icon fas fa-user-tag"></i>
                <p>{{ __('Papéis') }}</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('permissions.index') }}" class="nav-link">
                <i class="nav-icon fas fa-key"></i>
                <p>{{ __('Permissões') }}</p>
            </a>
        </li>
        @endif

        <li class="nav-item">
            <a href="{{ route('about') }}" class="nav-link">
                <i class="nav-icon far fa-address-card"></i>
                <p>{{ __('Sobre Nós') }}</p>
            </a>
        </li>

    </ul>
</nav>