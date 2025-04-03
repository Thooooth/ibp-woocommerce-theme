<?php
/**
 * Template para exibir os resultados da pesquisa
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package IBP_WooCommerce
 */

get_header();
?>

<style>
    /* Estilos para a página de resultados da busca */
    .search-results-header {
        background: linear-gradient(135deg, rgba(79, 2, 68, 0.95) 0%, rgba(98, 23, 114, 0.85) 100%);
        padding: 30px 0;
        text-align: center;
        color: white;
        margin-bottom: 40px;
        position: relative;
    }
    
    .search-results-header::before {
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
    
    .search-results-title {
        font-size: 28px;
        margin: 0 0 10px;
        position: relative;
        z-index: 1;
    }
    
    .search-results-description {
        font-size: 16px;
        opacity: 0.9;
        max-width: 800px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }
    
    .search-term {
        font-weight: bold;
        text-decoration: underline;
    }
    
    .search-count {
        background-color: white;
        color: #4f0244;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 14px;
        margin-top: 15px;
        display: inline-block;
        font-weight: 500;
        position: relative;
        z-index: 1;
    }
    
    .search-results-form {
        max-width: 600px;
        margin: 20px auto 0;
        position: relative;
        z-index: 1;
    }
    
    .search-results-form .search-input-wrapper {
        display: flex;
        background-color: white;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }
    
    .search-results-form .search-field {
        flex: 1;
        border: none;
        padding: 12px 20px;
        font-size: 16px;
        outline: none;
        background: transparent;
    }
    
    .search-results-form .search-submit {
        background: #00b050;
        color: white;
        border: none;
        padding: 0 25px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s;
    }
    
    .search-results-form .search-submit:hover {
        background: #009040;
    }
    
    /* Estilo para produtos nos resultados */
    .search-results-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
    }
    
    .search-product-card {
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .search-product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .search-product-image {
        width: 100%;
        height: auto;
        aspect-ratio: 1/1;
        object-fit: cover;
        display: block;
    }
    
    .search-product-content {
        padding: 15px;
    }
    
    .search-product-title {
        font-size: 16px;
        font-weight: 600;
        margin: 0 0 10px;
        height: 48px;
        overflow: hidden;
    }
    
    .search-product-price {
        color: #4f0244;
        font-weight: 700;
        font-size: 18px;
        margin-bottom: 15px;
    }
    
    .search-product-button {
        display: block;
        background-color: #00b050;
        color: white;
        text-align: center;
        padding: 8px 15px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 14px;
        transition: background-color 0.3s;
    }
    
    .search-product-button:hover {
        background-color: #009040;
    }
    
    .no-results-container {
        text-align: center;
        padding: 40px 0;
    }
    
    .no-results-icon {
        font-size: 48px;
        color: #4f0244;
        opacity: 0.3;
        margin-bottom: 20px;
    }
    
    .no-results-message {
        font-size: 24px;
        color: #333;
        margin-bottom: 15px;
    }
    
    .no-results-help {
        color: #666;
        margin-bottom: 30px;
    }
    
    @media (max-width: 991px) {
        .search-results-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    @media (max-width: 767px) {
        .search-results-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .search-results-title {
            font-size: 24px;
        }
    }
    
    @media (max-width: 480px) {
        .search-results-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<main id="primary" class="site-main">

    <header class="search-results-header">
        <h1 class="search-results-title">
            <?php
            /* translators: %s: search query. */
            printf(esc_html__('Resultados da busca por: %s', 'ibp-woocommerce'), '<span class="search-term">' . esc_html(get_search_query()) . '</span>');
            ?>
        </h1>
        <p class="search-results-description"><?php echo esc_html__('Encontre livros, autores e temas em nossa loja', 'ibp-woocommerce'); ?></p>
        
        <?php if (have_posts()) : ?>
            <div class="search-count">
                <?php
                $found_posts = $wp_query->found_posts;
                if ($found_posts == 1) {
                    echo esc_html__('1 produto encontrado', 'ibp-woocommerce');
                } else {
                    printf(esc_html__('%d produtos encontrados', 'ibp-woocommerce'), $found_posts);
                }
                ?>
            </div>
        <?php endif; ?>
        
        <div class="search-results-form">
            <?php get_search_form(); ?>
        </div>
    </header>

    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="search-results-grid">
                <?php
                /* Start the Loop */
                while (have_posts()) :
                    the_post();
                    
                    // Se for um produto
                    if (get_post_type() === 'product') :
                        global $product;
                        if (!is_a($product, 'WC_Product')) {
                            $product = wc_get_product(get_the_ID());
                        }
                        ?>
                        <article class="search-product-card">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('woocommerce_thumbnail', ['class' => 'search-product-image']); ?>
                                <?php else: ?>
                                    <img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" alt="<?php the_title_attribute(); ?>" class="search-product-image" />
                                <?php endif; ?>
                                
                                <div class="search-product-content">
                                    <h2 class="search-product-title"><?php the_title(); ?></h2>
                                    <div class="search-product-price">
                                        <?php echo $product->get_price_html(); ?>
                                    </div>
                                    <div class="search-product-button-container">
                                        <span class="search-product-button"><?php echo esc_html__('Ver Produto', 'ibp-woocommerce'); ?></span>
                                    </div>
                                </div>
                            </a>
                        </article>
                        <?php
                    else :
                        // Para outros tipos de post
                        get_template_part('template-parts/content', 'search');
                    endif;
                    
                endwhile;
                ?>
            </div>

            <?php
            the_posts_navigation([
                'prev_text' => '&larr; ' . esc_html__('Resultados anteriores', 'ibp-woocommerce'),
                'next_text' => esc_html__('Mais resultados', 'ibp-woocommerce') . ' &rarr;',
            ]);
            ?>

        <?php else : ?>
            <div class="no-results-container">
                <div class="no-results-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h2 class="no-results-message"><?php esc_html_e('Nenhum produto encontrado', 'ibp-woocommerce'); ?></h2>
                <p class="no-results-help"><?php esc_html_e('Desculpe, mas nada corresponde aos seus termos de pesquisa. Por favor, tente novamente com algumas palavras-chave diferentes.', 'ibp-woocommerce'); ?></p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
    </div>

</main><!-- #main -->

<?php
get_footer(); 