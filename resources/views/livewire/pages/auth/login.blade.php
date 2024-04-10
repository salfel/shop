<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest', ["title" => "Login"])] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }
}; ?>

<form class="w-96 space-y-6" wire:submit="login">
    <x-input wire:model="form.email" label="Email" placeholder="example@email.com" />

    <x-inputs.password wire:model="form.password" label="Password" />

    <x-button primary label="Login" class="w-full" type="submit" />
</form>
