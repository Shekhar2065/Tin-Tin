<?php
declare(strict_types=1);

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

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function db(): mysqli
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $name = getenv('DB_NAME') ?: 'tin_tin_trekking';
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASS') ?: '';
    $connection = new mysqli($host, $user, $pass, $name);
    $connection->set_charset('utf8mb4');
    return $connection;
}

function whatsapp_url(string $message = "Hello Tin-Tin Trekking, I'm interested in planning a Himalayan trek."): string
{
    return 'https://wa.me/' . SITE['whatsapp'] . '?text=' . rawurlencode($message);
}
