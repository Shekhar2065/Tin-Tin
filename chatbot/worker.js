const MODEL = "@cf/meta/llama-3.1-8b-instruct-fp8";
const MAX_MESSAGE_CHARS = 2000;
const MAX_HISTORY_ITEMS = 10;
const MAX_REQUEST_BYTES = 50_000;

const SYSTEM_PROMPT = `You are the concise, friendly website assistant for Tin-Tin Trekking & Adventure.
Help visitors understand Himalayan trekking and tour options and explain how personalized trip planning works.
Do not invent availability, prices, safety guarantees, permits, or booking confirmations.
When details depend on dates, route, conditions, or the traveler, recommend contacting the Tin-Tin team.
Keep answers clear and usually under 180 words.`;

export default {
  async fetch(request, env) {
    const url = new URL(request.url);
    const allowedOrigin = env.ALLOWED_ORIGIN;
    const requestOrigin = request.headers.get("Origin");

    if (url.pathname !== "/chat") {
      return jsonResponse({ error: "Not found." }, 404);
    }

    // Strict origin validation is in addition to browser-enforced CORS.
    if (!allowedOrigin || requestOrigin !== allowedOrigin) {
      return jsonResponse({ error: "Request not allowed." }, 403);
    }

    const corsHeaders = buildCorsHeaders(allowedOrigin);

    if (request.method === "OPTIONS") {
      return new Response(null, { status: 204, headers: corsHeaders });
    }

    if (request.method !== "POST") {
      return jsonResponse(
        { error: "Method not allowed." },
        405,
        corsHeaders,
        { Allow: "POST, OPTIONS" },
      );
    }

    if (!env.AI || !env.CHAT_RATE_LIMITER) {
      console.error("Chat Worker is missing a required binding.");
      return jsonResponse({ error: "Chat is temporarily unavailable." }, 503, corsHeaders);
    }

    const clientIp = request.headers.get("CF-Connecting-IP") || "unknown-client";
    let rateLimitResult;

    try {
      rateLimitResult = await env.CHAT_RATE_LIMITER.limit({ key: `chat:${clientIp}` });
    } catch (error) {
      console.error("Rate-limit check failed.", {
        type: error instanceof Error ? error.name : "UnknownError",
      });
      return jsonResponse({ error: "Chat is temporarily unavailable." }, 503, corsHeaders);
    }

    if (!rateLimitResult.success) {
      return jsonResponse(
        { error: "Too many messages. Please wait a moment and try again." },
        429,
        corsHeaders,
        { "Retry-After": "60" },
      );
    }

    const contentType = request.headers.get("Content-Type") || "";
    if (!contentType.toLowerCase().includes("application/json")) {
      return jsonResponse({ error: "A JSON request body is required." }, 415, corsHeaders);
    }

    const contentLength = Number(request.headers.get("Content-Length") || 0);
    if (Number.isFinite(contentLength) && contentLength > MAX_REQUEST_BYTES) {
      return jsonResponse({ error: "Request is too large." }, 413, corsHeaders);
    }

    let rawBody;
    try {
      rawBody = await request.text();
    } catch {
      return jsonResponse({ error: "Invalid request." }, 400, corsHeaders);
    }

    if (new TextEncoder().encode(rawBody).byteLength > MAX_REQUEST_BYTES) {
      return jsonResponse({ error: "Request is too large." }, 413, corsHeaders);
    }

    let body;
    try {
      body = JSON.parse(rawBody);
    } catch {
      return jsonResponse({ error: "Invalid JSON request." }, 400, corsHeaders);
    }

    const validation = validatePayload(body);
    if (!validation.ok) {
      return jsonResponse({ error: validation.error }, 400, corsHeaders);
    }

    const messages = [
      { role: "system", content: SYSTEM_PROMPT },
      ...validation.history,
      { role: "user", content: validation.message },
    ];

    try {
      const aiResponse = await env.AI.run(MODEL, {
        messages,
        max_tokens: 500,
        temperature: 0.3,
      });
      const reply = typeof aiResponse?.response === "string"
        ? aiResponse.response.trim()
        : "";

      if (!reply) {
        console.error("Workers AI returned no text content.");
        return jsonResponse({ error: "Chat is temporarily unavailable." }, 502, corsHeaders);
      }

      return jsonResponse({ reply }, 200, corsHeaders);
    } catch (error) {
      // Do not expose exception messages or stack traces to the browser.
      console.error("Chat request failed.", {
        type: error instanceof Error ? error.name : "UnknownError",
      });
      return jsonResponse({ error: "Chat is temporarily unavailable." }, 502, corsHeaders);
    }
  },
};

function validatePayload(body) {
  if (!body || typeof body !== "object" || Array.isArray(body)) {
    return { ok: false, error: "Invalid request body." };
  }

  if (typeof body.message !== "string") {
    return { ok: false, error: "Message must be text." };
  }

  const message = body.message.trim();
  if (!message) {
    return { ok: false, error: "Please enter a message." };
  }
  if (message.length > MAX_MESSAGE_CHARS) {
    return { ok: false, error: `Message must be ${MAX_MESSAGE_CHARS} characters or fewer.` };
  }

  const rawHistory = body.history ?? [];
  if (!Array.isArray(rawHistory)) {
    return { ok: false, error: "History must be an array." };
  }

  const history = rawHistory.slice(-MAX_HISTORY_ITEMS).map((item) => {
    if (!item || typeof item !== "object" || Array.isArray(item)) return null;
    if (item.role !== "user" && item.role !== "assistant") return null;
    if (typeof item.content !== "string") return null;

    const content = item.content.trim();
    if (!content || content.length > MAX_MESSAGE_CHARS) return null;
    return { role: item.role, content };
  });

  if (history.some((item) => item === null)) {
    return { ok: false, error: "History contains an invalid message." };
  }

  return { ok: true, message, history };
}

function buildCorsHeaders(origin) {
  return {
    "Access-Control-Allow-Origin": origin,
    "Access-Control-Allow-Methods": "POST, OPTIONS",
    "Access-Control-Allow-Headers": "Content-Type",
    "Access-Control-Max-Age": "86400",
    Vary: "Origin",
  };
}

function jsonResponse(payload, status = 200, corsHeaders = {}, additionalHeaders = {}) {
  return new Response(JSON.stringify(payload), {
    status,
    headers: {
      "Content-Type": "application/json; charset=utf-8",
      "Cache-Control": "no-store",
      "X-Content-Type-Options": "nosniff",
      ...corsHeaders,
      ...additionalHeaders,
    },
  });
}
