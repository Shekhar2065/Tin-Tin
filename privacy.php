<?php
$pageTitle = 'Privacy Policy';
$pageDescription = 'Privacy information for Tin-Tin Trekking trip inquiries and website communications.';
require __DIR__ . '/includes/header.php';
?>
<section class="bg-ink py-16 text-white md:py-20">
  <div class="site-shell max-w-4xl"><p class="eyebrow text-emerald-200">Website information</p><h1 class="mt-3 font-display text-5xl text-white md:text-6xl">Privacy Policy</h1></div>
</section>
<section class="py-16 md:py-20">
  <div class="site-shell max-w-4xl space-y-8 leading-7">
    <div>
      <h2 class="font-display text-2xl text-ink">Trip inquiry information</h2>
      <p class="mt-3">Information submitted through this website is used to respond to your inquiry and help plan a requested journey. Share only planning information that is necessary, and do not submit medical records, payment-card details or other sensitive information through these forms.</p>
    </div>
    <div>
      <h2 class="font-display text-2xl text-ink">Chat assistant</h2>
      <p class="mt-3">Messages sent to the website chat, together with a limited recent conversation history, are processed by Cloudflare Workers AI to generate a reply. Do not include passwords, payment information, medical records or other sensitive personal information in chat messages.</p>
    </div>
    <div>
      <h2 class="font-display text-2xl text-ink">Security and anti-abuse data</h2>
      <p class="mt-3">The inquiry forms use a short-lived, strictly necessary session cookie for request protection and rate limiting. The server may temporarily store a one-way hash derived from the connection address to limit automated abuse; it is not written to the inquiry database.</p>
    </div>
    <div>
      <h2 class="font-display text-2xl text-ink">Contact and retention</h2>
      <p class="mt-3">For questions about your information, contact <a class="font-semibold text-pine" href="mailto:<?= e(SITE['email']) ?>"><?= e(SITE['email']) ?></a>. Final retention, analytics and cookie details should be reviewed with the website owner before launch.</p>
    </div>
    <p class="border-l-2 border-pine bg-mist p-5 text-sm">This concise demo policy must be reviewed and approved by the business before the website is published.</p>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
