<?php
// Simple admin panel to view applications and approve/reject
$config = include __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
$db = solara_db();

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (($_POST['admin_password'] ?? '') !== $config['admin_password']) {
        $err = 'Forkert adgangskode';
    }
}

$apps = $db->query('SELECT * FROM applications ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="da">
<head><meta charset="utf-8"><title>Admin - Solara</title><link rel="stylesheet" href="../css/style.css"></head>
<body>
<div class="container">
<h1>Admin - Ansøgninger</h1>
<?php if($err): ?><div class="card"><?=htmlspecialchars($err)?></div><?php endif; ?>
<form method="post" id="adminAuth">
    <label>Admin password: <input type="password" name="admin_password" required></label>
</form>
<div id="apps">
<?php foreach($apps as $a): ?>
    <div class="card">
        <h3><?=htmlspecialchars($a['name'])?> — <?=htmlspecialchars($a['discord'])?></h3>
        <p><?=nl2br(htmlspecialchars($a['message']))?></p>
        <p>Status: <?=htmlspecialchars($a['status'])?></p>
        <button onclick="adminAction('approve',<?=$a['id']?>)">Godkend</button>
        <button onclick="adminAction('reject',<?=$a['id']?>)">Afvis</button>
    </div>
<?php endforeach; ?>
</div>
<h2>Staff</h2>
<div id="staffList">
<?php $st = $db->query('SELECT * FROM staff ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC); foreach($st as $s): ?>
    <div class="card"><strong><?=htmlspecialchars($s['name'])?></strong> — <?=htmlspecialchars($s['role'])?><br><?=nl2br(htmlspecialchars($s['responsibilities']))?></div>
<?php endforeach; ?>
</div>
<h3>Tilføj staff</h3>
<form id="addStaff">
    <label>Navn: <input name="name" required></label><br>
    <label>Role: <input name="role"></label><br>
    <label>Ansvar: <textarea name="responsibilities"></textarea></label><br>
    <label>Admin password: <input type="password" name="admin_password" required></label><br>
    <button type="submit">Tilføj</button>
 </form>
</div>
<script>
async function adminAction(action,id){
    const pwd = document.querySelector('#adminAuth [name="admin_password"]').value;
    if(!pwd){ alert('Indtast admin password øverst'); return; }
    const fd = new FormData(); fd.append('admin_password', pwd); fd.append('action', action); fd.append('id', id);
    const res = await fetch('../api/admin_action.php', {method:'POST', body:fd});
    const j = await res.json(); if(j.ok) location.reload(); else alert('Fejl');
}
document.getElementById('addStaff').addEventListener('submit', async e=>{
    e.preventDefault(); const fd = new FormData(e.target);
    const res = await fetch('../api/admin_action.php', {method:'POST', body:fd}); const j = await res.json();
    if(j.ok) location.reload(); else alert('Fejl: '+(j.error||''));
});
</script>
</body>
</html>
