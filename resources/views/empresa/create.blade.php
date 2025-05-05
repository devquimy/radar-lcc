@extends('layouts.default')

@section('content-auth')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form class="g-3" action="{{ route('empresa.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="razao_social" class="form-label">Razão social: <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control " id="razao_social" name="nome" value="" required>
                    </div>
                    <div class="col-md-6">
                        <label for="cnpj" class="form-label">CNPJ:</label>
                        <input type="text" class="form-control cnpj " id="cnpj" name="cnpj" value="" maxlength="18">
                    </div>
                    <div class="col-md-4">
                        <label for="cidade" class="form-label">Cidade:</label>
                        <input type="text" class="form-control cidade " id="cidade" name="cidade" value="" maxlength="18">
                    </div>
                    <div class="col-md-2">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" class="form-control">
                            <option value="">Selecione...</option>
                            <option value="AC">Acre (AC)</option>
                            <option value="AL">Alagoas (AL)</option>
                            <option value="AP">Amapá (AP)</option>
                            <option value="AM">Amazonas (AM)</option>
                            <option value="BA">Bahia (BA)</option>
                            <option value="CE">Ceará (CE)</option>
                            <option value="DF">Distrito Federal (DF)</option>
                            <option value="ES">Espírito Santo (ES)</option>
                            <option value="GO">Goiás (GO)</option>
                            <option value="MA">Maranhão (MA)</option>
                            <option value="MT">Mato Grosso (MT)</option>
                            <option value="MS">Mato Grosso do Sul (MS)</option>
                            <option value="MG">Minas Gerais (MG)</option>
                            <option value="PA">Pará (PA)</option>
                            <option value="PB">Paraíba (PB)</option>
                            <option value="PR">Paraná (PR)</option>
                            <option value="PE">Pernambuco (PE)</option>
                            <option value="PI">Piauí (PI)</option>
                            <option value="RJ">Rio de Janeiro (RJ)</option>
                            <option value="RN">Rio Grande do Norte (RN)</option>
                            <option value="RS">Rio Grande do Sul (RS)</option>
                            <option value="RO">Rondônia (RO)</option>
                            <option value="RR">Roraima (RR)</option>
                            <option value="SC">Santa Catarina (SC)</option>
                            <option value="SP">São Paulo (SP)</option>
                            <option value="SE">Sergipe (SE)</option>
                            <option value="TO">Tocantins (TO)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="tma" class="form-label">TMA - Taxa mínima de atratividade:</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="tma" name="tma" placeholder="" aria-label="" aria-describedby="basic-addon2" maxlength="3" min="0" max="100">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="aliquota" class="form-label">Aliquota do imposto de renda:</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="aliquota" name="aliquota" placeholder="" aria-label="" aria-describedby="basic-addon2" maxlength="3" min="0" max="100">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                        </div>
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
                                <input type="text" class="form-control " id="contato_tecnico_nome" name="nome_contato_tecnico" value="">
                            </div>
                            <div class="col">
                                <label for="contato_tecnico_email" class="form-label">E-mail:</label>
                                <input type="text" class="form-control " id="contato_tecnico_email" name="email_contato_tecnico" value="">
                            </div>
                            <div class="col">
                                <label for="contato_tecnico_telefone" class="form-label">Telefone:</label>
                                <input type="text" class="form-control " id="contato_tecnico_telefone" name="telefone_contato_tecnico" value="">
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
                                <input type="text" class="form-control " id="contato_tecnico_nome" name="nome_contato_comercial" value="">
                            </div>
                            <div class="col">
                                <label for="contato_tecnico_email" class="form-label">E-mail:</label>
                                <input type="text" class="form-control " id="contato_tecnico_email" name="email_contato_comercial" value="">
                            </div>
                            <div class="col">
                                <label for="contato_tecnico_telefone" class="form-label">Telefone:</label>
                                <input type="text" class="form-control " id="contato_tecnico_telefone" name="telefone_contato_comercial" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 pt-4">
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection