# SolaraRoleplay Website

Minimal PHP site for a FiveM server.

What this repo contains:

- Homepage with server status and join/Discord links
- Application form for new members
- Admin panel to approve/reject applications and add staff
- API endpoints for receiving FiveM server status

Setup (quick):

1. Edit `includes/config.php` and set `admin_password`, `discord_invite`, `fivem_connect` and `server_api_key`.
2. Ensure the `database/` folder is writable by the webserver. SQLite file is created at `database/solara.sqlite`.
3. Configure your FiveM resource to POST a JSON payload to `api/update_status.php?key=YOUR_KEY`.

Example FiveM snippet (pseudo):

```
PerformHttpRequest('https://your-site/api/update_status.php?key=YOUR_KEY',
	function(status, responseText) end,
	'POST', json.encode({ players = GetPlayers() }),
	{ ['Content-Type'] = 'application/json' }
)
```

If you prefer the README removed from the GitHub project page, tell me and I will delete or rename it instead.
