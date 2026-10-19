<?php

namespace App\Support;

class HtmlSanitizer
{
    public static function clean(?string $html): ?string
    {
        $html = trim((string) $html);

        if ($html === '' || $html === '<p><br></p>' || trim(strip_tags($html)) === '') {
            return null;
        }

        $html = preg_replace('#<script\b[^>]*>.*?</script>#is', '', $html) ?? $html;
        $html = preg_replace('#\son\w+\s*=\s*("|\')(.*?)\1#i', '', $html) ?? $html;
        $html = preg_replace('#javascript:#i', '', $html) ?? $html;

        return $html;
    }
}
