<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //


    protected $redirectTo = '/painel';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index() {
        return view('Admin.login');
    }

    public function authenticate(Request $request) {
        $data = $request->only([
            'email',
            'password'
        ]);

        $validator = $this->validator($data);

        $remember = $request->input('remember', false);

        if($validator->fails()) {
            return redirect()->route('login')
            ->withErrors($validator)
            ->withInput();
        }

        if(Auth::attempt($data, $remember)) {
            return redirect()->route('admin');
        } else {
            $validator->errors()->add('password', "E-mail e/ou senha inválidos!");
            return redirect()->route('login')
            ->withErrors($validator)
            ->withInput();
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('site');
    }

    protected function validator(array $data) {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:4']
        ]);
    }

}
