<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

send_security_headers();
header('Cache-Control: no-store, max-age=0');

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    exit('Method not allowed');
}

$contentLength = (int) ($_SERVER['CONTENT_LENGTH'] ?? 0);
if ($contentLength > 65_536) {
    http_response_code(413);
    exit('Request too large');
}

$source = $_POST['source'] ?? null;
$returns = [
    'budget' => 'budget-plan.php',
    'contact' => 'contact.php',
];

if (!is_string($source) || !isset($returns[$source])) {
    redirect_to_form('budget-plan.php', 'validation');
}
$returnPage = $returns[$source];

start_secure_session();
if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
    redirect_to_form($returnPage, 'session');
}

// Quietly accept honeypot submissions without writing them to the database.
if (is_string($_POST['website_check'] ?? null) && trim($_POST['website_check']) !== '') {
    unset($_SESSION['csrf_token']);
    redirect_to_form($returnPage, 'success');
}

$fullName = posted_text('full_name', 150);
$email = posted_text('email', 190);
$phone = posted_text('phone', 60);
$whatsapp = posted_text('whatsapp', 60);
$country = posted_text('country', 100);
$trek = posted_text('trek', 190);
$travelMonth = posted_text('travel_month', 30);
$travelDates = posted_text('travel_dates', 120);
$groupType = posted_text('group_type', 80);
$experience = posted_text('trekking_experience', 100);
$fitness = posted_text('fitness_level', 100);
$altitude = posted_text('altitude_experience', 100);
$health = posted_text('additional_health_notes', 2000, true);
$accommodation = posted_text('accommodation', 100);
$hotel = posted_text('hotel_level', 50);
$room = posted_text('room_type', 50);
$budget = posted_text('budget_range', 80);
$notes = posted_text('additional_notes', 5000, true);
$preferredContact = posted_text('preferred_contact', 20);

$textFields = [
    $fullName, $email, $phone, $whatsapp, $country, $trek, $travelMonth,
    $travelDates, $groupType, $experience, $fitness, $altitude, $health,
    $accommodation, $hotel, $room, $budget, $notes, $preferredContact,
];

if (in_array(null, $textFields, true)
    || $fullName === ''
    || $email === ''
    || filter_var($email, FILTER_VALIDATE_EMAIL) === false
) {
    redirect_to_form($returnPage, 'validation');
}

if ($travelMonth !== '' && preg_match('/^\d{4}-(?:0[1-9]|1[0-2])$/', $travelMonth) !== 1) {
    redirect_to_form($returnPage, 'validation');
}

$groupSizeRaw = $_POST['group_size'] ?? '1';
if (!is_string($groupSizeRaw) && !is_int($groupSizeRaw)) {
    redirect_to_form($returnPage, 'validation');
}
$groupSize = filter_var($groupSizeRaw, FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1, 'max_range' => 50],
]);
if ($groupSize === false) {
    redirect_to_form($returnPage, 'validation');
}

$flexibleRaw = $_POST['flexible_dates'] ?? null;
if ($flexibleRaw !== null && $flexibleRaw !== 'Yes') {
    redirect_to_form($returnPage, 'validation');
}
$flexible = $flexibleRaw === 'Yes' ? 'Yes' : 'No';

if (!allowed_value($groupType, ['', 'Solo', 'Couple', 'Family', 'Friends', 'Private group'])
    || !allowed_value($experience, ['', 'First trek', 'Some multi-day treks', 'Experienced trekker'])
    || !allowed_value($fitness, ['', 'Moderate activity', 'Regularly active', 'Very active'])
    || !allowed_value($altitude, ['', 'None', 'Up to 3,000 m', '3,000–5,000 m', 'Above 5,000 m'])
    || !allowed_value($accommodation, ['', 'standard', 'comfort', 'luxury'])
    || !allowed_value($hotel, ['', '3-star', '4-star', '5-star'])
    || !allowed_value($room, ['', 'Shared room', 'Private room'])
    || !allowed_value($budget, ['', 'Under $800', '$800–$1,200', '$1,200–$2,000', '$2,000–$3,500', '$3,500+', 'Not sure — advise me'])
    || !allowed_value($preferredContact, ['', 'Email', 'WhatsApp', 'Phone'])
) {
    redirect_to_form($returnPage, 'validation');
}

$interests = posted_interests();
if ($interests === null) {
    redirect_to_form($returnPage, 'validation');
}

if ($source === 'contact') {
    if ($notes === '') {
        redirect_to_form($returnPage, 'validation');
    }
    // Discard fields that are not present on the contact form.
    $whatsapp = '';
    $trek = 'General contact';
    $travelMonth = '';
    $travelDates = '';
    $flexible = 'No';
    $groupSize = 1;
    $groupType = '';
    $experience = '';
    $fitness = '';
    $altitude = '';
    $health = '';
    $accommodation = '';
    $hotel = '';
    $room = '';
    $interests = '';
    $budget = '';
    $preferredContact = '';
} else {
    if ($trek === '' || $country === '' || $experience === '' || $fitness === '' || $accommodation === '' || $budget === '') {
        redirect_to_form($returnPage, 'validation');
    }
}

