<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\Admin\NavBuilder;
use App\Models\NavItem;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class NavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_seeded_nav_labels(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('About Us')
            ->assertSee('Properties')
            ->assertSee('Relocation');
    }

    public function test_spanish_homepage_renders_translated_nav_labels(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/es')
            ->assertOk()
            ->assertSee('Sobre Nosotros')
            ->assertSee('Propiedades');
    }

    public function test_nav_builder_move_up_swaps_sort_order(): void
    {
        $this->actingAs(User::factory()->withPersonalTeam()->create());

        $first = NavItem::create([
            'label' => ['en' => 'Alpha'],
            'url' => ['en' => '/alpha'],
            'sort_order' => 1,
            'location' => 'primary',
            'is_active' => true,
        ]);

        $second = NavItem::create([
            'label' => ['en' => 'Beta'],
            'url' => ['en' => '/beta'],
            'sort_order' => 2,
            'location' => 'primary',
            'is_active' => true,
        ]);

        Livewire::test(NavBuilder::class)
            ->call('moveUp', $second->id);

        $this->assertSame(1, $second->fresh()->sort_order);
        $this->assertSame(2, $first->fresh()->sort_order);
    }

    public function test_nav_builder_move_down_swaps_sort_order(): void
    {
        $this->actingAs(User::factory()->withPersonalTeam()->create());

        $first = NavItem::create([
            'label' => ['en' => 'Alpha'],
            'url' => ['en' => '/alpha'],
            'sort_order' => 1,
            'location' => 'primary',
            'is_active' => true,
        ]);

        $second = NavItem::create([
            'label' => ['en' => 'Beta'],
            'url' => ['en' => '/beta'],
            'sort_order' => 2,
            'location' => 'primary',
            'is_active' => true,
        ]);

        Livewire::test(NavBuilder::class)
            ->call('moveDown', $first->id);

        $this->assertSame(2, $first->fresh()->sort_order);
        $this->assertSame(1, $second->fresh()->sort_order);
    }

    public function test_nav_builder_delete_removes_item(): void
    {
        $this->actingAs(User::factory()->withPersonalTeam()->create());

        $item = NavItem::create([
            'label' => ['en' => 'Temporary'],
            'url' => ['en' => '/temp'],
            'sort_order' => 1,
            'location' => 'primary',
            'is_active' => true,
        ]);

        Livewire::test(NavBuilder::class)
            ->call('delete', $item->id);

        $this->assertNull(NavItem::find($item->id));
    }

    public function test_nav_builder_toggle_active_flips_visibility(): void
    {
        $this->actingAs(User::factory()->withPersonalTeam()->create());

        $item = NavItem::create([
            'label' => ['en' => 'Toggle Me'],
            'url' => ['en' => '/toggle'],
            'sort_order' => 1,
            'location' => 'primary',
            'is_active' => true,
        ]);

        Livewire::test(NavBuilder::class)
            ->call('toggleActive', $item->id);

        $this->assertFalse($item->fresh()->is_active);
    }

    public function test_inactive_nav_items_are_excluded_from_public_nav(): void
    {
        NavItem::create([
            'label' => ['en' => 'Hidden Link'],
            'url' => ['en' => '/hidden'],
            'sort_order' => 1,
            'location' => 'primary',
            'is_active' => false,
        ]);

        NavItem::create([
            'label' => ['en' => 'Visible Link'],
            'url' => ['en' => '/visible'],
            'sort_order' => 2,
            'location' => 'primary',
            'is_active' => true,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertDontSee('Hidden Link')
            ->assertSee('Visible Link');
    }
}
