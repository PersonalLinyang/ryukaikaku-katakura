<?php

/*
 * 「メニュー」投稿タイプと関連タクソノミー追加
 */
function create_menu_type() {
  // 記事タイプ「メニュー」追加
  register_post_type('menu',
    array(
      'label' => 'メニュー',
      'public' => true,
      'has_archive' => true,
      'menu_position' => 6, 
      'supports' => [
        'title',
        'custom-fields',
        'editor',
      ]
    )
  );
  
  // タクソノミー「カテゴリ」追加
  register_taxonomy( 
    'menu_category',
    array('menu'),
    array(
      'labels' => array(
        'name' => 'カテゴリ',
        'edit_item' => '編集',
        'update_item' => '更新',
        'add_new_item' => 'カテゴリを追加'
      ),
      'meta_box_cb' => 'post_categories_meta_box',
    ) 
  );
}
add_action('init', 'create_menu_type');


/*
 * 「お知らせ」投稿タイプと関連タクソノミー追加
 */
function create_notification_type() {
  // 記事タイプ「お知らせ」追加
  register_post_type('notification',
    array(
      'label' => 'お知らせ',
      'public' => true,
      'has_archive' => true,
      'menu_position' => 6, 
      'supports' => [
        'title',
        'custom-fields',
        'editor',
      ]
    )
  );
}
add_action('init', 'create_notification_type');


/*
 * 「FAQ」投稿タイプと関連タクソノミー追加
 */
function create_faq_type() {
  // 記事タイプ「FAQ」追加
  register_post_type('faq',
    array(
      'label' => 'FAQ',
      'public' => true,
      'has_archive' => true,
      'menu_position' => 7, 
      'supports' => [
        'title',
        'custom-fields',
      ]
    )
  );
  
  // タクソノミー「FAQカテゴリ」追加
  register_taxonomy( 
    'faq_category',
    array('faq'),
    array(
      'labels' => array(
        'name' => 'FAQカテゴリ',
        'edit_item' => '編集',
        'update_item' => '更新',
        'add_new_item' => 'FAQカテゴリを追加'
      ),
      'meta_box_cb' => 'post_categories_meta_box',
    ) 
  );
}
add_action('init', 'create_faq_type');


/*
 * リライトルール設定
 */
function custom_rewrite_basic() {
  add_rewrite_rule('^menu/(m[a-z0-9]{13})/?', 'index.php?menu=$matches[1]', 'top');
  add_rewrite_rule('^menu/([a-z_]+)/?', 'index.php?menu_category=$matches[1]', 'top');
  flush_rewrite_rules();
}
add_action('init', 'custom_rewrite_basic');


/*
 * リライトルールのindex.phpのパラメータとして使える項目を追加
 */
function add_query_vars_filter( $vars ){
  array_push($vars, 'category_code');
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );


/*
 * 投稿作成時ユニックなpost_nameを自動付与
 */
function auto_update_post_name( $post_ID, $post, $update ) {
  if($post->post_type == 'menu') {
    // 新規作成以外ならslugを書き換えない
    if ($post->post_date_gmt != $post->post_modified_gmt)
        return;
    
    //slug作成
    $post_name = strtoupper(uniqid("m"));
  } else if($post->post_type == 'notification') {
    // 新規作成以外ならslugを書き換えない
    if ($post->post_date_gmt != $post->post_modified_gmt)
        return;
    
    //slug作成
    $post_name = strtoupper(uniqid("n"));
  } else {
    return;
  }
  
  // 無限ループを避けるためにフックを外す
  remove_action( 'save_post', 'slug_save_post_callback', 10, 3 );
  
  // 投稿のslugを更新する
  wp_update_post( array(
      'ID' => $post_ID,
      'post_name' => $post_name
  ));
  
  // 再度フックする
  add_action( 'save_post', 'auto_update_post_name', 10, 3 );
}
add_action( 'save_post', 'auto_update_post_name', 10, 3 );