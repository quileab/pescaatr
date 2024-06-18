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
    public $teamData=[];
    public $players=null;

    public function mount($id){
        $this->team=\App\Models\Team::with('players')->find($id);
        $this->teamData=$this->team->toArray();
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

    public function saveTeamData() {
        try{
            DB::beginTransaction();
            // update team data
            $team=\App\Models\Team::find($this->team->id);
            $team->number=$this->teamData['number'];
            $team->name=$this->teamData['name'];
            $team->boatName=$this->teamData['boatName'];
            $team->plate=$this->teamData['plate'];
            $team->hp=$this->teamData['hp'];
            $team->save();
            DB::commit();
            $this->success('Datos actualizados');
            $this->mount($team->id);
        } catch (Exception $e) {
            $this->warning('Exception', $e, timeout: 8000);
            DB::rollBack();
        }
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="Datos del Equipo {{$team->name}}" size="text-xl" separator progress-indicator />
        
        <x-form wire:submit="saveTeamData">
            <div class="flex flex1 flex-wrap gap-3">
            <x-input label="Equipo Número" wire:model="teamData.number" type='number' inline />
            <x-input label="Equipo" wire:model="teamData.name" inline />
            </div>
            <div class="flex flex1 flex-wrap gap-3">
            <x-input label="Nombre Lancha" wire:model="teamData.boatName" inline />
            <x-input label="Matrícula" wire:model="teamData.plate" inline />
            <x-input label="HP" wire:model="teamData.hp" type='number' inline />
            </div>
            <x-slot:actions>
                <x-button label="Actualizar" class="btn-primary" type="submit" spinner="saveTeamData" />
            </x-slot:actions>
        </x-form>
        
        <!-- TABLE  -->
        <x-header title="Participantes" size="text-xl" separator />
        <x-card>
        <x-table :headers="$headers" :rows="$players" :sort-by="$sortBy"
            link="/player/{id}/edit">
            @scope('actions', $team)
            <x-button icon="o-trash" wire:click="delete({{ $team['id'] }})" wire:confirm="⚠️ Está seguro?" spinner class="btn-ghost btn-sm text-red-500" />
            @endscope
        </x-table>
    </x-card>

</div>
