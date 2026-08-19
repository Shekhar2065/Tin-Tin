<?php
require_once __DIR__ . '/includes/config.php';
start_secure_session();
$formToken = csrf_token();
$pageTitle = 'Contact Tin-Tin Trekking';
$pageDescription = 'Contact Tin-Tin Trekking & Adventure in Jyatha, Thamel, Kathmandu, Nepal.';
require __DIR__ . '/includes/header.php';
?>
<section class="bg-ink py-16 text-white md:py-24">
  <div class="site-shell">
    <p class="eyebrow text-emerald-200">Kathmandu, Nepal</p>
    <h1 class="mt-3 max-w-4xl font-display text-5xl text-white md:text-7xl">Let&rsquo;s talk about your Himalayan plans.</h1>
  </div>
</section>

<section class="py-16 md:py-24">
  <div class="site-shell grid gap-12 lg:grid-cols-[.8fr_1.2fr]">
    <div>
      <img src="<?= url('assets/images/tin-tin-logo.png') ?>" class="h-40 w-64 object-contain" alt="Tin-Tin Trekking logo">
      <h2 class="mt-7 font-display text-3xl text-ink"><?= e(SITE['name']) ?></h2>
      <address class="mt-6 space-y-3 not-italic leading-7">
        <p><?= e(SITE['address']) ?></p>
        <p><b>Telephone</b><br><a href="tel:+97714248404"><?= e(SITE['telephone']) ?></a></p>
        <p><b>Mobile</b><br><a href="tel:+9779851044230"><?= e(SITE['mobile']) ?></a></p>
        <p><b>Email</b><br><a class="text-pine" href="mailto:<?= e(SITE['email']) ?>"><?= e(SITE['email']) ?></a></p>
        <p><b>Website</b><br><?= e(SITE['website']) ?></p>
      </address>
      <a class="btn-primary mt-7" target="_blank" rel="noopener" href="<?= e(whatsapp_url()) ?>">WhatsApp Us</a>
    </div>

    <div class="bg-mist p-6 md:p-10">
      <?php if (isset($_GET['success'])): ?>
        <div class="mb-6 border-l-4 border-pine bg-white p-5"><b class="text-ink">Message received.</b> We&rsquo;ll follow up using the details you provided.</div>
      <?php endif; ?>
      <?php if (isset($_GET['error'])): ?>
        <div class="mb-6 border-l-4 border-red-600 bg-white p-5 text-red-800">We couldn&rsquo;t send your message. Check the details and try again, or contact us directly.</div>
      <?php endif; ?>

      <p class="eyebrow text-pine">Send a message</p>
      <h2 class="mt-2 font-display text-4xl text-ink">How can we help?</h2>
      <form action="<?= url('submit-inquiry.php') ?>" method="post" class="mt-7 grid gap-5 md:grid-cols-2">
        <input type="hidden" name="source" value="contact">
        <input type="hidden" name="csrf_token" value="<?= e($formToken) ?>">
        <input type="text" name="website_check" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true">
        <label><span class="mb-2 block text-sm font-bold">Full name *</span><input name="full_name" required maxlength="150" autocomplete="name" class="form-field"></label>
        <label><span class="mb-2 block text-sm font-bold">Email *</span><input name="email" type="email" required maxlength="190" autocomplete="email" class="form-field"></label>
        <label><span class="mb-2 block text-sm font-bold">Phone</span><input name="phone" type="tel" maxlength="60" autocomplete="tel" class="form-field"></label>
        <label><span class="mb-2 block text-sm font-bold">Country</span><input name="country" maxlength="100" autocomplete="country-name" class="form-field"></label>
        <label class="md:col-span-2"><span class="mb-2 block text-sm font-bold">Message *</span><textarea name="additional_notes" required maxlength="5000" rows="6" class="form-field"></textarea></label>
        <p class="md:col-span-2 text-xs leading-5 text-slate-500">By submitting, you ask Tin-Tin Trekking to respond to this inquiry. See our <a class="font-semibold text-pine underline" href="<?= url('privacy.php') ?>">Privacy Policy</a>.</p>
        <div class="md:col-span-2"><button class="btn-primary" type="submit">Send Message</button></div>
      </form>
    </div>
  </div>
</section>

<section class="bg-mist py-14">
  <div class="site-shell">
    <div class="grid min-h-72 place-items-center border border-slate-300 bg-white text-center">
      <div><span class="text-4xl text-pine">⌖</span><h2 class="mt-3 font-display text-3xl text-ink">Jyatha, Thamel, Kathmandu</h2><p class="mt-2 text-sm">Interactive map placeholder &mdash; ready for the client&rsquo;s preferred map embed.</p></div>
    </div>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
