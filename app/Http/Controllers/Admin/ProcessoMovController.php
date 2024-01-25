<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessoMovRequest;
use App\Models\Processo;
use App\Models\ProcessoMov;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProcessoMovController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id = null)
    {
        if($id) {
            $processo = Processo::find($id);
            $users = User::all();
            $processos_mov = ProcessoMov::where('processo_id', $processo->id)
                ->orderBy('data', 'desc')
                ->orderBy('id', 'desc')
                ->get();

            $usuarioLogado = Auth::user();
            return view('Admin.Processos.processo_mov-listar', compact([ 'processo', 'users', 'processos_mov', 'usuarioLogado' ]) );
        }

        $processo = Processo::find($request)->first();
        $users = User::all();

        if($processo) {
            $processos_mov = ProcessoMov::where('processo_id', $processo->id)
                ->orderBy('data', 'desc')
                ->orderBy('id', 'desc')
                ->get();

            $usuarioLogado = Auth::user();
            return view('Admin.Processos.processo_mov-listar', compact([ 'processo', 'users', 'processos_mov', 'usuarioLogado' ]) );
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $processo_id = $request->query('processo_id');
        $users = User::all();
        $usuarioLogado = Auth::user();
        return view('Admin.Processos.processo_mov-adicionar', compact(['users', 'processo_id', 'usuarioLogado']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProcessoMovRequest $request)
    {
        $processo = Processo::find($request->processo_id);
        // Verificar se o status do processo é 'Concluido'
        if ($processo->status == 'Concluido') {
            return redirect()
                ->route('processoMov.index', ['processo' => $processo->id])
                ->with('error', 'Processo Concluído não pode ser movimentado');
        }


        $movimento = $request->only([
            'user_id',
            'processo_id',
            'data',
            'descricao',
            'anexo'
        ]);

        if($request->file('anexo')) {
            $file = $request->file('anexo');
            $movimento['anexo'] = $file->hashName();
            $file->move(public_path('processos/anexos'), $file->hashName());
        }

        ProcessoMov::create($movimento);
        $processo = Processo::find($movimento['processo_id']);
        return redirect()
            ->route('processoMov.index', ['processo' => $processo->id])
            ->with('success', 'Movimento criado com sucesso!');
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
    public function edit(String $id)
    {

        $processo_mov = ProcessoMov::find($id);
        $users = User::all();

        if($processo_mov) {
            return view('Admin.Processos.processo_mov-editar', compact([ 'processo_mov', 'users' ]) );
        }
        return view('Admin.Processos.processo_mov-listar');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProcessoMovRequest $request, string $id)
    {
        $processoMov = ProcessoMov::find($id);

        // Dados a serem atualizados
        $dadosAtualizados = $request->only([
            'user_id',
            'processo_id',
            'data',
            'descricao',

        ]);

        if ($request->hasFile('anexo')) {
            // Deletar arquivo antigo se existir
            if ($processoMov->anexo && file_exists($caminhoArquivo = public_path('processos/anexos/') . $processoMov->anexo)) {
                unlink($caminhoArquivo);
            }

            // Salvar novo arquivo
            $file = $request->file('anexo');
            $dadosAtualizados['anexo'] = $file->hashName();
            $file->move(public_path('processos/anexos'), $file->hashName());
        }

        // Atualizar registro no banco de dados
        $processoMov->update($dadosAtualizados);
        return redirect()
            ->route('processoMov.index', ['id' => $processoMov->processo_id])
            ->with('success', 'Processo alterado com sucesso!');


        // return redirect()->route('processoMov.index', ['id' => $processoMov->processo_id])->with('error', 'Nenhum registro alterado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $processo_mov = ProcessoMov::find($id);

        // Só pode excluir movimento no dia que for criado
        if($processo_mov->data < date('Y-m-d')) {
            return redirect()->route('processoMov.index', ['id' => $processo_mov->processo_id])->with('error', 'Movimento não pode ser excluído!');
        }

        if ($processo_mov) {
            // Deletar anexo, se existir
            if (!empty($processo_mov->anexo) && file_exists($caminhoArquivo = public_path('processos/anexos/') . $processo_mov->anexo)) {
                unlink($caminhoArquivo);
            }
            $processo_mov->delete();
            return redirect()->route('processoMov.index', ['id' => $processo_mov->processo_id])->with('warning', 'Movimento deletado com sucesso!');
        }

        return redirect()->route('processoMov.index', ['id' => $processo_mov->processo_id])->with('error', 'Nenhum movimento deletado!');
    }

}
