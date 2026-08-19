<?php
require_once __DIR__ . '/../data/treks.php';
if (!isset($slug, $treks[$slug])) { http_response_code(404); exit('Trek not found'); }

$trek = $treks[$slug];
$pageTitle = $trek['title'];
$pageDescription = $trek['summary'];
$includeLeaflet = true;
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
    ['bed', 'Accommodation', $trek['accommodation'] ?? 'Tea houses & hotels'],
    ['meal', 'Meals', 'Set with your plan'],
    ['route', 'Start / End point', $routePoints],
    ['private', 'Trip style', 'Private & personalized'],
    ['guide', 'Guide', 'Experienced local guide'],
    ['price', 'Pricing', 'Personalized proposal'],
];

$altitudeProfile = $trek['altitude_profile'];
$altitudeValues = array_column($altitudeProfile, 1);
$altitudeMinimum = min($altitudeValues);
$altitudeMaximum = max($altitudeValues);
$altitudeRange = max(1, $altitudeMaximum - $altitudeMinimum);
$altitudeChartWidth = max(900, count($altitudeProfile) * 112);
$altitudeChartHeight = 350;
$altitudePlotLeft = 62;
$altitudePlotRight = 46;
$altitudePlotTop = 68;
$altitudePlotBottom = 282;
$altitudePlotWidth = $altitudeChartWidth - $altitudePlotLeft - $altitudePlotRight;
$altitudePlotHeight = $altitudePlotBottom - $altitudePlotTop;
$altitudeChartPoints = [];
foreach ($altitudeProfile as $index => $stop) {
    $x = $altitudePlotLeft + ($index * ($altitudePlotWidth / max(1, count($altitudeProfile) - 1)));
    $y = $altitudePlotBottom - ((($stop[1] - $altitudeMinimum) / $altitudeRange) * $altitudePlotHeight);
    $altitudeChartPoints[] = ['x' => round($x, 1), 'y' => round($y, 1), 'name' => $stop[0], 'meters' => $stop[1]];
}
$altitudeLinePoints = implode(' ', array_map(static fn(array $point): string => $point['x'] . ',' . $point['y'], $altitudeChartPoints));
$altitudeAreaPoints = $altitudePlotLeft . ',' . $altitudePlotBottom . ' ' . $altitudeLinePoints . ' ' . ($altitudeChartWidth - $altitudePlotRight) . ',' . $altitudePlotBottom;
$routeMapPoints = array_map(static function (array $stop, int $index) use ($trek): array {
    $mapOptions = isset($stop[4]) && is_array($stop[4]) ? $stop[4] : [];
    return [
        'day' => $index + 1,
        'name' => $stop[0],
        'meters' => $stop[1],
        'lat' => $stop[2],
        'lng' => $stop[3],
        'summary' => $trek['itinerary'][$index][1] ?? '',
        'connectFromPrevious' => $index > 0 && ($mapOptions['connect'] ?? true),
        'mapFocus' => $mapOptions['focus'] ?? true,
    ];
}, $altitudeProfile, array_keys($altitudeProfile));
$routeMapJson = json_encode($routeMapPoints, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

$infographicPoints = [];
$infographicItemsPerRow = 5;
$infographicBaseY = 548;
$infographicRowGap = 128;
$infographicXGap = 220;
foreach ($altitudeProfile as $index => $stop) {
    $row = intdiv($index, $infographicItemsPerRow);
    $column = $index % $infographicItemsPerRow;
    if ($row % 2 === 1) { $column = $infographicItemsPerRow - 1 - $column; }
    $x = 105 + ($column * $infographicXGap);
    $y = $infographicBaseY - ($row * $infographicRowGap) + (sin($index * 1.35) * 18);
    $infographicPoints[] = ['x' => round($x, 1), 'y' => round($y, 1), 'name' => $stop[0], 'meters' => $stop[1]];
}
$infographicPath = '';
foreach ($infographicPoints as $index => $point) {
    if ($index === 0) {
        $infographicPath = 'M ' . $point['x'] . ' ' . $point['y'];
        continue;
    }
    $previous = $infographicPoints[$index - 1];
    $middleX = round(($previous['x'] + $point['x']) / 2, 1);
    $infographicPath .= ' C ' . $middleX . ' ' . $previous['y'] . ', ' . $middleX . ' ' . $point['y'] . ', ' . $point['x'] . ' ' . $point['y'];
}

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
        <div class="trip-altitude-card" data-altitude-profile aria-label="Illustrative day-by-day altitude profile">
          <div class="trip-altitude-toolbar">
            <div class="trip-altitude-units" aria-label="Altitude unit">
              <span>Altitude in:</span>
              <button class="active" type="button" data-altitude-unit="meter" aria-pressed="true">Meter</button>
              <i aria-hidden="true"></i>
              <button type="button" data-altitude-unit="feet" aria-pressed="false">Feet</button>
            </div>
            <button class="trip-altitude-download" type="button" data-altitude-download data-download-name="<?= e($trek['slug']) ?>-altitude-profile.svg">
              <span aria-hidden="true">&#8681;</span> Download
            </button>
          </div>

          <div class="trip-altitude-scroll">
            <svg class="trip-altitude-svg" width="<?= $altitudeChartWidth ?>" height="<?= $altitudeChartHeight ?>" viewBox="0 0 <?= $altitudeChartWidth ?> <?= $altitudeChartHeight ?>" role="img" aria-labelledby="altitude-chart-title-<?= e($trek['slug']) ?> altitude-chart-desc-<?= e($trek['slug']) ?>">
              <title id="altitude-chart-title-<?= e($trek['slug']) ?>"><?= e($trek['title']) ?> altitude profile</title>
              <desc id="altitude-chart-desc-<?= e($trek['slug']) ?>">An illustrative line chart showing the planned overnight stops and elevations for each day.</desc>
              <defs>
                <linearGradient id="altitude-fill-<?= e($trek['slug']) ?>" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="0" stop-color="#dceef6" stop-opacity=".82"></stop>
                  <stop offset="1" stop-color="#f4f8fa" stop-opacity=".75"></stop>
                </linearGradient>
              </defs>
              <line class="trip-altitude-gridline" x1="<?= $altitudePlotLeft ?>" y1="<?= $altitudePlotTop ?>" x2="<?= $altitudeChartWidth - $altitudePlotRight ?>" y2="<?= $altitudePlotTop ?>"></line>
              <line class="trip-altitude-gridline" x1="<?= $altitudePlotLeft ?>" y1="<?= ($altitudePlotTop + $altitudePlotBottom) / 2 ?>" x2="<?= $altitudeChartWidth - $altitudePlotRight ?>" y2="<?= ($altitudePlotTop + $altitudePlotBottom) / 2 ?>"></line>
              <line class="trip-altitude-axis" x1="<?= $altitudePlotLeft ?>" y1="<?= $altitudePlotBottom ?>" x2="<?= $altitudeChartWidth - $altitudePlotRight ?>" y2="<?= $altitudePlotBottom ?>"></line>
              <polygon class="trip-altitude-area" points="<?= $altitudeAreaPoints ?>" fill="url(#altitude-fill-<?= e($trek['slug']) ?>)"></polygon>
              <polyline class="trip-altitude-line" points="<?= $altitudeLinePoints ?>"></polyline>
              <?php foreach ($altitudeChartPoints as $index => $point): ?>
                <?php
                $labelLines = array_slice(explode("\n", wordwrap($point['name'], 15, "\n", true)), 0, 2);
                $labelY = $point['y'] - (count($labelLines) * 13) - 16 - (($index % 2) * 7);
                if ($labelY < 16) { $labelY = $point['y'] + 20; }
                $feet = (int) round($point['meters'] * 3.28084);
                ?>
                <g class="trip-altitude-point">
                  <circle cx="<?= $point['x'] ?>" cy="<?= $point['y'] ?>" r="4"></circle>
                  <text class="trip-altitude-stop" x="<?= $point['x'] ?>" y="<?= round($labelY, 1) ?>" text-anchor="middle">
                    <?php foreach ($labelLines as $lineIndex => $line): ?><tspan x="<?= $point['x'] ?>" dy="<?= $lineIndex === 0 ? 0 : 13 ?>"><?= e($line) ?></tspan><?php endforeach; ?>
                    <tspan class="trip-altitude-value" x="<?= $point['x'] ?>" dy="14" data-meter="<?= number_format($point['meters']) ?> m" data-feet="<?= number_format($feet) ?> ft"><?= number_format($point['meters']) ?> m</tspan>
                  </text>
                  <text class="trip-altitude-day" x="<?= $point['x'] ?>" y="322" text-anchor="middle">Day <?= $index + 1 ?></text>
                </g>
              <?php endforeach; ?>
            </svg>
          </div>
          <p>Illustrative profile, not a navigation chart. Elevations and daily stops may change in your confirmed route.</p>
        </div>
        <div class="trip-route-notes"><p><strong>Difficulty</strong><?= e($trek['difficulty']) ?>, assessed from daily distance, elevation and conditions.</p><p><strong>Best season</strong><?= e($trek['season']) ?> is the usual planning window, though mountain conditions vary.</p></div>

        <section class="trip-interactive-map" data-route-map data-route-points="<?= e((string) $routeMapJson) ?>" aria-labelledby="interactive-map-title-<?= e($trek['slug']) ?>">
          <header class="trip-map-heading">
            <div><p class="eyebrow text-pine">Follow the journey</p><h3 id="interactive-map-title-<?= e($trek['slug']) ?>">Interactive Map</h3></div>
            <div class="trip-map-tabs" role="tablist" aria-label="Route view">
              <button class="active" type="button" role="tab" aria-selected="true" data-route-view="map">Map</button>
              <button type="button" role="tab" aria-selected="false" data-route-view="elevation">Elevation</button>
            </div>
          </header>

          <div class="trip-map-panel" data-route-panel="map">
            <nav class="trip-map-days" aria-label="Select itinerary day"></nav>
            <div class="trip-map-canvas" id="route-map-<?= e($trek['slug']) ?>" aria-label="Illustrative trek route map"></div>
            <article class="trip-map-summary" aria-live="polite">
              <span>Day 1</span><strong></strong><p></p>
            </article>
          </div>

          <div class="trip-map-elevation-panel hidden" data-route-panel="elevation">
            <div class="trip-map-elevation-list" aria-label="Day-by-day elevation list"></div>
          </div>
          <p class="trip-map-disclaimer">Approximate route visualization only. It is not intended for trail navigation.</p>
        </section>

        <section class="trip-infographic" aria-labelledby="infographic-title-<?= e($trek['slug']) ?>">
          <header class="trip-infographic-heading">
            <div><p class="eyebrow text-pine">Route at a glance</p><h3 id="infographic-title-<?= e($trek['slug']) ?>">Infographic Map</h3></div>
            <button class="trip-infographic-download" type="button" data-svg-download data-download-name="<?= e($trek['slug']) ?>-infographic-map.svg">Download <span aria-hidden="true">&#8681;</span></button>
          </header>
          <div class="trip-infographic-scroll">
            <svg class="trip-infographic-svg" width="1100" height="690" viewBox="0 0 1100 690" role="img" aria-labelledby="infographic-svg-title-<?= e($trek['slug']) ?> infographic-svg-desc-<?= e($trek['slug']) ?>">
              <title id="infographic-svg-title-<?= e($trek['slug']) ?>"><?= e($trek['title']) ?> infographic route map</title>
              <desc id="infographic-svg-desc-<?= e($trek['slug']) ?>">A schematic route showing each itinerary day, stop and approximate elevation.</desc>
              <style>
                .info-bg{fill:#fff}.info-mountain-a{fill:#1591a1}.info-mountain-b{fill:#0b7285}.info-snow{fill:#eefafa}.info-range{fill:#237a57;font:700 10px Arial,sans-serif;letter-spacing:.04em}.info-route-shadow{fill:none;stroke:#d9ecdf;stroke-width:12;stroke-linecap:round;stroke-linejoin:round}.info-route{fill:none;stroke:#299b38;stroke-width:5;stroke-linecap:round;stroke-linejoin:round}.info-day{fill:#ffd326;stroke:#fff;stroke-width:3}.info-end{fill:#8d0d2d;stroke:#fff;stroke-width:3}.info-day-text{fill:#163b29;font:800 11px Arial,sans-serif}.info-label{fill:#267f3f;font:700 10px Arial,sans-serif}.info-altitude{fill:#536a5c;font:600 9px Arial,sans-serif}.info-legend{fill:#fff;stroke:#237a57;stroke-width:2}.info-legend-title{fill:#111;font:800 11px Arial,sans-serif}.info-legend-text{fill:#31443a;font:700 9px Arial,sans-serif}.info-ribbon{fill:#237a27}.info-ribbon-text{fill:#fff;font:800 18px Arial,sans-serif;letter-spacing:.04em}.info-note{fill:#6b7b72;font:10px Arial,sans-serif}
              </style>
              <rect class="info-bg" width="1100" height="690" rx="16"></rect>

              <g transform="translate(420 30)"><path class="info-mountain-a" d="M0 58 42 5l25 31 18-20 42 42Z"></path><path class="info-mountain-b" d="m42 5 25 31 18-20 42 42H62Z"></path><path class="info-snow" d="m42 5 12 15 8-5 10 15-5 6Z"></path><text class="info-range" x="63" y="74" text-anchor="middle"><?= e($trek['region']) ?></text></g>
              <g transform="translate(720 22)"><path class="info-mountain-a" d="M0 58 38 10l22 27 20-23 44 44Z"></path><path class="info-mountain-b" d="m38 10 22 27 20-23 44 44H58Z"></path><path class="info-snow" d="m38 10 11 14 8-5 8 13-5 5Z"></path><text class="info-range" x="62" y="74" text-anchor="middle">Highest point <?= e($trek['altitude']) ?></text></g>

              <path class="info-route-shadow" d="<?= e($infographicPath) ?>"></path>
              <path class="info-route" d="<?= e($infographicPath) ?>"></path>

              <?php foreach ($infographicPoints as $index => $point): ?>
                <?php
                $isEndpoint = $index === 0 || $index === count($infographicPoints) - 1;
                $labelLines = array_slice(explode("\n", wordwrap($point['name'], 17, "\n", true)), 0, 2);
                $labelAbove = $point['y'] > 490 || $index % 2 === 0;
                $labelY = $labelAbove ? $point['y'] - 34 - ((count($labelLines) - 1) * 12) : $point['y'] + 35;
                ?>
                <g>
                  <circle class="<?= $isEndpoint ? 'info-end' : 'info-day' ?>" cx="<?= $point['x'] ?>" cy="<?= $point['y'] ?>" r="<?= $isEndpoint ? 11 : 16 ?>"></circle>
                  <?php if (!$isEndpoint): ?><text class="info-day-text" x="<?= $point['x'] ?>" y="<?= $point['y'] + 4 ?>" text-anchor="middle"><?= $index + 1 ?></text><?php endif; ?>
                  <text class="info-label" x="<?= $point['x'] ?>" y="<?= round($labelY, 1) ?>" text-anchor="middle">
                    <?php foreach ($labelLines as $lineIndex => $line): ?><tspan x="<?= $point['x'] ?>" dy="<?= $lineIndex === 0 ? 0 : 12 ?>"><?= e($line) ?></tspan><?php endforeach; ?>
                    <tspan class="info-altitude" x="<?= $point['x'] ?>" dy="12"><?= number_format($point['meters']) ?> m</tspan>
                  </text>
                </g>
              <?php endforeach; ?>

              <g transform="translate(25 24)">
                <rect class="info-legend" width="170" height="118" rx="8"></rect>
                <text class="info-legend-title" x="14" y="23">LEGEND</text>
                <circle class="info-day" cx="22" cy="45" r="8"></circle><text class="info-legend-text" x="40" y="49">ITINERARY DAY</text>
                <line class="info-route" x1="14" y1="70" x2="31" y2="70"></line><text class="info-legend-text" x="40" y="74">TREKKING TRAIL</text>
                <circle class="info-end" cx="22" cy="96" r="7"></circle><text class="info-legend-text" x="40" y="100">START / FINISH</text>
              </g>
              <text class="info-note" x="1075" y="615" text-anchor="end">Schematic illustration — not for navigation</text>
              <rect class="info-ribbon" x="0" y="630" width="1100" height="60"></rect>
              <text class="info-ribbon-text" x="550" y="667" text-anchor="middle"><?= e(strtoupper($trek['title'])) ?> — <?= e(strtoupper($trek['duration'])) ?></text>
            </svg>
          </div>
        </section>
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
