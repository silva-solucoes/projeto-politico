<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sugestao;

class FormController extends Controller
{
    public function submitForm(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'name' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'category' => 'required|string|max:255',
            'message' => 'required|string',
            'termo' => 'accepted',
        ]);

        // Salvar os dados no banco de dados
        Sugestao::create([
            'name' => $request->name,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'category' => $request->category,
            'message' => $request->message,
        ]);

        // Redirecionar com uma mensagem de sucesso
        return redirect()->back()->with('cadastro_sucesso', true);
    }
}
