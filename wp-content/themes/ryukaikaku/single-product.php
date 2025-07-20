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

get_header('shop'); // WooCommerce�̃w�b�_�[��\��

while (have_posts()) :
    the_post();
    // WooCommerce�̏��i�ڍׂ�\��
    wc_get_template_part('content', 'single-product');

endwhile;

get_footer('shop'); // WooCommerce�̃t�b�^�[��\��
