<?php
get_header();

global $wpdb;

$category = get_term_by('slug', $term, $taxonomy);

if(!$category) :
  get_template_part('template-parts/404/'); 
else:
  $current_date = date_i18n( 'Ymd' );
  
  $args = array(
    'post_type' => 'menu',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'fields' => 'ids',
    'tax_query' => array(
      array(
        'taxonomy' => 'menu_category',
        'field' => 'term_id',
        'terms' => $category->term_id
       )
    ),
    'meta_query' => array(
      'relation' => 'AND',
      array(
        'relation' => 'OR',
        array(
          'key' => 'menu_start',
          'value' => $current_date,
          'compare' => '<=',
          'type' => 'DATE',
        ),
        array(
          'key' => 'menu_start',
          'value' => '',
          'compare' => '=',
        ),
      ),
      array(
        'relation' => 'OR',
        array(
          'key' => 'menu_finish',
          'value' => $current_date,
          'compare' => '>=',
          'type' => 'DATE',
        ),
        array(
          'key' => 'menu_finish',
          'value' => '',
          'compare' => '=',
        ),
      ),
    ),
  );
  $menu_id_list = get_posts($args);

?>

<section class="menu-topic">
  <p class="topic-en"><?php echo strtoupper(str_replace('_', ' ', $category->slug)); ?></p>
  <h2 class="topic-jp"><?php echo $category->name; ?></h2>
</section>

<section class="breadcrumb">
  <ol class="breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
    <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
      <a itemprop="item" href="<?php echo get_site_url(); ?>/">
        <span itemprop="name">ホーム</span>
      </a>
      <meta itemprop="position" content="1" />
    </li>
    
    <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
      <a itemprop="item" href="<?php echo get_site_url(); ?>/menu/">
        <span itemprop="name">メニュー</span>
      </a>
      <meta itemprop="position" content="2" />
    </li>
    
    <li class="breadcrumb-item"><?php echo $category->name; ?></li>
  </ol>
</section>

<section class="menu-list">
  <?php foreach($menu_id_list as $menu_id): ?>
    <div class="menu-list-item">
        <?php 
        $menu_name = get_the_title($menu_id);
        $menu_image = get_field('menu_image', $menu_id);
        $menu_price = get_field('menu_price', $menu_id);
        $menu_promotion = get_field('menu_promotion', $menu_id);
        ?>
        <div class="menu-list-image">
          <?php if($menu_image): ?>
            <p class="menu-list-image-inner menu-list-image-normal" style="background-image: url(<?php echo $menu_image[0]['image']['url']; ?>)"></p>
          <?php else: ?>
            <p class="menu-list-image-inner menu-list-image-comming"></p>
            <p class="menu-list-image-text">画像準備中<br/><span class="menu-list-image-english">COMMING SOON</span></p>
          <?php endif; ?>
          <?php if($menu_promotion): ?>
            <p class="menu-list-promotion menu-list-promotion-<?php echo $menu_promotion['value']; ?>"><?php echo $menu_promotion['label']; ?></p>
          <?php endif; ?>
        </div>
        <p class="menu-list-name"><a href="<?php echo get_site_url(); ?>/menu/<?php echo get_post_field('post_name', $menu_id); ?>/"><?php echo $menu_name; ?></a></p>
        <p class="menu-list-price"><span class="menu-list-price-number">&yen;<?php echo number_format(intval($menu_price)); ?></span>(税込)</p>
    </div>
  <?php endforeach; ?>
</section>

<?php

endif;
get_footer();
