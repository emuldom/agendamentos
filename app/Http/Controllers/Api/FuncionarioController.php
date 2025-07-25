<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Funcionario;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Funcionario::query();
        
        if ($request->has('id_empresa')) {
            $query->where('id_empresa', $request->id_empresa);
        }
        
        if ($request->has('ativo')) {
            $query->where('ativo', $request->boolean('ativo'));
        }
        
        return $query->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_empresa' => 'required|exists:empresas,id_empresa',
            'nome_completo' => 'required|string|max:255',
            'cargo' => 'nullable|string|max:100',
            'email_profissional' => 'nullable|email|max:255|unique:funcionarios',
            'telefone_contato' => 'nullable|string|max:20',
            'ativo' => 'nullable|boolean',
        ]);

        $funcionario = Funcionario::create($validated);

        return response()->json($funcionario, 201);
    }

    public function show(Funcionario $funcionario)
    {
        return $funcionario;
    }

    public function update(Request $request, Funcionario $funcionario)
    {
        $validated = $request->validate([
            'id_empresa' => 'required|exists:empresas,id_empresa',
            'nome_completo' => 'required|string|max:255',
            'cargo' => 'nullable|string|max:100',
            'email_profissional' => 'nullable|email|max:255|unique:funcionarios,email_profissional,' . $funcionario->id_funcionario . ',id_funcionario',
            'telefone_contato' => 'nullable|string|max:20',
            'ativo' => 'nullable|boolean',
        ]);

        $funcionario->update($validated);

        return response()->json($funcionario);
    }

    public function destroy(Funcionario $funcionario)
    {
        $funcionario->delete();

        return response()->json(null, 204);
    }
}