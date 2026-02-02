<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;

    public $search = '';
    public $filterPath = '';
    public $filterStatus = ''; // 'paid', 'free'

    protected $queryString = ['search', 'filterPath'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = User::query()->with('profile');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('email', 'like', '%' . $this->search . '%')
                    ->orWhereHas('profile', function ($p) {
                        $p->where('full_name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->filterPath) {
            $query->where('learning_path', $this->filterPath);
        }

        if ($this->filterStatus === 'paid') {
            $query->whereHas('transactions', function ($q) {
                $q->where('status', 'paid');
            });
        }

        return view('livewire.admin.user-table', [
            'users' => $query->latest()->paginate(10),
        ]);
    }
}
