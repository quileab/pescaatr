<?php

use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $species=null;
    public $speciesData;

    public function mount($id){
        $this->species=\App\Models\Species::find($id);
        $this->speciesData=$this->species->toArray();
    }
    
    // Delete action
    public function delete($id): void
    {
        $this->warning("Will delete #$id", 'It is fake.', position: 'toast-bottom');
    }

    public function saveSpeciesData() {
        try{
            DB::beginTransaction();
            // update team data
            $species=\App\Models\Species::find($this->species->id);
            $species->id=$this->speciesData['id'];
            $species->name=$this->speciesData['name'];
            $species->points1=$this->speciesData['points1'];
            $species->points2=$this->speciesData['points2'];
            $species->larger=$this->speciesData['larger'];
            $species->save();
            DB::commit();
            $this->success('Datos actualizados');
            $this->mount($species->id);
        } catch (Exception $e) {
            $this->warning('Exception', $e, timeout: 8000);
            DB::rollBack();
        }
    }
}; ?>

<div>
<!-- HEADER -->
<x-header title="Especie: {{$species->name}}" size="text-xl" separator progress-indicator />
    <x-form wire:submit="saveSpeciesData">
        <x-input label="ID" wire:model="speciesData.id" type='number' inline readonly />
        <x-input label="Nombre" wire:model="speciesData.name" inline />
        <div class="flex flex1 flex-wrap gap-3">
        <x-input label="Puntos 1" wire:model="speciesData.points1" type="number" inline />
        <x-input label="Puntos 2" wire:model="speciesData.points2" type="number" inline />
        <x-input label="Mayor" wire:model="speciesData.larger" type="number" inline />
        </div>
        <x-slot:actions>
            <x-button label="Actualizar" class="btn-primary" type="submit" spinner="saveSpeciesData" />
        </x-slot:actions>
    </x-form>
</div>
