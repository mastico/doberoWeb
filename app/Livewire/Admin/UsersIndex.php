<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class UsersIndex extends Component
{
    public function delete(int $id): void
    {
        abort_if($id === auth()->id(), 403, 'You cannot delete your own account.');

        User::findOrFail($id)->delete();
        session()->flash('status', 'User deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.users-index', [
            'users' => User::orderBy('name')->get(),
        ])->layout('components.layouts.admin', ['title' => 'Users']);
    }
}
