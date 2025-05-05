<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <h4><?=$titulo_pagina?></h4>
    <ul class="navbar-nav ml-auto">
        @if (Auth::user()->nivel_acesso->nome != 'Master')
            <li class="nav-item creditos_topo creditos_topo_desktop">
                <a class="" href="{{ route('credito.index') }}">Créditos disponíveis para estudo: {{ Auth::user()->credito_empresa->last()->total_creditos_disponiveis ?? 0 }}</a>
            </li>
        @endif
        <li class="nav-item creditos_topo creditos_topo_mobile">
            <a class="" href="{{ route('credito.index') }}" title="Créditos disponíveis para estudo">Créditos: {{ Auth::user()->credito_empresa->last()->total_creditos_disponiveis ?? 0 }}</a>
        </li>
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route("empresa.edit", Auth::user()->empresa->id ?? Auth::user()->empresa_id) }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Minha conta
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    
                    <button class="dropdown-item" type="submit">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Sair
                    </button>
                </form>
                
            </div>
        </li>
    </ul>
</nav>