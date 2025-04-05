<?php

use App\Models\Team;
use App\Models\Player;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\On;

new class extends Component {
    use Toast;

    public string $search = '';

    public bool $drawer = false;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public $team = null;
    public $teamData = [];
    public $player = null;
    public $playerData;
    public $players = null;

    public $sexes = [
        ['id' => 'm', 'name' => 'Masculino'],
        ['id' => 'f', 'name' => 'Femenino'],
    ];
    public $types = [
        ['id' => 'player', 'name' => 'Participante'],
        ['id' => 'wheel', 'name' => 'Timonel'],
        // ['id' => 'A', 'name' => 'A'],
        // ['id' => 'B', 'name' => 'B'],
    ];

    public function mount($id)
    {
        if ($this->team)
            return;
        $this->team = Team::with('players')->find($id);
        $this->teamData = $this->team->toArray();
        $this->players = $this->team->players;
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
            ['key' => 'phone', 'label' => 'Teléfono', 'class' => 'w-20'],
            ['key' => 'typeAttr', 'label' => 'Tipo', 'class' => 'w-10'],
        ];
    }

    public function players(): Collection
    {
        return $this->players = $this->team->players
            ->sortBy([[...array_values($this->sortBy)]]);

    }

    public function with(): array
    {
        return [
            'players' => $this->players(),
            'headers' => $this->headers()
        ];
    }

    public function saveTeamData()
    {
        try {
            DB::beginTransaction();
            // update team data
            $team = Team::find($this->team->id);
            $team->number = $this->teamData['number'];
            $team->name = $this->teamData['name'];
            $team->email = $this->teamData['email'];
            $team->boatName = $this->teamData['boatName'];
            $team->plate = $this->teamData['plate'];
            $team->hp = $this->teamData['hp'];
            $team->save();
            DB::commit();
            $this->success('Datos actualizados');
            $this->mount($team->id);
        } catch (Exception $e) {
            $this->warning('Exception', $e, timeout: 8000);
            DB::rollBack();
        }
    }

    public function createPlayerData()
    {
        $this->player = null;
        $this->playerData = [
            'id' => null,
            'fullname' => null,
            'phone' => null,
            'email' => null,
            'city' => null,
            'dob' => now()->subYears(18)->format('Y-m-d'),
            'sex' => $this->sexes[0]['id'],
            'type' => $this->types[0]['id'],
            'team_id' => $this->team->id
        ];
        $this->drawer = true;
    }

    public function editPlayerData(Player $player)
    {
        $this->player = $player;
        $this->playerData = $this->player->toArray();
        $this->drawer = true;
    }
    public function savePlayerData()
    {
        try {
            DB::beginTransaction();
            // update or create player data
            $player = Player::updateOrCreate(
                ['id' => $this->playerData['id']],
                [
                    'fullname' => $this->playerData['fullname'],
                    'phone' => $this->playerData['phone'],
                    'email' => $this->playerData['email'] ?? null,
                    'city' => $this->playerData['city'],
                    'dob' => $this->playerData['dob'],
                    'sex' => $this->playerData['sex'],
                    'type' => $this->playerData['type'],
                    'team_id' => $this->team->id,
                ]
            );

            DB::commit();
            $this->drawer = false;
            $this->success('Datos guardados');
            $this->mount($player->id);
        } catch (Exception $e) {
            $this->warning('Exception', $e, timeout: 8000);
            DB::rollBack();
        }
    }
}; ?>

<div>
    <x-card title="Datos del Equipo {{$team->name}} #{{$team->id}}" class="mb-2">
        <x-form wire:submit="saveTeamData">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <x-input label="Número asignado" wire:model="teamData.number" type='number' />
                <x-input label="Equipo" wire:model="teamData.name" />
                <x-input label="Email" wire:model="teamData.email" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <x-input label="Nombre Lancha" wire:model="teamData.boatName" />
                <x-input label="Matrícula" wire:model="teamData.plate" />
                <x-input label="HP" wire:model="teamData.hp" type='number' />
            </div>
            <x-slot:actions>
                <x-button label="Actualizar" class="btn-primary" type="submit" spinner="saveTeamData" />
            </x-slot:actions>
        </x-form>
    </x-card>

    <!-- TABLE  -->
    <x-card title="Participantes">
        <x-slot:menu>
            <x-button icon="o-user-plus" label="Nuevo" class="btn-success"
                wire:click="createPlayerData({{ $team['id'] }})" />
        </x-slot:menu>
        <x-table :headers="$headers" :rows="$players" :sort-by="$sortBy">
            @scope('actions', $team)
            <x-button icon="o-pencil" wire:click="editPlayerData({{ $team['id'] }})"
                class="btn-ghost btn-sm text-primary" />
            @endscope
        </x-table>
    </x-card>

    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawer" title="Datos del Participante" right separator with-close-button class="lg:w-1/3">
        <x-form wire:submit="savePlayerData">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <x-input label="DNI" wire:model="playerData.id" type='number' />
                <x-select label="Tipo" wire:model="playerData.type" :options="$types" />
            </div>
            <x-input label="Apellido y Nombre" wire:model="playerData.fullname" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <x-input label="Fecha de Nacimiento" type="date" wire:model="playerData.dob" />
                <x-select label="Sexo" wire:model="playerData.sex" :options="$sexes" />
            </div>
            <x-input label="Teléfono" wire:model="playerData.phone" type="tel" />
            <x-input label="E-mail" wire:model="playerData.email" type="email" />
            <x-input label="Ciudad" wire:model="playerData.city" />
            <x-slot:actions>
                <x-button label="Guardar" class="btn-primary" type="submit" spinner="savePlayerData" />
            </x-slot:actions>
        </x-form>
    </x-drawer>

</div>