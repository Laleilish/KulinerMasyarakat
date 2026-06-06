<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleMapsService
{
    /**
     * Extract latitude and longitude coordinates from a Google Maps URL.
     *
     * Supported formats:
     *  - https://maps.app.goo.gl/xxxxx (short link — resolved via redirect)
     *  - https://www.google.com/maps?q=-6.8845,107.6105
     *  - https://www.google.com/maps/place/.../@-6.8845,107.6105,...
     *  - https://maps.google.com/?ll=-6.8845,107.6105
     *  - https://www.google.com/maps/@-6.8845,107.6105,...
     *
     * @param  string  $url
     * @return array{latitude: float, longitude: float}|null
     */
    public function extractCoordinates(string $url): ?array
    {
        try {
            // Resolve short links (maps.app.goo.gl, goo.gl)
            if (preg_match('#^https?://(maps\.app\.goo\.gl|goo\.gl)/#i', $url)) {
                $url = $this->resolveShortLink($url);

                if (!$url) {
                    return null;
                }
            }

            // Pattern 1: /@lat,lng  (Place URLs, direct map URLs)
            if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $matches)) {
                return [
                    'latitude'  => (float) $matches[1],
                    'longitude' => (float) $matches[2],
                ];
            }

            // Pattern 2: ?q=lat,lng
            if (preg_match('/[?&]q=(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $matches)) {
                return [
                    'latitude'  => (float) $matches[1],
                    'longitude' => (float) $matches[2],
                ];
            }

            // Pattern 3: ?ll=lat,lng
            if (preg_match('/[?&]ll=(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $matches)) {
                return [
                    'latitude'  => (float) $matches[1],
                    'longitude' => (float) $matches[2],
                ];
            }

            // Pattern 4: !3d<lat>!4d<lng> (embedded/data format)
            if (preg_match('/!3d(-?\d+\.\d+)!4d(-?\d+\.\d+)/', $url, $matches)) {
                return [
                    'latitude'  => (float) $matches[1],
                    'longitude' => (float) $matches[2],
                ];
            }

            return null;
        } catch (\Throwable $e) {
            Log::warning('GoogleMapsService: failed to extract coordinates', [
                'url'   => $url,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Resolve a shortened Google Maps URL by following redirects.
     */
    protected function resolveShortLink(string $shortUrl): ?string
    {
        try {
            $response = Http::withOptions([
                'allow_redirects' => [
                    'max'       => 5,
                    'track_redirects' => true,
                ],
                'timeout' => 10,
            ])->get($shortUrl);

            // Get final URL from redirect history or effective URL
            $redirectHistory = $response->header('X-Guzzle-Redirect-History');

            if ($redirectHistory) {
                // The last redirect is the final URL
                $redirects = explode(', ', $redirectHistory);
                return end($redirects);
            }

            // Fallback: try to get from the response effective URL
            return $response->effectiveUri()?->__toString() ?? $shortUrl;
        } catch (\Throwable $e) {
            Log::warning('GoogleMapsService: failed to resolve short link', [
                'url'   => $shortUrl,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }
}
