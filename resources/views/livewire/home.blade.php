<?php

use Livewire\Volt\Component;

new class extends Component {
    //
    public $data=[];

    public function mount() {
        $this->data['teams']=\App\Models\Team::count();
        $this->data['dues']=\App\Models\Payment::sum('amount');
        $this->data['pays']=\App\Models\Payment::where('amount','>',0)->sum('amount');
        

    }
}; ?>

<div>
  <x-card title="Estadísticas" subtitle="Vista rápida" shadow >
    <x-slot:actions>

        <x-stat title="Equipos" description="Equipos registrados" value="{{$data['teams']}}" icon="o-user-group"
          color="text-blue-500" />
        <x-stat title="Deuda Total" description="»" value="{{number_format(abs($data['dues']),2,',','.')}}" icon="o-arrow-trending-down" class="text-red-500"
          color="text-pink-500" />
        <x-stat title="Pagos Totales" description="»" value="{{number_format(abs($data['pays']),2,',','.')}}" icon="o-arrow-trending-up" class="text-lime-500"
          color="text-cyan-500" />
    </x-slot:actions>
  </x-card>
</div>
