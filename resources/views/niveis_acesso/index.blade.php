@extends('layouts.default')

@section('content-auth')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($niveis_acessos as $nivel_acesso)
                                <tr>
                                    <td>{{ $nivel_acesso->nome }}</td>
                                    <td>
                                        <a href="{{ route('usuario.index', ['nivel_acesso_id' => $nivel_acesso->id]) }}" class="btn bg-primary btn-circle btn-sm text-white" data-toggle="tooltip" data-placement="top" title="Listar usuários">
                                            <i class="fas fa-fw fa-user"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection