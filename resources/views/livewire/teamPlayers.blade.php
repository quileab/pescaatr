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

    public $team=null;
    public $players=null;

    public function mount($id){
        $this->team=\App\Models\Team::with('players')->find($id);
        $this->players=$this->team->players;
        //dd($id,$this->team->name, $this->team->players[0]->fullname);
    }
    
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
            ['key' => 'id', 'label' => 'DNI', 'class' => 'w-4'],
            ['key' => 'fullname', 'label' => 'Nombre', 'class' => 'w-64'],
            ['key' => 'email', 'label' => 'Email', 'class' => 'w-20'],
            ['key' => 'type', 'label' => 'Tipo', 'class' => 'w-10'],
        ];
    }

    public function players(): Collection
    {
        return $this->players=$this->team->players
            ->sortBy([[...array_values($this->sortBy)]]);
     
    }

    public function with(): array
    {
        return [
            'players' => $this->players(),
            'headers' => $this->headers()
        ];
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="Datos del Equipo" separator progress-indicator>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$headers" :rows="$players" :sort-by="$sortBy"
            link="players/{id}/edit">
            @scope('actions', $team)
            <x-button icon="o-trash" wire:click="delete({{ $team['id'] }})" wire:confirm="⚠️ Está seguro?" spinner class="btn-ghost btn-sm text-red-500" />
            @endscope
        </x-table>
    </x-card>

</div>
