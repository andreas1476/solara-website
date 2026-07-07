<?php
// Admin actions: approve/reject applications, add staff
$config = include __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
$db = solara_db();

$pass = $_POST['admin_password'] ?? '';
if ($pass !== $config['admin_password']) {
    http_response_code(403);
    echo json_encode(['error' => 'unauthorized']);
    exit;
}

$action = $_POST['action'] ?? '';
if ($action === 'approve' || $action === 'reject') {
    $id = intval($_POST['id'] ?? 0);
    $status = $action === 'approve' ? 'approved' : 'rejected';
    $stmt = $db->prepare('UPDATE applications SET status = :status WHERE id = :id');
    $stmt->execute([':status' => $status, ':id' => $id]);
    echo json_encode(['ok' => true]);
    exit;
}

if ($action === 'add_staff') {
    $name = trim($_POST['name'] ?? '');
    $role = trim($_POST['role'] ?? '');
    $resp = trim($_POST['responsibilities'] ?? '');
    $stmt = $db->prepare('INSERT INTO staff (name, role, responsibilities) VALUES (:name, :role, :resp)');
    $stmt->execute([':name'=>$name,':role'=>$role,':resp'=>$resp]);
    echo json_encode(['ok'=>true,'id'=>$db->lastInsertId()]);
    exit;
}

echo json_encode(['error' => 'invalid action']);
