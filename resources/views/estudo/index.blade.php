@extends('layouts.default')

@section('content-auth')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        {{-- Busca desabilitado ate segunda ordem --}}
        <a href="javascript:void(0);" class="btn btn-sm btn-light shadow-sm busca_bt d-none">
            <i class="fas fa-search fa-sm text-black-50"></i> Busca
            <i class="fas fa-circle busca_realizada" title="Existe uma ou mais filtragens ativas" style="display: inline;"></i>
        </a>
        <a href="javascript:void(0);" data-toggle="modal" data-target="#novo_estudo" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Adicionar novo estudo
        </a>
    </div>
    <div class="row busca_box" style="display:none;">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-body table-responsive">
                    <form name="form_busca" method="GET" action="#">
                        <div class="form-row">
                            <div class="col-md-6 col-lg-5 d-flex">
                                <label class="form-label">Filtrar:</label>
                                <input type="text" name="busca" class="form-control" value="">
                            </div>
                            <div class="col-md-6 col-lg-2 d-flex">
                                <label class="form-label">Status:</label>
                                <select name="ativo" class="form-control">
                                    <option value="">Todos</option>
                                    <option value="1">Ativos</option>
                                    <option value="2">Inativos</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search fa-sm text-white-50"></i></button>
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
                                <th>Ano estudo</th>
                                <th>Data do estudo</th>
                                <th style="width:100px;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($estudos as $estudo)
                                <tr>
                                    <td>{{ date("Y", strtotime($estudo->created_at)) }}</td>
                                    <td>{{ date("d/m/Y H:i", strtotime($estudo->created_at)) }}</td>
                                    <td>
                                        <a href="{{ route('ativo_fisico.edit', [$estudo->ativo_fisico->id, $estudo->id]) }}" class="btn btn-warning btn-circle btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        {{-- Desabilitado ate segunda ordem --}}
                                        <a href="javascript:void(0);" data-id="65" class="btn btn-danger btn-circle btn-sm btnDelete d-none" id="btnDelete" data-toggle="modal" data-target="#delete_65">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <div class="modal" id="delete_65" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Exclusão de registro</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Tem certeza que deseja excluir esse registro?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form id="formDelete" action="#" name="deletar" method="post">
                                                        <button type="buttom" id="deleteConfirm" class="btn btn-primary">Confirmar</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                            <input type="hidden" name="companyId" id="idToDelete" value="65">
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
                    <div class="modal" id="novo_estudo" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Novo estudo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>
                                        Tem certeza que deseja criar um novo estudo para o ativo <b>{{ $estudos[0]->ativo_fisico->nome_ativo }}</b> ?<br>
                                        Após a conclusão do estudo um credito será debitado do seu saldo.
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <form id="formNovoEstudo" action="{{ route('estudo.repetir') }}" name="deletar" method="post">
                                        @csrf
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                        <button type="buttom" class="btn btn-success">Confirmar</button>
                                        <input type="hidden" name="ativo_fisico_id" id="ativo_fisico_id" value="{{ $estudos[0]->ativo_fisico->id }}">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection