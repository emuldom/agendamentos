<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TipoAgendamento;
use Illuminate\Http\Request;

class TipoAgendamentoController extends Controller
{
    public function index(Request $request)
    {
        $query = TipoAgendamento::query();
        
        if ($request->has('id_empresa')) {
            $query->where('id_empresa', $request->id_empresa);
        }
        
        return $query->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_empresa' => 'required|exists:empresas,id_empresa',
            'nome_servico' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'duracao_estimada_min' => 'nullable|integer|min:1',
            'valor' => 'nullable|numeric|min:0',
        ]);

        $tipoAgendamento = TipoAgendamento::create($validated);

        return response()->json($tipoAgendamento, 201);
    }

    public function show(TipoAgendamento $tipoAgendamento)
    {
        return $tipoAgendamento;
    }

    public function update(Request $request, TipoAgendamento $tipoAgendamento)
    {
        $validated = $request->validate([
            'id_empresa' => 'required|exists:empresas,id_empresa',
            'nome_servico' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'duracao_estimada_min' => 'nullable|integer|min:1',
            'valor' => 'nullable|numeric|min:0',
        ]);

        $tipoAgendamento->update($validated);

        return response()->json($tipoAgendamento);
    }

    public function destroy(TipoAgendamento $tipoAgendamento)
    {
        $tipoAgendamento->delete();

        return response()->json(null, 204);
    }
}