@extends('layouts.default')

@section('content-auth')
<div class="container-fluid">
    @if(session('novoPlano'))
        <div class="row">
            <div class="col-md-12" style="margin-bottom:20px">
                <div class="card shadow">
                    <div class="card-body">    
                        <p style="font-size:15px;">
                            <b>Parabéns {{ Auth::user()->name }}</b>, seus créditos foram contratados com sucesso !
                            Para realizar novos estudos <a href="{{ route('ativo_fisico.create') }}">clique aqui</a> 
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <b style="font-size:23px">Seus créditos antigos</b>
                                <h3 style="font-size:25px">
                                    {{ session('planoAntigo')->total_creditos_disponiveis ?? 0 }}
                                </h3>
                            </div>
                            <div class="col-md-6" style="text-align:center">
                                <img src="{{ asset('./img/seta-para-baixo.png') }}" alt="" srcset="" style="width:100px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                    <div class="row">
                            <div class="col-md-6">
                                <b style="font-size:23px">Seus créditos novos</b>
                                <h3 style="font-size:25px">
                                    {{ session('novoPlano')->total_creditos_disponiveis ?? 0 }}
                                </h3>
                            </div>
                            <div class="col-md-6" style="text-align:center">
                                <img src="{{ asset('./img/seta-para-cima.png') }}" alt="" srcset="" style="width:100px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <h4>Plano já contratado, não há nada para exibir no momento</h4>
                        <a href="{{ route('ativo_fisico.index') }}" class="btn btn-sm btn-primary shadow-sm">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection