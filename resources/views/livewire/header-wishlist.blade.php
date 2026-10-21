<a href="{{ route('wishlist') }}" class="icon-btn" aria-label="Wishlist">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20s-7-4.5-7-9.5A4 4 0 0 1 12 7a4 4 0 0 1 7 3.5C19 15.5 12 20 12 20z"/>
    </svg>
    @if ($this->count > 0)
        <span class="badge">{{ $this->count }}</span>
    @endif
</a>
