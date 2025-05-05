@extends('layouts.default')

@section('content-auth')
    <div class="container-fluid">
        <div class="row mb-2 pt-2">
            <div class="col-6">
                <h4>Cadastro</h4>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form class="row g-3" action="{{ route('usuario.store') }}" method="post">
                    @csrf
                    @if (Auth::user()->nivel_acesso->nome == 'Administrador')
                        <input type="hidden" name="empresa_id" value="{{ Auth::user()->empresa->id }}">
                    @endif

                    @if (Auth::user()->nivel_acesso->nome == 'Master')
                        <div class="col-md-4">
                            <label for="nivel" class="form-label">Nivel:</label>
                            <select class="custom-select" aria-label="Default select example" button="" name="nivel" id="nivel" required>
                                <option value=""></option>
                                <option value="Master">Master</option>
                                <option value="Administrador">Cliente (ADM)</option>
                                <option value="Usuário">Cliente (Usuário)</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label for="name" class="form-label">Empresa:</label>
                            <select class="custom-select" aria-label="Default select example" button="" name="empresa_id" id="empresa" required>
                                <option value=""></option>
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa->id }}">{{ $empresa->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="col-md-12">
                        <label for="name" class="form-label">Nome:</label>
                        <input type="text" class="form-control " id="name" name="name" value="" required>
                    </div>
                    <div class="col-md-3">
                        <label for="email" class="form-label">E-mail (login):</label>
                        <input type="email" class="form-control" id="email" name="email" value="" required>
                    </div>
                    <div class="col-md-3">
                        <label for="senha" class="form-label">Senha:</label>
                        <div class="input-group">
                            <input type="password" class="form-control float-left" id="senha" name="password" value="" required>
                            <div class="input-group-append">
                                <span class="input-group-text mostra_senha" id="basic-addon2"><i class="fas fa-eye verSenha float-right" width="10%"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status:</label>
                        <select class="custom-select" aria-label="Default select example" button="" name="status">
                            <option value="1" selected="">Ativo</option>
                            <option value="2">Inativo</option>
                        </select>
                    </div>
                    <div class="col-12 pt-4">
                        <button type="submit" class="btn btn-primary">Concluir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
