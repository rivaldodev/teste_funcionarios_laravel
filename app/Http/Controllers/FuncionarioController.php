<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FuncionarioController extends Controller
{
    public function index()
    {
        $funcionarios = Funcionario::orderBy('nome')->get();
        return view('funcionarios.index', compact('funcionarios'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:funcionarios,email',
            'cpf' => 'required|string|size:11|unique:funcionarios,cpf',
            'cargo' => 'nullable|string|max:100',
            'dataAdmissao' => 'nullable|date',
            'salario' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $funcionario = Funcionario::create($request->all());

        return response()->json([
            'success' => true,
            'funcionario' => $funcionario,
            'message' => 'Funcionário cadastrado com sucesso!'
        ]);
    }

    public function edit(string $id)
    {
        $funcionario = Funcionario::findOrFail($id);
        
        $data = $funcionario->toArray();
        if ($data['dataAdmissao']) {
            $data['dataAdmissao'] = $funcionario->dataAdmissao->format('Y-m-d');
        }
        
        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        $funcionario = Funcionario::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:funcionarios,email,' . $id,
            'cpf' => 'required|string|size:11|unique:funcionarios,cpf,' . $id,
            'cargo' => 'nullable|string|max:100',
            'dataAdmissao' => 'nullable|date',
            'salario' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $funcionario->update($request->all());

        return response()->json([
            'success' => true,
            'funcionario' => $funcionario,
            'message' => 'Funcionário atualizado com sucesso!'
        ]);
    }

    public function destroy(string $id)
    {
        $funcionario = Funcionario::findOrFail($id);
        $funcionario->status = 'inativo';
        $funcionario->save();

        return response()->json([
            'success' => true,
            'message' => 'Funcionário inativado com sucesso!'
        ]);
    }

    public function reativar(string $id)
    {
        $funcionario = Funcionario::findOrFail($id);
        $funcionario->status = 'ativo';
        $funcionario->save();

        return response()->json([
            'success' => true,
            'message' => 'Funcionário reativado com sucesso!'
        ]);
    }
}
