<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index()
    {
        return Empresa::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome_empresa' => 'required|string|max:255',
            'cnpj' => 'nullable|string|max:18|unique:empresas',
            'telefone_contato' => 'nullable|string|max:20',
            'email_contato' => 'nullable|email|max:255|unique:empresas',
        ]);

        $empresa = Empresa::create($validated);

        return response()->json($empresa, 201);
    }

    public function show(Empresa $empresa)
    {
        return $empresa;
    }

    public function update(Request $request, Empresa $empresa)
    {
        $validated = $request->validate([
            'nome_empresa' => 'required|string|max:255',
            'cnpj' => 'nullable|string|max:18|unique:empresas,cnpj,' . $empresa->id_empresa . ',id_empresa',
            'telefone_contato' => 'nullable|string|max:20',
            'email_contato' => 'nullable|email|max:255|unique:empresas,email_contato,' . $empresa->id_empresa . ',id_empresa',
        ]);

        $empresa->update($validated);

        return response()->json($empresa);
    }

    public function destroy(Empresa $empresa)
    {
        $empresa->delete();

        return response()->json(null, 204);
    }
}