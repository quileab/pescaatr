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

    // Clear filters
    public function clear(): void
    {
        $this->reset();
        $this->success('Filters cleared.', position: 'toast-bottom');
    }

    // Table headers
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'number', 'label' => 'N°', 'class' => 'w-1'],
            ['key' => 'name', 'label' => 'Nombre del Equipo', 'class' => 'w-64'],
            ['key' => 'plate', 'label' => 'Lancha', 'class' => 'w-20'],
        ];
    }

    public function teams(): Collection
    {
        // if search is only numbers
        if (is_numeric($this->search)) {
            return Team::where('number', $this->search)->get();
        }
        return Team::all()
            ->sortBy([[...array_values($this->sortBy)]])
            ->when($this->search, function (Collection $collection) {
                return $collection->filter(fn($item) => str($item['name'])->contains($this->search, true));
            });
    }

    public function with(): array
    {
        return [
            'teams' => $this->teams(),
            'headers' => $this->headers()
        ];
    }

    public function email($id)
    {
        Team::find($id)->sendWelcomeEmail();
    }

    public function copy($id)
    {
        // copy to clipboard with JS team number, players names and team name
        $team = Team::find($id);
        $players = $team->players;
        $players = $players->map(fn($player) =>
            // use tab to separate names 
            $player->fullname)->implode("\t");
        $teamNumber = $team->number;
        $teamName = $team->name;

        $this->dispatch(
            'copyToClipboard',
            $teamNumber . "\t" . $players . "\t" . $teamName
        );
        $this->success('Datos del equipo copiados al portapapeles', position: 'toast-bottom');
    }


}; ?>

<div>
    <!-- HEADER -->
    <x-header title="Equipos" size="text-lg" separator progress-indicator
        class="sticky top-0 z-50 backdrop-blur-xl p-1 mx-0">
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$headers" :rows="$teams" :sort-by="$sortBy" link="team/{id}/players">
            @scope('actions', $team)
            <div class="flex">
                <x-button label="@Bienvenida" icon="o-envelope" wire:click="email({{ $team['id'] }})"
                    class="btn-ghost btn-sm text-blue-500" />
                <x-button label="Pagos" icon="o-currency-dollar" link="/team/{{$team['id']}}/payments" spinner
                    class="btn-ghost btn-sm text-green-500" />
                <x-button icon="o-clipboard-document" wire:click="copy({{ $team['id'] }})"
                    class="btn-ghost btn-sm text-orange-500" />
            </div>
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

    @script
    <script>
        Livewire.on('copyToClipboard', (text) => {
            navigator.clipboard.writeText(text);
        })
    </script>
    @endscript
</div>