<?php
/**
 * The template for displaying the front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package IBP_WooCommerce
 */

get_header();
?>

<main id="primary" class="site-main front-page">

    <?php
    // Hero/Banner Section com Slider
    ?>
    <section class="hero-section">
        <div class="container">
            <?php 
            // Exibe o slider de hero banners
            if (function_exists('ibp_hero_slider')) {
                ibp_hero_slider();
            } else {
                // Fallback para o banner estático original
                ?>
                <div class="hero-content">
                    <div class="hero-text">
                        <span class="label-tag"><?php echo esc_html__('LANÇAMENTO', 'ibp-woocommerce'); ?></span>
                        <h2><?php echo esc_html__('Precatório na Prática', 'ibp-woocommerce'); ?></h2>
                        <h3><?php echo esc_html__('2ª Edição', 'ibp-woocommerce'); ?></h3>
                        <p><?php echo esc_html__('Gustavo Bachega', 'ibp-woocommerce'); ?></p>
                        <div class="price-tag">
                            <span class="price">R$ 139,90</span>
                        </div>
                        <a href="#" class="cta-button"><?php echo esc_html__('COMPRAR', 'ibp-woocommerce'); ?></a>
                    </div>
                    <div class="hero-image">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/livro-destaque.png'); ?>" alt="<?php echo esc_attr__('Precatório na Prática - 2ª Edição', 'ibp-woocommerce'); ?>">
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </section>

    <?php
    // Banner Livros Transformam Conhecimento em Oportunidades
    ibp_banner_livros_transformam_conhecimento_em_oportunidades();
    
    // Seção de Lançamentos Recentes (Removida conforme solicitado)
    // $recent_enabled = get_theme_mod('ibp_recent_enabled', true);
    // $recent_title = get_theme_mod('ibp_recent_title', __('Últimos Lançamentos', 'ibp-woocommerce'));
    // $recent_count = get_theme_mod('ibp_recent_count', 4);
    // $recent_columns = get_theme_mod('ibp_recent_columns', 4);
    
    // if ($recent_enabled) {
    //     ibp_recent_products($recent_count, $recent_columns, true, $recent_title);
    // }
    
    // Seção de Mais Vendidos (pode ser habilitada/desabilitada no customizador)
    $bestsellers_enabled = get_theme_mod('ibp_bestsellers_enabled', true);
    $bestsellers_title = get_theme_mod('ibp_bestsellers_title', __('Mais Vendidos', 'ibp-woocommerce'));
    $bestsellers_count = get_theme_mod('ibp_bestsellers_count', 4);
    $bestsellers_columns = get_theme_mod('ibp_bestsellers_columns', 4);
    
    if ($bestsellers_enabled) {
        ibp_best_sellers($bestsellers_count, $bestsellers_columns, true, $bestsellers_title);
    }
    
    // Seção de Todos os Produtos (pode ser habilitada/desabilitada no customizador)
    $allproducts_enabled = get_theme_mod('ibp_allproducts_enabled', true);
    $allproducts_title = get_theme_mod('ibp_allproducts_title', __('Todos os Produtos', 'ibp-woocommerce'));
    $allproducts_count = get_theme_mod('ibp_allproducts_count', 8);
    $allproducts_columns = get_theme_mod('ibp_allproducts_columns', 4);
    
    if ($allproducts_enabled) {
        ibp_all_products($allproducts_count, $allproducts_columns, true, $allproducts_title);
    }
    
    ?>

</main><!-- #main -->

<?php
get_footer(); 