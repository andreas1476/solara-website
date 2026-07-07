<?php
// Endpoint for FiveM server or admin to POST JSON status payload
$config = include __DIR__ . '/../includes/config.php';
// simple key check
$key = $_GET['key'] ?? $_POST['key'] ?? null;
if ($key !== $config['server_api_key']) {
    http_response_code(403);
    echo json_encode(['error' => 'invalid key']);
    exit;
}

$payload = file_get_contents('php://input');
if (empty($payload)) {
    echo json_encode(['error' => 'empty payload']);
    exit;
}

require_once __DIR__ . '/../includes/db.php';
$db = solara_db();
$stmt = $db->prepare('INSERT INTO status (payload) VALUES (:payload)');
$stmt->execute([':payload' => $payload]);

echo json_encode(['ok' => true]);
