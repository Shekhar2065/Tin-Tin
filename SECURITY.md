# Security Policy

## Reporting a vulnerability

Please do not publish security vulnerabilities, credentials, customer information, or proof-of-concept attacks in a public issue.

Report concerns privately to `tintintrek@gmail.com` with:

- the affected page or component;
- steps to reproduce the problem;
- the potential impact; and
- any safe supporting evidence.

Do not access, change, download, or retain other people's data while testing. The project owner will review the report and coordinate a fix before public disclosure.

## Supported code

Security fixes are applied to the current `main` branch. Older commits, forks, demo deployments, and third-party services are not maintained by this repository.

## Secrets and access

- Store database credentials in server environment variables.
- Store any future Worker secrets with Wrangler's secret mechanism, never in `wrangler.toml` or JavaScript.
- Keep `.env`, `.dev.vars`, logs, database exports, and `.wrangler` directories untracked.
- Use separate development and production credentials with the minimum required permissions.
- Revoke and replace a credential immediately if it is pasted into chat, an issue, a commit, or a screenshot.
- Use GitHub branch protection, secret scanning, push protection, and least-privilege collaborator access where available.

## Production expectations

Before launch, the owner should review HTTPS, security headers, form abuse controls, CSRF protection, database access, backups, retention of inquiry data, and the final privacy policy. Never use the documented local `root` database account or an empty database password in production.
