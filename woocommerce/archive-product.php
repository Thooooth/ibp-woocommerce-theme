<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');

?>
<style>
    .woocommerce-products-header {
        display: none; /* Oculta completamente o cabeçalho */
        margin-bottom: 30px;
        text-align: center;
        padding: 35px 0;
        background: linear-gradient(135deg, rgba(79, 2, 68, 0.95) 0%, rgba(98, 23, 114, 0.85) 100%);
        color: white;
        position: relative;
    }
    
    .woocommerce-products-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/pattern.png');
        background-repeat: repeat;
        opacity: 0.1;
        z-index: 0;
    }
    
    .woocommerce-products-header__title {
        color: white;
        font-size: 32px;
        margin: 0 0 10px;
        text-transform: uppercase;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }
    
    .woocommerce-products-header .term-description {
        position: relative;
        z-index: 1;
        max-width: 800px;
        margin: 10px auto 0;
        font-size: 16px;
        line-height: 1.6;
    }
    
    .shop-content-wrapper {
        max-width: 1200px;
        margin: 30px auto 0; /* Adicionado margem superior para compensar o cabeçalho removido */
        padding: 0 20px;
    }
    
    .woocommerce-notices-wrapper {
        margin-bottom: 20px;
    }
    
    /* Shop Controls */
    .shop-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        background-color: #f8f8f8;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }
    
    .shop-controls-left {
        display: flex;
        align-items: center;
    }
    
    .woocommerce-result-count {
        font-size: 14px;
        color: #555;
        margin-bottom: 0 !important;
        font-weight: 500;
        background-color: white;
        padding: 8px 15px;
        border-radius: 4px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    
    .woocommerce-ordering {
        margin-bottom: 0 !important;
        position: relative;
    }
    
    .woocommerce-ordering::before {
        content: 'Ordenar por:';
        font-size: 14px;
        color: #555;
        margin-right: 10px;
        font-weight: 500;
    }
    
    .woocommerce-ordering select {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: white;
        font-size: 14px;
        min-width: 220px;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="6"><path d="M0 0L12 0L6 6Z" fill="%234f0244"/></svg>');
        background-repeat: no-repeat;
        background-position: right 15px center;
        padding-right: 35px;
        font-weight: 500;
        color: #333;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }
    
    .woocommerce-ordering select:hover {
        border-color: #4f0244;
    }
    
    .woocommerce-ordering select:focus {
        outline: none;
        border-color: #4f0244;
        box-shadow: 0 0 0 2px rgba(79, 2, 68, 0.2);
    }
    
    /* Products Grid Layout */
    .products {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    
    .products li.product {
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        margin: 0 !important;
        width: 100% !important;
        padding-bottom: 15px;
    }
    
    .products li.product:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .products li.product a img {
        margin: 0 !important;
        display: block;
        width: 100%;
        height: auto;
        border-radius: 8px 8px 0 0;
        object-fit: cover;
        aspect-ratio: 1/1;
    }
    
    .products li.product .woocommerce-loop-product__title {
        font-size: 16px;
        padding: 10px 15px;
        margin: 0;
        height: 60px;
        overflow: hidden;
        color: #333;
        font-weight: 600;
    }
    
    .products li.product .price {
        color: #4f0244;
        font-weight: 700;
        font-size: 18px;
        margin: 5px 15px 10px;
        display: block;
    }
    
    .products li.product .button {
        margin: 0 15px;
        background-color: #00b050;
        color: white;
        border-radius: 4px;
        text-align: center;
        padding: 8px 15px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 14px;
        transition: background-color 0.3s;
        width: calc(100% - 30px);
        display: block;
    }
    
    .products li.product .button:hover {
        background-color: #009040;
    }
    
    .products li.product .onsale {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: #4f0244;
        color: white;
        padding: 5px 10px;
        font-size: 12px;
        text-transform: uppercase;
        font-weight: 600;
        border-radius: 4px;
        z-index: 1;
        margin: 0 !important;
        min-height: auto !important;
        min-width: auto !important;
        line-height: 1.5 !important;
    }
    
    /* Pagination */
    .woocommerce-pagination {
        margin-top: 40px;
        margin-bottom: 40px;
        text-align: center;
    }
    
    .woocommerce-pagination ul {
        display: inline-flex !important;
        list-style: none;
        margin: 0;
        padding: 0;
        border: none !important;
    }
    
    .woocommerce-pagination ul li {
        margin: 0 5px;
        border: none !important;
    }
    
    .woocommerce-pagination ul li a,
    .woocommerce-pagination ul li span {
        padding: 8px 15px;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        color: #333;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .woocommerce-pagination ul li a:hover {
        background-color: #f0f0f0;
    }
    
    .woocommerce-pagination ul li span.current {
        background-color: #4f0244;
        color: white;
        border-color: #4f0244;
    }
    
    /* Empty Results */
    .woocommerce-info {
        background-color: #f9f9f9;
        border-top-color: #4f0244;
        color: #333;
        padding: 20px;
        margin-bottom: 30px;
        border-radius: 8px;
    }
    
    /* Responsive */
    @media (max-width: 991px) {
        .products {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    @media (max-width: 767px) {
        .products {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .woocommerce-products-header__title {
            font-size: 24px;
        }
        
        .shop-controls {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .woocommerce-result-count {
            margin-bottom: 0 !important;
        }
        
        .woocommerce-ordering {
            width: 100%;
            display: flex;
            align-items: center;
        }
        
        .woocommerce-ordering select {
            flex: 1;
        }
    }
    
    @media (max-width: 480px) {
        .products {
            grid-template-columns: 1fr;
        }
        
        .products li.product .woocommerce-loop-product__title {
            height: auto;
        }
        
        .woocommerce-ordering::before {
            display: none;
        }
    }
</style>

<script>
    jQuery(document).ready(function($) {
        // Melhoria na usabilidade do dropdown de ordenação
        $('.woocommerce-ordering select').on('change', function() {
            $(this).closest('form').submit();
        });
        
        // Adiciona um indicador visual de carregamento ao mudar a ordenação
        $('.woocommerce-ordering select').on('change', function() {
            $('body').append('<div class="sorting-overlay"><div class="sorting-spinner"></div></div>');
        });
        
        // Melhora a apresentação do contador de resultados
        var resultCount = $('.woocommerce-result-count');
        if (resultCount.length) {
            resultCount.html('<i class="fas fa-tag"></i> ' + resultCount.html());
        }
    });
</script>

<style>
    /* Estilo para o indicador de carregamento da ordenação */
    .sorting-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.7);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .sorting-spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #4f0244;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<header class="woocommerce-products-header">
    <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
        <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
    <?php endif; ?>

    <?php
    /**
     * Hook: woocommerce_archive_description.
     *
     * @hooked woocommerce_taxonomy_archive_description - 10
     * @hooked woocommerce_product_archive_description - 10
     */
    do_action('woocommerce_archive_description');
    ?>
</header>

<div class="shop-content-wrapper">
    <?php
    if (woocommerce_product_loop()) {
        /**
         * Hook: woocommerce_before_shop_loop.
         *
         * @hooked woocommerce_output_all_notices - 10
         * @hooked woocommerce_result_count - 20
         * @hooked woocommerce_catalog_ordering - 30
         */
        
        // Outputs all notices first
        woocommerce_output_all_notices();
        
        // Start shop controls container
        echo '<div class="shop-controls">';
        
        // Left controls (result count)
        echo '<div class="shop-controls-left">';
        woocommerce_result_count();
        echo '</div>';
        
        // Right controls (ordering)
        echo '<div class="shop-controls-right">';
        woocommerce_catalog_ordering();
        echo '</div>';
        
        echo '</div>'; // End .shop-controls
        
        woocommerce_product_loop_start();

        if (wc_get_loop_prop('total')) {
            while (have_posts()) {
                the_post();

                /**
                 * Hook: woocommerce_shop_loop.
                 */
                do_action('woocommerce_shop_loop');

                wc_get_template_part('content', 'product');
            }
        }

        woocommerce_product_loop_end();

        /**
         * Hook: woocommerce_after_shop_loop.
         *
         * @hooked woocommerce_pagination - 10
         */
        do_action('woocommerce_after_shop_loop');
    } else {
        /**
         * Hook: woocommerce_no_products_found.
         *
         * @hooked wc_no_products_found - 10
         */
        do_action('woocommerce_no_products_found');
    }
    ?>
</div>

<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');

get_footer('shop'); 