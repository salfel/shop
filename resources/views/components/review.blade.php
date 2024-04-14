@props(['review'])
@use('App\Helpers\Format', 'Format')

<x-card>
    <div class="space-y-3">
        <div class="flex items-center gap-3">
            <x-avatar label="{{ Format::avatarLabel($review->user->name) }}" />

            <p>{{ $review->user->name }}</p>
        </div>

        <div class="flex gap-1 mb-3">
            @for($i = 0; $i < 5; $i++)
                <x-icon name="star" class="size-5 text-yellow-500" :solid="$i < $review->rating" />
            @endfor
        </div>

        <p>{{ $review->body }}</p>
    </div>
</x-card>
