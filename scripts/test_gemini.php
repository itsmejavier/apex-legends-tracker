<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

Dotenv\Dotenv::createImmutable(__DIR__ . '/..')->safeLoad();

$key = $_ENV['GOOGLE_GEMINI_API_KEY'] ?? '';
$model = $_ENV['GOOGLE_GEMINI_MODEL'] ?? 'gemini-1.5-pro';

if ($key === '') {
    fwrite(STDERR, "GOOGLE_GEMINI_API_KEY is empty\n");
    exit(1);
}

$url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$key}";
$payload = json_encode([
    'contents' => [
        [
            'parts' => [
                ['text' => 'Reply with only: OK'],
            ],
        ],
    ],
], JSON_THROW_ON_ERROR);

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => $payload,
]);

$response = curl_exec($ch);

if ($response === false) {
    echo 'CURL_ERR: ' . curl_error($ch) . PHP_EOL;
    curl_close($ch);
    exit(2);
}

$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo 'HTTP: ' . $status . PHP_EOL;
echo substr($response, 0, 600) . PHP_EOL;
