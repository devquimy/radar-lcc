<?php

use App\Http\Controllers\AtivoFisicoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\InflacaoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CapexController;
use App\Http\Controllers\CreditoController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\EstudosController;
use App\Http\Controllers\NiveisAcessoController;
use App\Http\Controllers\OpexController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\Inflacao;

Route::get('/login', [AuthenticatedSessionController::class, 'login']);

Route::get('/', [AuthenticatedSessionController::class, 'login']);

// Route::get('/', function () {
//     return view('login');
// });

// Route::get('/login', function () {
//     return view('login');
// });

Route::get('/register', function () {
    return view('registro');
})->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.create');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
   // Empresas
    Route::match(['get', 'post'], '/empresas', [EmpresaController::class, 'index'])->name("empresa.index");
    Route::get('/empresas/create', [EmpresaController::class, 'create'])->name("empresa.create");
    Route::get('/empresas/edit/{id}', [EmpresaController::class, 'edit'])->name('empresa.edit');
    Route::post('/empresas/update/{id}', [EmpresaController::class, 'update'])->name("empresa.update");
    Route::post('/empresas/store', [EmpresaController::class, 'store'])->name("empresa.store");
    Route::delete('/empresas/delete/{id}', [EmpresaController::class, 'destroy'])->name('empresas.deletar');

    //Inflacao
    Route::get('/inflacao', [InflacaoController::class, 'index'])->name("inflacao.index");
    Route::post('/inflacao/create', [InflacaoController::class, 'create'])->name("inflacao.create");

    //Créditos
    Route::get('/creditos', [CreditoController::class, 'index'])->name("credito.index");
    Route::get('/creditos/create', [CreditoController::class, 'create'])->name("credito.create");
    Route::post('/creditos/store', [CreditoController::class, 'store'])->name("credito.store");
    Route::get('/creditos/edit/{id}', [CreditoController::class, 'edit'])->name("credito.edit");
    Route::post('/creditos/update/{id}', [CreditoController::class, 'update'])->name("credito.update");
    Route::post('/creditos/contratar_creditos', [CreditoController::class, 'contratarNovosCreditos'])->name("credito.contratar_creditos");
    Route::get('/creditos/plano_contratado_sucesso', [CreditoController::class, 'planoContratadoSucesso'])->name("credito.plano_contratado_sucesso");

    //Usuários
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name("usuario.index");
    Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name("usuario.create");
    Route::post('/usuarios/store', [UsuarioController::class, 'store'])->name("usuario.store");
    Route::get('/usuarios/edit/{id}', [UsuarioController::class, 'edit'])->name("usuario.edit");
    Route::post('/usuarios/update/{id}', [UsuarioController::class, 'update'])->name("usuario.update");
    Route::post('/usuarios/adicionar-creditos', [UsuarioController::class, 'adicionarCreditos'])->name("usuario.adicionar_creditos");

    //Ativos Fisicos
    Route::get('/ativos_fisicos', [AtivoFisicoController::class, 'index'])->name("ativo_fisico.index");
    Route::get('/ativos_fisicos/create', [AtivoFisicoController::class, 'create'])->name("ativo_fisico.create");
    Route::post('/ativos_fisicos/store', [AtivoFisicoController::class, 'store'])->name("ativo_fisico.store");
    Route::get('/ativos_fisicos/edit/{id}/{estudo_id?}', [AtivoFisicoController::class, 'edit'])->name("ativo_fisico.edit");
    Route::post('/ativos_fisicos/update/{id}', [AtivoFisicoController::class, 'update'])->name("ativo_fisico.update");
    Route::delete('/ativos_fisicos/delete/{id}', [AtivoFisicoController::class, 'delete'])->name('ativo_fisico.delete');

    //Capex
    Route::post('/capex/store', [CapexController::class, 'store'])->name("capex.store");
    Route::get('/capex/edit/{id}', [CapexController::class, 'edit'])->name("capex.edit");
    Route::post('/capex/update/{id}', [CapexController::class, 'update'])->name("capex.update");

    //Opex
    Route::get('/opex/edit/{id}', [OpexController::class, 'edit'])->name("opex.edit");
    Route::post('/opex/store', [OpexController::class, 'store'])->name("opex.store");

    //Estudos
    Route::get('/estudos/{id}', [EstudosController::class, 'index'])->name("estudo.index");
    Route::get('/estudos/gerar_relatorio/{id}', [EstudosController::class, 'gerarRelatorio'])->name("estudo.gerar_relatorio");
    Route::post('/estudos/repetir', [AtivoFisicoController::class, 'criarNovoEstudo'])->name("estudo.repetir");
    Route::get('/estudo/curva_anual_equivalente/{id}', [EstudosController::class, 'curvaAnualEquivalente'])->name("estudo.curva_anual_equivalente");
    Route::get('/estudo/visualizar_relatorio/{id}', [EstudosController::class, 'visualizarRelatorio'])->name("estudo.visualizar_relatorio");

    //Niveis Acesso
    Route::get('/niveis_acessos', [NiveisAcessoController::class, 'index'])->name("niveis_acesso.index");

    //Pedidos
    Route::post('/pedidos/pagamento', [PedidosController::class, 'gerarPedido'])->name("pedido.pagamento");
    Route::get('/pedidos', [PedidosController::class, 'index'])->name("pedido.index");


    //Documentos
    Route::get('/documentos', [DocumentosController::class, 'index'])->name("documento.index");
    Route::get('/documentos/store', [DocumentosController::class, 'store'])->name("documento.store");
    Route::get('/documento/{id}', [DocumentosController::class, 'edit'])->name("documento.edit");
    Route::post('/documentos/create', [DocumentosController::class, 'create'])->name("documento.create");
    Route::post('/documentos/update/{id}', [DocumentosController::class, 'update'])->name("documento.update");

});

require __DIR__.'/auth.php';