<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Role;

class RoleTable extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $roles = Role::withCount('users')
            ->when($this->search, function ($query) {
                $search = strtolower(trim($this->search));
                $query->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('livewire.admin.role.table', [
            'roles' => $roles,
        ]);
    }
}
