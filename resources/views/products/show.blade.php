<x-app-layout class="space-y-8">
    <livewire:products.carousel :images="$product->images" />

    <div class="space-y-3">
        <h1 class="text-2xl font-semibold">{{ $product->name }}</h1>
        <p class="text-lg text-gray-100">{{ $product->description }}</p>
    </div>

    <div class="flex items-center justify-between">
        <div class="flex flex-col gap-3">
            <span class="text-3xl font-semibold">€ {{ $product->price }}</span>

            <span>{{ $product->quantity < 10 && "Only" }} {{ $product->quantity }} items left</span>
        </div>

        <div class="flex items-center gap-3">
            <!-- TODO: Favors this product -->
            <x-button.circle secondary icon="heart" size="lg" />

            <livewire:products.add-cart id="{{ $product->id }}" />
        </div>
    </div>

    <livewire:products.reviews :paginator="$reviews" :product="$product" />
</x-app-layout>
