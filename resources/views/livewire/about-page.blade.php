<div class="cms-page">
    <section class="cms-hero" aria-labelledby="about-title">
        <div class="container cms-hero-inner">
            <p class="cms-kicker">Our Story</p>
            <h1 id="about-title">{{ $page?->title ?? 'About Us' }}</h1>
        </div>
    </section>

    <section class="section">
        <div class="container cms-layout">
            <div class="cms-prose">
                {!! $page?->content ?: '<p>About content will appear here soon.</p>' !!}
            </div>

            @if ($page?->imageUrl())
                <div class="cms-media">
                    <img src="{{ $page->imageUrl() }}" alt="{{ $page->title }}" width="900" height="700" loading="lazy">
                </div>
            @endif
        </div>
    </section>
</div>
