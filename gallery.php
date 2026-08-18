<?php
$pageTitle = 'Himalayan Photo Gallery';
$pageDescription = 'Explore Tin-Tin Trekking destination photography from Nepal, Bhutan and Tibet.';
require __DIR__ . '/includes/header.php';

$galleryGroups = [
    'Nepal' => [
        ['Everest', 'High mountain trails', 'assets/images/everest-hero.png', 'Trekkers beneath Himalayan peaks at dawn', 'Everest region — the trail at first light'],
        ['Annapurna', 'Forest to sanctuary', 'assets/images/annapurna.png', 'Annapurna mountain above a rhododendron valley', 'Annapurna region — rhododendron forest and stone paths'],
        ['Manaslu', 'Remote mountain country', 'assets/images/manaslu.png', 'Remote Manaslu valley with prayer flags and a stone trail', 'Manaslu region — river valley, prayer flags and remote trails'],
        ['Kathmandu', 'Culture and heritage', 'assets/images/footer-nepal-cultural.png', 'Nepal mountain culture with temple architecture and Himalayan peaks', 'Kathmandu and Nepal culture — temples, village trails and Himalayan light'],
    ],
    'Bhutan' => [
        ['Tiger’s Nest', 'Paro, Bhutan', 'assets/images/bhutan-tigers-nest.png', 'Tiger’s Nest monastery built into a forested cliff in Bhutan', 'Bhutan — Paro Taktsang, the Tiger’s Nest monastery'],
    ],
    'Tibet' => [
        ['Tibetan Plateau', 'Mountains and open country', 'assets/images/tibet-plateau.png', 'Road leading across the Tibetan plateau toward snowy Himalayan mountains', 'Tibet — high plateau road, chorten and snow-covered Himalaya'],
    ],
];
?>

<section class="all-gallery-hero">
  <div class="site-shell">
    <p class="eyebrow text-pine">Destination photography</p>
    <h1>Himalaya,<br>in every frame.</h1>
    <p>Browse all available photographs from Nepal, Bhutan and Tibet. Select any image to open the full-screen viewer.</p>
    <nav aria-label="Gallery destinations">
      <?php foreach (array_keys($galleryGroups) as $groupName): ?>
        <a href="#gallery-<?= strtolower(e($groupName)) ?>"><?= e($groupName) ?></a>
      <?php endforeach; ?>
    </nav>
  </div>
</section>

<div class="all-gallery-content">
  <?php foreach ($galleryGroups as $groupName => $images): ?>
    <section id="gallery-<?= strtolower(e($groupName)) ?>" class="all-gallery-group scroll-mt-24">
      <div class="site-shell">
        <header><p><?= count($images) ?> <?= count($images) === 1 ? 'photograph' : 'photographs' ?></p><h2><?= e($groupName) ?></h2></header>
        <div class="all-gallery-grid">
          <?php foreach ($images as $image): ?>
            <button class="all-gallery-card" data-gallery-item data-src="<?= asset_url($image[2]) ?>" data-caption="<?= e($image[4]) ?>">
              <img loading="lazy" src="<?= asset_url($image[2]) ?>" alt="<?= e($image[3]) ?>">
              <span><strong><?= e($image[0]) ?></strong><small><?= e($image[1]) ?></small></span>
            </button>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endforeach; ?>
</div>

<div id="gallery-modal" class="gallery-modal hidden" role="dialog" aria-modal="true" aria-label="Himalayan photo viewer" aria-hidden="true">
  <button class="gallery-close" type="button" aria-label="Close gallery">×</button>
  <button class="gallery-prev" type="button" aria-label="Previous image">←</button>
  <figure><img src="" alt=""><figcaption></figcaption></figure>
  <button class="gallery-next" type="button" aria-label="Next image">→</button>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
