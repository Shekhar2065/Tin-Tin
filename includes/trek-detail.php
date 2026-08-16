<?php
require_once __DIR__ . '/../data/treks.php';
if (!isset($slug, $treks[$slug])) { http_response_code(404); exit('Trek not found'); }

$trek = $treks[$slug];
$pageTitle = $trek['title'];
$pageDescription = $trek['summary'];
$routePoints = $trek['start'] === $trek['end']
    ? $trek['start']
    : $trek['start'] . ' / ' . $trek['end'];
$tripFacts = [
    ['country', 'Country', 'Nepal'],
    ['calendar', 'Duration', $trek['duration']],
    ['gauge', 'Difficulty', $trek['difficulty']],
    ['activity', 'Activity', 'Trekking / Hiking'],
    ['mountain', 'Max. altitude', $trek['altitude']],
    ['season', 'Best season', $trek['season']],
    ['bed', 'Accommodation', 'Tea houses & hotels'],
    ['meal', 'Meals', 'Set with your plan'],
    ['route', 'Start / End point', $routePoints],
    ['private', 'Trip style', 'Private & personalized'],
    ['guide', 'Guide', 'Experienced local guide'],
    ['price', 'Pricing', 'Personalized proposal'],
];

require __DIR__ . '/header.php';
?>
<svg class="trip-icon-sprite" aria-hidden="true">
  <symbol id="trip-icon-country" viewBox="0 0 48 48"><circle cx="22" cy="24" r="15"></circle><path d="M7 24h30M22 9c-5 5-7 10-7 15s2 10 7 15M22 9c5 5 7 10 7 15M30 34l7 7 7-7a7 7 0 1 0-14 0Z"></path></symbol>
  <symbol id="trip-icon-calendar" viewBox="0 0 48 48"><rect x="8" y="11" width="32" height="30" rx="2"></rect><path d="M15 7v8M33 7v8M8 19h32M15 29l5 5 12-12"></path></symbol>
  <symbol id="trip-icon-gauge" viewBox="0 0 48 48"><path d="M7 33a17 17 0 0 1 34 0M24 31l9-11"></path><circle cx="24" cy="31" r="2"></circle></symbol>
  <symbol id="trip-icon-activity" viewBox="0 0 48 48"><circle cx="28" cy="8" r="3"></circle><path d="m22 15 8 5 7 1M22 15l-5 12-8 1M25 19l-2 12-7 10M23 31l10 9M13 19l6-2"></path></symbol>
  <symbol id="trip-icon-mountain" viewBox="0 0 48 48"><path d="m6 40 13-25 8 14 5-9 10 20H6ZM15 23l4 4 4-4M30 24l3 4 3-2"></path></symbol>
  <symbol id="trip-icon-season" viewBox="0 0 48 48"><path d="M15 35h22a7 7 0 0 0 0-14 12 12 0 0 0-22-3 8.5 8.5 0 0 0 0 17ZM10 8v4M3 15h4M8 10l3 3M13 40v3M24 40v3M35 40v3"></path></symbol>
  <symbol id="trip-icon-bed" viewBox="0 0 48 48"><path d="M7 39V15M7 31h35v8M13 22h12a6 6 0 0 1 6 6v3H13v-9ZM7 39v4M42 39v4"></path><circle cx="14" cy="17" r="3"></circle></symbol>
  <symbol id="trip-icon-meal" viewBox="0 0 48 48"><circle cx="26" cy="25" r="13"></circle><path d="M8 7v15M5 7v8c0 3 6 3 6 0V7M8 22v19M43 7c-5 3-5 13-1 17v17"></path></symbol>
  <symbol id="trip-icon-route" viewBox="0 0 48 48"><path d="M8 39c8-8 16 5 32-7" stroke-dasharray="3 3"></path><path d="M6 20c0 7 7 13 7 13s7-6 7-13a7 7 0 1 0-14 0ZM30 10c0 5 5 9 5 9s5-4 5-9a5 5 0 1 0-10 0Z"></path></symbol>
  <symbol id="trip-icon-private" viewBox="0 0 48 48"><circle cx="17" cy="15" r="6"></circle><circle cx="34" cy="18" r="5"></circle><path d="M6 40c0-9 5-15 11-15s11 6 11 15M27 28c2-3 4-5 7-5 5 0 9 6 9 14"></path></symbol>
  <symbol id="trip-icon-guide" viewBox="0 0 48 48"><circle cx="24" cy="13" r="7"></circle><path d="M11 41c1-11 6-18 13-18s12 7 13 18M17 26l7 7 7-7M15 8l9-4 9 4"></path></symbol>
  <symbol id="trip-icon-price" viewBox="0 0 48 48"><rect x="6" y="11" width="36" height="27" rx="3"></rect><path d="M6 19h36M13 30h8M34 27v6M31 30h6"></path></symbol>
