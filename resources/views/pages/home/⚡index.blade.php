<?php

use Livewire\Component;
use App\Models\Counter;
use Livewire\Attributes\On;

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
    }

    public function increment()
    {
        $this->counter->update([
            'value' => $this->counter->value + 1,
        ]);
    }

    #[On('kurang')]
    public function apdat()
    {
        $this->counter->refresh();
        Log::info('Event diterima');
        // dd('Event tertangkap!');
    }

    public function decrement()
    {
        $this->counter->decrement('value');
        // $this->counter->refresh();
        $this->dispatch('kurang');
    }

    public function ulang()
    {
        $this->counter->update(['value' => 0]);
        $this->counter->refresh();
    }
};
?>

<div>
    {{-- If you do not have a consistent goal in life, you can not live it in a consistent way. - Marcus Aurelius --}}
    <h1>{{ $counter->value }}</h1>
    <form wire:submit.prevent="increment">
        <button type="submit">Increment</button>
    </form>
    <button wire:click="decrement" type="button">Decrement</button>
    <button wire:click="ulang" type="button">RESET!</button>
</div>
