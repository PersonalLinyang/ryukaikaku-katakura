<?php
/* Template Name: Checkout Page */

get_header(); // ヘッダーの表示

echo '<div class="checkout-page">';
// WooCommerceのチェックアウトショートコードを追加
echo do_shortcode('[woocommerce_checkout]');
echo '</div>';

get_footer(); // フッターの表示
