@extends('layouts.default')

@section('content-auth')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form class="g-3" action="{{ route('credito.update', $credito->id) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label for="qtd_estudos" class="form-label">Quantidade estudos: <span class="text-danger">*</span> </label>
                            <input type="number" class="form-control " id="qtd_estudos" name="qtd_estudos" value="{{ $credito->qtd_estudos }}" placeholder="Digite..." required>
                        </div>
                        <div class="col-md-4">
                            <label for="valor" class="form-label">Valor: <span class="text-danger">*</span> </label>
                            <input type="text" class="form-control valor_rs" id="valor" name="valor" value="{{ number_format($credito->valor, 2, ",", ".") }}" placeholder="Digite..." required>
                        </div>
                        <div class="col-md-12 pt-4">
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection