<?php
require_once __DIR__ . '/config.php';
send_security_headers();
$pageTitle = $pageTitle ?? 'Personalized Himalayan Treks';
$pageDescription = $pageDescription ?? 'Personalized Himalayan adventures designed around your budget, travel style, comfort and goals.';
?>
<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?> | Tin-Tin Trekking</title>
  <meta name="description" content="<?= e($pageDescription) ?>">
  <meta property="og:title" content="<?= e($pageTitle) ?> | Tin-Tin Trekking">
  <meta property="og:description" content="<?= e($pageDescription) ?>">
  <meta property="og:type" content="website">
  <meta property="og:image" content="<?= url('assets/images/everest-hero.png') ?>">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config={theme:{extend:{colors:{ink:'#123B5D',pine:'#237A57',leaf:'#46936F',mist:'#FFFFFF',sand:'#B8D5E5',ember:'#237A57'},fontFamily:{sans:['Inter','ui-sans-serif','system-ui'],display:['Space Grotesk','Inter','ui-sans-serif','system-ui'],ui:['Geist','Inter','ui-sans-serif','system-ui']}}}}</script>
  <link rel="stylesheet" href="<?= asset_url('assets/css/site.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('assets/css/trust-icons.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('assets/css/planner-layout.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('assets/css/font-system.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('assets/css/minimal-theme.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('assets/css/footer.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('assets/css/polish.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('chatbot/chat-widget.css') ?>">
  <?php if (!empty($includeLeaflet)): ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
  <?php endif; ?>
</head>
<body class="bg-white text-slate-700 antialiased">
<a href="#main" class="skip-link">Skip to content</a>
<div class="top-ribbon">
  <div class="site-shell flex h-10 items-center justify-between gap-4">
    <span class="hidden items-center gap-2 sm:flex"><span class="top-ribbon-dot"></span>Local Himalayan expertise &nbsp;·&nbsp; Personal planning &nbsp;·&nbsp; Safety first</span>
    <div class="ml-auto flex items-center gap-5"><a href="tel:+97714248404">Call <?= e(SITE['telephone']) ?></a><a href="mailto:<?= e(SITE['email']) ?>" class="hidden md:inline"><?= e(SITE['email']) ?></a></div>
  </div>
</div>
<header id="site-header" class="sticky top-0 z-50 border-b border-slate-200/70 bg-white/95 backdrop-blur-xl">
  <div class="site-shell flex h-[74px] items-center gap-7">
    <a href="<?= url('index.php') ?>" class="brand-lockup shrink-0" aria-label="Tin-Tin Trekking home"><img src="<?= asset_url('assets/images/tin-tin-logo.png') ?>" class="h-[62px] w-[118px] object-contain" alt="Tin-Tin Trekking & Adventure logo"></a>
    <nav class="desktop-nav hidden flex-1 items-center justify-center gap-7 xl:flex" aria-label="Main navigation">
      <a href="<?= url('gallery.php') ?>">Destinations</a>
      <a href="<?= url('index.php#treks') ?>">Trekking in Nepal</a>
      <a href="<?= url('about.php') ?>">About</a>
      <a href="<?= url('contact.php') ?>">Contact</a>
    </nav>
    <div class="ml-auto hidden items-center gap-3 xl:flex">
      <a class="header-whatsapp" href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noopener"><span class="status-dot"></span>WhatsApp</a>
      <a class="btn-primary header-cta text-xs" href="<?= url('budget-plan.php') ?>">Get My Budget Plan <span aria-hidden="true">↗</span></a>
    </div>
    <button id="menu-button" class="menu-button ml-auto xl:hidden" type="button" aria-expanded="false" aria-controls="mobile-menu" aria-label="Open menu"><span></span><span></span><span></span></button>
  </div>

  <div id="mobile-menu" class="hidden max-h-[calc(100vh-76px)] overflow-y-auto border-t bg-white xl:hidden">
    <nav class="site-shell flex flex-col py-5 text-lg font-semibold">
      <a href="<?= url('gallery.php') ?>">Destinations</a>
      <a href="<?= url('index.php#treks') ?>">Trekking in Nepal</a>
      <a href="<?= url('about.php') ?>">About</a>
      <a href="<?= url('contact.php') ?>">Contact</a>
      <a class="btn-primary mt-4 text-center" href="<?= url('budget-plan.php') ?>">Get My Budget Plan</a>
    </nav>
  </div>
</header>
<main id="main">
