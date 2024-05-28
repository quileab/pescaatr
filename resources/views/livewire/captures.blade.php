<?php
use Illuminate\Validation\Rule as ValidationRule;
use App\Models\Fish;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    // UI
    public bool $drawer = false;
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];
    public string $search='';

    // form data
    public $teamNumber;
    public $fish;
    public $size;
    public $weight;

    // UX
    public \App\Models\Team $team;
    public $selectedTeam;
    public $species=[];
    public $mary_species;

    public function rules() 
    {
        return [
            'fish' => 'required',
            'teamNumber' => ['required',ValidationRule::exists('teams', 'number')],
            'size' => 'required|gt:0',
            'weight' => 'required|gt:0',
        ];
    }
    // On mount
    public function mount(){
        $this->mary_species=\App\Models\Species::orderBy('name')->get();
        foreach ($this->mary_species as $item) {
            $this->species[$item->id]=$item->name;
        }
        $this->validate();
    }

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
            ['key' => 'species.name', 'label' => 'Especie', 'class' => 'w-64'],
            ['key' => 'size', 'label' => 'Tamaño', 'class' => 'w-20'],
            ['key' => 'weight', 'label' => 'Peso', 'class' => 'w-20'],
            ['key' => 'created_at', 'label' => 'TT', 'class' => 'w-20'],
        ];
    }

    public function fishes(): Collection {
        return Fish::with('species')->get()
            ->sortBy([[...array_values($this->sortBy)]])
            ->when($this->selectedTeam, function (Collection $collection) {
                return $collection->filter(fn($item) => str($item['team_id'])->is($this->selectedTeam->id, true));
            });
    }

    public function with(): array {
        return [
            'fishes' => $this->fishes(),
            'headers' => $this->headers()
        ];
    }

    public function updatedTeamNumber($value){
        try{
            $this->team=\App\Models\Team::where('number',$value)->firstOrFail();
            $this->selectedTeam=$this->team;
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            unset($this->team);
        }
    }

    public function updatedSearch($value){
        try{
            $this->selectedTeam=\App\Models\Team::where('number',$value)->first();
        }
        catch(Exception $e){
            $this->warning('Error', 'No encontrado', timeout: 8000);
        }
    }

    public function validateData(){
        $this->validate(); 
    }

    public function saveCapture(){
        $this->validate();
        $this->team=\App\Models\Team::where('number',$this->teamNumber)->first();
        try{
            DB::beginTransaction();
            // add the capture
            $capture = \App\Models\Fish::create([
                'team_id' => $this->team->id,
                'species_id' => $this->fish,
                'size' => $this->size,
                'weight' => $this->weight,
            ]);
            DB::commit();
            $this->drawer=false;
            $this->reset('fish','teamNumber','size','weight');
            $this->success('Captura Registrada OK');
        } 
        catch (Exception $e) {
            DB::rollBack();
            $this->warning('Exception', $e->message, timeout: 8000);
        }
    }

}; ?>

<div>
    <!-- HEADER -->
    <x-header title="CAPTURAS {{ $this->selectedTeam->name ?? '?'}}" size="text-lg" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Equipo Número..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="NUEVA" @click="$wire.drawer = true" class="btn-success" responsive icon="o-plus" />
        </x-slot:actions>
    </x-header>
    <!-- TABLE  -->

    <x-card>

        <x-table :headers="$headers" :rows="$fishes" :sort-by="$sortBy"
            {{-- link="species/{id}/edit" --}}
            >
            {{-- @scope('actions', $species)
            <x-button icon="o-trash" wire:click="delete({{ $species['id'] }})" wire:confirm="⚠️ Está seguro?" spinner class="btn-ghost btn-sm text-red-500" />
            @endscope --}}
        </x-table>
    </x-card>

    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawer" title="
    {{ $team->name ?? '-' }}
    » {{$species[$fish] ?? '-' }}
    » {{$size ?? '-' }} cm. » {{$weight ?? '-' }} grs.
        " right separator with-close-button class="lg:w-1/3">

        <x-form wire:submit="saveCapture">

            <x-input label="Equipo Número" wire:model.lazy="teamNumber" type='number' error-class="hidden" />
            <x-choices-offline label="Especie"
                wire:model="fish"
                :options="$mary_species"
                single error-class="hidden"
                searchable />

            <x-input label="Tamaño" wire:model="size" type='number' inline error-class="hidden" />
            <x-input label="Peso" wire:model="weight" type='number' inline error-class="hidden" />
            <x-button label="Validar" icon="o-check" class="btn-primary" 
                wire:click='validateData' responsive spinner="validateData" />

            @if ($errors->count()==0)
                <x-button label="AGREGAR" icon="o-clipboard-document-check" class="btn-success" type="submit" spinner="saveCapture" />
            @endif
        </x-form>

        <x-slot:actions>
        </x-slot:actions>
    </x-drawer>
</div>
