<?php

use Livewire\Component;
use App\Models\Counter;
use Livewire\Attributes\On;
use App\Events\CounterUpdated;

new class extends Component {
    //
    public Counter $counter;

    public int $value;

    public function render()
    {
        return $this->view()->layout('layouts::app')->title('Counter');
    }

    public function mount()
    {
        $this->counter = Counter::firstOrCreate(['id' => 1], ['value' => 0]);
        $this->value = $this->counter->value;
    }

    public function increment()
    {
        $this->counter->increment('value');
        // $this->counter->refresh();
        $this->value = $this->counter->value;
        // CounterUpdated::dispatch($this->counter->value);
        broadcast(new CounterUpdated($this->value));
    }

    public function decrement()
    {
        $this->counter->decrement('value');
        $this->counter->refresh();
        CounterUpdated::dispatch($this->counter->value);
    }

    public function ulang()
    {
        $this->counter->update(['value' => 0]);
        $this->counter->refresh();
        CounterUpdated::dispatch($this->counter->value);
    }

    #[On('echo:counter,.CounterUpdated')]
    public function onCounterUpdated()
    {
        $this->counter->refresh();
    }

    // #[On('echo:counter,.CounterUpdated')]
    // public function onCounterUpdated($payload)
    // {
    //     // Payload: ['value' => 123]
    //     $this->value = $payload['value'];
    // }
};
?>

<div>
    {{-- If you do not have a consistent goal in life, you can not live it in a consistent way. - Marcus Aurelius --}}
    <h1>{{ $counter->value }}</h1>
    <button wire:click="increment" type="button">INC</button>
    <button wire:click="decrement" type="button">Decrement</button>
    <button wire:click="ulang" type="button">RESET!</button>


</div>

<script></script>
