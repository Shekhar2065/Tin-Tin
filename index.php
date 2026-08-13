<?php
$pageTitle = 'Personalized Himalayan Treks Built Around You';
$pageDescription = 'Tell us your budget and Tin-Tin Trekking will create a personalized Himalayan adventure around your travel style, comfort and goals.';
require __DIR__ . '/data/treks.php';
$featuredActivities = [
  'trekking' => [
    ['Everest Base Camp Trek','Everest Region','15 days','Challenging','assets/images/everest-hero.png','Walk through Sherpa country to the foot of the world’s highest mountain.','treks/everest-base-camp.php'],
    ['Annapurna Base Camp Trek','Annapurna Region','11 days','Moderate','assets/images/annapurna.png','Forest, mountain villages and the extraordinary Annapurna Sanctuary.','treks/annapurna-base-camp.php'],
    ['Langtang Valley Trek','Langtang Region','9 days','Moderate','assets/images/manaslu.png','A close-to-Kathmandu journey rich in valley landscapes and Tamang culture.','treks/langtang-valley.php'],
    ['Manaslu Circuit Trek','Manaslu Region','17 days','Challenging','assets/images/manaslu.png','A quieter high circuit through remote villages and the Larkya La.','treks/manaslu-circuit.php'],
  ],
  'camping' => [
    ['Remote Nepal Camping Journey','Western Nepal','Tailored','Challenging','assets/images/manaslu.png','A supported tented journey for routes where teahouse infrastructure is limited.','budget-plan.php?trek=Remote+Nepal+Camping+Journey'],
    ['Dhaulagiri Circuit Camping','Dhaulagiri Region','18 days','Challenging','assets/images/everest-hero.png','High mountain camps, wild valleys and a carefully paced expedition-style route.','budget-plan.php?trek=Dhaulagiri+Circuit+Camping'],
    ['Kanchenjunga Camp Trek','Eastern Nepal','Tailored','Challenging','assets/images/annapurna.png','A remote eastern Himalayan experience designed around permits and logistics.','budget-plan.php?trek=Kanchenjunga+Camp+Trek'],
    ['Limi Valley Cultural Camp','Far-West Nepal','Tailored','Moderate','assets/images/footer-nepal-cultural.png','Camping, village encounters and quiet landscapes in a culturally distinct valley.','budget-plan.php?trek=Limi+Valley+Cultural+Camp'],
  ],
  'cycling' => [
    ['Kathmandu Valley Ridge Cycling','Kathmandu Valley','3–5 days','Moderate','assets/images/footer-nepal-cultural.png','Village roads, heritage stops and green ridgelines around the Kathmandu Valley.','budget-plan.php?trek=Kathmandu+Valley+Ridge+Cycling'],
    ['Lower Mustang Mountain Biking','Mustang Region','8 days','Challenging','assets/images/manaslu.png','High-desert tracks, river valleys and traditional settlements beneath the Annapurnas.','budget-plan.php?trek=Lower+Mustang+Mountain+Biking'],
    ['Pokhara Hills Cycling','Pokhara Region','4 days','Easy–Moderate','assets/images/annapurna.png','Lakeside starts, rural lanes and wide Annapurna views at a relaxed pace.','budget-plan.php?trek=Pokhara+Hills+Cycling'],
    ['Annapurna Mountain Bike Journey','Annapurna Region','Tailored','Challenging','assets/images/everest-hero.png','A demanding multi-day ride shaped around ability, support and trail conditions.','budget-plan.php?trek=Annapurna+Mountain+Bike+Journey'],
  ],
  'climbing' => [
    ['Guided Peak Program','Nepal Himalaya','Tailored','Advanced','assets/images/everest-hero.png','A safety-led guided plan matched to experience, conditions and realistic objectives.','budget-plan.php?trek=Guided+Peak+Program'],
    ['Everest Region Peak Journey','Everest Region','Tailored','Advanced','assets/images/everest-hero.png','A trekking and guided climbing program with deliberate acclimatization.','budget-plan.php?trek=Everest+Region+Peak+Journey'],
    ['Mera Region Peak Journey','Makalu–Barun Region','Tailored','Advanced','assets/images/manaslu.png','A remote approach and guided summit program planned around the team.','budget-plan.php?trek=Mera+Region+Peak+Journey'],
    ['Peak Recommendation','Nepal Himalaya','Custom','Assessment required','assets/images/annapurna.png','Not sure which objective fits? Start with experience, fitness and timing.','budget-plan.php?trek=Peak+Recommendation'],
  ],
  'culture' => [
    ['Kathmandu Heritage Journey','Kathmandu Valley','1–3 days','Relaxed','assets/images/footer-nepal-cultural.png','Living heritage, courtyards, temples and local neighborhoods with a flexible pace.','budget-plan.php?trek=Kathmandu+Heritage+Journey'],
    ['Bhutan Cultural Tour','Bhutan','Tailored','Relaxed','assets/images/annapurna.png','Monasteries, valleys and cultural encounters designed as a private journey.','budget-plan.php?trek=Bhutan+Cultural+Tour'],
    ['Tibet Cultural Journey','Tibet','Tailored','Moderate','assets/images/manaslu.png','A considered high-plateau itinerary shaped around access and acclimatization.','budget-plan.php?trek=Tibet+Cultural+Journey'],
    ['Nepal Village & Food Journey','Nepal','Tailored','Relaxed','assets/images/footer-nepal-cultural.png','Village life, regional food and landscape woven into a slower cultural route.','budget-plan.php?trek=Nepal+Village+Food+Journey'],
  ],
];
require __DIR__ . '/includes/header.php';
?>
<section class="home-hero planner-hero relative min-h-[680px] overflow-hidden bg-ink text-white md:min-h-[720px]">
  <img src="<?= url('assets/images/everest-hero.png') ?>" class="absolute inset-0 h-full w-full object-cover object-center" alt="Trekkers walking beneath Himalayan peaks at dawn">
  <div class="hero-shade absolute inset-0"></div>
  <div class="site-shell relative flex min-h-[680px] items-center pb-40 pt-20 md:min-h-[720px] md:pb-44">
    <div class="hero-copy max-w-3xl">
      <p class="hero-kicker mb-6 text-[10px] font-bold uppercase tracking-[.18em] text-white">Personal journeys · Nepal, Bhutan & Tibet</p>
      <h1 class="font-display text-5xl leading-[.94] text-white sm:text-6xl md:text-7xl lg:text-[5.3rem]">Nepal trekking, tours<br><em class="text-[#91D2B6]">and Himalayan adventure.</em></h1>
      <p class="mt-7 max-w-2xl text-base leading-7 text-slate-200 md:text-lg">Explore trusted routes, then tell us your budget and priorities. We’ll turn them into a personal Himalayan plan.</p>
      <div class="mt-9 flex flex-col gap-3 sm:flex-row"><a class="btn-light" href="<?= url('budget-plan.php') ?>">Get My Budget Plan</a><a class="btn-outline" href="#treks">Explore Treks</a></div>
      <p class="mt-8 flex items-center gap-3 text-xs font-semibold tracking-wide text-slate-300"><span class="h-px w-8 bg-slate-400"></span>Designed locally in Kathmandu, one considered detail at a time.</p>
    </div>
    <form class="trip-finder" action="<?= url('budget-plan.php') ?>" method="get">
      <div class="trip-finder-heading"><span>Find your journey</span><small>Start with an idea. We’ll personalize the rest.</small></div>
      <label><span>Destination</span><select name="destination"><option>Nepal</option><option>Bhutan</option><option>Tibet</option><option>Not sure</option></select></label>
      <label><span>Activity</span><select name="trek"><option value="Not sure — recommend something">All activities</option><option>Trekking</option><option>Camping</option><option>Mountain Biking</option><option>Peak Climbing</option><option>Cultural Tour</option></select></label>
      <label><span>Duration</span><select name="duration"><option>Any duration</option><option>Under 7 days</option><option>7–12 days</option><option>13–18 days</option><option>19+ days</option></select></label>
      <button type="submit">Plan my trip <span>→</span></button>
    </form>
  </div>
</section>
<section class="trust-strip border-b border-slate-200">
  <div class="site-shell grid grid-cols-2 divide-x divide-slate-200 py-5 text-center md:grid-cols-5">
    <div class="trust-pillar"><span class="trust-icon"><svg viewBox="0 0 32 32" aria-hidden="true"><path d="M3 25L11 12l5 7 4-10 9 16M8 25h20"/><path d="M19 12l2 2 3-4"/></svg></span><span>Local Himalayan Expertise</span></div>
    <div class="trust-pillar"><span class="trust-icon"><svg viewBox="0 0 32 32" aria-hidden="true"><circle cx="16" cy="9" r="4"/><path d="M9 27v-7c0-4 3-7 7-7s7 3 7 7v7M12 18l4 3 4-3"/><path d="M24 13l3 3-5 5"/></svg></span><span>Experienced Guides</span></div>
    <div class="trust-pillar"><span class="trust-icon"><svg viewBox="0 0 32 32" aria-hidden="true"><path d="M16 3l11 4v8c0 7-4 11-11 14C9 26 5 22 5 15V7l11-4z"/><path d="M10 16l4 4 8-9"/></svg></span><span>Safety First</span></div>
    <div class="trust-pillar"><span class="trust-icon"><svg viewBox="0 0 32 32" aria-hidden="true"><path d="M5 6h9l3 3h10v17H5V6z"/><path d="M9 21l5-6 4 3 5-6"/><circle cx="9" cy="21" r="1.5"/><circle cx="23" cy="12" r="1.5"/></svg></span><span>Personalized Itineraries</span></div>
    <div class="trust-pillar last:col-span-2 md:last:col-span-1"><span class="trust-icon"><svg viewBox="0 0 32 32" aria-hidden="true"><path d="M6 17a10 10 0 0120 0"/><path d="M6 17v7h5v-9H6m20 2v7h-5v-9h5M21 27h-5"/><circle cx="14" cy="27" r="2"/></svg></span><span>Dedicated Support</span></div>
  </div>
