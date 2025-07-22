<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agendamento;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    public function index(Request $request)
    {
        $query = Agendamento::with(['cliente', 'funcionario', 'tipoAgendamento']);
        
        if ($request->has('id_empresa')) {
            $query->where('id_empresa', $request->id_empresa);
        }
        
        if ($request->has('id_funcionario')) {
            $query->where('id_funcionario', $request->id_funcionario);
        }
        
        if ($request->has('id_cliente')) {
            $query->where('id_cliente', $request->id_cliente);
        }
        
        if ($request->has('data_inicio') && $request->has('data_fim')) {
            $query->whereBetween('data_hora_agendamento', [$request->data_inicio, $request->data_fim]);
        }
        
        if ($request->has('status_agendamento')) {
            $query->where('status_agendamento', $request->status_agendamento);
        }
        
        return $query->orderBy('data_hora_agendamento')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_empresa' => 'required|exists:empresas,id_empresa',
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'id_funcionario' => 'required|exists:funcionarios,id_funcionario',
            'id_tipo_agendamento' => 'required|exists:tipos_de_agendamento,id_tipo_agendamento',
            'data_hora_agendamento' => 'required|date',
            'status_agendamento' => 'nullable|in:Agendado,Confirmado,Cancelado,Realizado,Não Compareceu',
            'origem_agendamento' => 'nullable|string|max:50',
            'observacoes' => 'nullable|string',
        ]);

        $agendamento = Agendamento::create($validated);

        return response()->json($agendamento, 201);
    }

    public function show(Agendamento $agendamento)
    {
        return $agendamento->load(['cliente', 'funcionario', 'tipoAgendamento']);
    }

    public function update(Request $request, Agendamento $agendamento)
    {
        $validated = $request->validate([
            'id_empresa' => 'required|exists:empresas,id_empresa',
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'id_funcionario' => 'required|exists:funcionarios,id_funcionario',
            'id_tipo_agendamento' => 'required|exists:tipos_de_agendamento,id_tipo_agendamento',
            'data_hora_agendamento' => 'required|date',
            'status_agendamento' => 'nullable|in:Agendado,Confirmado,Cancelado,Realizado,Não Compareceu',
            'origem_agendamento' => 'nullable|string|max:50',
            'observacoes' => 'nullable|string',
        ]);

        $agendamento->update($validated);

        return response()->json($agendamento);
    }

    public function destroy(Agendamento $agendamento)
    {
        $agendamento->delete();

        return response()->json(null, 204);
    }
}