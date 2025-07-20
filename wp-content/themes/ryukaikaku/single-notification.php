<?php
get_header();

?>

<section class="breadcrumb">
  <ol class="breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
    <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
      <a itemprop="item" href="<?php echo get_site_url(); ?>/">
        <span itemprop="name">ホーム</span>
      </a>
      <meta itemprop="position" content="1" />
    </li>
    
    <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
      <a itemprop="item" href="<?php echo get_site_url(); ?>/notification/">
        <span itemprop="name">お知らせ</span>
      </a>
      <meta itemprop="position" content="2" />
    </li>
    
    <li class="breadcrumb-item"><?php echo get_the_title($post->ID); ?></li>
  </ol>
</section>

<section class="notification-singletopic">
  <h2><?php echo get_the_title($post->ID); ?></h2>
</section>

<section class="notification-content">
  <?php echo "<p>" . str_replace("\n", "</p><p>", $post->post_content) . "</p>"; ?>
  <?php // echo get_field('notification_content', $post->ID); ?>
</section>

<section class="notification-navi">
  <ul class="notification-navi-list">
    <li class="notification-navi-item prev-item">
      <?php previous_post_link('%link'); ?>
    </li>
    <li class="notification-navi-item next-item">
      <?php next_post_link('%link'); ?>
    </li>
  </ul>
</section>

<?php

get_footer();
