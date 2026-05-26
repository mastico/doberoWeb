<?php

namespace App\Livewire\Admin;

use App\Models\TeamMember;
use Livewire\Component;

class TeamMembersIndex extends Component
{
    public function delete(int $id): void
    {
        TeamMember::findOrFail($id)->delete();
        session()->flash('status', 'Team member deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.team-members-index', [
            'members' => TeamMember::ordered()->get(),
        ])->layout('components.layouts.admin', ['title' => 'Team Members']);
    }
}
