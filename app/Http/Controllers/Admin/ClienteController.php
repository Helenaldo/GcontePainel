<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClienteRequest;
use App\Http\Requests\ClienteUpdateRequest;
use App\Models\Cidade;
use App\Models\Cliente;
use App\Models\Contato;
use App\Models\Processo;
use App\Models\Tributacao;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Clientes ativos: 'data_saida' é null
        $clientes = Cliente::whereNull('data_saida')
            ->orderBy('nome', 'asc')
            ->paginate(15);

        $filtro = 'ativos';
        return view('Admin.Clientes.cliente-listar', compact([ 'clientes', 'filtro' ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $cidades = Cidade::all();
        $loggedUser = auth()->user();
        return view('Admin.Clientes.cliente-adicionar', compact(['cidades', 'loggedUser']));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClienteRequest $request)
    {

        $cliente = $request->only([
            'tipo_identificacao',
            'cpf_cnpj',
            'nome',
            'fantasia',
            'cep',
            'logradouro',
            'numero',
            'bairro',
            'complemento',
            'cidade_id',
            'data_entrada',
            'data_saida',
            'tipo', // Matriz ou Filial
        ]);

        Cliente::create($cliente);

        return redirect()->route('clientes.index')->with('success', 'Cliente criado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cliente = Cliente::find($id);
        $cidades = Cidade::all();
        $loggedUser = auth()->user();

        if($cliente) {
            return view('Admin.Clientes.cliente-editar', compact([ 'cliente', 'cidades', 'loggedUser' ]) );
        }
        return redirect()->route('clientes');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClienteUpdateRequest $request, string $id)
    {
        $cliente = Cliente::find($id);

        if($cliente) {
            $data = $request->only([
                'nome',
                'fantasia',
                'cep',
                'logradouro',
                'numero',
                'bairro',
                'complemento',
                'cidade_id',
                'data_entrada',
                'data_saida',
                'tipo', // Matriz ou Filial
            ]);

            $cliente->fill($data)->save();
            return redirect()->route('clientes.index')->with('success', 'Cliente alterado com sucesso');
        }
        return redirect()->route('clientes.index')->with('error', 'Dados não alterados');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cliente = Cliente::find($id);

        $contatos = Contato::where('cliente_id', $id)->count();
        $tributacao = Tributacao::where('cliente_id', $id)->count();
        $processo = Processo::where('cliente_id', $id)->count();
        if($contatos || $tributacao || $processo) {
            return redirect()->route('clientes.index')->with('error', 'Cliente possui registros e não pode ser deletado');
        }

        $loggedUser = auth()->user();
        if ($loggedUser->perfil != 'Administrador') {
            return redirect()->route('usuarios.index')->with('error', 'Você não tem permissão para excluir clientes');
        }

        if ($cliente) {
            $cliente->delete();
            return redirect()->route('clientes.index')->with('warning', 'Cliente deletado com sucesso');
        }

        return redirect()->route('clientes.index')->with('error', 'Cliente não deletado');
    }

    public function clientesFiltrar(Request $request)
    {

        $filtro = $request->r1;

        if ($filtro == 'ativos') {
            // Clientes ativos: 'data_saida' é null
            $clientes = Cliente::whereNull('data_saida')->paginate(15);
        } elseif ($filtro == 'inativos') {
            // Clientes inativos: 'data_saida' não é null
            $clientes = Cliente::whereNotNull('data_saida')->paginate(15);
        } else {
            // Todos os clientes
            $clientes = Cliente::paginate(15);
        }

        return view('Admin.Clientes.cliente-listar', compact('clientes', 'filtro'));
    }


    // public function buscarCidade() {

    //     //Pega os dados via url
    //     $cidade = filter_input(INPUT_GET, "cidade", FILTER_DEFAULT);

    //     if(!empty($cidade)) {

    //         //pesquisa no banco de dados
    //         $cidades = Cidade::where('municipio', 'like', "%$cidade%")
    //             ->limit(20)
    //             ->select('id', 'municipio', 'UF')
    //             ->get();

    //         if(($cidades) and ($cidades->Count() !=0)) {
    //             //se encontrar envia para a js na variável dados
    //             return response()->json(['status' => true, 'dados' => $cidades]);

    //         } else {
    //             $retorna = ['status' => false, 'message' => 'Nenhuma cidade encontrada'];
    //         }

    //     } else {
    //         $retorna = ['status' => false, 'message' => 'Nenhuma cidade encontrada'];
    //     }
    //     echo json_encode($retorna);
    // }

    // protected function salvarEstabelecimento($clienteData) {

    //     $cliente = Cliente::where('cpf_cnpj', $clienteData['cpf_cnpj'])->first();

    //     $estabelecimento = [
    //         'cliente_id' => $cliente->id,
    //         'tipo_identificacao' => $cliente->tipo_identificacao,
    //         'cpf_cnpj' => $cliente->cpf_cnpj,
    //         'nome' => $cliente->nome,
    //         'fantasia' => $cliente->fantasia,
    //         'cep' => $cliente->cep,
    //         'logradouro' => $cliente->logradouro,
    //         'numero' => $cliente->numero,
    //         'bairro' => $cliente->bairro,
    //         'complemento' => $cliente->complemento,
    //         'cidade_id' => $cliente->cidade_id,
    //     ];

    //     Estabelecimento::create($estabelecimento);
    // }

    // protected function editarEstabelecimento($cliente) {
    //     $cpf_cnpj = $cliente->cpf_cnpj;
    //     $estabelecimento = Estabelecimento::where('cpf_cnpj', $cpf_cnpj)->first();
    //     $estabelecimento->update([
    //         //'tipo_identificacao' => $cliente->tipo_identificacao,
    //         //'cpf_cnpj' => $cliente->cpf_cnpj,
    //         'nome' => $cliente->nome,
    //         'fantasia' => $cliente->fantasia,
    //         'cep' => $cliente->cep,
    //         'logradouro' => $cliente->logradouro,
    //         'numero' => $cliente->numero,
    //         'bairro' => $cliente->bairro,
    //         'complemento' => $cliente->complemento,
    //         'cidade_id' => $cliente->cidade_id,
    //     ]);
    // }
}

