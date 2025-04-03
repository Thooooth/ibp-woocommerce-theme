<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}
?>
<style>
    #product-<?php the_ID(); ?> {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .woocommerce-breadcrumb {
        margin-bottom: 20px !important;
        font-size: 14px;
    }
    
    .product-header {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }
    
    .product-gallery {
        flex: 1;
        min-width: 300px;
        max-width: 40%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding-right: 20px;
    }
    
    .product-gallery img {
        width: 100%;
        height: auto;
        object-fit: contain;
        display: block;
        border: 1px solid #f0f0f0;
        border-radius: 4px;
        margin-bottom: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    .woocommerce-product-gallery {
        width: 100% !important;
    }
    
    .woocommerce-product-gallery__image {
        text-align: center;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .woocommerce-product-gallery__image a {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .woocommerce-product-gallery__image img {
        max-height: 100%;
        max-width: 100%;
        width: auto;
        height: auto;
        object-fit: contain;
    }
    
    .woocommerce-product-gallery__wrapper {
        margin: 0 !important;
    }
    
    .flex-control-thumbs {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px !important;
        padding: 0 !important;
        justify-content: center;
        width: 100%;
        max-width: 400px;
        margin-left: auto !important;
        margin-right: auto !important;
    }
    
    .flex-control-thumbs li {
        width: calc(25% - 8px) !important;
        margin: 0 !important;
        height: 80px;
        overflow: hidden;
        border-radius: 4px;
        position: relative;
    }
    
    .flex-control-thumbs img {
        border: 1px solid #f0f0f0;
        padding: 2px;
        transition: all 0.3s;
        height: 100%;
        width: 100%;
        object-fit: cover;
        border-radius: 4px;
        position: absolute;
        top: 0;
        left: 0;
    }
    
    .flex-control-thumbs img:hover {
        border-color: #4f0244;
        opacity: 0.9 !important;
    }
    
    .flex-control-thumbs img.flex-active {
        border-color: #4f0244;
        border-width: 2px;
        opacity: 1 !important;
    }
    
    .summary.entry-summary {
        flex: 1;
        min-width: 300px;
        padding-left: 40px;
    }
    
    .product_title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }
    
    .product-tag {
        margin-bottom: 15px;
    }
    
    .label-tag {
        display: inline-block;
        background-color: #4f0244;
        color: white;
        padding: 5px 10px;
        font-size: 12px;
        text-transform: uppercase;
        font-weight: 600;
        border-radius: 4px;
    }
    
    .product-code {
        font-size: 14px;
        color: #666;
        margin-bottom: 15px;
    }
    
    .product-price {
        margin: 15px 0;
    }
    
    .product-price .woocommerce-Price-amount {
        font-size: 24px;
        font-weight: bold;
        color: #4f0244;
    }
    
    .product-add-to-cart {
        margin: 20px 0;
    }
    
    .product-add-to-cart .single_add_to_cart_button {
        background-color: #00b050 !important;
        color: white !important;
        text-transform: uppercase;
        font-weight: bold;
        border-radius: 4px;
        padding: 12px 25px !important;
        transition: background-color 0.3s;
    }
    
    .product-add-to-cart .single_add_to_cart_button:hover {
        background-color: #009040 !important;
    }
    
    .product-details {
        clear: both;
        margin-top: 40px;
        border-top: 1px solid #f0f0f0;
        padding-top: 30px;
    }
    
    .product-description-heading {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #4f0244;
    }
    
    .product-description {
        line-height: 1.6;
        color: #333;
    }
    
    .frete-e-prazo {
        margin: 20px 0;
        padding: 15px;
        background-color: #f7f7f7;
        border-radius: 5px;
    }
    
    .frete-e-prazo h3 {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #4f0244;
    }
    
    .frete-e-prazo p {
        font-size: 14px;
        margin-bottom: 10px;
    }
    
    .shipping-calculator-form {
        display: flex;
        margin-top: 10px;
    }
    
    .shipping-calculator-form input {
        flex-grow: 1;
        border: 1px solid #ddd;
        border-radius: 4px 0 0 4px;
        padding: 8px 12px;
    }
    
    .shipping-calculator-form button {
        background-color: #4f0244;
        color: white;
        border: none;
        border-radius: 0 4px 4px 0;
        padding: 8px 15px;
        cursor: pointer;
    }
    
    .product-share {
        margin: 20px 0;
    }
    
    .share-product-title h3 {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #4f0244;
    }
    
    .social-share-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .social-share-buttons a {
        padding: 8px 15px;
        text-decoration: none;
        border-radius: 4px;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: white;
        transition: opacity 0.3s;
    }
    
    .social-share-buttons a:hover {
        opacity: 0.9;
    }
    
    .facebook-share {
        background-color: #3b5998;
    }
    
    .whatsapp-share {
        background-color: #25d366;
    }
    
    .twitter-share {
        background-color: #1da1f2;
    }
    
    .pinterest-share {
        background-color: #bd081c;
    }
    
    @media (max-width: 768px) {
        .product-header {
            flex-direction: column;
        }
        
        .product-gallery {
            max-width: 100%;
        }
        
        .summary.entry-summary {
            padding-left: 0;
            margin-top: 20px;
        }
        
        .social-share-buttons {
            flex-direction: column;
        }
        
        .product_title {
            font-size: 20px;
        }
        
        .product-price .woocommerce-Price-amount {
            font-size: 20px;
        }
    }
</style>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
    
    <?php
    // Custom breadcrumb
    if (function_exists('woocommerce_breadcrumb')) {
        woocommerce_breadcrumb(array(
            'delimiter' => ' / ',
            'wrap_before' => '<nav class="woocommerce-breadcrumb">',
            'wrap_after'  => '</nav>',
        ));
    }
    ?>

    <div class="product-header">
        <div class="product-gallery">
            <?php
            /**
             * Hook: woocommerce_before_single_product_summary.
             *
             * @hooked woocommerce_show_product_sale_flash - 10
             * @hooked woocommerce_show_product_images - 20
             */
            do_action('woocommerce_before_single_product_summary');
            ?>
        </div>

        <div class="summary entry-summary">
            <?php if ($product->is_on_sale()) : ?>
                <div class="product-tag">
                    <span class="label-tag"><?php echo esc_html__('LANÇAMENTO', 'ibp-woocommerce'); ?></span>
                </div>
            <?php endif; ?>

            <h1 class="product_title entry-title"><?php the_title(); ?></h1>
            <div class="product-author">
                <?php echo esc_html__('Por: ', 'ibp-woocommerce') . '<a href="' . esc_url($product->get_attribute('Author URL')) . '" target="_blank">' . esc_html($product->get_attribute('Author')) . '</a>'; ?>
            </div>
            <?php if ($product->get_sku()) : ?>
                <div class="product-code">
                    <?php echo esc_html__('CÓDIGO: ', 'ibp-woocommerce') . esc_html($product->get_sku()); ?>
                </div>
            <?php endif; ?>
            
            <div class="product-price">
                <?php woocommerce_template_single_price(); ?>
            </div>
            
            <div class="product-add-to-cart">
                <?php woocommerce_simple_add_to_cart(); ?>
            </div>
            
            <div class="frete-e-prazo">
                <h3><?php echo esc_html__('FRETE E PRAZO', 'ibp-woocommerce'); ?></h3>
                <p><?php echo esc_html__('Simule o frete e o prazo de entrega estimados para sua região.', 'ibp-woocommerce'); ?></p>
                <form class="shipping-calculator-form" action="" method="post">
                    <input type="text" name="calc_shipping_postcode" id="calc_shipping_postcode" placeholder="<?php esc_attr_e('Digite seu CEP', 'ibp-woocommerce'); ?>" />
                    <button type="submit" class="button"><?php esc_html_e('Calcular', 'ibp-woocommerce'); ?></button>
                </form>
                <div class="shipping-calculator-response"></div>
            </div>
            
            <div class="product-share">

                <div class="social-share-buttons" style="display: flex; flex-wrap: wrap; gap: 10px; width: 100%;">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="facebook-share" style="width: calc(50% - 5px); box-sizing: border-box; text-align: center; justify-content: center; display: flex; align-items: center; height: 40px; font-weight: bold; padding: 0;">
                         FACEBOOK
                    </a>
                    <a href="https://api.whatsapp.com/send?text=<?php echo urlencode(get_the_title() . ' - ' . get_permalink()); ?>" target="_blank" class="whatsapp-share" style="width: calc(50% - 5px); box-sizing: border-box; text-align: center; justify-content: center; display: flex; align-items: center; height: 40px; font-weight: bold; padding: 0;">
                         WHATSAPP
                    </a>
                    <a href="https://x.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="x-share" style="width: calc(50% - 5px); box-sizing: border-box; text-align: center; justify-content: center; display: flex; align-items: center; height: 40px; font-weight: bold; padding: 0;">
                        X
                    </a>
                    <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&media=<?php echo urlencode(get_the_post_thumbnail_url()); ?>&description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="pinterest-share" style="width: calc(50% - 5px); box-sizing: border-box; text-align: center; justify-content: center; display: flex; align-items: center; height: 40px; font-weight: bold; padding: 0;">
                        PINTEREST
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="product-details">
        <div class="product-tabs">
            <h2 class="product-description-heading"><?php echo esc_html__('DESCRIÇÃO DO PRODUTO', 'ibp-woocommerce'); ?></h2>
            <div class="product-description">
                <?php the_content(); ?>
            </div>
            
            <?php
            /**
             * Hook: woocommerce_after_single_product_summary.
             * 
             * Removendo as seguintes funções:
             * @hooked woocommerce_output_product_data_tabs - 10
             * @hooked woocommerce_upsell_display - 15 
             * @hooked woocommerce_output_related_products - 20
             */
            // Removendo produtos relacionados, upsells e tabs
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
            
            // Executando outros hooks que possam estar registrados
            do_action('woocommerce_after_single_product_summary');
            ?>
        </div>
    </div>
</div>

<?php do_action('woocommerce_after_single_product'); ?> 