<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentosController extends Controller
{
    public function index()
    {
        $documentos = Documento::all();

        return view("documento.index",[
            'documentos' => $documentos,
            'titulo_pagina' => 'Documentos'
        ]);
    }

    public function store()
    {
        return view("documento.create",[
            'titulo_pagina' => 'Adicionar Documento'
        ]);
    }

    public function edit($id)
    {   
        $documento = Documento::findOrFail($id);

        return view("documento.edit",[
            'documento' => $documento,
            'titulo_pagina' => 'Editar documento'
        ]);
    }

    public function update($id, Request $request)
    {
        $documento = Documento::findOrFail($id);

        $documento->nome_documento = $request->nome_documento;
        $documento->documento = $request->documento;
        $documento->tipo_documento = $request->tipo_documento;
        $documento->usuario_ultima_edicao_id = Auth::user()->id;

        try {
            $documento->save();

        } catch (\Throwable $th) {
            return redirect("/documentos")->with("error", 'Erro não identificado encontrado, por favor entre em contato com o departamento de TI');

        }

        return redirect("/documentos")->with("success", 'Documento editado com sucesso!');
    }

    public function create(Request $request)
    {
        $documento = new Documento;

        $documento->nome_documento = $request->nome_documento;
        $documento->documento = $request->documento;
        $documento->tipo_documento = $request->tipo_documento;
        $documento->usuario_ultima_edicao_id = Auth::user()->id;

        try {
            $documento->save();

        } catch (\Throwable $th) {
            return redirect("/documentos")->with("error", 'Erro não identificado encontrado, por favor entre em contato com o departamento de TI');

        }

        return redirect("/documentos")->with("success", 'Documento cadastrado com sucesso!');
    }
}
