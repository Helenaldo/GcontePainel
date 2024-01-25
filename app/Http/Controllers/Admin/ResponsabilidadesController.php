<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResponsabilidadeResquest;
use App\Models\Cliente;
use App\Models\Responsabilidade;
use App\Models\User;
use Illuminate\Http\Request;

class ResponsabilidadesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $responsaveis = Responsabilidade::paginate(15);

        return view('Admin.Responsabilidades.responsabilidades-listar', compact(['responsaveis']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::all();
        $users = User::all();
        return view('Admin.Responsabilidades.responsabilidades-adicionar', compact(['clientes', 'users']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ResponsabilidadeResquest $request)
    {
        $loggedUser = auth()->user();

        // Verifica se o usuário logado é um administrador
        if ($loggedUser->perfil != 'Administrador') {
            return redirect()->route('responsabilidades.index')->with('error', 'Ação não permitida');
        }

        $responsavel = $request->only([
            'data',
            'cliente_id',
            'contabil',
            'fiscal',
            'pessoal',
            'paralegal',
        ]);

        Responsabilidade::create($responsavel);

        return redirect()->route('responsabilidades.index')->with('success', 'Responsável atribuído com sucesso!');
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
        $responsabilidade = Responsabilidade::find($id);
        $users = User::all();
        $clientes = Cliente::all();

        if($responsabilidade) {
            return view('Admin.Responsabilidades.responsabilidades-editar', compact([ 'responsabilidade', 'users', 'clientes' ]) );
        }
        return redirect()->route('responsabilidades.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ResponsabilidadeResquest $request, string $id)
    {
        // dd($request);
        $loggedUser = auth()->user();

        // Verifica se o usuário logado é um administrador
        if ($loggedUser->perfil != 'Administrador') {
            return redirect()->route('responsabilidades.index')->with('error', 'Ação não permitida');
        }

        $responsabilidades = Responsabilidade::find($id);

        if($responsabilidades) {
            $data = $request->only([
                'data',
                'cliente_id',
                'contabil',
                'fiscal',
                'pessoal',
                'paralegal',
            ]);

            $responsabilidades->fill($data)->save();
            return redirect()->route('responsabilidades.index')->with('success', 'Responsabilidade alterada com sucesso');
        }
        return redirect()->route('responsabilidades.index')->with('error', 'Responsabilidade não alterada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $responsabilidade = Responsabilidade::find($id);
        $loggedUser = auth()->user();

        // Verifica se o usuário logado é um administrador
        if ($loggedUser->perfil != 'Administrador') {
            return redirect()->route('responsabilidades.index')->with('error', 'Ação não permitida');
        }

        if ($responsabilidade) {
            $responsabilidade->delete();
            return redirect()->route('responsabilidades.index')->with('warning', 'Responsabilidade deletada com sucesso');
        }

        return redirect()->route('responsabilidades.index')->with('error', 'Responsabilidade não deletada');
    }
}
