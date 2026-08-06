<?php

namespace App\Livewire;

use App\Models\Inscricao;
use Livewire\Component;
use Livewire\WithPagination;

class BuscarInscricoes extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $busca = '';

    public $cursoId = '';

    public function updatedBusca()
    {
        $this->resetPage();
    }

    public function updatedCursoId()
    {
        $this->resetPage();
    }

    public function limpar()
    {
        $this->busca = '';
        $this->cursoId = '';
        $this->resetPage();
    }

    public function render()
    {
        $cursos = \App\Models\Curso::orderBy('nome')->get();

        $query = Inscricao::with('curso.encontros', 'user');

        if ($this->cursoId) {
            $query->where('curso_id', $this->cursoId);
        }

        if (strlen($this->busca) >= 2) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%'.$this->busca.'%');
            });
        }

        $inscricoes = $query->paginate(10);

        return view('livewire.buscar-inscricoes', compact('inscricoes', 'cursos'));
    }
}
