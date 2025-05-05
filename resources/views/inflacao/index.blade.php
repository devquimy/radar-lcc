@extends('layouts.default')

@section('content-auth')
    <div class="container-fluid">
        <form class="g-3" action="{{ route("inflacao.create") }}" method="post">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4" style="height:415px;overflow:auto">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="razao_social" class="form-label">Ano:</label>
                                </div>
                                <div class="col-md-6">
                                    <label for="razao_social" class="form-label">Inflação:</label>
                                </div>
                                <div class="col-md-12">
                                    <div id="rowColunas">
                                        @for ($i = 1995; $i <= 2200; $i++)
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <input type="number" class="form-control ano" id="ano{{ $i }}" name="ano[]" placeholder="Digite o ano..." value="{{ $i }}" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control inflacao" id="" name="inflacao[]" placeholder="Digite a inflação..." value="<?= $inflacoes[$i]['inflacao'] ?? null ?>">
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Desabilitado até posteriormente cliente solicitar --}}
                        {{-- <div class="col-md-4" style="padding-top:2.3rem;display:none">
                            <button type="button" class="btn btn-primary" onclick="adicionarColunas()">Adicionar</button>
                        </div> --}}
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col">
                        <button type="submit" class="btn btn-success btn-block">Atualizar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section("js")
    <script>
        $(document).ready(function(){
            loadRegras();

            //Função de remover celulas descontinuada
            $(".colunaRemover").on("click", function() {
                $(this).closest('.form-row').remove()
            });
        });

        function loadRegras()
        {
            $(".inflacao").on('blur',function(){                
                if($(this).val().length > 0)

                var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
                var str = $(this).val();

                if(!numberRegex.test(str)) {
                    $(this).val('');

                    return alert('Só é permitido inserir números');
                }   

                $(this).val( $(this).val() + '%' );
            }).on('focus',function(){
                $(this).val( $(this).val().replace('%','') ); 
            });
        }

        function adicionarColunas()
        {
            $('.form-row:first').clone().appendTo('#rowColunas');
            
            $('.form-row:last').find('.col-md-5 input').removeAttr('readonly')

            loadRegras();
        }
    </script>
@endsection