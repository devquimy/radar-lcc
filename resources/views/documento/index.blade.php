@extends('layouts.default')

@section('content-auth')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('documento.store') }}" class="btn btn-success" style="float: right">Adicionar</a>
                        </div>
                        <div class="col-md-12" style="margin-top: 15px">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Última revisão</th>
                                        <th>Tipo documento</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($documentos as $documento)
                                        <tr>
                                            <td>{{ $documento->nome_documento }}</td>
                                            <td>{{ date("d/m/Y H:i", strtotime($documento->updated_at)) }}</td>
                                            <td>{{ ucfirst($documento->tipo_documento) }}</td>
                                            <td>
                                                <button onclick="previewDocumento(this)" data-documento="{{ $documento->documento }}" type="button" class="btn bg-primary btn-circle btn-sm text-white" data-toggle="tooltip" data-placement="top" title="Pre-visualizar">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                                <a href="{{ route('documento.edit', $documento->id) }}" class="btn bg-warning btn-circle btn-sm text-white" data-toggle="tooltip" data-placement="top" title="Editar documento">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modalPreviewDocumento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content" style="border-radius: 20px">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Preview Documento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12" id="divPreviewDocumento" style="padding:20px">
                                    
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("js")
    <script>
        function previewDocumento(elemento)
        {
            var documento = $(elemento).attr("data-documento");

            $("#divPreviewDocumento").html("");

            $("#divPreviewDocumento").html(documento);

            $("#modalPreviewDocumento").modal("show")
        }
    </script>
@endsection