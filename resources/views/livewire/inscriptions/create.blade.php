<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Mary\Traits\Toast;
use App\Models\Team;

new #[Layout('components.layouts.clean')] #[Title('Inscripciones')] class extends Component {
  use Toast;

  #[Validate('required')]
  public string $teamName = '';
  #[Validate('required')]
  public string $teamBoatName = '';
  #[Validate('sometimes')]
  public string $teamBoatPlate = '';
  #[Validate('int')]
  public int $teamBoatHp = 0;
  #[Validate('bool')]
  public bool $wheelplayer = false;

  #[Validate('required|unique:players,id|integer|min_digits:7')]
  public int $wheelId = 0;
  #[Validate('required')]
  public string $wheelFullName = '';
  #[Validate('required')]
  public string $wheelPhone = '';
  #[Validate('required|email')]
  public string $wheelEmail = '';
  #[Validate('sometimes')]
  public string $wheelCity = '';
  #[Validate('required')]
  public string $wheelSex = 'm';
  #[Validate('required')] // date today - 18 years
  public string $wheelDob = '';

  // #- [--] Validate('required|unique:players,id|integer|min_digits:7')]
  public int $player1Id = 0;
  // #- [--] Validate('required')]
  public string $player1FullName = '';
  // #- [--] Validate('required')]
  public string $player1Phone = '';
  // #- [--] Validate('required|email')]
  public string $player1Email = '';
  // #- [--] Validate('sometimes')]
  public string $player1City = '';
  // #- [--] Validate('required')]
  public string $player1Sex = 'm';
  // #- [--] Validate('required')] // date today - 18 years
  public string $player1Dob = '';


  // #- [--] Validate('required|unique:players,id|integer|min_digits:7')]
  public int $player2Id = 0;
  // #- [--] Validate('required')]
  public string $player2FullName = '';
  // #- [--] Validate('required')]
  public string $player2Phone = '';
  // #- [--] Validate('required|email')]
  public string $player2Email = '';
  // #- [--] Validate('sometimes')]
  public string $player2City = '';
  // #- [--] Validate('required')]
  public string $player2Sex = 'm';
  // #- [--] Validate('required')] // date today - 18 years
  public string $player2Dob = '';

  // #- [--] Validate('required|unique:players,id|integer|min_digits:7')]
  public int $player3Id = 0;
  // #- [--] Validate('required')]
  public string $player3FullName = '';
  // #- [--] Validate('required')]
  public string $player3Phone = '';
  // #- [--] Validate('required|email')]
  public string $player3Email = '';
  // #- [--] Validate('sometimes')]
  public string $player3City = '';
  // #- [--] Validate('required')]
  public string $player3Sex = 'm';
  // #- [--] Validate('required')] // date today - 18 years
  public string $player3Dob = '';

  public $sexes = [
    [
      'id' => 'm',
      'name' => 'Masculino'
    ],
    [
      'id' => 'f',
      'name' => 'Femenino',
    ]
  ];

  public function mount()
  {
    $this->wheelDob = Carbon\Carbon::now()->subYears(18)->format('Y-m-d');
    $this->player1Dob = Carbon\Carbon::now()->subYears(18)->format('Y-m-d');
    $this->player2Dob = Carbon\Carbon::now()->subYears(18)->format('Y-m-d');
    $this->player3Dob = Carbon\Carbon::now()->subYears(18)->format('Y-m-d');
  }

  public function updatedWheelplayer()
  {
    $this->render();
  }

  public function save()
  {
    //validate
    try {
      $this->validate();
    } catch (\Illuminate\Validation\ValidationException $e) {
      $this->warning('Error', 'Error de validación:' . $e->getMessage());
    }
    // start database transaction
    try {
      DB::beginTransaction();
      // create the team
      $team = \App\Models\Team::create([
        'name' => $this->teamName,
        'boatName' => $this->teamBoatName,
        'plate' => $this->teamBoatPlate,
        'hp' => $this->teamBoatHp,
        'wheelplay' => $this->wheelplayer
      ]);

      $wheel = \App\Models\Player::create([
        'id' => $this->wheelId,
        'fullname' => $this->wheelFullName,
        'phone' => $this->wheelPhone,
        'email' => $this->wheelEmail,
        'city' => $this->wheelCity,
        'dob' => $this->wheelDob,
        'sex' => $this->wheelSex,
        'type' => 'wheel',
        'team_id' => $team->id,
      ]);

      if($this->player1Id > 0 && $this->player1FullName != '')
      {        
        $player1 = \App\Models\Player::create([
          'id' => $this->player1Id,
          'fullname' => $this->player1FullName,
          'phone' => $this->player1Phone,
          'email' => $this->player1Email,
          'city' => $this->player1City,
          'dob' => $this->player1Dob,
          'sex' => $this->player1Sex,
          'type' => 'player',
          'team_id' => $team->id,
        ]);
      }

      if($this->player2Id > 0 && $this->player2FullName != '')
      {        
        $player2 = \App\Models\Player::create([
          'id' => $this->player2Id,
          'fullname' => $this->player2FullName,
          'phone' => $this->player2Phone,
          'email' => $this->player2Email,
          'city' => $this->player2City,
          'dob' => $this->player2Dob,
          'sex' => $this->player2Sex,
          'type' => 'player',
          'team_id' => $team->id,
        ]);
      }

      // if no wheel player and player3 id >0 and fullname!= ''
      if (!$this->wheelplayer && $this->player3Id > 0 && $this->player3FullName != '') {
        $player3 = \App\Models\Player::create([
          'id' => $this->player3Id,
          'fullname' => $this->player3FullName,
          'phone' => $this->player3Phone,
          'email' => $this->player3Email,
          'city' => $this->player3City,
          'dob' => $this->player3Dob,
          'sex' => $this->player3Sex,
          'type' => 'player',
          'team_id' => $team->id,
        ]);
      }

      DB::commit();
      $this->success('Equipo agregado con éxito', 'Bienvenidos');
      // send welcome email
      Illuminate\Support\Facades\Mail::send(new App\Mail\Welcome($this->teamBoatPlate));
      $this->reset();
    } catch (Exception $e) {
      $this->warning('Exception', 'Verifique que los datos ingresados sean correctos.' . $e, timeout: 8000);
      DB::rollBack();
    }
  }

}; ?>

