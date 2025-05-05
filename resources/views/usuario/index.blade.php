@extends('layouts.default')

@section('content-auth')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            @if (request()->get('nivel_acesso_id'))
                <a href="{{ route('niveis_acesso.index') }}" class="btn btn-sm btn-primary shadow-sm">
                    Voltar
                </a>
            @endif
            <a href="{{ route('usuario.create') }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Adicionar
            </a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Celular</th>
                                <th>E-mail</th>
                                <th>Status</th>
                                <th>Nível Acesso</th>
                                <th>Empresa</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->name }}</td>
                                    <td>{{ $usuario->empresa->telefone_contato_comercial ?? $usuario->empresa->telefone_contato_tecnico ?? null }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>
                                        @if ($usuario->status == 1)
                                            <small class="bg-success text-white d-inline-flex px-2 py-1 rounded">Ativo</small>
                                        @else
                                            <small class="bg-danger text-white d-inline-flex px-2 py-1 rounded">Inativo</small>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $usuario->nivel_acesso->nome ?? null }}
                                    </td>
                                    <td>{{ $usuario->empresa->nome ?? null }}</td>
                                    <td>
                                        <a href="{{ route('usuario.edit', $usuario->id) }}" class="btn btn-warning btn-circle btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if(Auth::user()->nivel_acesso->nome == 'Master') : ?>
                                            <button class="btn btn-success btn-circle btn-sm" data-toggle="modal" data-target="#modalCreditos{{ $usuario->id }}">
                                                <i class="fas fa-plus fa-sm text-white-100" data-toggle="tooltip" title="Adicionar créditos"></i>
                                            </button>
                                            <div class="modal" id="modalCreditos{{ $usuario->id }}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ url("/usuarios/adicionar-creditos") }}" method="POST">
                                                            {{ csrf_field() }}

                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Adicionar créditos</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <label><b>Quantidade de créditos:</b></label>
                                                                <input type="number" name="credito" class="form-control" placeholder="Digite..." max="9999" required>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                                                <button type="submit" class="btn btn-success">Confirmar</button>
                                                                <input type="hidden" name="id" value="{{ $usuario->id }}">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Paginação --}}
                    <div class="container text-center paginacao_espacamento">
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700 leading-5">
                                        Total
                                        <span class="font-medium">{{ $usuarios->total() }}</span>
                                        resultados
                                    </p>
                                </div>
                                @if ($usuarios->hasPages())
                                    <div>
                                        <span class="relative z-0 inline-flex">
                                            @if ($usuarios->lastPage() > 1)
                                                <span aria-disabled="true" aria-label="&amp;laquo; Previous">
                                                    <a href="{{ $usuarios->url($usuarios->currentPage() - 1) }}" aria-hidden="true" class="paginacao_bt {{ ($usuarios->currentPage() == 1) ? ' paginacao_bt_disabled' : '' }}">
                                                        <svg 0="" 10="" 25="" style="max-height:25px;" fill="currentColor" viewBox="5 0 10 22">
                                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </a>
                                                </span>
                                                @for ($i = 1; $i <= $usuarios->lastPage(); $i++)
                                                    @if ($usuarios->currentPage() == $i)
                                                        <span aria-current="page" class="paginacao_bt paginacao_bt_active">
                                                            <span class="">{{ $i }}</span>
                                                        </span>
                                                    @else
                                                        <a href="{{ $usuarios->url($i) }}" aria-label="Go to page {{ $i }}" class="paginacao_bt">
                                                            {{ $i }}
                                                        </a>
                                                    @endif
                                                @endfor
                                                <a href="{{ ($usuarios->currentPage() == $usuarios->lastPage()) ? '' : $usuarios->url($usuarios->currentPage() + 1) }}"  rel="next" aria-label="Next &amp;raquo;" class="paginacao_bt {{ ($usuarios->currentPage() == $usuarios->lastPage()) ? ' paginacao_bt_disabled' : '' }}">
                                                    <svg 0="" 10="" 25="" style="max-height:25px;" fill="currentColor" viewBox="5 0 10 22">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </a>
                                            @endif                                       
                                        </span>
                                    </div>
                                @endif    
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
