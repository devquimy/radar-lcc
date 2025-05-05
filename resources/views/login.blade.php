@extends('layouts.default')

@section('content')
<?php 
if(Auth::check()){
    echo "<script>window.location.href = '" . url('/ativos_fisicos') . "'</script>";
}
?>
<body style="background-image: url({{ asset('/public/img/fundo_login.jpg') }}); background-position: bottom;">
    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>Radar LCC</h3>
                    @include('layouts.flash-message')

                </div>
                <form class="user" action="{{ route('login') }}" method="post">
                    @csrf

                    <div class="card-body">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="email" class="form-control" placeholder="Login" value="" required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control" value="" placeholder="Senha" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-8 pt-2">
                                <a href="{{ route('register') }}" style="color:white; text-decoration: none;">Não tenho cadastro</a>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <input type="submit" value="Acessar" class="btn float-right login_btn">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
@endsection
