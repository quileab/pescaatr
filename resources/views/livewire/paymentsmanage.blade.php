<?php

use App\Models\Payment;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public string $search = '';

    public bool $drawer = false;

    public array $sortBy = ['column' => 'date', 'direction' => 'des'];

    public $team = null;
    public $players = null;
    public $total = 0;

    public $payDate,$payDescription, $payAmount;
    protected $rules = [
        'payDate' => 'required|date',
        'payDescription' => 'required|min:3',
        'payAmount' => 'required|numeric|gt:0',
    ];

    public function mount($id) {
        $this->team = $id; //\App\Models\Team::with('payments')->find($id);
        //$this->payments=$this->team->payments;
        //dd($id,$this->team->name, $this->team->players[0]->fullname);
        $this->payDate=now()->format('Y-m-d');
    }

    // register Payment
    public function registerPayment(): void {
        try{
        DB::beginTransaction();
            // create the team
            $payment = \App\Models\Payment::create([
                'team_id' => $this->team,
                'date' => $this->payDate,
                'amount' => $this->payAmount,
                'notes' => $this->payDescription,
            ]);
            DB::commit();
            $this->success('Pago ingresado OK');
            // send welcome email
            //Illuminate\Support\Facades\Mail::send(new App\Mail\Welcome($this->teamBoatPlate));
            $this->reset(['payDate','payAmount','payDescription']);
            $this->drawer=false;

        } catch (Exception $e) {
            $this->warning('Exception', 'Verifique que los datos ingresados sean correctos.', timeout: 8000);
            DB::rollBack();
        }
    }

    // Delete action
    public function delete($id): void {
        $this->warning("Will delete #$id", 'It is fake.', position: 'toast-bottom');
    }

    // Table headers
    public function headers(): array {
        return [['key' => 'id', 'label' => '#', 'class' => 'w-1'], ['key' => 'date', 'label' => 'Fecha', 'class' => 'w-20'], ['key' => 'notes', 'label' => 'Descripción', 'class' => 'w-40'], ['key' => 'amount', 'label' => 'Importe', 'class' => 'w-20 text-right']];
    }

    public function payments(): Collection {
        $result = \App\Models\Payment::where('team_id', $this->team)
            ->get()
            ->sortBy([[...array_values($this->sortBy)]])
            ->when($this->search, function (Collection $collection) {
                return $collection->filter(fn($item) => str($item['notes'])->contains($this->search, true));
            });
        $this->total = $result->sum('amount');
        return $result;
    }

    public function with(): array
    {
        return [
            'payments' => $this->payments(),
            'headers' => $this->headers(),
        ];
    }
}; ?>

<div>
  <!-- HEADER -->
  <x-header title="Pagos" size="text-lg" separator progress-indicator>
    <x-slot:middle class="!justify-end">
        <x-input placeholder="buscar..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
    </x-slot:middle>
    <x-slot:actions>
        @if($total < 0)
            <x-button label="Nuevo Pago" class="btn-primary" @click="$wire.drawer = true" responsive icon="o-plus-circle" />
        @else
            <x-button label="Generar Deuda" link="/debts" class="btn-accent" />
        @endif
    </x-slot:actions>
  </x-header>

  <!-- TABLE  -->
  <x-card>
    <x-table :headers="$headers" :rows="$payments" :sort-by="$sortBy">
      @scope('cell_amount', $payments)
        <x-badge :value="number_format($payments->amount, 2, ',', '.')" />
      @endscope
      @scope('actions', $payment)
        <x-button icon="o-trash" wire:click="delete({{ $payment['id'] }})" wire:confirm="⚠️ Está seguro?" spinner
          class="btn-ghost btn-sm text-red-500" />
      @endscope
    </x-table>
    <x-slot:actions>
        <x-stat description="Saldo a la fecha" value="{{ number_format($total, 2, ',', '.') }}" 
        icon="o-currency-dollar"
        class="text-orange-400" color="text-lime-500" />
    </x-slot:actions>
  </x-card>

  <!-- FILTER DRAWER -->
  <x-drawer wire:model="drawer" title="Nuevo Pago" right separator with-close-button class="lg:w-1/3">
    <x-datetime label="Fecha" wire:model="payDate" icon="o-calendar" inline class="mb-1" />
    <x-input label="Descripción" wire:model.live.debounce="payDescription" icon="o-pencil-square" inline class="mb-1" />
    <x-input label="Importe" wire:model="payAmount" icon="o-currency-dollar" money locale="pt-BR" inline class="mb-1" />
    <x-slot:actions>
        <x-button label="Cerrar" icon="o-x-mark" class="btn-secondary" @click="$wire.drawer = false" />
      <x-button label="Registrar" icon="o-check" class="btn-accent" wire:click="registerPayment" spinner />
    </x-slot:actions>
  </x-drawer>
</div>
