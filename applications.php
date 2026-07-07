<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ansøgninger - SolaraRoleplay</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <img src="assets/logo.png" alt="SolaraRoleplay logo" class="logo">
            <h1>Ansøgninger</h1>
        </div>
    </header>

    <main class="container">
        <section class="card">
            <h2>Ansøg om medlemsskab</h2>
            <p>Send en kort besked om dig selv og hvorfor du vil være en del af community'et.</p>
            <form id="appForm">
                <label>Navn:<br><input type="text" name="name" required></label><br>
                <label>Discord:<br><input type="text" name="discord" required></label><br>
                <label>Job præference (fx police, ems):<br><input type="text" name="job_pref"></label><br>
                <label>Fortæl om dig selv:<br><textarea name="message"></textarea></label><br>
                <button type="submit">Send ansøgning</button>
            </form>
            <div id="appResult" style="margin-top:1rem"></div>
        </section>
    </main>
    <script>
    document.getElementById('appForm').addEventListener('submit', async e=>{
        e.preventDefault();
        const form = e.currentTarget;
        const data = new FormData(form);
        const res = await fetch('api/submit_application.php', {method:'POST', body:data});
        const json = await res.json();
        if (json.ok) document.getElementById('appResult').textContent = 'Ansøgning sendt!';
        else document.getElementById('appResult').textContent = 'Fejl: ' + (json.error||'');
        form.reset();
    });
    </script>

    <script src="js/app.js"></script>
</body>
</html>
