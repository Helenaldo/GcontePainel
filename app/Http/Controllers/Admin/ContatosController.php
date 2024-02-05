<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContatoRequest;
use App\Http\Requests\ContatoUpdateRequest;
use App\Models\Cliente;
use App\Models\Contato;
use Illuminate\Http\Request;

class ContatosController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $contatos = Contato::when($request->has('pesquisa'), function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->where('nome', 'like', '%' . $request->pesquisa . '%')
                      ->orwhere('email', 'like', '%' . $request->pesquisa . '%');
            });
        })
        ->orderBy('nome', 'asc')
        ->paginate(15)
        ->withQueryString();

        return view('Admin.Clientes.contato-listar', [
            'contatos' => $contatos,
            'pesquisa' => $request->pesquisa
        ]);
    }


    // public function index(Request $request)
    // {
    //     $contatos = Contato::orderBy('nome', 'asc')->paginate(15);

    //     return view('Admin.Clientes.contato-listar', compact(['contatos']));
    // }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::all();
        return view('Admin.Clientes.contato-adicionar', compact(['clientes']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContatoRequest $request)
    {
        $contato = $request->only([
            'cliente_id',
            'nome',
            'email',
            'telefone',
        ]);

        Contato::create($contato);

        return redirect()->route('contatos.index')->with('success', 'Contato criado com sucesso!');
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
        $contato = Contato::find($id);

        if($contato) {
            return view('Admin.Clientes.contato-editar', compact([ 'contato' ]) );
        }
        return redirect()->route('contatos');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContatoUpdateRequest $request, string $id)
    {
        $contato = Contato::find($id);

        if($contato) {
            $data = $request->only([
                'cliente_id',
                'nome',
                'email',
                'telefone',
            ]);

            $contato->fill($data)->save();
            return redirect()->route('contatos.index')->with('success', 'Contato alterado com sucesso');
        }
        return redirect()->route('contatos.index')->with('error', 'Contato não alterado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contato = Contato::find($id);

        if ($contato) {
            $contato->delete();
            return redirect()->route('contatos.index')->with('warning', 'Contato deletado com sucesso');
        }

        return redirect()->route('contatos.index')->with('error', 'Contato não deletado');
    }
}