<div class="text-white text-lg ">
  <x-form wire:submit.prevent="save">
    <div class="mb-0 p-2 border-b-4 bg-slate-800 bg-opacity-35 rounded-t-md border-slate-500">
      <x-icon name="o-user-group" />Datos del Equipo
      {{-- <span
        class="font-bold ml-3 bg-gradient-to-r from-indigo-600 via-purple-600 to-red-700 bg-clip-text text-transparent ">
        Datos del Equipo
      </span> --}}
    </div>
    <div class="grid gap-3 grid-cols-1 mb-2 md:grid-cols-2">
      <x-input label="Peña / Club o Barra Pesquera" wire:model.lazy="teamName" inline />
      <x-input label="Nombre de la Embarcación" wire:model="teamBoatName" inline />

      <x-input label="Matrícula" wire:model="teamBoatPlate" inline />
      <x-input label="HP" wire:model="teamBoatHp" type='number' inline />
    </div>

    <div class="flex justify-between mb-0 p-2 border-b-4 bg-slate-800 bg-opacity-35 rounded-t-md border-slate-500">
      <div>
        <x-icon name="o-cog" />Timonel
      </div>
      <x-toggle label="También Participa" wire:model.live="wheelplayer"
        hint="Seleccione si aparte de timonel participa de la pesca" />
    </div>
    <div class="grid gap-3 grid-cols-1 mb-2 md:grid-cols-2">
      <x-input icon="o-identification" label="DNI" wire:model="wheelId" type='number' inline />
      <x-input icon="o-user" label="Apellido, Nombre" wire:model="wheelFullName" inline />
      <x-input icon="o-device-phone-mobile" label="Celular" type="tel" wire:model="wheelPhone" inline />
      <x-input icon="o-at-symbol" label="E-Mail" type="email" wire:model="wheelEmail" inline />
      <x-input icon="o-map-pin" label="Ciudad, Provincia" wire:model="wheelCity" inline />
      <div class="grid grid-cols-2 gap-3">
        <x-input icon="o-calendar" label="Fecha de Nacimiento" type="date" wire:model="wheelDob" inline />
        <x-select label="Sexo" wire:model="wheelSex" icon="o-identification" :options="$sexes" inline />
      </div>
    </div>

    <div class="mb-0 p-2 border-b-4 bg-slate-800 bg-opacity-35 rounded-t-md border-slate-500">
      <x-icon name="o-user" />Participante 1
    </div>
    <div class="grid gap-3 grid-cols-1 mb-2 md:grid-cols-2">
      <x-input icon="o-identification" label="DNI" wire:model="player1Id" type='number' inline />
      <x-input icon="o-user" label="Apellido, Nombre" wire:model="player1FullName" inline />
      <x-input icon="o-device-phone-mobile" label="Celular" type="tel" wire:model="player1Phone" inline />
      <x-input icon="o-at-symbol" label="E-Mail" type="email" wire:model="player1Email" inline />
      <x-input icon="o-map-pin" label="Ciudad, Provincia" wire:model="player1City" inline />
      <div class="grid grid-cols-2 gap-3">
        <x-input icon="o-calendar" label="Fecha de Nacimiento" type="date" wire:model="player1Dob" inline />
        <x-select label="Sexo" wire:model="player1Sex" icon="o-identification" :options="$sexes" inline />
      </div>
    </div>

    <div class="mb-0 p-2 border-b-4 bg-slate-800 bg-opacity-35 rounded-t-md border-slate-500">
      <x-icon name="o-user" />Participante 2
    </div>
    <div class="grid gap-3 grid-cols-1 mb-2 md:grid-cols-2">
      <x-input icon="o-identification" label="DNI" wire:model="player2Id" type='number' inline />
      <x-input icon="o-user" label="Apellido, Nombre" wire:model="player2FullName" inline />
      <x-input icon="o-device-phone-mobile" label="Celular" type="tel" wire:model="player2Phone" inline />
      <x-input icon="o-at-symbol" label="E-Mail" type="email" wire:model="player2Email" inline />
      <x-input icon="o-map-pin" label="Ciudad, Provincia" wire:model="player2City" inline />
      <div class="grid grid-cols-2 gap-3">
        <x-input icon="o-calendar" label="Fecha de Nacimiento" type="date" wire:model="player2Dob" inline />
        <x-select label="Sexo" wire:model="player2Sex" icon="o-identification" :options="$sexes" inline />
      </div>
    </div>

    @if (!$wheelplayer)
    <div class="mb-0 p-2 border-b-4 bg-slate-800 bg-opacity-35 rounded-t-md border-slate-500">
      <x-icon name="o-user" />Participante 3
    </div>
    <div class="grid gap-3 grid-cols-1 mb-2 md:grid-cols-2">
      <x-input icon="o-identification" label="DNI" wire:model="player3Id" type='number' inline />
      <x-input icon="o-user" label="Apellido, Nombre" wire:model="player3FullName" inline />
      <x-input icon="o-device-phone-mobile" label="Celular" type="tel" wire:model="player3Phone" inline />
      <x-input icon="o-at-symbol" label="E-Mail" type="email" wire:model="player3Email" inline />
      <x-input icon="o-map-pin" label="Ciudad, Provincia" wire:model="player3City" inline />
      <div class="grid grid-cols-2 gap-3">
      <x-input icon="o-calendar" label="Fecha de Nacimiento" type="date" wire:model="player3Dob" inline />
      <x-select label="Sexo" wire:model="player3Sex" icon="o-identification" :options="$sexes" inline />
      </div>
    </div>
  @endif

    <x-slot:actions>
      <x-button label="Guardar Formulario" class="btn-primary" type="submit" spinner="save" />
    </x-slot:actions>
  </x-form>
</div>