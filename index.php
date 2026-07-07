<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SolaraRoleplay</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <img src="assets/logo.png" alt="SolaraRoleplay logo" class="logo">
            <h1>SolaraRoleplay</h1>
            <nav>
                <a href="index.php">Forside</a>
                <a href="rules.php">Regler</a>
                <a href="applications.php">Ansøgninger</a>
                <a href="staff.php">Staff</a>
                <a href="support.php">Support</a>
                <a href="login.php">Login</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="hero">
            <h2>Velkommen til SolaraRoleplay</h2>
            <p>Et fællesskab med spændende historier, ordentlig rolleplay og engageret staff. Vi fokuserer på stærke roller, fair spil og et professionelt miljø.</p>
            <div id="server-status" style="margin-top:1rem"></div>
            <div style="margin-top:1rem">
                <a id="join-server" class="button" href="#">Join FiveM</a>
                <a id="join-discord" class="button secondary" href="#" target="_blank">Join Discord</a>
            </div>
        </section>

        <section class="grid" style="margin-top:1.5rem;">
            <div class="card">
                <h3>Regler</h3>
                <p>Læs vores retningslinjer for respekt, rolleplay og fair play.</p>
                <a class="button secondary" href="rules.php">Se regler</a>
            </div>
            <div class="card">
                <h3>Ansøgninger</h3>
                <p>Er du klar til at blive en del af serveren? Ansøg her.</p>
                <a class="button secondary" href="applications.php">Ansøg nu</a>
            </div>
            <div class="card">
                <h3>Staff</h3>
                <p>Se vores team og deres ansvar.</p>
                <a class="button secondary" href="staff.php">Se staff</a>
            </div>
        </section>

        <section class="card">
            <h2>Aktive spillere</h2>
            <div id="players">Henter status...</div>
        </section>
    </main>

    <script>
    async function loadStatus(){
        try{
            const res = await fetch('api/get_status.php');
            const data = await res.json();
            // data shape depends on FiveM payload; try to read players and jobs
            let html = '';
            if (data && Array.isArray(data.players)){
                html += `<p>Online: ${data.players.length}/${data.sv_maxclients ?? 'unknown'}</p>`;
                // count jobs
                const counts = {};
                data.players.forEach(p=>{ if(p.job){ counts[p.job] = (counts[p.job]||0)+1; }});
                html += '<ul>' + Object.keys(counts).slice(0,10).map(k=>`<li>${k}: ${counts[k]}</li>`).join('') + '</ul>';
            } else if (data && data.players) {
                html = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
            } else {
                html = 'Ingen status tilgængelig.';
            }
            document.getElementById('players').innerHTML = html;
        }catch(e){ document.getElementById('players').textContent = 'Fejl ved hentning af status'; }
        // set discord and join links from config fetch
        try{
            const cfgRes = await fetch('includes/config.php');
        }catch(e){ }
    }
    loadStatus();
    </script>
    <script src="js/app.js"></script>
</body>
</html>
