<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.3.0
 */

defined('ABSPATH') || exit;

get_header('shop'); // WooCommerceのヘッダーを表示

while (have_posts()) :
    the_post();
    // WooCommerceの商品詳細を表示
    wc_get_template_part('content', 'single-product');

endwhile;

get_footer('shop'); // WooCommerceのフッターを表示
