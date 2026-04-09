<?php

namespace App\Livewire;

use App\Models\Pendaftaran;
use Livewire\Component;
use Livewire\WithPagination;

class PendaftaranTable extends Component
{
    use WithPagination;

    public $search = '';

    public $sortBy = 'nama';

    public $sortDirection = 'asc';

    public $studentType = 'all'; // all, maputra, maputri, mtsputra, mtsputri

    public $perPage = 10;

    public $hasSearched = false;

    protected $queryString = ['search', 'sortBy', 'sortDirection', 'studentType'];

    public function updatedSearch()
    {
        $this->hasSearched = strlen($this->search) >= 0;
        $this->resetPage();
    }

    public function updatingStudentType()
    {
        $this->resetPage();
    }

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function gotoPage($page)
    {
        $this->setPage($page);
    }

    public function render()
    {
        $students = collect();
        $totalItems = 0;
        $page = $this->getPage();
        $totalPages = 1;

        // Only fetch data when user has searched
        if ($this->hasSearched && strlen($this->search) > 0) {
            $query = Pendaftaran::query()
                ->where('status_pendaftaran', 'pending');
            if ($this->search) {
                $query->where('nama', 'like', '%'.$this->search.'%');
            }
            $students = $students->concat($query->get());

            // Sort
            $students = $students->sortBy($this->sortBy, SORT_REGULAR, $this->sortDirection === 'desc');

            // Paginate using Livewire's paginate method
            $totalItems = $students->count();
            $paginatedStudents = $students->slice(($page - 1) * $this->perPage, $this->perPage)->values();
            $totalPages = ceil($totalItems / $this->perPage);

            $students = $paginatedStudents;
        }

        return view('livewire.pendaftaran-table', [
            'students' => $students,
            'totalItems' => $totalItems,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }
}
