@props(['products'])

<x-app-layout>
    <div class="flex-1 mb-6">
        <div class="grid grid-cols-3 gap-4">
            @foreach($products as $product)
                <x-product-preview :product="$product" />
            @endforeach
        </div>
    </div>
</x-app-layout>
