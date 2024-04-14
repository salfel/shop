<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Actions\Logout;

new class extends Component {
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect(route("home"), navigate: true);
    }
}

?>

<header class="w-full flex items-center justify-between mx-auto sm:max-w-3xl px-5 py-4 mb-3">
    <a href="{{ route("home") }}" wire:navigate>
        <h2 class="text-xl font-semibold">
            Shop
        </h2>
    </a>

    <nav class="flex items-center gap-5">
        @auth
            <a href="{{ route('cart') }}" wire:navigate>
                <x-icon name="shopping-cart" class="size-6" solid />
            </a>

            <x-dropdown>
                <x-slot name="trigger">
                    <x-icon name="user-circle" class="size-6" solid />
                </x-slot>

                <x-dropdown.header label="{{ auth()->user()->name }}">
                    <x-dropdown.item wire:click="logout" label="Logout" class="!text-red-500" />
                </x-dropdown.header>
            </x-dropdown>
        @else
            <a href="{{ route("login") }}" class="font-medium" wire:navigate>
                Login
            </a>

            <a href="{{ route("register") }}" class="font-medium" wire:navigate>
                Register
            </a>
        @endauth
    </nav>
</header>