</section>

<section id="treks" class="featured-activities py-20 md:py-28">
  <div class="site-shell">
    <div class="platform-review-intro grid gap-7 lg:grid-cols-[.85fr_1.15fr] lg:items-end">
      <div><p class="eyebrow text-pine">Featured journeys</p><h2 class="mt-3 font-display text-5xl text-ink md:text-7xl">Choose how you<br>meet the Himalaya.</h2></div>
      <p class="max-w-2xl text-lg leading-8 lg:justify-self-end">Trek between high villages, camp in remote country, ride mountain trails, explore living culture or ask us to shape something entirely personal.</p>
    </div>
    <div class="offer-tabs mt-12" role="tablist" aria-label="Featured activity categories">
      <button class="offer-tab active" data-offer-filter="trekking" role="tab" aria-selected="true" aria-controls="activity-panel-trekking"><svg viewBox="0 0 32 32" aria-hidden="true"><path d="M4 25L12 12l4 6 4-9 8 16M8 25h20"/></svg><span>Trekking</span><small>Classic journeys</small></button>
      <button class="offer-tab" data-offer-filter="camping" role="tab" aria-selected="false" aria-controls="activity-panel-camping"><svg viewBox="0 0 32 32" aria-hidden="true"><path d="M3 26L16 7l13 19M9 26l7-11 7 11M16 7v19"/></svg><span>Camping</span><small>Remote routes</small></button>
      <button class="offer-tab" data-offer-filter="cycling" role="tab" aria-selected="false" aria-controls="activity-panel-cycling"><svg viewBox="0 0 32 32" aria-hidden="true"><circle cx="8" cy="22" r="5"/><circle cx="24" cy="22" r="5"/><path d="M8 22l6-10 5 10H8l7-7h5M13 9h5"/></svg><span>Cycling</span><small>Mountain & valley</small></button>
      <button class="offer-tab" data-offer-filter="climbing" role="tab" aria-selected="false" aria-controls="activity-panel-climbing"><svg viewBox="0 0 32 32" aria-hidden="true"><path d="M3 26L12 9l5 8 4-11 8 20M11 12l3 1 2-3M21 9l3 3"/></svg><span>Peak climbing</span><small>Guided programs</small></button>
      <button class="offer-tab" data-offer-filter="culture" role="tab" aria-selected="false" aria-controls="activity-panel-culture"><svg viewBox="0 0 32 32" aria-hidden="true"><path d="M5 27h22M8 27V14h16v13M6 14h20l-3-4H9l-3 4zM12 10l4-5 4 5M13 18v5m6-5v5"/></svg><span>Culture & tours</span><small>Nepal, Bhutan, Tibet</small></button>
    </div>
    <?php foreach ($featuredActivities as $categoryKey => $items): ?>
    <div id="activity-panel-<?= e($categoryKey) ?>" class="offer-panel <?= $categoryKey === 'trekking' ? '' : 'hidden' ?>" data-offer-panel="<?= e($categoryKey) ?>" role="tabpanel">
      <div class="offer-grid">
        <?php foreach ($items as $item): ?>
        <article class="offer-card">
          <a href="<?= url($item[6]) ?>" class="offer-image"><img loading="lazy" src="<?= url($item[4]) ?>" alt="<?= e($item[0]) ?> landscape"><span><?= e(ucfirst($categoryKey)) ?></span></a>
          <div class="offer-body"><p class="offer-region"><?= e($item[1]) ?></p><h3><a href="<?= url($item[6]) ?>"><?= e($item[0]) ?></a></h3><div class="offer-meta"><span><b><?= e($item[2]) ?></b> Duration</span><span><b><?= e($item[3]) ?></b> Style</span></div><p class="offer-summary"><?= e($item[5]) ?></p><div class="offer-footer"><span>Custom plan</span><a href="<?= url($item[6]) ?>">Explore <b>→</b></a></div></div>
        </article>
        <?php endforeach; ?>
      </div>
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
<section id="why-tintin" class="why-tintin scroll-mt-24" aria-labelledby="why-tintin-heading">
  <div class="site-shell why-tintin-inner">
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
<section class="planning-section bg-ink py-20 text-white md:py-28">
  <div class="site-shell"><div class="max-w-2xl"><p class="eyebrow text-emerald-200">Budget-based planning, explained</p><h2 class="mt-4 font-display text-4xl text-white md:text-6xl">A better journey begins with an honest conversation.</h2></div>
    <div class="mt-12 grid border-y border-white/15 md:grid-cols-2 xl:grid-cols-4">
      <?php $steps=[['01','Tell Us Your Budget','Choose a useful budget range—only inside our private inquiry.'],['02','Tell Us What You Want','Share dates, group size, experience and what matters to you.'],['03','We Design Your Trip','We balance route, lodging, transport and service around your priorities.'],['04','Receive Your Plan','You receive a personalized proposal with clear inclusions.']]; foreach($steps as $s): ?><div class="border-b border-white/15 p-7 md:border-r xl:border-b-0"><span class="font-display text-4xl text-emerald-300"><?= $s[0] ?></span><h3 class="mt-8 text-lg font-bold text-white"><?= e($s[1]) ?></h3><p class="mt-3 text-sm leading-6 text-slate-300"><?= e($s[2]) ?></p></div><?php endforeach; ?>
    </div>
    <div class="mt-8 grid gap-5 rounded-sm bg-white/5 p-7 md:grid-cols-2 lg:grid-cols-4"><p class="text-sm"><b class="text-white">Accommodation</b><br>Lodge and hotel level</p><p class="text-sm"><b class="text-white">Privacy</b><br>Room and group arrangements</p><p class="text-sm"><b class="text-white">Transport</b><br>Shared or private options</p><p class="text-sm"><b class="text-white">Experiences</b><br>Culture, nature and extensions</p></div>
  </div>
</section>

<section id="gallery" class="gallery-section py-20 md:py-28">
  <div class="site-shell">
    <div class="grid gap-7 lg:grid-cols-[.8fr_1.2fr] lg:items-end">
      <div><p class="eyebrow text-pine">Through the lens</p><h2 class="mt-3 font-display text-5xl text-ink md:text-7xl">Himalaya,<br>in moments.</h2></div>
      <div class="max-w-xl lg:justify-self-end"><p class="text-lg leading-8">From first light on the high peaks to quiet village trails, these landscapes shape every journey we plan.</p><p class="mt-3 text-xs font-bold uppercase tracking-[.16em] text-slate-500">Select an image to explore</p></div>
    </div>
    <div class="gallery-grid mt-12">
      <button class="gallery-tile gallery-tile-feature" data-gallery-item data-src="<?= url('assets/images/footer-nepal-cultural.png') ?>" data-caption="Himalayan culture — chorten, village trail and mountain light"><img loading="lazy" src="<?= url('assets/images/footer-nepal-cultural.png') ?>" alt="Nepal mountain culture with a chorten, prayer flags and stone village"><span><b>Nepal culture</b><small>Village trail · Himalaya</small></span></button>
      <button class="gallery-tile" data-gallery-item data-src="<?= url('assets/images/everest-hero.png') ?>" data-caption="Everest region — the trail at first light"><img loading="lazy" src="<?= url('assets/images/everest-hero.png') ?>" alt="Trekkers beneath Himalayan peaks at dawn"><span><b>Everest region</b><small>High mountain morning</small></span></button>
      <button class="gallery-tile" data-gallery-item data-src="<?= url('assets/images/annapurna.png') ?>" data-caption="Annapurna region — rhododendron forest and stone paths"><img loading="lazy" src="<?= url('assets/images/annapurna.png') ?>" alt="Annapurna mountain above a rhododendron valley"><span><b>Annapurna</b><small>Forest to sanctuary</small></span></button>
      <button class="gallery-tile gallery-tile-wide" data-gallery-item data-src="<?= url('assets/images/manaslu.png') ?>" data-caption="Manaslu region — river valley, prayer flags and remote trails"><img loading="lazy" src="<?= url('assets/images/manaslu.png') ?>" alt="Remote Manaslu valley with prayer flags and stone trail"><span><b>Manaslu</b><small>Remote mountain country</small></span></button>
    </div>
  </div>
