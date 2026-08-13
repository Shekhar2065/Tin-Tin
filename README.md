# Tin-Tin Trekking & Adventure Demo

## Project overview

A responsive client-demo website for **Tin-Tin Trekking & Adventure (P) Ltd.** The primary journey is a five-step budget inquiry that creates a personalized-plan request without publishing fixed trek prices. The project includes a premium homepage, four data-driven trek pages, About and Contact pages, a working PHP form handler, and MySQL persistence.

The supplied client logo and these confirmed contact details are centralized in `includes/config.php`.

## Technology stack

- HTML5 and semantic PHP templates
- Tailwind CSS via the browser CDN for a no-build XAMPP demo
- Small custom CSS layer and vanilla JavaScript
- PHP 8+ with MySQLi prepared statements
- MySQL / MariaDB

No frontend framework, admin panel, login, payment system, or public fixed trek prices are included.

## Windows + XAMPP setup

1. Copy this folder to `xampp/htdocs/Tin-Tin`.
2. Start Apache and MySQL from the XAMPP Control Panel.
3. Import `database/schema.sql` through phpMyAdmin.
4. Visit `http://localhost/Tin-Tin/`.

The default local database settings are database `tin_tin_trekking`, user `root`, and an empty password. Use environment variables for other credentials; do not commit secrets.

## macOS + XAMPP setup

1. Copy the project into the XAMPP `htdocs` directory.
2. Start Apache and MySQL in the XAMPP manager.
3. Import `database/schema.sql` using phpMyAdmin.
4. Open the matching localhost project URL.

All application paths are relative and use web-safe `/` separators.

## MySQL database setup

Import `database/schema.sql`. The PHP connection reads these optional environment variables:

- `DB_HOST` (default `127.0.0.1`)
- `DB_NAME` (default `tin_tin_trekking`)
- `DB_USER` (default `root`)
- `DB_PASS` (default empty)

The form handler uses a prepared statement. Errors are logged server-side and do not expose database details to visitors.

## Running the website

Use XAMPP, PHP’s compatible local server, or normal PHP/MySQL hosting. For a quick local check from the project directory:

```bash
php -S 127.0.0.1:8080
```

Database submissions still require MySQL and the imported schema.

## GitHub workflow

Create a repository, commit source and optimized public assets, and use branches or pull requests for changes. Keep `.env`, credentials, logs, and editor files out of version control using the included `.gitignore`.

**GitHub Pages cannot run PHP or MySQL.** GitHub can host the source code and project history, but this website must run on XAMPP, PHP-compatible hosting, or another server with PHP and MySQL/MariaDB.

## Brand asset note

`assets/images/tin-tin-logo.png` is derived from the client-supplied logo image. If the client supplies an original high-resolution PNG/SVG, replace this file while keeping the same filename and artwork proportions.

## Generated visual assets

The Himalayan hero/card images were created with the built-in OpenAI image-generation tool for this demo. Prompts requested documentary-style Nepal Himalayan landscapes with no logos, text, watermarks, or identifiable close-up people.
