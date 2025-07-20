<?php
/* Template Name: Cart Page */

get_header(); // ヘッダーの表示

echo '<div class="cart-page">';
// WooCommerceのカートショートコードを追加
echo do_shortcode('[woocommerce_cart]');
echo '</div>';

get_footer(); // フッターの表示
