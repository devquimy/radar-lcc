<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Empresa;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\CreditoUsuario;
use App\Models\HistoricoTransacaoCredito;
use Validator;

class RegisteredUserController extends Controller
{
    private function validator($request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'aceito_termos' => ['required'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];

        $messages = [
            'razao_social.required' => 'O campo Razão Social é obrigátorio',
            'cnpj.required' => 'O campo CNPJ é obrigátorio',
            'name.required' => 'O campo nome é obrigátorio',
            'aceito_termos.required' => 'Necessário aceitar os termos de uso',
            'email.required'  => 'O campo e-mail é obrigatório.',
            'email.unique'    => ':attribute já está em uso',
            'email.email' => 'Incluir um email válido',
            'password.min' => 'A senha deve ter no mínimo :min caracteres!',
            'password.required' => 'O campo senha é obrigatório',
            'password.confirmed' => 'A senha e confirmação não são iguais',
        ];

        $data = $request->all();

        return Validator::make($data, $rules, $messages);
    }

    private function criarHistoricoCreditoInicial()
    {
        $historicoTransacaoCredito = new HistoricoTransacaoCredito();

        $historicoTransacaoCredito->user_id = Auth::user()->id;
        $historicoTransacaoCredito->quantidade_credito = 1;
        $historicoTransacaoCredito->tipo_transacao = "add";
        $historicoTransacaoCredito->descricao = "Adição de crédito inicial para a empresa";
        $historicoTransacaoCredito->empresa_id = Auth::user()->empresa_id;

        $historicoTransacaoCredito->save();
    }

    private function criarNovoPlano()
    {
        $creditosUsuario = new CreditoUsuario;

        $creditosUsuario->total_creditos_disponiveis = 1;
        $creditosUsuario->user_id = Auth::user()->id;
        $creditosUsuario->empresa_id = Auth::user()->empresa_id;

        $creditosUsuario->save();

        return;
    }

    /**
     * Método que registra um usuário
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {        

        $validator = $this->validator($request);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('error', $validator->errors()->first())
                ->withInput();
        }

        $validarEmpresa = Empresa::where('cnpj', $request->cnpj)->first();

        if($validarEmpresa != null){
            return redirect()
                ->back()
                ->with('error', 'CNPJ já existente no sistema, utilize outro CNPJ')
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nivel_acesso_id' => 1,
            'password' => Hash::make($request->password),
        ]);

        $empresa = new Empresa();
        $empresa->nome = $request->razao_social;
        $empresa->cnpj = $request->cnpj;
        $empresa->nome_contato_comercial = $request->name;
        $empresa->email_contato_comercial = $request->email;
        $empresa->user_id = $user->id;

        $empresa->save();

        $user->empresa_id = $empresa->id;

        $user->save();

        event(new Registered($user));

        Auth::login($user);

        // $this->criarHistoricoCreditoInicial();
        // $this->criarNovoPlano();

        return redirect('/ativos_fisicos')->with("success", 'Usuário cadastrado com sucesso');
    }
}
