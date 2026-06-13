<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

$baseUrl = 'http://127.0.0.1:8000';
$cookieFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'laravel_chatbot_cookie.txt';

function curlRequest(string $url, array $options): array
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
    curl_setopt($ch, CURLOPT_TIMEOUT, 90);

    foreach ($options as $opt => $value) {
        curl_setopt($ch, $opt, $value);
    }

    $body = curl_exec($ch);

    if ($body === false) {
        $error = curl_error($ch);
        curl_close($ch);
        throw new RuntimeException('cURL error: ' . $error);
    }

    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return [$status, $body];
}

try {
    echo "Step 1: GET /chatbot\n";
    [$statusGet, $html] = curlRequest("{$baseUrl}/chatbot", [
        CURLOPT_COOKIEJAR => $cookieFile,
        CURLOPT_COOKIEFILE => $cookieFile,
    ]);

    if ($statusGet !== 200) {
        throw new RuntimeException("GET /chatbot failed with HTTP {$statusGet}");
    }

    if (!preg_match('/meta name="csrf-token" content="([^"]+)"/', $html, $matches)) {
        throw new RuntimeException('CSRF token not found in chatbot page.');
    }

    $csrfToken = $matches[1];
    echo "Step 2: CSRF token captured\n";

    $payload = json_encode([
        'message' => 'Halo, tolong analisis performa saya dari data yang ada',
        'stats' => [
            'totalKills' => 120,
            'totalDamage' => 45000,
            'wins' => 8,
            'matches' => 60,
            'avgKills' => 2.0,
            'avgDamage' => 750,
        ],
    ], JSON_THROW_ON_ERROR);

    echo "Step 3: POST /chatbot/message\n";
    [$statusPost, $responseBody] = curlRequest("{$baseUrl}/chatbot/message", [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'X-CSRF-TOKEN: ' . $csrfToken,
        ],
        CURLOPT_COOKIEJAR => $cookieFile,
        CURLOPT_COOKIEFILE => $cookieFile,
    ]);

    echo "HTTP: {$statusPost}\n";
    echo $responseBody . "\n";
} catch (Throwable $e) {
    fwrite(STDERR, 'ERROR: ' . $e->getMessage() . PHP_EOL);
    exit(1);
}
