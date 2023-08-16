<?php

namespace App\Http\Controllers;

use App\Models\Cep;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class CepController extends Controller
{
    public function index()
    {
        $ceps = Cep::all();
        return response()->json($ceps);
    }

    public function show($id)
    {
        $cep = Cep::findOrFail($id);
        return response()->json($cep);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cep' => 'required|string|unique:ceps',
            'logradouro' => 'required|string',
            'localidade' => 'required|string',
            'uf' => 'required|string'
        ]);

        $cep = Cep::create($data);
        return response()->json($cep, 201);
    }

    public function update(Request $request, $id)
    {
        $cep = Cep::findOrFail($id);

        $data = $request->validate([
            'cep' => 'required|string|unique:ceps',
            'logradouro' => 'required|string',
            'localidade' => 'required|string',
            'uf' => 'required|string',
        ]);

        $cep->update($data);
        return response()->json($cep);
    }

    public function destroy($id)
    {
        $cep = Cep::findOrFail($id);
        $cep->delete();
        return response()->json(null, 204);
    }

    public function search($cep)
{
    $existingCep = Cep::where('cep', $cep)->first();

    if ($existingCep) {
        return response()->json(['message' => 'CEP already exists in the database.']);
    }

    $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");
    $data = $response->json();

    if (isset($data['erro'])) {
        return response()->json(['message' => 'CEP not found.']);
    }

    $existingLogradouro = Cep::where('logradouro', $data['logradouro'])->first();

    if ($existingLogradouro) {
        return response()->json(['message' => 'CEP ou Logradouro already exists in the database.']);
    }

    $newCep = Cep::create([
        'cep' => $data['cep'],
        'logradouro' => $data['logradouro'],
        'localidade' => $data['localidade'],
        'uf' => $data['uf']
    ]);

    return response()->json($newCep, 201);
}

}



