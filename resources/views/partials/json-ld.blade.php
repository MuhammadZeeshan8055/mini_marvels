@php
    $siteName = 'Mini Marvels';
    $siteUrl = url('/');
    $description = $metaDescription ?? 'Mini Marvels — kids toys, deals, and playful learning.';
    $logoUrl = asset('images/logo.png');
    $footer = $footerSettings ?? \App\Models\SiteSetting::footerDefaults();
    $sameAs = collect($footer['social_links'] ?? \App\Models\SiteSetting::resolvedSocialLinks())
        ->map(fn ($link) => trim((string) ($link['url'] ?? '')))
        ->filter(fn ($url) => str_starts_with($url, 'http://') || str_starts_with($url, 'https://'))
        ->unique()
        ->values()
        ->all();

    $organization = array_filter([
        '@type' => 'Organization',
        '@id' => $siteUrl.'#organization',
        'name' => $siteName,
        'url' => $siteUrl,
        'logo' => [
            '@type' => 'ImageObject',
            'url' => $logoUrl,
        ],
        'email' => $footer['email'] ?? null,
        'telephone' => $footer['phone'] ?? null,
        'address' => array_filter([
            '@type' => 'PostalAddress',
            'streetAddress' => $footer['address'] ?? null,
            'addressLocality' => 'Rawalpindi',
            'addressCountry' => 'PK',
        ]),
        'sameAs' => $sameAs !== [] ? $sameAs : null,
    ], fn ($value) => $value !== null && $value !== '');

    $graph = [
        $organization,
        [
            '@type' => 'WebSite',
            '@id' => $siteUrl.'#website',
            'url' => $siteUrl,
            'name' => $siteName,
            'description' => $description,
            'publisher' => ['@id' => $siteUrl.'#organization'],
            'inLanguage' => str_replace('_', '-', app()->getLocale()),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => route('shop').'?search={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ],
    ];

    if (! empty($structuredData) && is_array($structuredData)) {
        foreach ($structuredData as $node) {
            if (is_array($node) && isset($node['@type'])) {
                $graph[] = $node;
            }
        }
    }

    $payload = [
        '@context' => 'https://schema.org',
        '@graph' => $graph,
    ];
@endphp
<script type="application/ld+json">{!! json_encode($payload, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT) !!}</script>
