<?php
declare(strict_types=1);

if (strtolower((string) (getenv('APP_ENV') ?: 'development')) === 'production') {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    ini_set('log_errors', '1');
}

const SITE = [
    'name' => 'Tin-Tin Trekking & Adventure (P) Ltd.',
    'short_name' => 'Tin-Tin Trekking',
    'address' => 'Jyatha, Thamel, Kathmandu, Nepal',
    'website' => 'www.tintintrekking.com',
    'email' => 'tintintrek@gmail.com',
    'telephone' => '00977-1-4248404',
    'mobile' => '00977-9851044230',
    'whatsapp' => '9779851044230',
    // Replace these searches with Tin-Tin's exact verified profile URLs when supplied.
    'google_reviews_url' => 'https://www.google.com/search?q=Tin-Tin+Trekking+%26+Adventure+Kathmandu+reviews',
    'tripadvisor_reviews_url' => 'https://www.tripadvisor.com/Search?q=Tin-Tin%20Trekking%20%26%20Adventure%20Kathmandu',
    // Replace these discovery links with Tin-Tin's exact social profile URLs when supplied.
    'instagram_url' => 'https://www.instagram.com/explore/search/keyword/?q=tin%20tin%20trekking',
    'tiktok_url' => 'https://www.tiktok.com/search?q=Tin-Tin%20Trekking%20Adventure',
    'facebook_url' => 'https://www.facebook.com/search/top?q=Tin-Tin%20Trekking%20%26%20Adventure',
];

function base_path(): string
{
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $parts = explode('/', trim($script, '/'));
    $root = count($parts) > 1 ? '/' . $parts[0] : '';
    return rtrim($root, '/');
}

function url(string $path = ''): string
{
    return base_path() . '/' . ltrim($path, '/');
}

function asset_url(string $path): string
{
    $cleanPath = ltrim($path, '/');
    $filePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $cleanPath);
    $version = is_file($filePath) ? (string) filemtime($filePath) : '1';
    return url($cleanPath) . '?v=' . rawurlencode($version);
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function environment(string $key, ?string $default = null): ?string
{
    $value = getenv($key);
    return $value === false || $value === '' ? $default : $value;
}

function is_production(): bool
{
    return strtolower((string) environment('APP_ENV', 'development')) === 'production';
}

function is_https_request(): bool
{
    if (isset($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off') {
        return true;
    }

    // Trust the proxy header only when the application is explicitly configured for production.
    return is_production()
        && strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')) === 'https';
}

function chat_endpoint(): string
{
    $endpoint = environment('CHAT_ENDPOINT');
    if ($endpoint === null) {
        if (is_production()) {
            return '';
        }
        $endpoint = 'https://tin-tin-website-chat.thapasther101.workers.dev/chat';
    }

    if (!is_string($endpoint) || filter_var($endpoint, FILTER_VALIDATE_URL) === false) {
        return '';
    }

    $scheme = strtolower((string) parse_url($endpoint, PHP_URL_SCHEME));
    if (!in_array($scheme, ['https', 'http'], true)) {
        return '';
    }

    if (is_production() && $scheme !== 'https') {
        return '';
    }

    return $endpoint;
}

function send_security_headers(): void
{
    if (headers_sent()) {
        return;
    }

    $connectSources = ["'self'"];
    $endpoint = chat_endpoint();
    if ($endpoint !== '') {
        $scheme = (string) parse_url($endpoint, PHP_URL_SCHEME);
        $host = (string) parse_url($endpoint, PHP_URL_HOST);
        $port = parse_url($endpoint, PHP_URL_PORT);
        if ($scheme !== '' && $host !== '') {
            $connectSources[] = $scheme . '://' . $host . ($port ? ':' . $port : '');
        }
    }

    $policy = [
        "default-src 'self'",
        "base-uri 'self'",
        "object-src 'none'",
        "frame-ancestors 'none'",
        "form-action 'self'",
        "script-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com https://unpkg.com",
        "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://unpkg.com",
        "font-src 'self' https://fonts.gstatic.com data:",
        "img-src 'self' data: https://tile.openstreetmap.org https://*.tile.openstreetmap.org",
        'media-src \'self\'',
        'connect-src ' . implode(' ', array_unique($connectSources)),
        "worker-src 'none'",
        "manifest-src 'self'",
        "upgrade-insecure-requests" . (is_production() ? '' : " 'none'"),
    ];

    if (!is_production()) {
        // `upgrade-insecure-requests` has no useful development-mode equivalent.
        array_pop($policy);
    }

    header('Content-Security-Policy: ' . implode('; ', $policy));
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), geolocation=(), microphone=(), payment=(), usb=()');
    header('Cross-Origin-Opener-Policy: same-origin');

    if (is_production() && is_https_request()) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }
}

function start_secure_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_strict_mode', '1');
    ini_set('session.cookie_httponly', '1');

    $cookiePath = base_path();
    session_name('tintin_session');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => $cookiePath !== '' ? $cookiePath : '/',
        'secure' => is_https_request(),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function csrf_token(): string
{
    start_secure_session();
    $token = $_SESSION['csrf_token'] ?? null;
    if (!is_string($token) || strlen($token) !== 64) {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
    }
    return $token;
}

function verify_csrf_token(mixed $submittedToken): bool
{
    start_secure_session();
    $storedToken = $_SESSION['csrf_token'] ?? null;
    return is_string($submittedToken)
        && is_string($storedToken)
        && strlen($submittedToken) === 64
        && hash_equals($storedToken, $submittedToken);
}

function db(): mysqli
{
    $host = (string) environment('DB_HOST', '127.0.0.1');
    $name = (string) environment('DB_NAME', 'tin_tin_trekking');
    $user = (string) environment('DB_USER', 'root');
    $pass = (string) environment('DB_PASS', '');

    if (is_production() && ($user === 'root' || $pass === '')) {
        throw new RuntimeException('Production database credentials are not configured.');
    }

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $connection = new mysqli($host, $user, $pass, $name);
    $connection->set_charset('utf8mb4');
    return $connection;
}

function whatsapp_url(string $message = "Hello Tin-Tin Trekking, I'm interested in planning a Himalayan trek."): string
{
    return 'https://wa.me/' . SITE['whatsapp'] . '?text=' . rawurlencode($message);
}
