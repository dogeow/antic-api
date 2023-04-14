<div style="text-align: center">
    <input wire:model="message" type="text">
    <button wire:click="increment">+</button>
    <h1>{{ $message }}</h1>
    <h1>{{ $count }}</h1>
    <h1>{{ $user->name }}</h1>
</div>
