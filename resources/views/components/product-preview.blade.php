@props(['product'])

<x-card>
    <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" />
    <h3 class="mt-2">
        <a class="text-sm" href="{{ route('products.show', [$product->id]) }}">
            {{ $product->name  }}
        </a>
    </h3>

    <div class="flex items-baseline justify-between">
        <span class="text-xl font-medium">€ {{ $product->price }}</span>
        <span class="text-xs">{{ $product->quantity }} left</span>
    </div>
</x-card>
