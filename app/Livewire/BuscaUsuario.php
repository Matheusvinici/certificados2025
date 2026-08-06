<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class BuscaUsuario extends Component
{
    public $busca = '';

    public $usuarioSelecionadoId = '';

    public $resultado = null;

    public $resultados = [];

    public $mostrarResultados = false;

    public $campoNome = 'user_assinatura_id';

    public function mount($selected = null, $name = null)
    {
        if ($name) {
            $this->campoNome = $name;
        }

        if ($selected) {
            $usuario = User::find($selected);
            if ($usuario) {
                $this->usuarioSelecionadoId = $usuario->id;
                $this->busca = $usuario->name.' — '.$usuario->cpf;
                $this->resultado = [
                    'id' => $usuario->id,
                    'name' => $usuario->name,
                    'cpf' => $usuario->cpf,
                    'role' => $usuario->role,
                ];
            }
        }
    }

    public function updatedBusca()
    {
        $this->resultado = null;
        $this->usuarioSelecionadoId = '';
        $this->mostrarResultados = false;

        if (strlen($this->busca) < 2) {
            $this->resultados = [];

            return;
        }

        $this->resultados = User::where(function ($q) {
            $q->where('name', 'like', '%'.$this->busca.'%')
                ->orWhere('cpf', 'like', '%'.$this->busca.'%');
        })
            ->limit(10)
            ->get()
            ->map(fn ($u) => [
                'id' => $u->id,
                'name' => $u->name,
                'cpf' => $u->cpf,
                'role' => $u->role,
            ])
            ->toArray();

        $this->mostrarResultados = count($this->resultados) > 0;
    }

    public function selecionar($id)
    {
        $usuario = User::find($id);
        if ($usuario) {
            $this->usuarioSelecionadoId = $id;
            $this->busca = $usuario->name.' — '.$usuario->cpf;
            $this->resultado = [
                'id' => $usuario->id,
                'name' => $usuario->name,
                'cpf' => $usuario->cpf,
                'role' => $usuario->role,
            ];
            $this->resultados = [];
            $this->mostrarResultados = false;
        }
    }

    public function limpar()
    {
        $this->busca = '';
        $this->usuarioSelecionadoId = '';
        $this->resultado = null;
        $this->resultados = [];
        $this->mostrarResultados = false;
    }

    public function render()
    {
        return view('livewire.busca-usuario');
    }
}
