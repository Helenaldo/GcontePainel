<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserSenhaRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::paginate(15);

        return view('Admin.Usuarios.usuarios-listar', compact(['usuarios']));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Usuarios.usuario-adicionar');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
    //    dd($request);
        $user = $request->only([
            'name',
            'email',
            'perfil',
            'ativo',
            'password',
            'password_confirmation',
        ]);

        $user['name'] = strtoupper($user['name']);
        $user['email'] = strtolower($user['email']);

        User::create($user);

        return redirect()->route('usuarios.index')->with('success', 'Usuário cadastrado com sucesso');
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
        $usuario = User::find($id);

        if($usuario) {
            return view('Admin.Usuarios.usuario-editar', compact([ 'usuario' ]) );
        }
        return redirect()->route('usuarios.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {

        $user = User::find($id);
        $loggedUser = auth()->user();
        // dd($loggedUser->perfil);
        if ($loggedUser->perfil != 'Administrador' && $user->id != $loggedUser->id) {
            return redirect()->route('usuarios.index')->with('error', 'Ação não permitida');
        }

        if($user) {
            $data = $request->only([
                'name',
                'email',
                'perfil',
                'ativo',
            ]);

            $data['name'] = strtoupper($data['name']);
            $data['email'] = strtolower($data['email']);

            $user->fill($data)->save();
            return redirect()->route('usuarios.index')->with('success', 'Usuário alterada com sucesso');
        }
        return redirect()->route('usuarios.index')->with('error', 'Usuário não alterado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Obtém o usuário logado
        $loggedUser = auth()->user();

        // Verifica se o usuário logado é um administrador
        if ($loggedUser->perfil != 'Administrador') {
            return redirect()->route('usuarios.index')->with('error', 'Ação não permitida');
        }

        $user = User::find($id);

        if ($user) {
            // Alternar o status de ativo/inativo
            $user->ativo = !$user->ativo;
            $user->save();

            if ($user->ativo) {
                return redirect()->route('usuarios.index')->with('success', 'Usuário ativado com sucesso');
            } else {
                return redirect()->route('usuarios.index')->with('success', 'Usuário desativado com sucesso');
            }
        }

        return redirect()->route('usuarios.index')->with('error', 'Usuário não encontrado');
    }

    public function alterarSenha(string $id)
    {
        $usuario = User::find($id);

        if($usuario) {
            return view('Admin.Usuarios.alterar-senha', compact([ 'usuario' ]) );
        }
        return redirect()->route('usuarios.index');

    }

    public function alterarSenhaAction(UserSenhaRequest $request)
    {
        $userId = $request->query('usuario');
        $user = User::find($userId);

        // Obtém o usuário logado
        $loggedUser = auth()->user();

        // Verifica se o usuário foi encontrado e se o usuário logado é o mesmo ou é um administrador
        if ($user && ($user->id == $loggedUser->id || $loggedUser->perfil == 'Administrador')) {
            $data = $request->only(['password']);
            $user->password = $data['password'];
            $user->save();

            return redirect()->route('usuarios.index')->with('success', 'Senha do usuário alterada com sucesso');
        }

        return redirect()->route('usuarios.index')->with('error', 'Operação não permitida ou usuário não encontrado');
    }
}