</section>

<section id="reviews" class="platform-reviews py-20 md:py-28">
  <div class="site-shell">
    <div class="grid gap-7 lg:grid-cols-[.85fr_1.15fr] lg:items-end">
      <div><p class="eyebrow text-pine">Independent reviews</p><h2 class="mt-3 font-display text-5xl text-ink md:text-7xl">Read reviews on<br>trusted platforms.</h2></div>
      <p class="max-w-2xl text-lg leading-8 lg:justify-self-end">See recent traveler feedback on Google and Tripadvisor. Ratings and review counts are shown only on the platforms themselves so they always remain current.</p>
    </div>

    <div class="platform-review-grid mt-12 grid gap-5 lg:grid-cols-2">
      <article class="platform-review-card platform-review-google">
        <div class="platform-review-head">
          <div class="google-mark" aria-hidden="true"><span>G</span></div>
          <div><p class="platform-review-label">Reviews on</p><h3>Google</h3></div>
        </div>
        <div class="platform-review-body">
          <div class="platform-review-stars" aria-hidden="true">☆☆☆☆☆</div>
          <p>Open Google to view Tin-Tin Trekking&rsquo;s current rating, verified review count and traveler comments.</p>
        </div>
        <div class="platform-review-footer">
          <span><i></i>Live platform results</span>
          <a href="<?= e(SITE['google_reviews_url']) ?>" target="_blank" rel="noopener">View Google Reviews <b aria-hidden="true">&nearr;</b></a>
        </div>
      </article>

      <article class="platform-review-card platform-review-tripadvisor">
        <div class="platform-review-head">
          <svg class="tripadvisor-mark" viewBox="0 0 64 40" aria-hidden="true"><path d="M18 10h28M22 10l3-5h14l3 5"/><circle cx="17" cy="23" r="11"/><circle cx="47" cy="23" r="11"/><circle cx="17" cy="23" r="4"/><circle cx="47" cy="23" r="4"/><path d="M28 25h8M8 12 3 8m53 4 5-4"/></svg>
          <div><p class="platform-review-label">Reviews on</p><h3>Tripadvisor</h3></div>
        </div>
        <div class="platform-review-body">
          <div class="tripadvisor-rating" aria-hidden="true"><span></span><span></span><span></span><span></span><span></span></div>
          <p>Open Tripadvisor to find the matching company profile and read its latest independent traveler feedback.</p>
        </div>
        <div class="platform-review-footer">
          <span><i></i>Profile search link</span>
          <a href="<?= e(SITE['tripadvisor_reviews_url']) ?>" target="_blank" rel="noopener">View Tripadvisor Reviews <b aria-hidden="true">&nearr;</b></a>
        </div>
      </article>
    </div>

    <p class="mt-5 text-xs leading-5 text-slate-500">Exact profile URLs, ratings and review counts can be connected when verified listing links are supplied.</p>
  </div>
</section>

<div id="gallery-modal" class="gallery-modal hidden" role="dialog" aria-modal="true" aria-label="Himalayan photo viewer" aria-hidden="true">
  <button class="gallery-close" type="button" aria-label="Close gallery">×</button>
  <button class="gallery-prev" type="button" aria-label="Previous image">←</button>
  <figure><img src="" alt=""><figcaption></figcaption></figure>
  <button class="gallery-next" type="button" aria-label="Next image">→</button>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
