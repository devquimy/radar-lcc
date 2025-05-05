@extends('layouts.default')

@section('content-auth')
    <style>
        .tox-promotion{
            display: none
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalVariaveis" style="margin-bottom:15px;float:right;">Consultar variáveis</button>
            </div>
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row">
                            <form method="post" action="{{ route('documento.create') }}">
                                @csrf
                                <div class="row" style="padding-right: 15px;padding-left:15px">
                                    <div class="col-md-6" style="margin-bottom:15px">
                                        <label for="nome"><b>Nome do documento:</b></label>
                                        <input type="text" name="nome_documento" class="form-control" placeholder="Digite o nome do documento...">
                                    </div>
                                    <div class="col-lg-6" style="margin-bottom:15px">
                                        <label for="tipo_documento"><b>Tipo do documento:</b></label>
                                        <select name="tipo_documento" id="tipo_documento" class="form-control">
                                            <option value="">Selecione...</option>
                                            <option value="positivo">Positivo</option>
                                            <option value="negativo">Negativo</option>
                                            <option value="nulo">Nulo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="documento"><b>Documento:</b></label>
                                        <textarea id="documento" name="documento"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-success btn-block" style="margin-top:15px">Criar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal fade" id="modalVariaveis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content" style="border-radius: 20px">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Variáveis</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-warning">
                                            <p>
                                                <b>@{{nome_ativo}}</b> = Nome do ativo físico
                                            </p>
                                            <p>
                                                <b>@{{data_relatorio}}</b> = Data de geração do relátorio
                                            </p>
                                            <p>
                                                <b>@{{valores_entrada}}</b> = Valores de entrada do ativo físico
                                            </p>
                                            <p>
                                                <b>@{{valor_aquisicao_instalacao_comissionamento}}</b> = Valor de aquisição + valor de instalação + valor de comissionamento
                                            </p>
                                            <p>
                                                <b>@{{melhorias_reformas}}</b> = Tabela de valores de melhorias e reformas da tela de Capex
                                            </p>
                                            <p>
                                                <b>@{{opex}}</b> = Tabela de valores da tela de Opex
                                            </p>
                                            <p>
                                                <b>@{{cae}}</b> = Gráfico gerado do C.A.E
                                            </p>
                                            <p>
                                                <b>@{{ano_posterior_menor_cae}}</b> = Ano posterior ao menor valor encontrado do C.A.E
                                            </p>
                                            <p>
                                                <b>@{{ano_menor_cae}}</b> = Ano de menor valor encontrado do C.A.E
                                            </p>
                                            <p>
                                                <b>@{{ano_estudo}}</b> = Ano em que o estudo foi realizado
                                            </p>
                                            <p>
                                                <b>@{{valor_revenda_ano_estudo}}</b> = Valor de revenda do ano do estudo
                                            </p>
                                        </div>
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
    </div>
@endsection

@section("js")
    <script src="{{ asset('/public/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: 'textarea#documento',
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
            image_title: true,
            automatic_uploads: true,
            statusbar: false,
            file_picker_types: 'image',
            language: 'pt_BR',
            language_url: '{{ asset("/public/js/tinymce/langs/pt_BR.js") }}',  
            file_picker_callback: (cb, value, meta) => {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.addEventListener('change', (e) => {
                const file = e.target.files[0];

                const reader = new FileReader();
                reader.addEventListener('load', () => {
                    const id = 'blobid' + (new Date()).getTime();
                    const blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    const base64 = reader.result.split(',')[1];
                    const blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                });
                reader.readAsDataURL(file);
                });

                input.click();
            },
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });
    </script>

@endsection