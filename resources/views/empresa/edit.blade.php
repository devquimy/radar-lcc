@extends('layouts.default')

@section('content-auth')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form class="g-3" action="{{ route('empresa.update', $empresa->id) }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="razao_social" class="form-label">Razão social: <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control " id="razao_social" name="nome" value="{{ $empresa->nome }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="cnpj" class="form-label">CNPJ:</label>
                        <input type="text" class="form-control cnpj " id="cnpj" name="cnpj" value="{{ $empresa->cnpj }}" maxlength="18">
                    </div>
                    <div class="col-md-6">
                        <label for="cidade" class="form-label">Cidade:</label>
                        <input type="text" class="form-control cidade " id="cidade" name="cidade" value="{{ $empresa->cidade }}" maxlength="18">
                    </div>
                    <div class="col-md-6">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" class="form-control">
                            <option value="">Selecione...</option>
                            <option value="AC" <?= ($empresa->estado == "AC") ? "selected" : "" ?>>Acre (AC)</option>
                            <option value="AL" <?= ($empresa->estado == "AL") ? "selected" : "" ?>>Alagoas (AL)</option>
                            <option value="AP" <?= ($empresa->estado == "AP") ? "selected" : "" ?>>Amapá (AP)</option>
                            <option value="AM" <?= ($empresa->estado == "AM") ? "selected" : "" ?>>Amazonas (AM)</option>
                            <option value="BA" <?= ($empresa->estado == "BA") ? "selected" : "" ?>>Bahia (BA)</option>
                            <option value="CE" <?= ($empresa->estado == "CE") ? "selected" : "" ?>>Ceará (CE)</option>
                            <option value="DF" <?= ($empresa->estado == "DF") ? "selected" : "" ?>>Distrito Federal (DF)</option>
                            <option value="ES" <?= ($empresa->estado == "ES") ? "selected" : "" ?>>Espírito Santo (ES)</option>
                            <option value="GO" <?= ($empresa->estado == "GO") ? "selected" : "" ?>>Goiás (GO)</option>
                            <option value="MA" <?= ($empresa->estado == "MA") ? "selected" : "" ?>>Maranhão (MA)</option>
                            <option value="MT" <?= ($empresa->estado == "MT") ? "selected" : "" ?>>Mato Grosso (MT)</option>
                            <option value="MS" <?= ($empresa->estado == "MS") ? "selected" : "" ?>>Mato Grosso do Sul (MS)</option>
                            <option value="MG" <?= ($empresa->estado == "MG") ? "selected" : "" ?>>Minas Gerais (MG)</option>
                            <option value="PA" <?= ($empresa->estado == "PA") ? "selected" : "" ?>>Pará (PA)</option>
                            <option value="PB" <?= ($empresa->estado == "PB") ? "selected" : "" ?>>Paraíba (PB)</option>
                            <option value="PR" <?= ($empresa->estado == "PR") ? "selected" : "" ?>>Paraná (PR)</option>
                            <option value="PE" <?= ($empresa->estado == "PE") ? "selected" : "" ?>>Pernambuco (PE)</option>
                            <option value="PI" <?= ($empresa->estado == "PI") ? "selected" : "" ?>>Piauí (PI)</option>
                            <option value="RJ" <?= ($empresa->estado == "RJ") ? "selected" : "" ?>>Rio de Janeiro (RJ)</option>
                            <option value="RN" <?= ($empresa->estado == "RN") ? "selected" : "" ?>>Rio Grande do Norte (RN)</option>
                            <option value="RS" <?= ($empresa->estado == "RS") ? "selected" : "" ?>>Rio Grande do Sul (RS)</option>
                            <option value="RO" <?= ($empresa->estado == "RO") ? "selected" : "" ?>>Rondônia (RO)</option>
                            <option value="RR" <?= ($empresa->estado == "RR") ? "selected" : "" ?>>Roraima (RR)</option>
                            <option value="SC" <?= ($empresa->estado == "SC") ? "selected" : "" ?>>Santa Catarina (SC)</option>
                            <option value="SP" <?= ($empresa->estado == "SP") ? "selected" : "" ?>>São Paulo (SP)</option>
                            <option value="SE" <?= ($empresa->estado == "SE") ? "selected" : "" ?>>Sergipe (SE)</option>
                            <option value="TO" <?= ($empresa->estado == "TO") ? "selected" : "" ?>>Tocantins (TO)</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-4">
                        <div class="card-form">
                            <div class="col">
                                <h5 class="pt-2 font-weight-bold">Contato técnico</h5>
                            </div>
                            <div class="col">
                                <label for="contato_tecnico_nome" class="form-label">Nome:</label>
                                <input type="text" class="form-control " id="contato_tecnico_nome" name="nome_contato_tecnico" value="{{ $empresa->nome_contato_tecnico }}">
                            </div>
                            <div class="col">
                                <label for="contato_tecnico_email" class="form-label">E-mail:</label>
                                <input type="text" class="form-control " id="contato_tecnico_email" name="email_contato_tecnico" value="{{ $empresa->email_contato_tecnico }}">
                            </div>
                            <div class="col">
                                <label for="contato_tecnico_telefone" class="form-label">Telefone:</label>
                                <input type="text" class="form-control " id="contato_tecnico_telefone" name="telefone_contato_tecnico" value="{{ $empresa->telefone_contato_tecnico }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-4">
                        <div class="card-form">
                            <div class="col">
                                <h5 class="pt-2 font-weight-bold">Contato comercial</h5>
                            </div>
                            <div class="col">
                                <label for="contato_tecnico_nome" class="form-label">Nome:</label>
                                <input type="text" class="form-control " id="contato_tecnico_nome" name="nome_contato_comercial" value="{{ $empresa->nome_contato_comercial }}">
                            </div>
                            <div class="col">
                                <label for="contato_tecnico_email" class="form-label">E-mail:</label>
                                <input type="text" class="form-control " id="contato_tecnico_email" name="email_contato_comercial" value="{{ $empresa->email_contato_comercial }}">
                            </div>
                            <div class="col">
                                <label for="contato_tecnico_telefone" class="form-label">Telefone:</label>
                                <input type="text" class="form-control " id="contato_tecnico_telefone" name="telefone_contato_comercial" value="{{ $empresa->telefone_contato_comercial }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <h4>Dados de Login</h4>
                    </div>
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nome:</label>
                        <input type="text" class="form-control " id="name" name="name" value="{{ $empresa->user_empresa()->first()->name }}">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email:</label>
                        <input type="text" class="form-control " id="email" name="email" value="{{ $empresa->user_empresa()->first()->email }}">
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Senha:</label>
                        <input type="password" class="form-control " id="password" name="password" value="">
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirm" class="form-label">Confirmar Senha:</label>
                        <input type="password" class="form-control " id="password_confirm" name="password_confirm" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 pt-4">
                        <button type="submit" class="btn btn-primary">Editar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection