# SolaraRoleplay Website

Simple PHP site for a FiveM server providing:

- Homepage with server status and join/Discord links
- Application form for new members
- Admin panel to approve/reject applications and add staff
- API endpoints for FiveM server to POST status

Configuration:

1. Edit `includes/config.php` and set `admin_password`, `discord_invite`, `fivem_connect` and `server_api_key`.
2. Make the `database/` folder writable by the webserver. The site uses SQLite at `database/solara.sqlite`.
3. Configure your FiveM server or a resource to POST a JSON payload to `api/update_status.php?key=YOUR_KEY` periodically. Example payload is an object with `players` array (matching FiveM `players.json`).

Example FiveM resource (pseudo):
```
PerformHttpRequest('https://your-site/api/update_status.php?key=YOUR_KEY', function() end, 'POST', json.encode({players = GetPlayers()}), {['Content-Type'] = 'application/json'})
```
