# Tin-Tin AI chat widget

This folder contains a dependency-free browser widget and a Cloudflare Worker
that uses Cloudflare Workers AI. The deployed Worker uses the
`@cf/meta/llama-3.1-8b-instruct-fp8` model and does not require an Anthropic API
key.

## Files

- `worker.js` — secure `/chat` API endpoint
- `wrangler.toml` — Worker, Workers AI and rate-limit bindings
- `chat-widget.js` — browser widget behavior
- `chat-widget.css` — responsive widget styles

## Free allowance

Cloudflare Workers AI currently includes 10,000 neurons per day on the Workers
Free plan. The allowance resets daily. When it is exhausted, further AI calls
fail until the next reset; this project does not automatically upgrade the
account or create overage charges.

## Configure and deploy

In `wrangler.toml`, set `ALLOWED_ORIGIN` to the exact website origin. An origin
contains the scheme and hostname, plus a port when non-standard, but no path or
trailing slash.

For XAMPP at `http://localhost/Tin-Tin/`:

```toml
ALLOWED_ORIGIN = "http://localhost"
```

For production:

```toml
ALLOWED_ORIGIN = "https://www.tintintrekking.com"
```

Deploy from this folder:

```powershell
wrangler.cmd deploy
```

The current endpoint is:

```text
https://tin-tin-website-chat.thapasther101.workers.dev/chat
```

## Embed the widget

Load the stylesheet in the page head:

```html
<link rel="stylesheet" href="/chatbot/chat-widget.css">
```

Load the widget near the end of the page:

```html
<script
  src="/chatbot/chat-widget.js"
  data-chat-endpoint="https://tin-tin-website-chat.thapasther101.workers.dev/chat"
  data-greeting="Namaste! How can I help you plan your Himalayan trip?"
  defer
></script>
```

The Tin-Tin site already includes these tags through `includes/header.php` and
`includes/footer.php`.

## Security and limits

- CORS accepts only the exact `ALLOWED_ORIGIN` value.
- The rate limiter allows 20 requests per 60 seconds for each connecting IP.
- Messages are limited to 2,000 characters and the final 10 history items.
- Request bodies are capped at 50 KB and AI output is capped at 500 tokens.
- Chat text is not written to Worker logs by this code.
- Change `ALLOWED_ORIGIN` to the production origin before launching the site.

## Test

Open `http://localhost/Tin-Tin/index.php`, select the chat launcher and send a
short question. A successful `/chat` response has this shape:

```json
{"reply":"..."}
```

The model and system prompt can be changed near the top of `worker.js`.
