@props([
    'title',
    'subtitle' => null,
])

<div class="mb-8">
    <h2 class="section-title">{{ $title }}</h2>
    @if ($subtitle)
        <p class="section-sub">{{ $subtitle }}</p>
    @endif
</div>
