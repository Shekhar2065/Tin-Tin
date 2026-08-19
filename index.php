<?php
$pageTitle = 'Personalized Himalayan Treks Built Around You';
$pageDescription = 'Tell us your budget and Tin-Tin Trekking will create a personalized Himalayan adventure around your travel style, comfort and goals.';
require __DIR__ . '/data/treks.php';
$featuredActivities = [
  'trekking' => [
    ['Everest Base Camp Trek','Everest Region','15 days','Challenging','assets/images/everest-hero.png','Walk through Sherpa country to the foot of the world’s highest mountain.','treks/everest-base-camp.php'],
    ['Annapurna Base Camp Trek','Annapurna Region','11 days','Moderate','assets/images/annapurna.png','Forest, mountain villages and the extraordinary Annapurna Sanctuary.','treks/annapurna-base-camp.php'],
    ['Upper Dolpo Trek','Dolpo Region','22 days','Challenging','assets/images/tibet-plateau.png','Remote high-desert landscapes, ancient villages and a carefully planned journey through Dolpo.','treks/upper-dolpo.php'],
  ],
  'camping' => [],
];
require __DIR__ . '/includes/header.php';
?>
<section class="home-hero reference-hero">
  <!-- Royalty-free Mount Ama Dablam timelapse: Pexels video 29632693 by Chandra Man Dongol. -->
  <video class="reference-hero-image reference-hero-video" data-hero-video autoplay muted loop playsinline preload="auto" aria-hidden="true">
    <source src="<?= asset_url('assets/videos/ama-dablam-closeup.mp4') ?>" type="video/mp4">
  </video>
  <div class="reference-hero-shade" aria-hidden="true"></div>

  <div class="site-shell reference-hero-inner">
    <div class="reference-hero-copy">
      <p class="reference-hero-eyebrow">Personal journeys across Nepal, Bhutan &amp; Tibet</p>
      <h1>Experience the Difference!<strong>Discover the Himalaya.</strong></h1>
      <p>Thoughtful trekking and tours, shaped by local experts around your pace, interests and budget.</p>

      <form class="hero-trip-search" action="<?= url('budget-plan.php') ?>" method="get" role="search">
        <label class="sr-only" for="hero-trip-query">Search trips</label>
        <input id="hero-trip-query" name="trek" type="search" placeholder="Search trips, destinations and activities" autocomplete="off">
        <button type="submit" aria-label="Search trips">
          <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"></circle><path d="m16.5 16.5 4 4"></path></svg>
        </button>
      </form>
    </div>

    <div class="hero-stats" aria-label="Why travel with Tin-Tin Trekking">
      <div class="hero-stat">
        <svg class="hero-stat-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
          <circle cx="12" cy="8" r="4"></circle>
          <path d="M4.5 21a7.5 7.5 0 0 1 15 0"></path>
          <path d="m17 12.5 1.8 1.8 3.2-3.6"></path>
        </svg>
        <p><strong>35+ Years</strong><span>of Experience</span></p>
      </div>
      <div class="hero-stat">
        <svg class="hero-stat-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
          <path d="M3 20 9 9l3.5 5 3-7L22 20"></path>
          <path d="M5 20h17"></path>
          <path d="m16 10 1.5 1.5L20 8.5"></path>
        </svg>
        <p><strong>Professional</strong><span>Guides</span></p>
      </div>
      <div class="hero-stat">
        <svg class="hero-stat-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
          <path d="M4 13a8 8 0 0 1 16 0"></path>
          <path d="M4 13v5h3v-6H4"></path>
          <path d="M20 13v5h-3v-6h3"></path>
          <path d="M17 20h-4"></path>
          <circle cx="11.5" cy="20" r="1.5"></circle>
        </svg>
        <p><strong>Experienced</strong><span>Counselors</span></p>
      </div>
    </div>
  </div>
</section>

<section id="treks" class="featured-activities py-20 md:py-28">
  <div class="site-shell">
    <div class="platform-review-intro grid gap-7 lg:grid-cols-[.85fr_1.15fr] lg:items-end">
      <div><p class="eyebrow text-pine">Featured journeys</p><h2 class="mt-3 font-display text-5xl text-ink md:text-7xl">Choose how you<br>meet the Himalaya.</h2></div>
      <p class="max-w-2xl text-lg leading-8 lg:justify-self-end">Explore our Everest, Annapurna and Dolpo journeys. Dedicated camping programs are currently being prepared.</p>
    </div>
    <div class="offer-tabs mt-12" role="tablist" aria-label="Featured activity categories">
      <button class="offer-tab active" data-offer-filter="trekking" role="tab" aria-selected="true" aria-controls="activity-panel-trekking"><svg viewBox="0 0 32 32" aria-hidden="true"><path d="M18 3c1 6-4 7-4 12 0 2 1 4 3 5-1-5 4-6 5-10 4 4 6 8 6 12a11 11 0 1 1-22 0c0-5 3-9 7-13-1 6 1 8 3 9-1-6 4-8 2-15Z"/></svg><span>Trekking</span></button>
      <button class="offer-tab" data-offer-filter="camping" role="tab" aria-selected="false" aria-controls="activity-panel-camping"><svg viewBox="0 0 32 32" aria-hidden="true"><path d="M4 26 16 5l12 21H4Zm6 0 6-11 6 11M16 5v10"/></svg><span>Camping <b>Coming Soon</b></span></button>
    </div>
    <?php foreach ($featuredActivities as $categoryKey => $items): ?>
    <div id="activity-panel-<?= e($categoryKey) ?>" class="offer-panel <?= $categoryKey === 'trekking' ? '' : 'hidden' ?>" data-offer-panel="<?= e($categoryKey) ?>" role="tabpanel">
      <?php if ($categoryKey === 'camping'): ?>
      <div class="activity-coming-soon">
        <svg viewBox="0 0 64 64" aria-hidden="true"><path d="M8 52 32 10l24 42H8Zm13 0 11-20 11 20M32 10v22"></path><path d="M4 52h56"></path></svg>
        <p>Camping adventures</p>
        <h3>Coming Soon</h3>
        <span>We are preparing the route, logistics and safety details before publishing these journeys.</span>
      </div>
      <?php else: ?>
      <div class="offer-grid">
        <?php foreach ($items as $item): ?>
        <article class="offer-card">
          <a href="<?= url($item[6]) ?>" class="offer-image"><img loading="lazy" src="<?= url($item[4]) ?>" alt="<?= e($item[0]) ?> landscape"></a>
          <div class="offer-body">
            <p class="activity-card-duration"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"></rect><path d="M7 3v4M17 3v4M3 10h18M8 14h2M14 14h2M8 18h2"></path></svg><span><?= e($item[2]) ?></span></p>
            <h3><a href="<?= url($item[6]) ?>"><?= e($item[0]) ?></a></h3>
            <p class="activity-card-region"><?= e($item[1]) ?> <span aria-hidden="true">&middot;</span> <?= e($item[3]) ?></p>
            <div class="offer-footer"><span>Personalized quote</span><a href="<?= url($item[6]) ?>">View trip <b>&rarr;</b></a></div>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="company-welcome py-20 md:py-28">
  <div class="site-shell grid gap-12 lg:grid-cols-[1.05fr_.95fr] lg:items-center">
    <div class="welcome-image"><img loading="lazy" src="<?= url('assets/images/footer-nepal-cultural.png') ?>" alt="Traditional Nepal mountain village, chorten and Himalayan peaks"><span>Based in Jyatha, Thamel · Kathmandu</span></div>
    <div><p class="eyebrow text-pine">Namaste & welcome</p><h2 class="mt-3 font-display text-5xl leading-none text-ink md:text-7xl">Your local partner for Nepal’s mountains.</h2><p class="mt-6 text-lg leading-8">Tin-Tin Trekking & Adventure is a Kathmandu-based trekking company creating Himalayan journeys around the traveler—not around a fixed package.</p><p class="mt-4 leading-7">Browse classic treks, remote camping routes, cycling journeys, guided climbing and cultural tours. Then tell us your dates, comfort and budget so we can shape a practical personal plan.</p><div class="mt-8 flex flex-wrap gap-3"><a class="btn-primary" href="<?= url('about.php') ?>">More about us</a><a class="welcome-contact" href="<?= url('contact.php') ?>">Talk to our team →</a></div></div>
  </div>
  <div class="site-shell service-band">
    <?php $services=[['⌁','Route planning'],['▣','Accommodation'],['↗','Transport & flights'],['◇','Permits & logistics']];foreach($services as $service):?><div><span><?= e($service[0]) ?></span><b><?= e($service[1]) ?></b><small>Adapted to your confirmed itinerary</small></div><?php endforeach;?>
  </div>
</section>

<section id="why-tintin" class="why-tintin scroll-mt-24 relative overflow-hidden isolate bg-white" aria-labelledby="why-tintin-heading">

  <!-- Background trekking silhouette -->
  <div class="absolute inset-0 z-0 pointer-events-none select-none">
    <img 
      src="/assets/img/himalaya-climber-bg.png" 
      alt="" 
      aria-hidden="true"
      class="absolute left-0 bottom-0 h-[95%] md:h-[100%] w-auto max-w-[45%] object-contain object-bottom
             opacity-[0.08] grayscale brightness-[0.3] mix-blend-luminosity
             [mask-image:linear-gradient(to_right,black_20%,transparent_85%),linear-gradient(to_top,black_60%,transparent_100%)]
             [mask-composite:intersect]
             [-webkit-mask-image:linear-gradient(to_right,black_20%,transparent_85%),linear-gradient(to_top,black_60%,transparent_100%)]
             [-webkit-mask-composite:source-in]
             hidden md:block"
    />

    <!-- Soft brand-tinted wash so the image sits inside the palette, not on top of it -->
    <div class="absolute inset-0 bg-gradient-to-r from-white via-white/60 to-transparent"></div>

    <!-- Subtle top fade so it never fights the heading -->
    <div class="absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-white to-transparent"></div>
  </div>

  <div class="site-shell why-tintin-inner relative z-10">
    <div class="why-tintin-intro">
      <div>
        <p class="eyebrow text-pine">Discover the Tin-Tin difference</p>
        <h2 id="why-tintin-heading" class="font-display">Why Tin-Tin Trekking?</h2>
      </div>
      <p><strong>Different by design.</strong> Instead of beginning with a fixed package, we begin with you&mdash;your budget, pace, comfort, interests and mountain goals.</p>
    </div>

    <div class="why-tintin-grid">
      <article class="why-tintin-item">
        <span class="why-tintin-icon why-icon-blue"><svg viewBox="0 0 48 48" aria-hidden="true"><path d="M8 39 19 21l6 9 5-12 10 21M13 39h27"/><path d="M21 12a5 5 0 1 0 10 0 5 5 0 0 0-10 0Z"/><path d="M17 29c2-5 5-8 9-8s7 3 9 8"/></svg></span>
        <div><h3>Kathmandu-based expertise</h3><p>Your journey is planned from Jyatha, Thamel, with practical local knowledge of Himalayan routes and logistics.</p></div>
      </article>

      <article class="why-tintin-item">
        <span class="why-tintin-icon why-icon-green"><svg viewBox="0 0 48 48" aria-hidden="true"><path d="M8 39h32M13 39V21h22v18M10 21h28l-4-6H14l-4 6Z"/><path d="M19 15 24 7l5 8M20 28h8v11"/></svg></span>
        <div><h3>Personal, not pre-packaged</h3><p>Route, pacing, accommodation and transport are shaped around your dates, group and travel style.</p></div>
      </article>

      <article class="why-tintin-item">
        <span class="why-tintin-icon why-icon-blue"><svg viewBox="0 0 48 48" aria-hidden="true"><path d="M24 5 40 11v12c0 10-6 17-16 21C14 40 8 33 8 23V11l16-6Z"/><path d="m16 24 5 5 11-13"/></svg></span>
        <div><h3>Safety before compromise</h3><p>If a route, schedule or budget conflicts with safe planning, we recommend a better and more realistic option.</p></div>
      </article>

      <article class="why-tintin-item">
        <span class="why-tintin-icon why-icon-green"><svg viewBox="0 0 48 48" aria-hidden="true"><path d="M8 13h32v25H8zM8 20h32"/><path d="M15 29h8M15 34h14M33 28l3 3-6 6"/></svg></span>
        <div><h3>Clear personal proposals</h3><p>Your plan explains its route, inclusions and comfort choices so you can understand what is being designed.</p></div>
      </article>

      <article class="why-tintin-item">
        <span class="why-tintin-icon why-icon-blue"><svg viewBox="0 0 48 48" aria-hidden="true"><path d="M7 30c7-1 11-5 15-12 5 7 10 11 19 12"/><path d="M10 38c5-5 9-7 14-7s9 2 14 7M24 31v11"/><circle cx="24" cy="11" r="5"/></svg></span>
        <div><h3>Guides matched to the journey</h3><p>Guide and support arrangements are selected around the route, group needs and confirmed itinerary.</p></div>
      </article>

      <article class="why-tintin-item">
        <span class="why-tintin-icon why-icon-green"><svg viewBox="0 0 48 48" aria-hidden="true"><path d="M7 24a17 17 0 0 1 34 0M7 24v11h8V21H7m34 3v11h-8V21h8M33 39h-9"/><circle cx="20" cy="39" r="4"/></svg></span>
        <div><h3>Budget-led customization</h3><p>Your budget guides useful choices in duration, lodging and transport&mdash;without reducing essential safety.</p></div>
      </article>
    </div>

    <div class="why-tintin-action">
      <p><strong>What makes us different?</strong> One considered plan, created around the traveler rather than a public price list.</p>
      <a class="btn-primary" href="<?= url('budget-plan.php') ?>">Build My Personal Plan <span aria-hidden="true">&rarr;</span></a>
    </div>
  </div>
</section>

<section class="planning-section relative overflow-hidden py-20 text-white md:py-28 bg-[#111714]">

  <!-- Background image -->
  <div class="planning-background absolute inset-0 z-0">
    <img 
      src="<?= url('assets/images/mountain-climber-bg.png') ?>" 
      alt=""
      aria-hidden="true"
      class="h-full w-full object-cover object-bottom"
    >
    <!-- Overlay to keep text readable + blend edges into bg-ink -->
    <div class="planning-overlay planning-overlay-horizontal absolute inset-0"></div>
    <div class="planning-overlay planning-overlay-vertical absolute inset-0"></div>
  </div>

  <div class="site-shell relative z-10">
    <div class="max-w-2xl">
      <p class="eyebrow text-emerald-200">Budget-based planning, explained</p>
      <h2 class="mt-4 font-display text-4xl text-white md:text-6xl">A better journey begins with an honest conversation.</h2>
    </div>

    <div class="mt-12 grid border-y border-white/15 md:grid-cols-2 xl:grid-cols-4">
      <?php $steps=[['01','Tell Us Your Budget','Choose a useful budget range—only inside our private inquiry.'],['02','Tell Us What You Want','Share dates, group size, experience and what matters to you.'],['03','We Design Your Trip','We balance route, lodging, transport and service around your priorities.'],['04','Receive Your Plan','You receive a personalized proposal with clear inclusions.']]; foreach($steps as $s): ?>
      <div class="planning-step-card border-b border-white/15 p-7 md:border-r xl:border-b-0 bg-black/35 backdrop-blur-sm">
        <span class="font-display text-4xl text-emerald-300"><?= $s[0] ?></span>
        <h3 class="mt-8 text-lg font-bold text-white"><?= e($s[1]) ?></h3>
        <p class="mt-3 text-sm leading-6 text-slate-300"><?= e($s[2]) ?></p>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="planning-detail-grid mt-8 grid gap-5 rounded-sm bg-white/5 p-7 backdrop-blur-sm md:grid-cols-2 lg:grid-cols-4">
      <p class="text-sm"><b class="text-white">Accommodation</b><br>Lodge and hotel level</p>
      <p class="text-sm"><b class="text-white">Privacy</b><br>Room and group arrangements</p>
      <p class="text-sm"><b class="text-white">Transport</b><br>Shared or private options</p>
      <p class="text-sm"><b class="text-white">Experiences</b><br>Culture, nature and extensions</p>
    </div>
  </div>
</section>

<section id="gallery" class="destination-gallery-section py-16 md:py-24" aria-labelledby="destination-gallery-title">
  <div class="site-shell">
    <div class="destination-gallery-shell">
      <header class="destination-gallery-heading">
        <p><span aria-hidden="true"></span>Explore our destination photography</p>
        <h2 id="destination-gallery-title">Destination Photo Albums</h2>
      </header>

      <div class="destination-card-tabs" aria-label="Destination photo albums">
        <a class="destination-card-tab destination-album-link" href="<?= url('gallery.php#gallery-nepal') ?>" aria-label="Open the Nepal photo album">
          <img loading="lazy" src="<?= url('assets/images/footer-nepal-cultural.png') ?>" alt="Temple architecture and Himalayan mountains in Nepal">
          <span><strong>Nepal</strong><small>4 photos</small><b>View album <i aria-hidden="true">&rarr;</i></b></span>
        </a>
        <a class="destination-card-tab destination-album-link" href="<?= url('gallery.php#gallery-bhutan') ?>" aria-label="Open the Bhutan photo album">
          <img loading="lazy" src="<?= asset_url('assets/images/bhutan-tigers-nest.png') ?>" alt="Tiger's Nest monastery on a forested cliff in Bhutan">
          <span><strong>Bhutan</strong><small>1 photo</small><b>View album <i aria-hidden="true">&rarr;</i></b></span>
        </a>
        <a class="destination-card-tab destination-album-link" href="<?= url('gallery.php#gallery-tibet') ?>" aria-label="Open the Tibet photo album">
          <img loading="lazy" src="<?= asset_url('assets/images/tibet-plateau.png') ?>" alt="Road, chorten and snowy mountains on the Tibetan plateau">
          <span><strong>Tibet</strong><small>1 photo</small><b>View album <i aria-hidden="true">&rarr;</i></b></span>
        </a>
      </div>

    </div>
  </div>
</section>

<section id="reviews" class="client-reviews py-20 md:py-28" aria-labelledby="client-reviews-title">
  <div class="site-shell">
    <header class="client-reviews-heading">
      <p><span aria-hidden="true"></span>Traveler&rsquo;s Tales</p>
      <h2 id="client-reviews-title">What Our Clients Say</h2>
    </header>

    <div class="client-review-tabs" role="tablist" aria-label="Review platform">
      <button class="client-review-tab active" type="button" role="tab" aria-selected="true" aria-controls="tripadvisor-review-panel" data-review-tab="tripadvisor">
        <svg class="client-tripadvisor-mark" viewBox="0 0 64 40" aria-hidden="true"><path d="M18 10h28M22 10l3-5h14l3 5"/><circle cx="17" cy="23" r="11"/><circle cx="47" cy="23" r="11"/><circle cx="17" cy="23" r="4"/><circle cx="47" cy="23" r="4"/><path d="M28 25h8M8 12 3 8m53 4 5-4"/></svg>
        <span>Tripadvisor</span><strong>4 sample reviews</strong>
      </button>
      <button class="client-review-tab" type="button" role="tab" aria-selected="false" aria-controls="google-review-panel" data-review-tab="google" tabindex="-1">
        <img class="client-google-logo" src="<?= asset_url('assets/images/google-g-logo.svg') ?>" alt=""><span>Google</span><strong>4 sample reviews</strong>
      </button>
    </div>

    <?php
    $clientReviewGroups = [
      'tripadvisor' => [
        'url' => SITE['tripadvisor_reviews_url'],
        'label' => 'Tripadvisor',
        'reviews' => [
          ['AR', 'Aarav R.', 'Amazing trek to Everest Base Camp', 'Our guide kept every day organized and relaxed. The views were unforgettable, and the village stops made the whole journey feel personal.'],
          ['HM', 'Holly M.', 'Highly recommended!', 'The itinerary had the perfect balance of challenge and rest. Every question was answered quickly, and we always felt well supported.'],
          ['FR', 'Faith R.', 'A wonderful Himalayan experience', 'The team was warm, patient and knowledgeable. Their attention to detail helped us enjoy Nepal with complete confidence.'],
        ],
      ],
      'google' => [
        'url' => SITE['google_reviews_url'],
        'label' => 'Google',
        'reviews' => [
          ['AY', 'Aisha Y.', 'An experience we will never forget', 'Our trek was seamless, and a huge part of that was the supportive team. They were friendly, attentive and encouraging throughout.'],
          ['SP', 'Sai P.', 'Excellent experience', 'Everything was smooth and taken care of. Our guides were knowledgeable, kind and always ready to help us along the trail.'],
          ['KP', 'Kevin P.', 'A magical Everest journey', 'The landscape was incredible, but the people made it truly special. We felt welcomed and supported from beginning to end.'],
        ],
      ],
    ];
    foreach ($clientReviewGroups as $platform => $group):
    ?>
      <div id="<?= e($platform) ?>-review-panel" class="client-review-panel<?= $platform === 'tripadvisor' ? '' : ' hidden' ?>" role="tabpanel" data-review-panel="<?= e($platform) ?>">
        <div class="client-review-grid">
          <?php foreach ($group['reviews'] as $review): ?>
            <article class="client-review-card">
              <div class="client-review-rating">
                <span class="client-review-stars" role="img" aria-label="Five out of five stars">★★★★★</span>
                <?php if ($platform === 'google'): ?><img class="client-google-logo" src="<?= asset_url('assets/images/google-g-logo.svg') ?>" alt=""><?php else: ?><svg class="client-tripadvisor-mark" viewBox="0 0 64 40" aria-hidden="true"><path d="M18 10h28M22 10l3-5h14l3 5"/><circle cx="17" cy="23" r="11"/><circle cx="47" cy="23" r="11"/><circle cx="17" cy="23" r="4"/><circle cx="47" cy="23" r="4"/><path d="M28 25h8M8 12 3 8m53 4 5-4"/></svg><?php endif; ?>
              </div>
              <h3><?= e($review[2]) ?></h3>
              <p><?= e($review[3]) ?></p>
              <a class="client-review-read" href="<?= e($group['url']) ?>" target="_blank" rel="noopener">Read more +</a>
              <footer class="client-review-author">
                <span class="client-review-avatar"><?= e($review[0]) ?><i aria-hidden="true">✓</i></span>
                <span><strong><?= e($review[1]) ?></strong><small>Sample testimonial</small></span>
              </footer>
            </article>
          <?php endforeach; ?>
        </div>
        <a class="client-review-all" href="<?= e($group['url']) ?>" target="_blank" rel="noopener">View all <?= e($group['label']) ?> reviews <span aria-hidden="true">→</span></a>
      </div>
    <?php endforeach; ?>

    <p class="client-review-disclosure">These testimonials, names and ratings are fictional placeholders for this website demo, not verified Google or Tripadvisor reviews.</p>
  </div>
</section>

<section id="faq" class="home-faq-section" aria-labelledby="home-faq-title">
  <div class="site-shell home-faq-layout">
    <div class="home-faq-intro">
      <p class="eyebrow text-pine">Frequently asked questions</p>
      <h2 id="home-faq-title">Planning your Himalayan journey</h2>
      <p>Clear answers about personalized trips, timing, guides and what happens after you contact us.</p>
      <a class="btn-primary" href="<?= url('contact.php') ?>">Ask a different question <span aria-hidden="true">&nearr;</span></a>
    </div>

    <div class="home-faq-list" data-accordion>
      <?php
      $homeFaqs = [
        ['How does personalized trip pricing work?', 'Your proposal is shaped around your dates, group size, route, accommodation and transport preferences. We explain the confirmed inclusions before you decide whether to book.'],
        ['When is the best time to trek in Nepal?', 'Spring and autumn are common planning seasons for many routes, but the best window depends on the region, altitude and type of journey. We recommend dates after learning which trip interests you.'],
        ['Can beginners plan a Himalayan trek?', 'Yes. We can recommend realistic routes and pacing based on your experience, available time and preferred comfort. Some high-altitude or technical trips require stronger preparation.'],
        ['Are trips private or group based?', 'Our planning is personalized. Your proposal can be designed for a private traveler, couple, family or group, with guide and support arrangements matched to the confirmed itinerary.'],
        ['What is normally included in a proposal?', 'The final proposal clearly lists the planned accommodation, guides, permits, core transport and other confirmed services. Anything not included is shown separately.'],
        ['How do I start planning with Tin-Tin Trekking?', 'Send your dates, group details, interests and budget range through the planning form. We will review them and follow up with practical recommendations.'],
      ];
      foreach ($homeFaqs as $i => $faq):
      ?>
      <div class="accordion-item <?= $i === 0 ? 'open' : '' ?>">
        <button class="accordion-button" type="button" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>">
          <span class="home-faq-number"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <span class="home-faq-question"><?= e($faq[0]) ?></span>
          <span class="accordion-icon" aria-hidden="true">+</span>
        </button>
        <div class="accordion-content"><p><?= e($faq[1]) ?></p></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<div id="gallery-modal" class="gallery-modal hidden" role="dialog" aria-modal="true" aria-label="Himalayan photo viewer" aria-hidden="true">
  <button class="gallery-close" type="button" aria-label="Close gallery">×</button>
  <button class="gallery-prev" type="button" aria-label="Previous image">←</button>
  <figure><img src="" alt=""><figcaption></figcaption></figure>
  <button class="gallery-next" type="button" aria-label="Next image">→</button>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
