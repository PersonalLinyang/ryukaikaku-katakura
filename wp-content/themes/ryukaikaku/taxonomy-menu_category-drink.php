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
  <p class="topic-en"><?php echo strtoupper($category->slug); ?></p>
  <h2 class="topic-jp"><?php echo $category->name; ?></h2>
</section>

<section class="menu-list">
  <?php foreach($menu_id_list as $menu_id): ?>
    <div class="menu-list-item">
      <a class="full-link" href="<?php echo get_site_url(); ?>/menu/<?php echo get_post_field('post_name', $menu_id); ?>/">
        <?php 
        $menu_name = get_the_title($menu_id);
        $menu_image = get_field('menu_image', $menu_id); 
        if($menu_image):
        ?>
          <div class="menu-list-image">
            <p class="menu-list-image-inner" style="background-image: url(<?php echo $menu_image[0]['image']['url']; ?>)"></p>
          </div>
        <?php else: ?>
          <div class="menu-list-image">
            <p class="menu-list-image-text">COMMING SOON</p>
          </div>
        <?php endif; ?>
        <p><?php echo $menu_name; ?></p>
      </a>
    </div>
  <?php endforeach; ?>
</section>

<?php

endif;
get_footer();
