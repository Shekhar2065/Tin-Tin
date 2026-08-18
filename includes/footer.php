</main>

<footer class="tin-footer overflow-hidden bg-white" aria-label="Website footer">
  <div class="tin-footer-mountains relative w-full overflow-hidden" aria-hidden="true">
    <img class="tin-footer-mountain-art absolute inset-0 h-full w-full object-cover object-bottom" src="<?= url('assets/images/footer/nepal-footer-panorama.png') ?>" alt="">
  </div>

  <div class="tin-footer-main relative -mt-px bg-[#0b0b0b] text-blue-50">
    <div class="footer-contained">
      <section class="footer-budget-row grid gap-7 border-b border-white/15 py-11 md:grid-cols-[1fr_auto] md:items-center lg:py-14" aria-labelledby="footer-budget-heading">
        <div>
          <p class="text-[11px] font-bold uppercase tracking-[.2em] text-[#91D2B6]">A journey designed around you</p>
          <h2 id="footer-budget-heading" class="mt-3 font-display text-3xl text-white md:text-4xl">Tell Us Your Budget</h2>
          <p class="mt-3 max-w-2xl text-sm leading-7 text-blue-100/80">Share your budget and travel preferences, and we&rsquo;ll help design a trip around them.</p>
        </div>
        <a class="footer-budget-button inline-flex min-h-12 items-center justify-center gap-3 bg-[#237A57] px-6 text-xs font-bold uppercase tracking-[.1em] text-white transition hover:bg-white hover:text-[#0b0b0b] focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-[#0b0b0b]" href="<?= url('budget-plan.php') ?>">Plan My Trip <span aria-hidden="true">&rarr;</span></a>
      </section>

      <div class="footer-column-grid grid gap-11 py-14 md:grid-cols-2 lg:grid-cols-[1.25fr_repeat(3,minmax(0,1fr))] lg:gap-12 lg:py-16">
        <div class="footer-brand-column">
          <a class="footer-brand-logo" href="<?= url('index.php') ?>" aria-label="Tin-Tin Trekking home">
            <img src="<?= url('assets/images/tin-tin-logo.png') ?>" alt="Tin-Tin Trekking &amp; Adventure logo">
          </a>
          <p class="mt-6 max-w-sm text-sm leading-7 text-blue-100/75">Explore Nepal and the Himalayas with carefully designed trekking and tour experiences built around your interests and budget.</p>
          <address class="footer-address mt-5 space-y-2 text-sm not-italic text-blue-100/75">
            <p><?= e(SITE['address']) ?></p>
            <a class="block transition hover:text-white" href="tel:+9779851044230"><?= e(SITE['mobile']) ?></a>
            <a class="block transition hover:text-white" href="mailto:<?= e(SITE['email']) ?>"><?= e(SITE['email']) ?></a>
          </address>
        </div>

        <nav aria-labelledby="footer-activities-heading">
          <h2 id="footer-activities-heading" class="text-xl font-bold text-white">Activities</h2>
          <div class="footer-link-list mt-5 flex flex-col items-start gap-3 text-sm text-blue-100/75">
            <a class="transition hover:text-white" href="<?= url('index.php#treks') ?>">Trekking in Nepal</a>
            <a class="transition hover:text-white" href="<?= url('index.php#treks') ?>">Nepal Tour Packages</a>
            <a class="transition hover:text-white" href="<?= url('index.php#treks') ?>">Peak Climbing</a>
            <a class="transition hover:text-white" href="<?= url('index.php#treks') ?>">Adventure Activities</a>
            <a class="transition hover:text-white" href="<?= url('index.php#treks') ?>">Cultural Tours</a>
          </div>
        </nav>

        <nav aria-labelledby="footer-company-heading">
          <h2 id="footer-company-heading" class="text-xl font-bold text-white">Company</h2>
          <div class="footer-link-list mt-5 flex flex-col items-start gap-3 text-sm text-blue-100/75">
            <a class="transition hover:text-white" href="<?= url('about.php') ?>">About Us</a>
            <a class="transition hover:text-white" href="<?= url('about.php#vision') ?>">Our Vision</a>
            <a class="transition hover:text-white" href="<?= url('about.php') ?>">Our Team</a>
            <a class="transition hover:text-white" href="<?= url('index.php#why-tintin') ?>">Why Choose Us</a>
            <a class="transition hover:text-white" href="<?= url('contact.php') ?>">Contact Us</a>
          </div>
        </nav>

        <div>
          <nav aria-labelledby="footer-useful-heading">
            <h2 id="footer-useful-heading" class="text-xl font-bold text-white">Useful Links</h2>
            <div class="footer-link-list mt-5 flex flex-col items-start gap-3 text-sm text-blue-100/75">
              <a class="transition hover:text-white" href="<?= url('index.php#journal') ?>">Travel Blogs</a>
              <a class="transition hover:text-white" href="<?= url('index.php#journal') ?>">Trekking Guide</a>
              <a class="transition hover:text-white" href="<?= url('budget-plan.php') ?>">Plan Your Trip</a>
              <a class="transition hover:text-white" href="<?= url('index.php#faq') ?>">FAQs</a>
              <a class="transition hover:text-white" href="<?= url('terms.php') ?>">Terms &amp; Conditions</a>
            </div>
          </nav>

          <form class="mt-8" data-footer-newsletter novalidate>
            <label class="text-sm font-semibold text-white" for="footer-newsletter-email">Subscribe to Our Newsletter</label>
            <div class="footer-newsletter-fields mt-3 flex">
              <input id="footer-newsletter-email" class="min-w-0 flex-1 border border-white/20 bg-white/10 px-3 py-3 text-sm text-white outline-none placeholder:text-blue-100/50 focus:border-[#91D2B6]" name="newsletter_email" type="email" autocomplete="email" placeholder="Email address" required>
              <button class="bg-[#237A57] px-4 text-xs font-bold text-white transition hover:bg-[#2F936B] focus:outline-none focus:ring-2 focus:ring-white" type="submit">Subscribe</button>
            </div>
            <p class="mt-2 min-h-5 text-xs leading-5 text-blue-100/65" data-newsletter-status aria-live="polite">Newsletter service will be connected before launch.</p>
          </form>
        </div>
      </div>

      <section class="footer-trust-connect" aria-label="Travel platforms and contact channels">
        <div class="footer-platform-list">
          <h2>Find us on:</h2>
          <a class="footer-platform footer-platform-google" href="<?= e(SITE['google_reviews_url']) ?>" target="_blank" rel="noopener"><span>G</span>Google Reviews</a>
          <a class="footer-platform footer-platform-tripadvisor" href="<?= e(SITE['tripadvisor_reviews_url']) ?>" target="_blank" rel="noopener"><span>●</span>Tripadvisor</a>
          <a class="footer-platform" href="https://www.taan.org.np/members/968" target="_blank" rel="noopener"><span>✓</span>TAAN Member</a>
          <a class="footer-platform" href="https://trade.ntb.gov.np/useful_contacts/tin-tin-trekking-adventure-p-ltd/" target="_blank" rel="noopener"><span>◆</span>Nepal Tourism Board</a>
        </div>

        <div class="footer-connect-list">
          <h2>Connect with us:</h2>
          <a class="footer-connect-button footer-connect-whatsapp" href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noopener" aria-label="WhatsApp Tin-Tin Trekking">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 11.7a8 8 0 0 1-11.8 7L4 20l1.3-4A8 8 0 1 1 20 11.7Z"/><path d="M9 8.5c.6 2.2 2.1 3.7 4.5 4.5l1-1 2 .8c-.2 1.5-1.2 2.3-2.7 2.2-3.9-.3-7-3.4-7.3-7.3-.1-1.5.7-2.5 2.2-2.7l.8 2-1 1Z"/></svg>
          </a>
          <a class="footer-connect-button footer-connect-email" href="mailto:<?= e(SITE['email']) ?>" aria-label="Email Tin-Tin Trekking">
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg>
          </a>
          <a class="footer-connect-button footer-connect-phone" href="tel:+9779851044230" aria-label="Call Tin-Tin Trekking">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 3 4 5c0 8 7 15 15 15l2-3-4-3-2 2c-3-1-6-4-7-7l2-2-3-4Z"/></svg>
          </a>
        </div>
      </section>

      <section class="footer-contact-panel" aria-label="Tin-Tin Trekking contact and verification">
        <article class="footer-contact-block">
          <h2>Tin-Tin Trekking</h2>
          <address>
            <p><span aria-hidden="true">●</span><?= e(SITE['address']) ?></p>
            <a href="mailto:<?= e(SITE['email']) ?>"><span aria-hidden="true">✉</span><?= e(SITE['email']) ?></a>
            <a href="tel:+9779851044230"><span aria-hidden="true">☎</span><?= e(SITE['mobile']) ?></a>
          </address>
        </article>

        <article class="footer-representative-block">
          <h2>Speak with our representative</h2>
          <div class="footer-representative">
            <span class="footer-representative-avatar" aria-hidden="true">SD</span>
            <div><small>NEPAL</small><strong>Suresh Dongol</strong><a href="tel:+9779851044230"><?= e(SITE['mobile']) ?></a></div>
            <a class="footer-representative-whatsapp" href="<?= e(whatsapp_url('Hello Suresh, I would like to plan a Himalayan trip.')) ?>" target="_blank" rel="noopener" aria-label="Message Suresh Dongol on WhatsApp">●</a>
          </div>
        </article>

        <article class="footer-verification-block">
          <h2>Verified listings</h2>
          <a href="https://www.taan.org.np/members/968" target="_blank" rel="noopener"><strong>TAAN</strong><span>Member listing ↗</span></a>
          <a href="https://trade.ntb.gov.np/useful_contacts/tin-tin-trekking-adventure-p-ltd/" target="_blank" rel="noopener"><strong>NTB</strong><span>Nepal Tourism Board ↗</span></a>
        </article>
      </section>

      <div class="footer-bottom-bar flex flex-col gap-4 border-t border-white/15 py-6 text-xs text-blue-100/60 sm:flex-row sm:items-center sm:justify-between">
        <p>&copy; <?= date('Y') ?> <?= e(SITE['name']) ?>. All rights reserved.</p>
        <nav class="flex gap-5" aria-label="Legal links">
          <a class="transition hover:text-white" href="<?= url('privacy.php') ?>">Privacy Policy</a>
          <a class="transition hover:text-white" href="<?= url('terms.php') ?>">Terms &amp; Conditions</a>
        </nav>
      </div>
    </div>
  </div>
</footer>

<a href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noopener" class="tin-footer-whatsapp fixed bottom-5 left-5 z-50 grid h-14 w-14 place-items-center rounded-full bg-[#25D366] text-white shadow-[0_10px_30px_rgba(12,45,72,.25)] transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-[#25D366] focus:ring-offset-2" aria-label="Chat with Tin-Tin Trekking on WhatsApp">
  <svg class="h-7 w-7" viewBox="0 0 32 32" fill="none" aria-hidden="true"><path fill="currentColor" d="M16 3.5A12.4 12.4 0 0 0 5.34 22.2L3.5 28.5l6.48-1.7A12.48 12.48 0 1 0 16 3.5Zm0 22.67c-1.9 0-3.76-.52-5.37-1.5l-.38-.23-3.84 1.01 1.03-3.75-.25-.39A10.14 10.14 0 1 1 16 26.17Zm5.56-7.6c-.3-.16-1.8-.9-2.09-.99-.28-.1-.49-.15-.7.15-.2.3-.78.98-.96 1.18-.18.2-.36.23-.67.08-.3-.15-1.28-.47-2.44-1.51a9.13 9.13 0 0 1-1.69-2.1c-.18-.3-.02-.47.13-.62.14-.13.31-.35.46-.53.15-.18.2-.3.3-.51.11-.2.06-.38-.02-.53-.08-.15-.7-1.68-.95-2.3-.25-.61-.51-.52-.7-.53h-.6c-.2 0-.53.08-.81.38-.28.3-1.07 1.05-1.07 2.56 0 1.51 1.1 2.97 1.25 3.17.15.2 2.16 3.3 5.24 4.63.73.31 1.3.5 1.75.64.74.23 1.4.2 1.93.12.6-.09 1.8-.74 2.06-1.45.26-.72.26-1.33.18-1.46-.07-.12-.27-.2-.57-.36Z"/></svg>
</a>
<script src="<?= asset_url('assets/js/site.js') ?>" defer></script>
<script
  src="<?= asset_url('chatbot/chat-widget.js') ?>"
  data-chat-endpoint="https://tin-tin-website-chat.thapasther101.workers.dev/chat"
  data-greeting="Namaste! How can I help you plan your Himalayan trip?"
  defer
></script>
</body></html>
