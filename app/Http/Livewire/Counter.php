<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class Counter extends Component
{
    public $count = 0;
    public $message = '';

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        return view('livewire.counter', [
            'user' => User::find(1),
            'message' => $this->message
        ]);
    }
}
