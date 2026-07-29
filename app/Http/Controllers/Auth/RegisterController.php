<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Secretaria;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $secretarias = Secretaria::orderBy('nome')->get();

        return view('auth.register', compact('secretarias'));
    }

    protected function validator(array $data)
    {
        $data['cpf'] = preg_replace('/\D/', '', $data['cpf']);

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'size:11', 'unique:users,cpf'],
            'matricula' => ['required', 'string', 'max:30', 'unique:users,matricula'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'secretaria' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'cpf' => preg_replace('/\D/', '', $data['cpf']),
            'matricula' => $data['matricula'],
            'email' => $data['email'],
            'secretaria' => $data['secretaria'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
