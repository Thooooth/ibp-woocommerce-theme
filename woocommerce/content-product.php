<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
    return;
}
?>
<li <?php wc_product_class('', $product); ?>>
    <div class="product-card">
        <?php
        /**
         * Hook: woocommerce_before_shop_loop_item.
         *
         * @hooked woocommerce_template_loop_product_link_open - 10
         */
        do_action('woocommerce_before_shop_loop_item');
        ?>

        <?php if ($product->is_on_sale()) : 
            $regular_price = $product->get_regular_price();
            $sale_price = $product->get_sale_price();
            if (!empty($regular_price) && !empty($sale_price)) {
                $discount = round((($regular_price - $sale_price) / $regular_price) * 100);
                echo '<span class="sale-badge">-' . $discount . '%</span>';
            }
        endif; ?>
        
        <?php 
        // Verificar se o produto é novo (menos de 30 dias)
        $post_date = get_the_date('Y-m-d H:i:s');
        $thirty_days_ago = date('Y-m-d H:i:s', strtotime('-30 days'));
        $is_new = strtotime($post_date) > strtotime($thirty_days_ago);
        
        if ($is_new) {
            echo '<span class="new-badge">' . esc_html__('Novo', 'ibp-woocommerce') . '</span>';
        }
        ?>

        <div class="product-image">
            <?php
            /**
             * Hook: woocommerce_before_shop_loop_item_title.
             *
             * @hooked woocommerce_show_product_loop_sale_flash - 10
             * @hooked woocommerce_template_loop_product_thumbnail - 10
             */
            do_action('woocommerce_before_shop_loop_item_title');
            ?>
        </div>

        <div class="product-content">
            <h3 class="woocommerce-loop-product__title"><?php echo esc_html($product->get_name()); ?></h3>
            
            <?php
            /**
             * Hook: woocommerce_after_shop_loop_item_title.
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10
             */
            do_action('woocommerce_after_shop_loop_item_title');
            ?>
        </div>

        <div class="product-content">
            <?php
            /**
             * Hook: woocommerce_after_shop_loop_item.
             *
             * @hooked woocommerce_template_loop_product_link_close - 5
             * @hooked woocommerce_template_loop_add_to_cart - 10
             */
            remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
            echo '<a href="' . esc_url($product->add_to_cart_url()) . '" class="cta-button">' . esc_html__('Comprar', 'ibp-woocommerce') . '</a>';
            ?>
        </div>
    </div>
</li> 