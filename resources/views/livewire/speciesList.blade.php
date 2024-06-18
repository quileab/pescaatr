<?php

use App\Models\Species;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public string $search = '';

    public bool $drawer = false;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    // Clear filters
    public function clear(): void {
        $this->reset();
        $this->success('Sin filtros .', position: 'toast-bottom');
    }

    // Delete action
    public function delete($id): void {
        $this->warning("Eliminar #$id", 'It is fake.', position: 'toast-bottom');
    }

    // Table headers
    public function headers(): array {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => 'Nombre', 'class' => 'w-64'],
            ['key' => 'points1', 'label' => 'Puntos 1', 'class' => 'w-20'],
            ['key' => 'points2', 'label' => 'Puntos 2', 'class' => 'w-20'],
            ['key' => 'larger', 'label' => 'Pieza Mayor', 'class' => 'w-20'],
        ];
    }

    public function species(): Collection {
        return Species::all()
            ->sortBy([[...array_values($this->sortBy)]])
            ->when($this->search, function (Collection $collection) {
                return $collection->filter(fn($item) => str($item['name'])->contains($this->search, true));
            });
    }

    public function with(): array {
        return [
            'species' => $this->species(),
            'headers' => $this->headers()
        ];
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="Especies" size="text-lg" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="buscar..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Filtros" @click="$wire.drawer = true" responsive icon="o-funnel" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$headers" :rows="$species" :sort-by="$sortBy"
            link="species/{id}/edit">
            {{-- @scope('actions', $species)
            <x-button icon="o-trash" wire:click="delete({{ $species['id'] }})" wire:confirm="⚠️ Está seguro?" spinner class="btn-ghost btn-sm text-red-500" />
            @endscope --}}
        </x-table>
    </x-card>

    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawer" title="Filtros" right separator with-close-button class="lg:w-1/3">
        <x-input placeholder="buscar..." wire:model.live.debounce="search" icon="o-magnifying-glass" @keydown.enter="$wire.drawer = false" />

        <x-slot:actions>
            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Listo" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />
        </x-slot:actions>
    </x-drawer>
</div>
