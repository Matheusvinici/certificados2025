<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- Painel Inicial - Acesso para formador, user comum e admin -->
        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'user' || Auth::user()->role == 'formador')
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-tachometer-alt text-white"></i>
                <p>{{ __('Painel Inicial') }}</p>
            </a>
        </li>
        @endif

        <!-- Opção: Servidores - Apenas para admin -->
        @if(Auth::user()->role == 'admin')
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-users text-white"></i>
                <p>{{ __('Servidores') }}</p>
            </a>
        </li>
        @endif

        <!-- Opção: Cursos - Apenas para admin -->
        @if(Auth::user()->role == 'admin')
        <li class="nav-item">
            <a href="{{ route('cursos.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-book text-white"></i>
                <p>{{ __('Cursos') }}</p>
            </a>
        </li>
        @endif

        <!-- Opção: Inscrições - Apenas para admin e usuário comum -->
        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'user')
        <li class="nav-item">
            <a href="{{ route('inscricoes.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-edit text-white"></i>
                <p>{{ __('Inscrições') }}</p>
            </a>
        </li>
        @endif

        <!-- Opção: Certificados - Apenas para admin e usuário comum (com título alterado) -->
        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'user')
        <li class="nav-item">
            <a href="{{ route('certificados.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-file-alt text-white"></i>
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

        <!-- Opção: Formadores - Apenas para admin e formadores -->
        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'formador')
        <li class="nav-item">
            <a href="{{ route('formador.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-chalkboard-teacher text-white"></i>
                <p>{{ __('Formadores') }}</p>
            </a>
        </li>
        @endif

        <!-- Opção: Relatórios de Frequência - Apenas para admin e formadores -->
        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'formador')
        <li class="nav-item">
            <a href="{{ route('relatorios.frequencia') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-chart-bar text-white"></i>
                <p>{{ __('Relatórios de Frequência') }}</p>
            </a>
        </li>
        @endif

        <!-- About Us - Acesso para todos -->
        <li class="nav-item">
            <a href="{{ route('about') }}" class="nav-link text-white">
                <i class="nav-icon far fa-address-card text-white"></i>
                <p>{{ __('Sobre Nós') }}</p>
            </a>
        </li>

    </ul>
</nav>
<!-- /.sidebar-menu -->
