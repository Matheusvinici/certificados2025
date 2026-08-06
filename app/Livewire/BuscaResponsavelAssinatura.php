<?php

namespace App\Livewire;

use App\Models\Assinatura;
use App\Models\User;
use Livewire\Component;

class BuscaResponsavelAssinatura extends Component
{
    public $busca = '';

    public $selecionados = [];

    public $detalhes = [];

    public $facilitadoresIds = [];

    public $resultados = [];

    public $mostrarResultados = false;

    public function mount($selecionados = [])
    {
        $this->selecionados = collect($selecionados)
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();

        $this->carregarDetalhes();
    }

    public function adicionar($id)
    {
        $usuario = User::find($id);

        if (! $usuario) {
            return;
        }

        $id = (int) $id;

        if (! in_array($id, $this->selecionados)) {
            $this->selecionados[] = $id;
            $this->carregarDetalhes();
        }

        $this->busca = '';
        $this->resultados = [];
        $this->mostrarResultados = false;
    }

    public function remover($id)
    {
        $this->selecionados = collect($this->selecionados)
            ->reject(fn ($s) => (int) $s === (int) $id)
            ->values()
            ->all();

        $this->carregarDetalhes();
    }

    public function updatedBusca()
    {
        $this->mostrarResultados = false;

        if (strlen($this->busca) < 2) {
            $this->resultados = [];

            return;
        }

        // Somente servidores que possuem assinatura cadastrada.
        $this->resultados = User::whereHas('assinaturas')
            ->where(function ($q) {
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
                'facilitador' => Assinatura::where('user_id', $u->id)->latest()->value('facilitador'),
            ])
            ->toArray();

        $this->mostrarResultados = count($this->resultados) > 0;
    }

    private function carregarDetalhes()
    {
        $this->detalhes = User::whereIn('id', $this->selecionados)->get()->map(fn ($u) => [
            'id' => $u->id,
            'name' => $u->name,
            'cpf' => $u->cpf,
            'role' => $u->role,
        ])->toArray();

        $this->facilitadoresIds = Assinatura::whereIn('user_id', $this->selecionados)
            ->where('facilitador', true)
            ->latest()
            ->pluck('user_id')
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();
    }

    public function render()
    {
        return view('livewire.busca-responsavel-assinatura');
    }
}
