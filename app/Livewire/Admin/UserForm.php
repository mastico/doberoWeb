<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UserForm extends Component
{
    public ?User $user = null;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(?User $user = null): void
    {
        if ($user?->exists) {
            $this->user = $user;
            $this->name  = $user->name;
            $this->email = $user->email;
        }
    }

    public function save(): void
    {
        $isEdit = $this->user?->exists;

        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($this->user?->id),
            ],
        ];

        if (! $isEdit || $this->password !== '') {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        $this->validate($rules);

        $data = ['name' => $this->name, 'email' => $this->email];

        if (! $isEdit || $this->password !== '') {
            $data['password'] = Hash::make($this->password);
        }

        if ($isEdit) {
            // If email changed, un-verify it so they re-confirm.
            if ($this->user->email !== $this->email) {
                $data['email_verified_at'] = null;
            }
            $this->user->update($data);
            session()->flash('status', 'User updated successfully.');
        } else {
            $user = User::create(array_merge($data, [
                'email_verified_at' => now(), // admin-created users are pre-verified
            ]));
            session()->flash('status', "User {$user->name} created successfully.");
        }

        $this->redirect(route('admin.users.index'), navigate: true);
    }

    public function render()
    {
        $title = $this->user?->exists ? 'Edit User' : 'Add User';

        return view('livewire.admin.user-form')
            ->layout('components.layouts.admin', ['title' => $title]);
    }
}
