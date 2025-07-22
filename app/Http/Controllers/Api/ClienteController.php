<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::query();
        
        if ($request->has('id_empresa')) {
            $query->where('id_empresa', $request->id_empresa);
        }
        
        return $query->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_empresa' => 'required|exists:empresas,id_empresa',
            'nome_completo' => 'required|string|max:255',
            'numero_whatsapp' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $cliente = Cliente::create($validated);

        return response()->json($cliente, 201);
    }

    public function show(Cliente $cliente)
    {
        return $cliente;
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'id_empresa' => 'required|exists:empresas,id_empresa',
            'nome_completo' => 'required|string|max:255',
            'numero_whatsapp' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $cliente->update($validated);

        return response()->json($cliente);
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return response()->json(null, 204);
    }

    /**
     * Cria ou atualiza um cliente com base no telefone e empresa_id
     */
    public function createOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
        ]);

        // Busca cliente pelo telefone e empresa_id
        $cliente = Cliente::where('numero_whatsapp', $validated['telefone'])
                          ->where('empresa_id', $validated['empresa_id'])
                          ->first();

        if ($cliente) {
            // Atualiza cliente existente se o nome for diferente
            if ($cliente->nome_completo !== $validated['nome']) {
                $cliente->nome_completo = $validated['nome'];
                $cliente->save();
            }
            $message = 'Cliente atualizado com sucesso';
        } else {
            // Cria novo cliente
            $cliente = Cliente::create([
                'empresa_id' => $validated['empresa_id'],
                'nome_completo' => $validated['nome'],
                'numero_whatsapp' => $validated['telefone'],
            ]);
            $message = 'Cliente criado com sucesso';
        }

        return response()->json([
            'message' => $message,
            'cliente' => $cliente
        ], $cliente->wasRecentlyCreated ? 201 : 200);
    }
}