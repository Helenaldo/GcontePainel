<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessoRequest;
use App\Models\Cliente;
use App\Models\Processo;
use App\Models\ProcessoMov;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProcessoController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Chama o método para atualizar o status dos processos
        $this->updateConcluido();

        $processos = Processo::whereNull('concluido')
            ->orderBy('data', 'desc')
            ->paginate(15);

        $filtro = 'ativos';
        return view('Admin.Processos.processo-listar', compact(['processos', 'filtro']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::all();
        $users = User::all();
        $usuarioLogado = Auth::user();
        return view('Admin.Processos.processo-adicionar', compact(['clientes', 'users', 'usuarioLogado']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProcessoRequest $request)
    {
        $processo = $request->only([
            'cliente_id',
            'user_id',
            'titulo',
            'numero',
            'status',
            'data',
            'prazo',
            'concluido',
        ]);

        // Definir a data atual se não estiver presente no pedido
        if(!$processo['data']) {
            $processo['data'] = date('Y-m-d');
        }
        // Definir 'Em andamento' como valor padrão para 'status' se estiver vazio
        if(!$processo['status']) {
            $processo['status'] = 'Em andamento';
        }

        Processo::create($processo);

        return redirect()->route('processo.index')->with('success', 'Processo criado com sucesso!');
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
        $processo = Processo::find($id);
        $users = User::all();

        if($processo) {
            return view('Admin.Processos.processo-editar', compact([ 'processo', 'users' ]) );
        }
        return redirect()->route('processo');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProcessoRequest $request, string $id)
    {

        $processo = Processo::find($id);

        if($processo && $processo->status == 'Concluido') {
            return redirect()->route('processo.index')->with('error', 'Procersso não pode ser alterado!');
        }

        if($processo) {
            $data = $request->only([
                'titulo',
                'numero',
                'status',
                'data',
                'prazo',
                'concluido',
                'user_id',
            ]);

            if($data['status'] != 'Concluido') {
                $data['concluido'] = null;
            }

            $processo->fill($data)->save();
            return redirect()->route('processo.index')->with('success', 'Processo alterado com sucesso!');
        }
        return redirect()->route('processo.index')->with('error', 'Nenhum registro alterado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $processo = Processo::find($id);
        $processos_mov = ProcessoMov::where('processo_id', $processo->id)->count();

        // Se processo estiver com status Concluído não pode ser deletado
        if($processo && $processo->status == 'Concluido') {
            return redirect()->route('processo.index')->with('error', 'Procersso não pode ser excluído!');
        }

        // Se processo tiver movimentos não poderá ser deletado.
        if($processos_mov > 0) {
            return redirect()->route('processo.index')->with('error', 'Processo possui movimentos e não pode ser excluído!');
        }

        if ($processo) {
            $processo->delete();
            return redirect()->route('processo.index')->with('warning', 'Processo excluído com sucesso!');
        }

        return redirect()->route('processo.index')->with('error', 'Nenhum Processo excluído!');
    }

    // Atualiza todos registros quando estiver com prazo vencido
    public function updateConcluido() {

        // Pegar todos os registros onde o campo "status" for igual a "Em andamento"
        // e o campo "Prazo" for menor que a data atual
        $processos = Processo::where('status', 'Em andamento')
                        ->whereDate('prazo', '<', date('Y-m-d'))
                        ->get();

        foreach ($processos as $processo) {
            $data = ['status' => 'Atrasado'];
            $processo->update($data);
        }
    }

    public function processoFim(Request $request, string $id) {

        $processo = Processo::find($id);

        if($processo && $processo->status == 'Concluido') {
            $data['status'] = 'Em andamento';
            $data['concluido'] = null;
            $processo->fill($data)->save();
            return redirect()->route('processo.index')->with('success', 'Processo reaberto com sucesso!');
        }

        if($processo && $processo->status != 'Concluido') {
            $data['status'] = 'Concluido';
            $data['concluido'] = date('Y-m-d');
            $processo->fill($data)->save();
            return redirect()->route('processo.index')->with('success', 'Processo finalizado com sucesso!');
        }

        return redirect()->route('processo.index');
    }

    public function processosFiltrar(Request $request)
    {

        $filtro = $request->r1;

        if ($filtro == 'ativos') {
            // Clientes ativos: 'data_saida' é null
            $processos = Processo::whereNull('concluido')->paginate(15);
        } elseif ($filtro == 'inativos') {
            // Clientes inativos: 'data_saida' não é null
            $processos = Processo::whereNotNull('concluido')->paginate(15);
        } else {
            // Todos os clientes
            $processos = Processo::paginate(15);
        }

        return view('Admin.Processos.processo-listar', compact(['processos', 'filtro']));
    }

}