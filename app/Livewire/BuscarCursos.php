<?php

namespace App\Livewire;

use App\Models\Curso;
use Livewire\Component;
use Livewire\WithPagination;

class BuscarCursos extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $busca = '';

    public function updatedBusca()
    {
        $this->resetPage();
    }

    public function limpar()
    {
        $this->busca = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Curso::with('formadores', 'encontros');

        if (strlen($this->busca) >= 2) {
            $query->where(function ($q) {
                $q->where('nome', 'like', '%'.$this->busca.'%')
                    ->orWhereHas('formadores', function ($qf) {
                        $qf->where('name', 'like', '%'.$this->busca.'%');
                    });
            });
        }

        $cursos = $query->paginate(10);

        return view('livewire.buscar-cursos', compact('cursos'));
    }
}
