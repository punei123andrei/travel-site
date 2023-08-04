<?php

$prefetchSrc = ['*.zitec.dev'];

$sdWhileListDomains = [];

$whitelistDomains = [
    "https://*.google.com",
    "https://*.googletagmanager.com",
    "https://*.google-analytics.com",
    "https://*.facebook.com",
    "https://secure.gravatar.com",
];

$scriptSrcWhiteListDomains = [
    "https://ajax.cloudflare.com",
    "https://*.wp.com",
    "https://*.hotjar.com ",
    "https://*.gstatic.com/recaptcha/",
    "https://*.fontawesome.com",
    "https://*.recaptcha.net",
    "https://consent.cookiebot.com",
    "https://*.googleapis.com",
    "https://*.facebook.net",
];

$styleSrcWhiteListDomains = [
    "https://cdnjs.cloudflare.com",
    "https://*.hotjar.com",
    "https://use.fontawesome.com",
    "https://*.fontawesome.com",
    "https://*.facebook.net",
    "*.gstatic.com",
];

$frameSrcWhiteListDomains = [
    "https://*.googletagmanager.com;",
    "https://*.google.com;",
    "https://*.facebook.com;",
    "https://*.youtube.com;",
];

$manifestSrcWhiteListDomains = [];

$imgSrc = [
    "https://*.facebook.com",
    "https://secure.gravatar.com",
    "https://*.google.ro",
    "https://*.doubleclick.net",
    "https://*.googleapis.com",
    "https://*.gstatic.com",
];

$connectSrc = [
    "https://*.doubleclick.net",
    "https://*.googleapis.com",
    "*.oribi.io",
];

$csp = [
    "upgrade-insecure-requests;",
    "default-src 'self' " . implode(' ', $whitelistDomains) . ";",
    "script-src 'self' https: " . implode(' ', $whitelistDomains) . " " . implode(' ', $scriptSrcWhiteListDomains) . " 'unsafe-inline' 'unsafe-eval';",
    "style-src * 'unsafe-inline';",
    "img-src * data:;",
    "font-src * data:;",
    "connect-src 'self' " . implode(' ', $whitelistDomains) . " " . implode(' ', $connectSrc) . ";",
    "media-src  *;",
    "object-src 'none';",
    "prefetch-src " . implode(' ', $prefetchSrc) . ";",
    "child-src 'self';",
    "frame-src 'self' https: " . implode(' ', $whitelistDomains) . ";",
    "worker-src 'self' " . implode(' ', $whitelistDomains) . ";",
    "manifest-src *;",
    "base-uri 'self';",
    "form-action 'self';",
    "frame-ancestors https: " . implode(' ', $whitelistDomains) . ";",
];

$headers = [
    'Cross-Origin-Opener-Policy: same-origin',
    'Cross-Origin-Resource-Policy: same-origin',
    'Cross-Origin-Embedder-Policy: unsafe-none',
    'X-Permitted-Cross-Domain-Policies: none',
    'Access-Control-Allow-Methods: *',
    'Access-Control-Max-Age: 600',
    'Access-Control-Exposed-Header: Content-Encoding',
    'Access-Control-Allow-Credentials: true',
    'Access-Control-Allow-Origin: ' . implode(' ', $sdWhileListDomains) . ';',
    'Access-Control-Allow-Headers: Accept',
    'Referrer-Policy: same-origin',
    'Permission-Policy: fullscreen=(self) geolocation=(self)',
    'Content-Security-Policy: ' . implode(' ', $csp) . ';',
];

add_action('send_headers', function () use ($headers) {
    foreach ($headers as $header) {
        header($header);
    }
});
