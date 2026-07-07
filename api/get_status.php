<?php
// Returns latest saved status as JSON
require_once __DIR__ . '/../includes/db.php';
$db = solara_db();
$row = $db->query('SELECT payload, updated_at FROM status ORDER BY id DESC LIMIT 1')->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    echo json_encode(['players' => 0, 'raw' => null]);
    exit;
}

header('Content-Type: application/json');
echo $row['payload'];
