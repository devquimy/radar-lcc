<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand" href="/index.html">
        <img src="{{ asset('./img/logo_radarlcc.png') }}" class="img-fluid" alt="Logo">
        <br>
    </a>
    <hr class="sidebar-divider my-0">
    @if (Auth::user()->nivel_acesso->nome == 'Master')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('empresa.index') }}">
                <i class="fas fa-fw fa-building"></i>
                <span>Empresas</span>
            </a>
        </li>
    @endif
    <li class="nav-item">
        <a class="nav-link" href="{{ route('ativo_fisico.index') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Estudos</span>
        </a>
    </li>
    @if (Auth::user()->nivel_acesso->nome == 'Master')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('inflacao.index') }}">
                <i class="fas fa-fw fa-money-bill-wave"></i>
                <span>Inflação</span>
            </a>
        </li>
    @endif
    <li class="nav-item">
        <a class="nav-link" href="{{ route('credito.index') }}">
            <i class="fas fa-fw fa-dollar-sign"></i>
            <span>&nbsp;Créditos</span>
        </a>
    </li>
    @if (Auth::user()->nivel_acesso->nome == 'Master' || Auth::user()->nivel_acesso->nome == 'Administrador')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pedido.index') }}">
                &nbsp;<i class="fas fa-cash-register"></i>
                <span>&nbsp;Pedidos</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('usuario.index') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Usuários</span>
            </a>
        </li>
    @endif

    @if (Auth::user()->nivel_acesso->nome == 'Master')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('niveis_acesso.index') }}">
                <i class="fas fa-fw fa-level-up"></i>
                <span>Níveis</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('documento.index') }}">
                <i class="fas fa-fw fa-file"></i>
                <span>Documentos</span>
            </a>
        </li>
    @endif
</ul>