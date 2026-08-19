# Contributing to Tin-Tin Trekking

Thank you for helping improve the project. Keep changes small, reviewable, and safe for a PHP/MySQL production website.

## Before you start

- Read [README.md](README.md) and [SECURITY.md](SECURITY.md).
- Use PHP 8.1 or newer with the `mysqli` extension.
- Import `database/schema.sql` into a local MySQL or MariaDB instance when testing inquiry submissions.
- Never commit credentials, database exports, visitor inquiries, `.env`, `.dev.vars`, logs, or `.wrangler` output.
- Confirm that any new image, video, logo, font, or copy may legally be used in this project.

## Local workflow

1. Pull the latest `main` branch.
2. Create a focused branch, such as `feature/gallery-filter` or `fix/mobile-header`.
3. Make the smallest change that solves the issue.
4. Run the validation commands below.
5. Open a pull request and complete its checklist.

Do not commit directly to `main`. Avoid mixing formatting changes, generated files, or unrelated design edits into the same pull request.

## Validation

From the repository root in PowerShell:

```powershell
Get-ChildItem -Recurse -Filter *.php | ForEach-Object { php -l $_.FullName }
node --check assets/js/site.js
node --check assets/js/route-map.js
node --check chatbot/chat-widget.js
node --check chatbot/worker.js
git diff --check
```

Then run the site and manually check the homepage, all five trek pages, the inquiry forms, responsive navigation, gallery, maps, and chatbot launcher.

## Pull requests

- Explain the user-visible outcome and the files changed.
- Include screenshots for visual work at desktop and mobile widths.
- Call out schema, configuration, privacy, or deployment changes.
- Do not include real customer data in screenshots or test fixtures.
- Wait for CI and review before merging.

## Cloudflare Worker changes

The chatbot uses Cloudflare Workers AI. Work from `chatbot/`, keep account state out of Git, and review `chatbot/README.md` before deploying. Each developer should authenticate through Wrangler; credentials must never be copied into source files or pull requests.

Only an authorized maintainer should deploy the production Worker or change its allowed production origin.
