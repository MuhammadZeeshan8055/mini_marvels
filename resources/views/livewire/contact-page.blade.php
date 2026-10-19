<div class="cms-page">
    <section class="cms-hero" aria-labelledby="contact-title">
        <div class="container cms-hero-inner">
            <p class="cms-kicker">Get In Touch</p>
            <h1 id="contact-title">{{ $page?->title ?? 'Contact Us' }}</h1>
        </div>
    </section>

    <section class="section">
        <div class="container cms-contact">
            <div class="cms-prose">
                {!! $page?->content ?: '<p>Contact details will appear here soon.</p>' !!}

                <ul class="cms-contact-list">
                    <li>
                        <strong>Address</strong>
                        <span>{{ $page?->extra('address') ?: 'Coming soon' }}</span>
                    </li>
                    <li>
                        <strong>Phone</strong>
                        <a href="tel:{{ preg_replace('/\s+/', '', (string) $page?->extra('phone')) }}">{{ $page?->extra('phone') ?: 'Coming soon' }}</a>
                    </li>
                    <li>
                        <strong>Email</strong>
                        <a href="mailto:{{ $page?->extra('email') }}">{{ $page?->extra('email') ?: 'Coming soon' }}</a>
                    </li>
                </ul>
            </div>

            @if ($page?->extra('show_form', true))
                <div class="cms-form-card">
                    <h2>Send a message</h2>
                    @if (session('contact_success'))
                        <p class="cms-form-success">{{ session('contact_success') }}</p>
                    @endif

                    @if ($page?->extra('form_note'))
                        <p class="cms-form-note">{{ $page->extra('form_note') }}</p>
                    @endif

                    <form wire:submit="submit" class="cms-form">
                        <label>
                            <span>Name</span>
                            <input type="text" wire:model="name" required>
                            @error('name') <em>{{ $message }}</em> @enderror
                        </label>
                        <label>
                            <span>Email</span>
                            <input type="email" wire:model="email" required>
                            @error('email') <em>{{ $message }}</em> @enderror
                        </label>
                        <label>
                            <span>Message</span>
                            <textarea wire:model="message" rows="5" required></textarea>
                            @error('message') <em>{{ $message }}</em> @enderror
                        </label>
                        <button type="submit" class="btn btn-plum">Send Message</button>
                    </form>
                </div>
            @endif
        </div>
    </section>
</div>
