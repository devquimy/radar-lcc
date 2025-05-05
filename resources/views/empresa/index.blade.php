@extends('layouts.default')

@section('content-auth')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <a href="javascript:void(0);" class="btn btn-sm btn-light shadow-sm busca_bt">
                <i class="fas fa-search fa-sm text-black-50"></i> Filtros
                @if(request()->busca != '' || request()->status != '')
                    <i class="fas fa-circle busca_realizada" data-toggle="tooltip" data-placement="top" title="Existe uma ou mais filtragens ativas" style="display: inline;"></i>
                @endif
            </a>
        </div>
        <div class="row busca_box" style="display:none;">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body table-responsive">
                        <form name="form_busca" method="GET" action="{{ route('empresa.index') }}">
                            <div class="form-row">
                                <div class="col-md-6 col-lg-5">
                                    <label class="form-label">Razão Social:</label>
                                    <input type="text" name="busca" class="form-control" value="<?= (isset($_GET['busca'])) ? $_GET['busca'] : "" ?>">
                                </div>
                                <div class="col-md-6 col-lg-2">
                                    <label class="form-label">Status:</label>
                                    <select name="status" class="form-control">
                                        <option value="">Todos</option>
                                        <option value="ativo" <?= (isset($_GET['status'] ) && $_GET['status'] == 'ativo') ? "selected" : "" ?>>Ativos</option>
                                        <option value="inativo" <?= (isset($_GET['status'] ) && $_GET['status'] == 'inativo') ? "selected" : "" ?>>Inativos</option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-lg-2" style="margin-top:30px">
                                    @if(request()->busca != '' || request()->status != '')
                                        <a href="{{ route('empresa.index') }}" class="btn btn-primary mr-2">Limpar</a>
                                    @endif

                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search fa-sm text-white"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-body table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Razão social</th>
                                    <th>CNPJ</th>
                                    <th>Contato</th>
                                    <th>Celular</th>
                                    <th style="width:100px;">Status</th>
                                    <th style="width:70px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($empresas as $empresa)
                                    <tr>
                                        <td>{{ $empresa->nome }}</td>
                                        <td>{{ $empresa->cnpj }}</td>
                                        <td>{{ $empresa->nome_contato_tecnico }}</td>
                                        <td>{{ $empresa->telefone_contato_tecnico }}</td>
                                        <td>
                                            @if ($empresa->status == 'ativo')
                                                <small class="bg-success text-white d-inline-flex px-2 py-1 rounded">Ativo</small>
                                            @else
                                                <small class="bg-danger text-white d-inline-flex px-2 py-1 rounded">Inativo</small>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url("/empresas/edit/$empresa->id") }}" class="btn btn-warning btn-circle btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-id="{{ $empresa->id }}" class="btn btn-danger btn-circle btn-sm btnDelete" id="btnDelete" data-toggle="modal" data-target="#confirmationModal{{ $empresa->id }}">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <div class="modal" id="confirmationModal{{ $empresa->id }}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Exclusão de empresa</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Tem certeza que deseja excluir esta empresa?</p>
                                                            <p>
                                                                <b>
                                                                    Todos os estudos e usuários desta empresa serão excluídos.
                                                                </b>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ url("/empresas/delete/$empresa->id") }}" method="POST">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                                <button type="submit" id="deleteConfirm" class="btn btn-danger">Confirmar</button>
                                                                <input type="hidden" name="id" value="{{ $empresa->id }}">
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                                            <span class="font-medium">{{ $empresas->total() }}</span>
                                            resultados
                                        </p>
                                    </div>
                                    @if ($empresas->hasPages())
                                        <div>
                                            <span class="relative z-0 inline-flex">
                                                @if ($empresas->lastPage() > 1)
                                                    <span aria-disabled="true" aria-label="&amp;laquo; Previous">
                                                        <a href="{{ $empresas->url($empresas->currentPage() - 1) }}" aria-hidden="true" class="paginacao_bt {{ ($empresas->currentPage() == 1) ? ' paginacao_bt_disabled' : '' }}">
                                                            <svg 0="" 10="" 25="" style="max-height:25px;" fill="currentColor" viewBox="5 0 10 22">
                                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                            </svg>
                                                        </a>
                                                    </span>
                                                    @for ($i = 1; $i <= $empresas->lastPage(); $i++)
                                                        @if ($empresas->currentPage() == $i)
                                                            <span aria-current="page" class="paginacao_bt paginacao_bt_active">
                                                                <span class="">{{ $i }}</span>
                                                            </span>
                                                        @else
                                                            <a href="{{ $empresas->url($i) }}" aria-label="Go to page {{ $i }}" class="paginacao_bt">
                                                                {{ $i }}
                                                            </a>
                                                        @endif
                                                    @endfor
                                                    <a href="{{ ($empresas->currentPage() == $empresas->lastPage()) ? '' : $empresas->url($empresas->currentPage() + 1) }}"  rel="next" aria-label="Next &amp;raquo;" class="paginacao_bt {{ ($empresas->currentPage() == $empresas->lastPage()) ? ' paginacao_bt_disabled' : '' }}">
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
    </div>
@endsection