</svg>

<section class="trip-product-hero">
  <div class="site-shell">
    <nav class="trip-breadcrumb" aria-label="Breadcrumb"><a href="<?= url('index.php') ?>">Home</a><span>/</span><a href="<?= url('index.php#treks') ?>">Nepal treks</a><span>/</span><span><?= e($trek['title']) ?></span></nav>
    <div class="trip-product-grid">
      <div class="trip-product-copy">
        <p class="eyebrow text-pine"><?= e($trek['region']) ?></p>
        <h1><?= e($trek['title']) ?></h1>
        <p class="trip-product-summary"><?= e($trek['summary']) ?></p>
        <div class="trip-product-trust" aria-label="Service benefits"><span>Local Nepal team</span><span>Private planning</span><span>Safety-first pacing</span></div>
        <div class="trip-product-actions">
          <a class="btn-primary" href="<?= url('budget-plan.php?trek='.urlencode($trek['title'])) ?>">Get My Budget Plan <span aria-hidden="true">&nearr;</span></a>
          <a class="trip-product-whatsapp" href="<?= e(whatsapp_url("Hello Tin-Tin Trekking, I'm interested in the {$trek['title']}.")) ?>" target="_blank" rel="noopener">Talk on WhatsApp</a>
        </div>
      </div>
      <div class="trip-product-gallery" aria-label="Trip gallery">
        <figure class="trip-product-gallery-main"><img src="<?= url($trek['image']) ?>" alt="<?= e($trek['title']) ?> mountain landscape"></figure>
        <figure><img loading="lazy" src="<?= url('assets/images/annapurna.png') ?>" alt="Himalayan forest and mountain trail"></figure>
        <figure><img loading="lazy" src="<?= url('assets/images/manaslu.png') ?>" alt="Remote Nepal mountain valley"></figure>
      </div>
    </div>
  </div>
</section>

<section class="trip-facts-section" aria-label="Trip facts">
  <div class="site-shell">
    <dl class="trip-facts-card">
      <?php foreach ($tripFacts as $fact): ?>
        <div class="trip-fact"><svg viewBox="0 0 48 48" aria-hidden="true"><use href="#trip-icon-<?= e($fact[0]) ?>"></use></svg><div><dt><?= e($fact[1]) ?></dt><dd><?= e($fact[2]) ?></dd></div></div>
      <?php endforeach; ?>
    </dl>
  </div>
</section>

<nav class="trip-section-nav" aria-label="Trip page sections">
  <div class="site-shell"><a href="#highlights">Highlights</a><a href="#overview">Overview</a><a href="#itinerary">Itinerary</a><a href="#included">Includes</a><a href="#route">Route &amp; altitude</a><a href="#faqs">FAQs</a><a class="trip-section-nav-cta" href="<?= url('budget-plan.php?trek='.urlencode($trek['title'])) ?>">Plan this trip</a></div>
</nav>

<section class="trip-content-section">
  <div class="site-shell trip-content-grid">
    <article class="trip-content-main">
      <section class="trip-content-block" id="highlights">
        <p class="eyebrow text-pine">At a glance</p><h2><?= e($trek['title']) ?> highlights</h2>
        <ul class="trip-highlight-list"><?php foreach ($trek['highlights'] as $highlight): ?><li><span aria-hidden="true">&#10003;</span><?= e($highlight) ?></li><?php endforeach; ?></ul>
      </section>

      <section class="trip-content-block" id="overview">
        <p class="eyebrow text-pine">The journey</p><h2>Trip overview</h2><p class="trip-lead"><?= e($trek['overview']) ?></p>
        <div class="trip-note"><strong>A route built around you.</strong><span>Dates, daily pacing, rooms and transport are finalized after we understand your group and priorities.</span></div>
      </section>

      <section class="trip-content-block" id="itinerary">
        <div class="trip-section-heading"><div><p class="eyebrow text-pine">Day by day</p><h2>Trip itinerary</h2></div><span><?= e($trek['duration']) ?></span></div>
        <p class="trip-section-intro">This sample itinerary is a practical planning foundation. Your confirmed route may adapt to dates, conditions and preferences.</p>
        <div class="trip-itinerary" data-accordion>
          <?php foreach ($trek['itinerary'] as $i => $day): ?>
            <div class="accordion-item <?= $i === 0 ? 'open' : '' ?>"><button class="accordion-button" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>"><span class="trip-day-number">Day <?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span><span class="trip-day-title"><?= e($day[0]) ?></span><span class="accordion-icon">+</span></button><div class="accordion-content"><p><?= e($day[1]) ?></p></div></div>
          <?php endforeach; ?>
        </div>
      </section>

      <section class="trip-content-block" id="included">
        <p class="eyebrow text-pine">Your proposal</p><h2>Included and not included</h2>
        <div class="trip-inclusion-grid">
          <div><h3>Included</h3><ul><?php foreach ($trek['included'] as $item): ?><li><span aria-hidden="true">&#10003;</span><?= e($item) ?></li><?php endforeach; ?></ul></div>
          <div><h3>Not included</h3><ul><?php foreach ($trek['excluded'] as $item): ?><li><span aria-hidden="true">&minus;</span><?= e($item) ?></li><?php endforeach; ?></ul></div>
        </div>
      </section>

      <section class="trip-content-block" id="route">
        <p class="eyebrow text-pine">Route &amp; altitude</p><h2>Climb steadily. Adapt deliberately.</h2>
        <div class="trip-altitude-card" aria-label="Illustrative altitude profile"><div class="trip-altitude-chart"><i></i><i></i><i></i><i></i><span class="trip-altitude-start"><?= e($trek['start']) ?></span><strong><?= e($trek['altitude']) ?></strong><span class="trip-altitude-end"><?= e($trek['end']) ?></span></div><p>Illustrative profile, not a navigation chart. Your final plan contains route-specific details.</p></div>
        <div class="trip-route-notes"><p><strong>Difficulty</strong><?= e($trek['difficulty']) ?>, assessed from daily distance, elevation and conditions.</p><p><strong>Best season</strong><?= e($trek['season']) ?> is the usual planning window, though mountain conditions vary.</p></div>
      </section>

      <section class="trip-content-block" id="comfort">
        <p class="eyebrow text-pine">Comfort options</p><h2>Choose where comfort matters</h2>
        <div class="trip-comfort-grid"><?php $options = [['Standard','Essential teahouses, shared options and core transport.'],['Comfort','Better lodge selection, hotel upgrades and more privacy.'],['Luxury','Premium rooms, enhanced service and private transport where possible.']]; ?><?php foreach ($options as $option): ?><div><h3><?= e($option[0]) ?></h3><p><?= e($option[1]) ?></p></div><?php endforeach; ?></div>
      </section>

      <section class="trip-content-block" id="faqs">
        <p class="eyebrow text-pine">Trip questions</p><h2>Frequently asked questions</h2>
        <div class="trip-faq-list" data-accordion><?php foreach ($trek['faqs'] as $i => $faq): ?><div class="accordion-item <?= $i === 0 ? 'open' : '' ?>"><button class="accordion-button" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>"><span><?= e($faq[0]) ?></span><span class="accordion-icon">+</span></button><div class="accordion-content"><p><?= e($faq[1]) ?></p></div></div><?php endforeach; ?></div>
      </section>
    </article>

    <aside class="trip-booking-sidebar" aria-label="Plan this trip">
      <div class="trip-booking-card">
        <p class="trip-booking-kicker">Personalized trip</p><h2>Plan this trek around your budget</h2><p>Share your dates, group size and preferred comfort. We&rsquo;ll return with a practical route and clear proposal.</p>
        <ul><li>Private, custom itinerary</li><li>Local planning expertise</li><li>No obligation to book</li></ul>
        <a class="btn-primary" href="<?= url('budget-plan.php?trek='.urlencode($trek['title'])) ?>">Get My Budget Plan <span aria-hidden="true">&nearr;</span></a>
        <a class="trip-booking-whatsapp" href="<?= e(whatsapp_url("Hello Tin-Tin Trekking, I'm interested in the {$trek['title']}.")) ?>" target="_blank" rel="noopener">Talk on WhatsApp</a>
      </div>
    </aside>
  </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
