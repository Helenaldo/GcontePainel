<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TributacaoRequest;
use App\Models\Cliente;
use App\Models\Tributacao;
use Illuminate\Http\Request;

class TributacaoController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tributacoes = Tributacao::paginate(15);

        return view('Admin.Clientes.tributacao-listar', compact(['tributacoes']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::all();
        return view('Admin.Clientes.tributacao-adicionar', compact(['clientes']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TributacaoRequest $request)
    {
        // dd($request);
        $tributacao = $request->only([
            'cliente_id',
            'tipo',
            'data',
        ]);

        Tributacao::create($tributacao);

        return redirect()->route('tributacao.index')->with('success', 'Tributação cadastrada com sucesso');
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
        $tributacao = Tributacao::find($id);

        if($tributacao) {
            return view('Admin.Clientes.tributacao-editar', compact([ 'tributacao' ]) );
        }
        return redirect()->route('tributacao');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TributacaoRequest $request, string $id)
    {
        $tributacao = Tributacao::find($id);

        if($tributacao) {
            $data = $request->only([
                'tipo',
                'data',
            ]);

            $tributacao->fill($data)->save();
            return redirect()->route('tributacao.index')->with('success', 'Tributação alterada com sucesso');
        }
        return redirect()->route('tributacao.index')->with('error', 'Tributação não alterada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tributacao = Tributacao::find($id);

        if ($tributacao) {
            $tributacao->delete();
            return redirect()->route('tributacao.index')->with('warning', 'Tributação deletada com sucesso');
        }

        return redirect()->route('tributacao.index')->with('error', 'Tributação não deletada');
    }
}
