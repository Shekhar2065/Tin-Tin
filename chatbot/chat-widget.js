(function () {
  "use strict";

  // Read configuration now; document.currentScript may be unavailable later.
  const script = document.currentScript;
  const endpoint = script?.dataset.chatEndpoint?.trim() || "";
  const greeting =
    script?.dataset.greeting?.trim() ||
    "Namaste! How can I help you plan your Himalayan trip?";

  function initializeWidget() {
    if (document.getElementById("tt-chat-widget")) return;

    const root = document.createElement("div");
    root.id = "tt-chat-widget";
    root.innerHTML = `
      <div class="tt-chat-invite" aria-label="Chat greeting" hidden>
        <button class="tt-chat-invite-open" type="button" aria-controls="tt-chat-panel">
          <span class="tt-chat-invite-title">Namaste!</span>
          <span>How can I help you plan your Himalayan trip?</span>
        </button>
        <button class="tt-chat-invite-close" type="button" aria-label="Dismiss chat greeting">&times;</button>
      </div>
      <section class="tt-chat-panel" id="tt-chat-panel" role="dialog"
        aria-label="Trip planning chat" hidden>
        <header class="tt-chat-header">
          <div class="tt-chat-avatar" aria-hidden="true">TT</div>
          <div class="tt-chat-heading">
            <p class="tt-chat-title">Tin-Tin trip assistant</p>
            <p class="tt-chat-status">Ask about treks and trip planning</p>
          </div>
          <button class="tt-chat-close" type="button" aria-label="Close chat">
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M6 6l12 12M18 6L6 18" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round"/>
            </svg>
          </button>
        </header>
        <div class="tt-chat-messages" id="tt-chat-messages" role="log"
          aria-live="polite" aria-relevant="additions"></div>
        <form class="tt-chat-form">
          <textarea class="tt-chat-input" rows="1" maxlength="2000"
            placeholder="Type your question..." aria-label="Message" required></textarea>
          <button class="tt-chat-send" type="submit" aria-label="Send message">
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M21 3L10.6 13.4M21 3l-6.6 18-3.8-7.6L3 9.6 21 3z"
                fill="none" stroke="currentColor" stroke-width="1.8"
                stroke-linejoin="round" stroke-linecap="round"/>
            </svg>
          </button>
        </form>
      </section>
      <button class="tt-chat-launcher" type="button" aria-label="Open chat"
        aria-controls="tt-chat-panel" aria-expanded="false">
        <span class="tt-chat-unread" aria-hidden="true" hidden>1</span>
        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path d="M20 11.5a7.5 7.5 0 01-8 7.5 9.2 9.2 0 01-3.4-.65L4 20l1.45-4A7.2 7.2 0 014 11.5 7.5 7.5 0 0112 4a7.5 7.5 0 018 7.5z"
            fill="none" stroke="currentColor" stroke-width="1.8"
            stroke-linejoin="round"/>
        </svg>
      </button>`;
    document.body.appendChild(root);

    const panel = root.querySelector(".tt-chat-panel");
    const launcher = root.querySelector(".tt-chat-launcher");
    const unreadBadge = root.querySelector(".tt-chat-unread");
    const invite = root.querySelector(".tt-chat-invite");
    const inviteOpen = root.querySelector(".tt-chat-invite-open");
    const inviteClose = root.querySelector(".tt-chat-invite-close");
    const closeButton = root.querySelector(".tt-chat-close");
    const messages = root.querySelector(".tt-chat-messages");
    const form = root.querySelector(".tt-chat-form");
    const input = root.querySelector(".tt-chat-input");
    const sendButton = root.querySelector(".tt-chat-send");

    // Memory only: refreshing or leaving the page clears this conversation.
    const conversation = [];
    const inviteSessionKey = "tt-chat-invite-shown";
    const unreadSessionKey = "tt-chat-unread";
    let waiting = false;
    let inviteDismissed = hasSeenInvite();
    let audioContext = null;

    addMessage("assistant", greeting);
    setUnread(hasUnreadMessage());

    window.setTimeout(function () {
      if (panel.hidden && !inviteDismissed) {
        rememberInvite();
        invite.hidden = false;
        setUnread(true);
        const soundAttemptedAt = performance.now();
        prepareReplySound().then(function () {
          if (!invite.hidden && performance.now() - soundAttemptedAt < 500) playReplySound();
        });
      }
    }, 1200);

    // A prior visitor interaction lets browsers permit the later notification chime.
    document.addEventListener("pointerdown", prepareReplySound, { once: true, passive: true });
    document.addEventListener("keydown", prepareReplySound, { once: true });

    launcher.addEventListener("click", function () {
      const willOpen = panel.hidden;
      dismissInvite();
      panel.hidden = !willOpen;
      launcher.setAttribute("aria-expanded", String(willOpen));
      launcher.setAttribute("aria-label", willOpen ? "Close chat" : "Open chat");
      if (willOpen) {
        setUnread(false);
        input.focus();
      }
    });

    inviteOpen.addEventListener("click", function () {
      dismissInvite();
      panel.hidden = false;
      launcher.setAttribute("aria-expanded", "true");
      launcher.setAttribute("aria-label", "Close chat");
      setUnread(false);
      input.focus();
    });

    inviteClose.addEventListener("click", dismissInvite);

    closeButton.addEventListener("click", closeChat);

    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape" && !panel.hidden) closeChat();
    });

    input.addEventListener("input", resizeInput);
    input.addEventListener("keydown", function (event) {
      if (event.key === "Enter" && !event.shiftKey) {
        event.preventDefault();
        form.requestSubmit();
      }
    });

    form.addEventListener("submit", async function (event) {
      event.preventDefault();
      if (waiting) return;

      const message = input.value.trim();
      if (!message) return;

      prepareReplySound();

      // Snapshot history before adding this new user turn.
      const history = conversation.slice(-10);
      addMessage("user", message);
      input.value = "";
      resizeInput();
      setWaiting(true);
      const typing = addTypingIndicator();

      try {
        if (!endpoint || !/^https?:\/\//i.test(endpoint)) {
          throw new Error("Widget endpoint is not configured");
        }

        const response = await fetch(endpoint, {
          method: "POST",
          mode: "cors",
          credentials: "omit",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ message, history }),
        });

        let data = null;
        try {
          data = await response.json();
        } catch {
          // Hide malformed or internal server details from visitors.
        }

        if (!response.ok || typeof data?.reply !== "string" || !data.reply.trim()) {
          throw new Error("Chat request failed");
        }

        conversation.push(
          { role: "user", content: message },
          { role: "assistant", content: data.reply },
        );
        addMessage("assistant", data.reply);
        playReplySound();
        if (panel.hidden) setUnread(true);
      } catch (error) {
        console.warn("Tin-Tin chat is unavailable", {
          name: error instanceof Error ? error.name : "UnknownError",
        });
        addMessage(
          "error",
          "Sorry, I couldn't send that message. Please try again in a moment.",
        );
      } finally {
        typing.remove();
        setWaiting(false);
        input.focus();
      }
    });

    function closeChat() {
      panel.hidden = true;
      launcher.setAttribute("aria-expanded", "false");
      launcher.setAttribute("aria-label", "Open chat");
      launcher.focus();
    }

    function dismissInvite() {
      inviteDismissed = true;
      rememberInvite();
      invite.hidden = true;
    }

    function hasSeenInvite() {
      try {
        return window.sessionStorage.getItem(inviteSessionKey) === "1";
      } catch {
        return false;
      }
    }

    function rememberInvite() {
      inviteDismissed = true;
      try {
        window.sessionStorage.setItem(inviteSessionKey, "1");
      } catch {
        // Keep the in-memory value when browser storage is unavailable.
      }
    }

    function hasUnreadMessage() {
      try {
        return window.sessionStorage.getItem(unreadSessionKey) === "1";
      } catch {
        return false;
      }
    }

    function setUnread(value) {
      unreadBadge.hidden = !value;
      try {
        if (value) {
          window.sessionStorage.setItem(unreadSessionKey, "1");
        } else {
          window.sessionStorage.removeItem(unreadSessionKey);
        }
      } catch {
        // The visible badge still works when browser storage is unavailable.
      }
      launcher.setAttribute(
        "aria-label",
        value && panel.hidden ? "Open chat, 1 unread message" : panel.hidden ? "Open chat" : "Close chat",
      );
    }

    function addMessage(role, text) {
      const wrapper = document.createElement("div");
      wrapper.className = `tt-chat-message tt-chat-message--${role}`;
      const bubble = document.createElement("p");
      bubble.className = "tt-chat-bubble";
      // textContent prevents user/API content from becoming executable HTML.
      bubble.textContent = text;
      wrapper.appendChild(bubble);
      messages.appendChild(wrapper);
      scrollToLatest();
      return wrapper;
    }

    function addTypingIndicator() {
      const wrapper = document.createElement("div");
      wrapper.className = "tt-chat-message tt-chat-message--assistant";
      wrapper.setAttribute("aria-label", "Assistant is typing");
      wrapper.innerHTML = `<div class="tt-chat-bubble tt-chat-typing" aria-hidden="true">
        <span></span><span></span><span></span></div>`;
      messages.appendChild(wrapper);
      scrollToLatest();
      return wrapper;
    }

    function setWaiting(value) {
      waiting = value;
      input.disabled = value;
      sendButton.disabled = value;
    }

    function resizeInput() {
      input.style.height = "auto";
      input.style.height = `${Math.min(input.scrollHeight, 116)}px`;
    }

    function scrollToLatest() {
      requestAnimationFrame(function () {
        messages.scrollTop = messages.scrollHeight;
      });
    }

    function prepareReplySound() {
      try {
        const AudioContext = window.AudioContext || window.webkitAudioContext;
        if (!AudioContext) return Promise.resolve();
        if (!audioContext) audioContext = new AudioContext();
        if (audioContext.state === "suspended") {
          return audioContext.resume().catch(function () {});
        }
      } catch {
        audioContext = null;
      }
      return Promise.resolve();
    }

    function playReplySound() {
      if (!audioContext || audioContext.state !== "running") return;
      const now = audioContext.currentTime;
      const gain = audioContext.createGain();
      gain.gain.setValueAtTime(0.0001, now);
      gain.gain.exponentialRampToValueAtTime(0.035, now + 0.015);
      gain.gain.exponentialRampToValueAtTime(0.0001, now + 0.22);
      gain.connect(audioContext.destination);

      [659.25, 880].forEach(function (frequency, index) {
        const oscillator = audioContext.createOscillator();
        oscillator.type = "sine";
        oscillator.frequency.value = frequency;
        oscillator.connect(gain);
        oscillator.start(now + index * 0.055);
        oscillator.stop(now + 0.18 + index * 0.055);
      });
    }
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initializeWidget, { once: true });
  } else {
    initializeWidget();
  }
})();
