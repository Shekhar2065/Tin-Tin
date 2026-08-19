# Tin-Tin Trekking & Adventure

A responsive PHP website for **Tin-Tin Trekking & Adventure (P) Ltd.** Visitors can explore Himalayan destinations, compare trek information, browse galleries and maps, chat with an AI trip assistant, and submit a five-step personalized trip inquiry without relying on fixed public package prices.

The site currently includes five data-driven trek pages:

- Everest Base Camp
- Annapurna Base Camp
- Langtang Valley
- Manaslu Circuit
- Upper Dolpo

Business details and shared URLs are centralized in `includes/config.php`. Trek content is centralized in `data/treks.php`, and the shared trek template is in `includes/trek-detail.php`.

## Technology stack

- PHP 8.1+ with semantic templates and the `mysqli` extension
- MySQL or MariaDB
- Tailwind CSS through the browser CDN
- Project CSS and dependency-free browser JavaScript
- Leaflet with OpenStreetMap tiles for interactive trek maps
- Cloudflare Workers AI for the optional chatbot backend

There is no frontend framework, Composer dependency, npm build, admin panel, login, or payment system.

## Prerequisites

For the website:

- PHP 8.1 or newer with `mysqli`
- MySQL 8+ or a compatible MariaDB release
- A local web server such as XAMPP, or PHP's built-in server for page testing
- A modern browser

For chatbot development or deployment:

- Node.js 20 or newer
- Wrangler 4, either installed separately or run with `npx`
- An authorized Cloudflare account with Workers AI access

## Windows and XAMPP setup

1. Clone or copy the repository to `C:\xampp\htdocs\Tin-Tin`.
2. Start Apache and MySQL from the XAMPP Control Panel.
3. Import `database/schema.sql` through phpMyAdmin.
4. Visit `http://localhost/Tin-Tin/`.

The development defaults are:

- Host: `127.0.0.1`
- Database: `tin_tin_trekking`
- User: `root`
- Password: empty

These defaults are for a local XAMPP installation only. Never use the MySQL `root` account or an empty password in production.

## macOS or Linux setup

1. Put the project inside the web server's document root, or clone it anywhere for use with PHP's built-in server.
2. Start MySQL or MariaDB.
3. Import `database/schema.sql`.
4. Configure the database environment variables described below.
5. Open the matching local URL.

All application URLs are generated with web-safe `/` separators.

## Database configuration

The PHP connection reads these process environment variables:

- `DB_HOST` — default `127.0.0.1`
- `DB_NAME` — default `tin_tin_trekking`
- `DB_USER` — default `root`
- `DB_PASS` — default empty
- `APP_ENV` — set to `production` on the live server; local default is `development`
- `CHAT_ENDPOINT` — public HTTPS URL of the deployed Worker `/chat` route

For example, in PowerShell:

```powershell
$env:DB_HOST = '127.0.0.1'
$env:DB_NAME = 'tin_tin_trekking'
$env:DB_USER = 'tin_tin_app'
$env:DB_PASS = 'replace-with-a-local-password'
$env:CHAT_ENDPOINT = 'https://your-worker.your-subdomain.workers.dev/chat'
php -S 127.0.0.1:8080
```

Then open `http://127.0.0.1:8080/`.

The repository ignores `.env` files as a safety measure, but the application does **not** automatically load them. Set variables in the PHP/Apache process environment unless the team deliberately adds and documents an environment loader.

Inquiry submissions require the database. Normal page browsing does not. Use fictional test data only; never commit a database export containing visitor information.

## Chatbot and Cloudflare Workers AI

The browser widget is in `chatbot/chat-widget.js`; the API Worker is in `chatbot/worker.js`. The Worker uses Cloudflare Workers AI and does not require an Anthropic or OpenAI API key.

Before deploying from a new Cloudflare account:

1. Open `chatbot/wrangler.toml`.
2. Choose a Worker `name` available to that account.
3. Set `ALLOWED_ORIGIN` to the exact website origin, with no path or trailing slash.
4. Confirm that the rate-limit `namespace_id` is appropriate for that account.
5. Authenticate and deploy:

```powershell
cd chatbot
npx wrangler@4 login
npx wrangler@4 deploy
```

After deployment, set the PHP server's `CHAT_ENDPOINT` environment variable to the new `/chat` URL. `includes/footer.php` reads it through the shared configuration, so teammates do not need to edit templates. Production fails closed and does not render the widget when this value is missing. The development-only fallback endpoint belongs to the existing deployment and does not grant access to its Cloudflare account.

Wrangler account state and generated deployment bundles belong in `.wrangler/` and are ignored by Git. If the Worker ever needs a true secret, store it using Wrangler's secret mechanism rather than `wrangler.toml` or source code.

Workers AI availability, quotas, and pricing can change. Check the authorized Cloudflare account dashboard and current Cloudflare documentation before production launch.

More Worker-specific behavior and limits are documented in `chatbot/README.md`.

## Validation

Run these checks from the repository root before opening a pull request:

```powershell
Get-ChildItem -Recurse -Filter *.php | ForEach-Object { php -l $_.FullName }
node --check assets/js/site.js
node --check assets/js/route-map.js
node --check chatbot/chat-widget.js
node --check chatbot/worker.js
git diff --check
```

The GitHub Actions workflow repeats syntax checks and smoke-tests the main public pages. Also perform a browser check at desktop and mobile widths for visual changes.

## Team workflow

1. Pull the current `main` branch.
2. Create a small feature or fix branch.
3. Keep generated files, secrets, customer data, and unrelated formatting out of the commit.
4. Run the validation commands.
5. Open a pull request using the included template.
6. Merge only after CI passes and review is complete.

See [CONTRIBUTING.md](CONTRIBUTING.md) for the full checklist. Protect `main`, require pull requests, and enable GitHub secret scanning and push protection where available. Authenticate to GitHub with Git Credential Manager or `gh auth login`; never place a personal access token in a remote URL.

## Production deployment checklist

- Use PHP-compatible hosting; GitHub Pages cannot execute PHP or MySQL.
- Set `APP_ENV=production`, create a least-privilege production database user, and set all `DB_*` variables securely. Production intentionally refuses the local `root`/empty-password defaults.
- Serve the site over HTTPS.
- Point the web server at a dedicated public document root when possible. On Apache, keep the root `.htaccess` enabled; on Nginx or another server, reproduce its deny rules for repository metadata, configuration, schema, and build files.
- Import and back up the production schema through an approved process.
- Deploy the chatbot from the authorized Cloudflare account, set the production origin, and update its endpoint.
- Compile and self-host Tailwind before production instead of relying on the browser Play CDN; this allows a stricter Content Security Policy without an inline script exception.
- Put the public forms behind a host-level rate rule or Cloudflare Turnstile/WAF in addition to the built-in session and IP throttles.
- Review security headers, CSRF protection, form abuse controls, validation limits, logging, and backup access.
- Approve the final privacy policy and define who may access and delete inquiry data.
- Verify all contact, review, social, association, and certification links.
- Confirm media, logo, and written-content permissions.

Read [SECURITY.md](SECURITY.md) before launch or when handling a vulnerability report.

## Repository and secrets

Safe-to-share source should never include:

- API keys, passwords, tokens, or private keys;
- `.env` or `.dev.vars` files;
- `.wrangler` account caches or deployment bundles;
- visitor inquiries, database exports, or production logs; or
- screenshots containing private account or customer information.

If a credential is pasted into chat, a commit, an issue, or a screenshot, revoke and replace it immediately even if it is later deleted. Removing a secret from the newest commit does not remove it from Git history.

## Brand, media, and licensing

`assets/images/tin-tin-logo.png` is based on client-supplied branding. Replace it only with an owner-approved asset while preserving its intended proportions.

The active close-up Himalayan hero video is sourced from Pexels. Generated images, hosted libraries, map attribution, platform logos, and other ownership notes are recorded in [THIRD_PARTY_NOTICES.md](THIRD_PARTY_NOTICES.md).

This repository currently has no open-source license. Public visibility does not grant permission to copy, redistribute, or commercially reuse the code, client branding, or media. The owner should choose a license only after confirming client and asset rights.
