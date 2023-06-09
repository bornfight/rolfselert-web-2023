<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" user-scalable="yes">
  <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
  <link rel="stylesheet" type="text/css" href="//cloud.typography.com/6567652/634828/css/fonts.css">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/site.min.css?v=6">
  <script src="https://player.vimeo.com/api/player.js"></script>
  <script type="text/javascript" src="//fast.fonts.net/jsapi/18489b80-5f8d-446b-836a-9c07dbe986b7.js"></script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-58821205-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-58821205-1');
</script>
  <?php wp_head(); ?>
</head>
<body>
  <div class="siteWrapper">

    <div class="stickyHeader" data-js-component="stickyHeader">
      <div class="stickyHeader_content">
            <div class="contentWrapper">
        <a href="<?= site_url(); ?>" class="home_link logo" data-pjax>
          <?php
            $logo = file_get_contents(get_template_directory() .'/img/logo.svg');
            echo preg_replace('!^[^>]+>(\r\n|\n)!', '', $logo);
          ?>
        </a>
        <nav class="globalNav">
          <ul class="globalNav_menu">
            <li class="globalNav_item"><a href="<?= site_url(); ?>#work" class="globalNav_link" data-pjax>Work</a></li>
            <li class="globalNav_item"><a href="<?= site_url(); ?>#about" class="globalNav_link" data-pjax>About</a></li>
            <li class="globalNav_item"><a href="<?= site_url(); ?>#contact" class="globalNav_link" data-pjax>Contact</a></li>
          </ul>
        </nav>
        <div class="globalNav_toggle">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      </div>
    </div>

    <header class="globalHeader <?php if (is_page( "In Progress" ) ): ?> globalHeader--dark<?php endif; ?>">
      <div class="contentWrapper">
        <a href="<?= site_url(); ?>" class="home_link logo" data-pjax>
          <?php
            $logo = file_get_contents(get_template_directory() .'/img/logo.svg');
            echo preg_replace('!^[^>]+>(\r\n|\n)!', '', $logo);
          ?>
        </a>
        <nav class="globalNav">
          <ul class="globalNav_menu">
            <li class="globalNav_item"><a href="<?= site_url(); ?>#work" class="globalNav_link" data-pjax>Work</a></li>
            <li class="globalNav_item"><a href="<?= site_url(); ?>#about" class="globalNav_link" data-pjax>About</a></li>
            <li class="globalNav_item"><a href="<?= site_url(); ?>#contact" class="globalNav_link" data-pjax>Contact</a></li>
          </ul>
        </nav>
        <div class="globalNav_toggle">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </header>
    <div id="pjax-container">
      <div id="pjax-fragment">
