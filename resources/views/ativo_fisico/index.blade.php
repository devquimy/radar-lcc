@extends('layouts.default')

@section('content-auth')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        @if (Auth::user()->nivel_acesso->nome == 'Master') 
            <a href="javascript:void(0);" class="btn btn-sm btn-light shadow-sm busca_bt">
                <i class="fas fa-search fa-sm text-black-50"></i> Filtros
                @if(request()->empresa_id != '')
                    <i class="fas fa-circle busca_realizada" data-toggle="tooltip" data-placement="top" title="Existe uma ou mais filtragens ativas" style="display: inline;"></i>
                @endif
            </a>
        @endif
        <a href="{{ route('ativo_fisico.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Adicionar
        </a>
    </div>
    <div class="row busca_box" style="display:none;">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-body table-responsive">
                    <form name="form_busca" method="GET" action="#">
                        <div class="form-row">
                            <div class="col-md-4 col-lg-4 d-flex">
                                <label class="form-label">Empresas:</label>
                                <select name="empresa_id" class="form-control">
                                    <option value="">Selecione</option>
                                    @foreach ($empresas as $id => $empresa)
                                        <option value="{{ $id }}" <?= (isset($_GET['empresa_id']) && $_GET['empresa_id'] == $id) ? "selected" : "" ?>>{{ $empresa }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <a href="{{ url('/ativos_fisicos') }}" class="btn btn-primary"><i class="fas fa-eraser fa-sm text-white-50" style="color:white!important"></i></a>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search fa-sm text-white-50" style="color:white!important"></i></button>
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
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Setor/Tag</th>
                                <th>Ativo físico</th>
                                @if (Auth::user()->nivel_acesso->nome == 'Master')
                                    <th>Empresa</th>
                                @endif
                                <th>Código</th>
                                <th>Ano Início Operação</th>
                                <th>Qtd. estudos</th>
                                <th style="width:100px;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ativos_fisicos as $ativo_fisico)
                                @php
                                    $estudo_id = \App\Models\Estudo::where('ativo_fisico_id', '=', $ativo_fisico->id)->get()->last()->id;
                                @endphp
                                <tr>
                                    <td>{{ $ativo_fisico->setor_tag }}</td>
                                    <td>{{ $ativo_fisico->nome_ativo }}</td>
                                    @if (Auth::user()->nivel_acesso->nome == 'Master')
                                        <td>{{ $ativo_fisico->estudos->first()->user->empresa->nome ?? null }}</td>
                                    @endif
                                    <td>{{ $ativo_fisico->cod_ativo_fisico }}</td>
                                    <td>{{ $ativo_fisico->ano_aquisicao }}</td>
                                    <td>
                                        @if ($ativo_fisico->quantidade_estudos >= 1)
                                            <small class="bg-primary text-white d-inline-flex px-2 py-1 rounded">{{ $ativo_fisico->quantidade_estudos }}</small>
                                        @else
                                            {{ $ativo_fisico->quantidade_estudos }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('estudo.index', $ativo_fisico->id) }}" class="btn bg-primary btn-circle btn-sm text-white" data-toggle="tooltip" data-placement="top" title="Listar estudos">
                                            <i class="fas fa-fw fa-chart-area"></i>
                                        </a>
                                        <a href="{{ route('ativo_fisico.edit', [$ativo_fisico->id, $estudo_id]) }}" class="btn btn-warning btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="Editar estudo">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if(Auth::user()->nivel_acesso->nome == 'Master') : ?>
                                            <a href="javascript:void(0);" data-id="{{ $ativo_fisico->id }}" class="btn btn-danger btn-circle btn-sm btnDelete" id="btnDelete" data-toggle="modal" data-target="#confirmationModal{{ $ativo_fisico->id }}">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <div class="modal" id="confirmationModal{{ $ativo_fisico->id }}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Exclusão de atívo</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Tem certeza que deseja excluir este atívo?</p>

                                                            <p>  
                                                                <b>
                                                                    Todos os estudos referente a este ativo serão apagados
                                                                </b>
                                                            </p> 
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ url("/ativos_fisicos/delete/$ativo_fisico->id") }}" method="POST">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                                <button type="submit" id="deleteConfirm" class="btn btn-danger">Confirmar</button>
                                                                <input type="hidden" name="id" value="{{ $ativo_fisico->id }}">
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
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
                                        <span class="font-medium">{{ $ativos_fisicos->total() }}</span>
                                        resultados
                                    </p>
                                </div>
                                @if ($ativos_fisicos->hasPages())
                                    <div>
                                        <span class="relative z-0 inline-flex">
                                            @if ($ativos_fisicos->lastPage() > 1)
                                                <span aria-disabled="true" aria-label="&amp;laquo; Previous">
                                                    <a href="{{ $ativos_fisicos->appends(['empresa_id' => request()->query('empresa_id')])->url($ativos_fisicos->currentPage() - 1) }}" aria-hidden="true" class="paginacao_bt {{ ($ativos_fisicos->currentPage() == 1) ? ' paginacao_bt_disabled' : '' }}">
                                                        <svg 0="" 10="" 25="" style="max-height:25px;" fill="currentColor" viewBox="5 0 10 22">
                                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </a>
                                                </span>
                                                @for ($i = 1; $i <= $ativos_fisicos->lastPage(); $i++)
                                                    @if ($ativos_fisicos->currentPage() == $i)
                                                        <span aria-current="page" class="paginacao_bt paginacao_bt_active">
                                                            <span class="">{{ $i }}</span>
                                                        </span>
                                                    @else
                                                        <a href="{{ $ativos_fisicos->appends(['empresa_id' => request()->query('empresa_id')])->url($i) }}" aria-label="Go to page {{ $i }}" class="paginacao_bt">
                                                            {{ $i }}
                                                        </a>
                                                    @endif
                                                @endfor
                                                <a href="{{ ($ativos_fisicos->currentPage() == $ativos_fisicos->lastPage()) ? '' : $ativos_fisicos->appends(['empresa_id' => request()->query('empresa_id')])->url($ativos_fisicos->currentPage() + 1) }}"  rel="next" aria-label="Next &amp;raquo;" class="paginacao_bt {{ ($ativos_fisicos->currentPage() == $ativos_fisicos->lastPage()) ? ' paginacao_bt_disabled' : '' }}">
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

@section("js")
    <script>        
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection