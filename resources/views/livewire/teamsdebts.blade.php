<?php

use App\Models\Team;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public string $search = '';

    public bool $drawer = false;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public $price = 300000;

    // Clear filters
    public function clear(): void
    {
        $this->reset();
        $this->success('Filters cleared.', position: 'toast-bottom');
    }

    // Delete action
    public function delete($id): void
    {
        $this->warning("Will delete #$id", 'It is fake.', position: 'toast-bottom');
    }

    // Table headers
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => 'Nombre del Equipo', 'class' => 'w-64'],
            ['key' => 'plate', 'label' => 'Lancha', 'class' => 'w-20'],
        ];
    }

    public function teams(): Collection
    {
        $res = App\Models\Team::doesnthave('payments')->get()
            ->sortBy([[...array_values($this->sortBy)]])
            ->when($this->search, function (Collection $collection) {
                return $collection->filter(fn($item) => str($item['name'])->contains($this->search, true));
            });
        //dd($res);
        return $res;
    }

    public function with(): array
    {
        return [
            'teams' => $this->teams(),
            'headers' => $this->headers()
        ];
    }

    public function assignInscriptionDue(\App\Models\Team $team)
    {
        // Assign $this->price as inscription due in payments as negative
        \App\Models\Payment::updateOrCreate(
            ['team_id' => $team->id],
            [
                'date' => now(),
                'amount' => $this->price * -1,
                'notes' => 'inscription'
            ],
        );
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="Equipos sin Deuda Inicial" size="text-lg" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-input label="Deuda a Asignar" wire:model="price" prefix="$" money inline locale="pt-BR" />
            <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$headers" :rows="$teams" :sort-by="$sortBy" link="team/{id}/players">
            @scope('actions', $team)
            <x-dropdown right>
                <x-slot:trigger>
                    <x-button label="Generar Deuda" icon="o-currency-dollar" class="text-green-500" />
                </x-slot:trigger>
                <x-menu-item title="Confirmar" wire:click="assignInscriptionDue({{ $team['id'] }})"
                    icon="o-check-circle" />
            </x-dropdown>
            @endscope
        </x-table>
    </x-card>

    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawer" title="Filters" right separator with-close-button class="lg:w-1/3">
        <x-input placeholder="Search..." wire:model.live.debounce="search" icon="o-magnifying-glass"
            @keydown.enter="$wire.drawer = false" />

        <x-slot:actions>
            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />
        </x-slot:actions>
    </x-drawer>
</div>