if ($preferredContact !== '') {
    $notes = trim($notes . "\nPreferred contact: " . $preferredContact);
}

enforce_submission_rate_limit($returnPage);

try {
    $database = db();
    $statement = $database->prepare(
        'INSERT INTO inquiries '
        . '(full_name,email,phone,whatsapp,country,trek,travel_month,travel_dates,flexible_dates,group_size,group_type,trekking_experience,fitness_level,altitude_experience,additional_health_notes,accommodation,hotel_level,room_type,interests,budget_range,additional_notes) '
        . 'VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
    );
    $statement->bind_param(
        'sssssssssisssssssssss',
        $fullName,
        $email,
        $phone,
        $whatsapp,
        $country,
        $trek,
        $travelMonth,
        $travelDates,
        $flexible,
        $groupSize,
        $groupType,
        $experience,
        $fitness,
        $altitude,
        $health,
        $accommodation,
        $hotel,
        $room,
        $interests,
        $budget,
        $notes
    );
    $statement->execute();
    $statement->close();
    $database->close();

    unset($_SESSION['csrf_token']);
    session_regenerate_id(true);
    redirect_to_form($returnPage, 'success');
} catch (Throwable $error) {
    // Log only the exception type so credentials and customer data cannot leak to logs.
    error_log('Inquiry save failed [' . get_debug_type($error) . ']');
    redirect_to_form($returnPage, 'database');
}

function posted_text(string $key, int $maxLength, bool $allowNewlines = false): ?string
{
    $raw = $_POST[$key] ?? '';
    if (!is_string($raw) || preg_match('//u', $raw) !== 1 || str_contains($raw, "\0")) {
        return null;
    }

    $value = trim($raw);
    $length = function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
    if ($length > $maxLength || (!$allowNewlines && preg_match('/[\r\n]/', $value))) {
        return null;
    }

    return $value;
}

function allowed_value(string $value, array $allowed): bool
{
    return in_array($value, $allowed, true);
}

function posted_interests(): ?string
{
    $raw = $_POST['interests'] ?? [];
    if (!is_array($raw) || count($raw) > 7) {
        return null;
    }

    $allowed = ['Culture', 'Photography', 'Wildlife', 'Food', 'Mountain views', 'Peak climbing', 'Relaxation'];
    $clean = [];
    foreach ($raw as $value) {
        if (!is_string($value) || !in_array($value, $allowed, true)) {
            return null;
        }
        $clean[] = $value;
    }

    return implode(', ', array_unique($clean));
}

function enforce_submission_rate_limit(string $returnPage): void
{
    $now = time();
    $attempts = $_SESSION['inquiry_submission_times'] ?? [];
    if (!is_array($attempts)) {
        $attempts = [];
    }

    $attempts = array_values(array_filter(
        $attempts,
        static fn ($timestamp): bool => is_int($timestamp) && $timestamp > $now - 600
    ));

    $lastAttempt = $attempts === [] ? 0 : (int) end($attempts);
    if (count($attempts) >= 5 || $lastAttempt > $now - 10) {
        redirect_to_form($returnPage, 'rate');
    }

    $attempts[] = $now;
    $_SESSION['inquiry_submission_times'] = $attempts;

    if (!record_ip_submission($now)) {
        redirect_to_form($returnPage, 'rate');
    }
}

function record_ip_submission(int $now): bool
{
    $address = $_SERVER['REMOTE_ADDR'] ?? '';
    if (!is_string($address) || filter_var($address, FILTER_VALIDATE_IP) === false) {
        return true;
    }

    $directory = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'tin-tin-inquiry-limits';
    if (!is_dir($directory) && !@mkdir($directory, 0700, true) && !is_dir($directory)) {
        // Retain the session throttle if the host does not allow a private temp directory.
        return true;
    }

    $path = $directory . DIRECTORY_SEPARATOR . hash('sha256', $address) . '.json';
    $handle = @fopen($path, 'c+');
    if ($handle === false) {
        return true;
    }

    $allowed = true;
    try {
        if (!flock($handle, LOCK_EX)) {
            return true;
        }

        rewind($handle);
        $decoded = json_decode((string) stream_get_contents($handle), true);
        $timestamps = is_array($decoded) ? $decoded : [];
        $timestamps = array_values(array_filter(
            $timestamps,
            static fn ($timestamp): bool => is_int($timestamp) && $timestamp > $now - 600
        ));

        $lastAttempt = $timestamps === [] ? 0 : (int) end($timestamps);
        if (count($timestamps) >= 20 || $lastAttempt > $now - 2) {
            $allowed = false;
        } else {
            $timestamps[] = $now;
            rewind($handle);
            ftruncate($handle, 0);
            fwrite($handle, json_encode($timestamps, JSON_THROW_ON_ERROR));
            fflush($handle);
        }

        flock($handle, LOCK_UN);
    } catch (Throwable) {
        // A storage failure should not take the inquiry form offline.
        $allowed = true;
    } finally {
        fclose($handle);
    }

    return $allowed;
}

function redirect_to_form(string $returnPage, string $status): never
{
    $parameter = $status === 'success' ? 'success=1' : 'error=' . rawurlencode($status);
    header('Location: ' . url($returnPage . '?' . $parameter), true, 303);
    exit;
}
