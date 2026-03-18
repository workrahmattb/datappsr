<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Maputra;
use App\Models\Maputri;
use App\Models\Mtsputra;
use App\Models\Mtsputri;
use Illuminate\Pagination\Paginator;

class StudentTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'nama';
    public $sortDirection = 'asc';
    public $studentType = 'all'; // all, maputra, maputri, mtsputra, mtsputri
    public $perPage = 10;

    protected $queryString = ['search', 'sortBy', 'sortDirection', 'studentType'];

    public function updatingSearch()
    {
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

        if ($this->studentType === 'all' || $this->studentType === 'maputra') {
            $query = Maputra::query();
            if ($this->search) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            }
            $students = $students->concat($query->get());
        }

        if ($this->studentType === 'all' || $this->studentType === 'maputri') {
            $query = Maputri::query();
            if ($this->search) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            }
            $students = $students->concat($query->get());
        }

        if ($this->studentType === 'all' || $this->studentType === 'mtsputra') {
            $query = Mtsputra::query();
            if ($this->search) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            }
            $students = $students->concat($query->get());
        }

        if ($this->studentType === 'all' || $this->studentType === 'mtsputri') {
            $query = Mtsputri::query();
            if ($this->search) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            }
            $students = $students->concat($query->get());
        }

        // Sort
        $students = $students->sortBy($this->sortBy, SORT_REGULAR, $this->sortDirection === 'desc');

        // Paginate using Livewire's paginate method
        $totalItems = $students->count();
        $page = $this->getPage();
        $paginatedStudents = $students->slice(($page - 1) * $this->perPage, $this->perPage)->values();
        $totalPages = ceil($totalItems / $this->perPage);

        return view('livewire.student-table', [
            'students' => $paginatedStudents,
            'totalItems' => $totalItems,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }
}
