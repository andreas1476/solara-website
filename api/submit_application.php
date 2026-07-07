<?php
// Handles application submissions from the website
require_once __DIR__ . '/../includes/db.php';
$db = solara_db();

$name = trim($_POST['name'] ?? '');
$discord = trim($_POST['discord'] ?? '');
$message = trim($_POST['message'] ?? '');
$job_pref = trim($_POST['job_pref'] ?? '');

if (!$name || !$discord) {
    http_response_code(400);
    echo json_encode(['error' => 'missing fields']);
    exit;
}

$stmt = $db->prepare('INSERT INTO applications (name, discord, message, job_pref) VALUES (:name, :discord, :message, :job_pref)');
$stmt->execute([
    ':name' => $name,
    ':discord' => $discord,
    ':message' => $message,
    ':job_pref' => $job_pref,
]);

echo json_encode(['ok' => true, 'id' => $db->lastInsertId()]);
