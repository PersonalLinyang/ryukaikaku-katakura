<?php
/*
 * ヘッダ部分
 */

$header_class = '';
$main_class = '';

if(is_front_page()) {
  $main_class = 'front-main';
  $header_class = 'front-header';
}

$menu_categories = get_terms(array('taxonomy'=>'menu_category', 'get'=>'all')); 

?><!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/site_icon.ico">
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/font/Oswald-Stencil.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/font/TokufutoGyousho.woff2" as="font" type="font/woff2" crossorigin>
    <script>
      (function(d) {
        var config = {
          kitId: 'jfr8jyk',
          scriptTimeout: 3000,
          async: true
        },
        h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
      })(document);
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/style.css" />
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/common.js"></script>
    <?php if(is_archive('faq')): ?>
      <script src="<?php echo get_template_directory_uri(); ?>/assets/js/faq.js"></script>
    <?php elseif(is_page('about')): ?>
      <script src="<?php echo get_template_directory_uri(); ?>/assets/js/about.js"></script>
    <?php endif; ?>
    <?php wp_head(); ?>
  </head>

  <body>

    <header class="header <?php echo $header_class; ?>">
      <div class="header-inner">
        <a href="<?php echo get_site_url(); ?>/">
          <?php get_template_part('template-parts/logo', null, array('logo_key' => 'header-logo')); ?>
        </a>
        <div class="header-menu">
          <ul class="header-menu-list">
            <li class="header-menu-item">
              <a class="full-link" href="<?php echo get_site_url(); ?>/">ホーム</a>
            </li>
            <li class="header-menu-item has-sub">
              <span>メニュー</span>
              <div class="header-menu-subarea">
                <ul class="header-menu-sublist">
                  <?php foreach($menu_categories as $menu_category): ?>
                    <li class="header-menu-subitem">
                      <a class="full-link" href="<?php echo get_site_url(); ?>/menu/<?php echo $menu_category->slug; ?>/">
                        <?php echo $menu_category->name; ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </li>
            <li class="header-menu-item">
              <a class="full-link" href="<?php echo get_site_url(); ?>/notification/">お知らせ</a>
            </li>
            <li class="header-menu-item">
              <a class="full-link" href="<?php echo get_site_url(); ?>/faq/">よくある質問</a>
            </li>
            <li class="header-menu-item">
              <a class="full-link" href="<?php echo get_site_url(); ?>/about/">店舗案内</a>
            </li>
          </ul>
          <?php get_template_part('template-parts/phone', null, array('phone_key' => 'header-menu-phone')); ?>
        </div>
        <div class="header-controller sp-only">
          <div class="header-menu-handler">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>
      </div>
    </header>

    <main class='main <?php echo $main_class; ?>'>