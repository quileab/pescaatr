<?php

use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $player=null;
    public $playerData;

    public function mount($id){
        $this->player=\App\Models\Player::find($id);
        $this->playerData=$this->player->toArray();
    }
    
    // Delete action
    public function delete($id): void
    {
        $this->warning("Will delete #$id", 'It is fake.', position: 'toast-bottom');
    }

    public function savePlayerData() {
        try{
            DB::beginTransaction();
            // update team data
            $player=\App\Models\Player::find($this->player->id);
            $player->id=$this->playerData['id'];
            $player->fullname=$this->playerData['fullname'];
            $player->phone=$this->playerData['phone'];
            $player->email=$this->playerData['email'];
            $player->city=$this->playerData['city'];
            $player->save();
            DB::commit();
            $this->success('Datos actualizados');
            $this->mount($player->id);
        } catch (Exception $e) {
            $this->warning('Exception', $e, timeout: 8000);
            DB::rollBack();
        }
    }
}; ?>

<div>
<!-- HEADER -->
<x-header title="Datos del Participante {{$player->name}}" size="text-xl" separator progress-indicator />
    <x-form wire:submit="savePlayerData">
        <x-input label="DNI" wire:model="playerData.id" type='number' inline />
        <x-input label="Apellido y Nombre" wire:model="playerData.fullname" inline />
        <x-input label="Teléfono" wire:model="playerData.phone" type="tel" inline />
        <x-input label="E-mail" wire:model="playerData.email" type="email" inline />
        <x-input label="Ciudad" wire:model="playerData.city" inline />
        <x-slot:actions>
            <x-button label="Actualizar" class="btn-primary" type="submit" spinner="savePlayerData" />
        </x-slot:actions>
    </x-form>
</div>
