<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- Painel Inicial -->
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-tachometer-alt text-white"></i>
                <p>{{ __('Painel Inicial') }}</p>
            </a>
        </li>

        <!-- Opção: Servidores -->
        @if(Auth::user()->role == 'admin')
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-users text-white"></i>
                <p>{{ __('Servidores') }}</p>
            </a>
        </li>
        @endif

        <!-- Opção: Cursos -->
        @if(Auth::user()->role == 'admin')
        <li class="nav-item">
            <a href="{{ route('cursos.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-book text-white"></i>
                <p>{{ __('Cursos') }}</p>
            </a>
        </li>
        @endif

        <!-- Opção: Inscrições -->
        <li class="nav-item">
            <a href="{{ route('inscricoes.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-edit text-white"></i>
                <p>
                    {{ Auth::user()->role == 'admin' ? __('Inscrições') : __('Minhas Inscrições') }}
                </p>
            </a>
        </li>

        <!-- Opção: Certificados -->
        <li class="nav-item">
            <a href="{{ route('certificados.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-file-alt text-white"></i>
                <p>
                    {{ Auth::user()->role == 'admin' ? __('Certificados') : __('Meus Certificados') }}
                </p>
            </a>
        </li>

        <!-- Opção: Formadores -->
        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'formador')
        <li class="nav-item">
            <a href="{{ route('formador.index') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-chalkboard-teacher text-white"></i>
                <p>{{ __('Formadores') }}</p>
            </a>
        </li>
        @endif

                    <!-- Opção: Relatórios -->
            @if(Auth::user()->role == 'admin')
            <li class="nav-item">
                <a href="{{ route('relatorios.frequencia') }}" class="nav-link text-white">
                    <i class="nav-icon fas fa-chart-bar text-white"></i>
                    <p>{{ __('Relatórios de Frequência') }}</p>
                </a>
            </li>
            @endif


        <!-- About Us -->
        <li class="nav-item">
            <a href="{{ route('about') }}" class="nav-link text-white">
                <i class="nav-icon far fa-address-card text-white"></i>
                <p>{{ __('Sobre Nós') }}</p>
            </a>
        </li>

    </ul>
</nav>
<!-- /.sidebar-menu -->
