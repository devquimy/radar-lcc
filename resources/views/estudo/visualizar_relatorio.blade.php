@extends('layouts.default')

@section('content-auth')
    <div class="container-fluid">
        @include('layouts.time_line_estudos')

        <div class="card shadow mt-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                    <iframe src="{{ $caminho_relatorio }}" download="{{ $estudo->nome_relatorio }}" width="100%" height="600px"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection