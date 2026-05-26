<?php

namespace App\Livewire\Admin;

use App\Models\NavItem;
use Livewire\Component;

class NavBuilder extends Component
{
    public function moveUp(int $id): void
    {
        $item = NavItem::findOrFail($id);
        $previous = NavItem::query()
            ->where('parent_id', $item->parent_id)
            ->where('location', $item->location)
            ->where('sort_order', '<', $item->sort_order)
            ->orderByDesc('sort_order')
            ->first();

        if (! $previous) {
            return;
        }

        [$item->sort_order, $previous->sort_order] = [$previous->sort_order, $item->sort_order];
        $item->save();
        $previous->save();
    }

    public function moveDown(int $id): void
    {
        $item = NavItem::findOrFail($id);
        $next = NavItem::query()
            ->where('parent_id', $item->parent_id)
            ->where('location', $item->location)
            ->where('sort_order', '>', $item->sort_order)
            ->orderBy('sort_order')
            ->first();

        if (! $next) {
            return;
        }

        [$item->sort_order, $next->sort_order] = [$next->sort_order, $item->sort_order];
        $item->save();
        $next->save();
    }

    public function toggleActive(int $id): void
    {
        $item = NavItem::findOrFail($id);
        $item->update(['is_active' => ! $item->is_active]);
        session()->flash('status', 'Navigation item updated successfully.');
    }

    public function delete(int $id): void
    {
        NavItem::findOrFail($id)->delete();
        session()->flash('status', 'Navigation item deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.nav-builder', [
            'items' => NavItem::roots()
                ->location('primary')
                ->ordered()
                ->with(['children' => fn ($query) => $query->ordered()])
                ->get(),
        ])->layout('components.layouts.admin', ['title' => 'Navigation']);
    }
}
