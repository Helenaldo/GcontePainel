<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessoRequest;
use App\Models\Cliente;
use App\Models\Processo;
use App\Models\ProcessoMov;
use App\Models\User;
use Carbon\Carbon;
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

     public function index(Request $request)
     {
        // dd($request);
         $this->updateConcluido(); // Atualiza o status dos processos como antes

         $filtro = $request->input('r1', 'ativos'); // Assume 'ativos' como padrão se nenhum filtro for fornecido
         $pesquisa = $request->input('pesquisa', '');

         $query = Processo::query();

         // Filtragem por pesquisa textual
         if (!empty($pesquisa)) {
             $query->where(function ($query) use ($pesquisa) {
                 $query->where('titulo', 'like', '%' . $pesquisa . '%')
                     ->orWhere('status', 'like', '%' . $pesquisa . '%')
                     ->orWhereHas('cliente', function ($q) use ($pesquisa) {
                         $q->where('nome', 'like', '%' . $pesquisa . '%');
                     });
             });
         }

         // Filtragem por status
         switch ($filtro) {
             case 'ativos':
                 $query->whereNull('concluido');
                 break;
             case 'inativos':
                 $query->whereNotNull('concluido');
                 break;
             case 'parados':
                 $dezDiasAtras = Carbon::now()->subDays(11);
                 $query->whereDoesntHave('movimentacoes', function ($query) use ($dezDiasAtras) {
                     $query->where('data', '>', $dezDiasAtras);
                 })->where('status', '!=', 'Concluido');
                 break;
             default:
                 // Não aplica nenhum filtro adicional, listando todos os processos
                 break;
         }

         $processos = $query->get()->map(function ($processo) {
             // Cálculo dos dias passados para cada processo, como no método index
             $dataProcesso = new Carbon($processo->data);
             $hoje = Carbon::now();
             $processo->diasPassados = $dataProcesso->diffInDays($hoje);
             return $processo;
         });

         return view('Admin.Processos.processo-listar', compact('processos', 'filtro', 'pesquisa'));
     }


    // public function index(Request $request)
    // {
    //     // Chama o método para atualizar o status dos processos
    //     $this->updateConcluido();

    //     $processos = Processo::when($request->has('pesquisa'), function ($query) use ($request) {
    //         $query->where(function ($query) use ($request) {
    //             $query->where('titulo', 'like', '%' . $request->pesquisa . '%')
    //                 ->orWhere('status', 'like', '%' . $request->pesquisa . '%')
    //                 ->orWhereHas('cliente', function ($q) use ($request) {
    //                     $q->where('nome', 'like', '%' . $request->pesquisa . '%');
    //                 });
    //         });
    //     })
    //     ->whereNull('concluido')
    //     ->orderBy('data', 'desc')
    //     ->get()
    //     ->map(function ($processo) {
    //         // Aqui você calcula a diferença em dias entre a data do processo e hoje
    //         $dataProcesso = new Carbon($processo->data);
    //         $hoje = Carbon::now();
    //         $diasPassados = $dataProcesso->diffInDays($hoje);

    //         // Adiciona o número de dias passados como um novo atributo do processo
    //         $processo->diasPassados = $diasPassados;

    //         return $processo;
    //     });

    //     $filtro = 'ativos';
    //     return view('Admin.Processos.processo-listar', [
    //         'processos' => $processos,
    //         'filtro' => $filtro,
    //         'pesquisa' => $request->pesquisa
    //     ]);
    // }

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

        // Definir a prazo d+30 se não estiver presente no pedido
        if(!$processo['prazo']) {
            $processo['prazo'] = now()->addDays(30)->format('Y-m-d');
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

    // public function processosFiltrar(Request $request)
    // {

    //     // Data de 10 dias atrás
    //     $dezDiasAtras = Carbon::now()->subDays(11);

    //     $processosParados = Processo::whereDoesntHave('movimentacoes', function ($query) use ($dezDiasAtras) {
    //         $query->where('data', '>', $dezDiasAtras);
    //         })
    //         ->where('status', '!=', 'Concluido') // Exclui processos com status 'Concluido'
    //         ->get();

    //     $filtro = $request->r1;

    //     if ($filtro == 'ativos') {
    //         // Processos ativos: 'data_saida' é null
    //         $processos = Processo::whereNull('concluido')->get();
    //     } elseif ($filtro == 'inativos') {
    //         // Processos inativos: 'data_saida' não é null
    //         $processos = Processo::whereNotNull('concluido')->get();
    //     } elseif ($filtro == 'parados') {
    //         // Processos parados
    //         $processos = $processosParados;
    //     } else {
    //         // Todos os processos
    //         $processos = Processo::all();
    //     }

    //     $pesquisa = "";

    //     return view('Admin.Processos.processo-listar', compact(['processos', 'filtro', 'pesquisa']));
    // }

}
