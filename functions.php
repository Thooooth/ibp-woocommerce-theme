<?php
/**
 * IBP WooCommerce Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package IBP_WooCommerce
 */

// Define theme version
define('IBP_THEME_VERSION', '1.0.0');

// Setup theme
function ibp_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Register menu locations
    register_nav_menus(
        array(
            'primary' => esc_html__('Menu Principal', 'ibp-woocommerce'),
            'footer' => esc_html__('Menu do Rodapé', 'ibp-woocommerce'),
        )
    );

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'ibp_setup');

/**
 * Enqueue scripts and styles.
 */
function ibp_scripts() {
    // Enqueue Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap', array(), null);
    
    // Enqueue main stylesheet
    wp_enqueue_style('ibp-style', get_stylesheet_uri(), array(), IBP_THEME_VERSION);
    
    // Enqueue custom styles
    wp_enqueue_style('ibp-custom', get_template_directory_uri() . '/assets/css/custom.css', array(), IBP_THEME_VERSION);
    
    // Enqueue Font Awesome com fallback local
    $fa_version = '6.5.1';
    $fa_url = 'https://use.fontawesome.com/releases/v' . $fa_version . '/css/all.css';
    
    // Tenta carregar do CDN primeiro
    wp_enqueue_style('font-awesome', $fa_url, array(), $fa_version);
    
    // Adiciona script para verificar se o Font Awesome carregou e usar fallback se necessário
    wp_add_inline_script('jquery', '
        jQuery(document).ready(function($) {
            var $span = $("<span class=\'fa\' style=\'display:none\'></span>").appendTo("body");
            if ($span.css("fontFamily") !== "FontAwesome") {
                $("head").append("<link rel=\'stylesheet\' href=\'' . get_template_directory_uri() . '/assets/css/fontawesome/all.min.css\' type=\'text/css\' media=\'all\'>");
            }
            $span.remove();
        });
    ');
    
    // Enqueue main JavaScript file
    wp_enqueue_script('ibp-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), IBP_THEME_VERSION, true);

    // If comments are open and we have at least one comment, load up the comment-reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'ibp_scripts');

/**
 * Carrega o Font Awesome localmente
 */

function carregar_fontawesome_local() {
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/fontawesome/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'carregar_fontawesome_local');



/**
 * Register widget area.
 */
function ibp_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__('Barra lateral', 'ibp-woocommerce'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Adicione widgets aqui.', 'ibp-woocommerce'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
    
    register_sidebar(
        array(
            'name'          => esc_html__('Rodapé Coluna 1', 'ibp-woocommerce'),
            'id'            => 'footer-1',
            'description'   => esc_html__('Adicione widgets aqui.', 'ibp-woocommerce'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
    
    register_sidebar(
        array(
            'name'          => esc_html__('Rodapé Coluna 2', 'ibp-woocommerce'),
            'id'            => 'footer-2',
            'description'   => esc_html__('Adicione widgets aqui.', 'ibp-woocommerce'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
}
add_action('widgets_init', 'ibp_widgets_init');

/**
 * Hero Slider Customizer Settings
 */
function ibp_hero_slider_customizer($wp_customize) {
    // Add section for hero slider
    $wp_customize->add_section('ibp_hero_slider', array(
        'title'       => __('Slider da Página Inicial', 'ibp-woocommerce'),
        'description' => __('Configure as imagens do slider da página inicial.', 'ibp-woocommerce'),
        'priority'    => 30,
    ));
    
    // Setting para número de slides
    $wp_customize->add_setting('ibp_hero_slider_count', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('ibp_hero_slider_count', array(
        'label'       => __('Número de Slides', 'ibp-woocommerce'),
        'description' => __('Quantos slides você deseja no slider?', 'ibp-woocommerce'),
        'section'     => 'ibp_hero_slider',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 10,
            'step' => 1,
        ),
    ));
    
    // Loop para criar as opções para cada slide
    $slide_count = get_theme_mod('ibp_hero_slider_count', 3);
    
    for ($i = 1; $i <= $slide_count; $i++) {
        // Imagem do slide
        $wp_customize->add_setting('ibp_hero_slide_image_' . $i, array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        ));
        
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'ibp_hero_slide_image_' . $i, array(
            'label'       => sprintf(__('Slide %d - Imagem', 'ibp-woocommerce'), $i),
            'description' => __('Recomendado: imagem retangular com 1200px de largura.', 'ibp-woocommerce'),
            'section'     => 'ibp_hero_slider',
            'mime_type'   => 'image',
        )));
        
        // Link do slide (opcional)
        $wp_customize->add_setting('ibp_hero_slide_link_' . $i, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control('ibp_hero_slide_link_' . $i, array(
            'label'       => sprintf(__('Slide %d - Link (opcional)', 'ibp-woocommerce'), $i),
            'description' => __('Se preenchido, a imagem será clicável e redirecionará para este link.', 'ibp-woocommerce'),
            'section'     => 'ibp_hero_slider',
            'type'        => 'url',
        ));
        
        // Texto alternativo (para acessibilidade)
        $wp_customize->add_setting('ibp_hero_slide_alt_' . $i, array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control('ibp_hero_slide_alt_' . $i, array(
            'label'       => sprintf(__('Slide %d - Texto Alternativo', 'ibp-woocommerce'), $i),
            'description' => __('Texto descritivo da imagem, importante para acessibilidade.', 'ibp-woocommerce'),
            'section'     => 'ibp_hero_slider',
            'type'        => 'text',
        ));
    }
    
    // Configurações do slider
    $wp_customize->add_setting('ibp_hero_slider_autoplay', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    
    $wp_customize->add_control('ibp_hero_slider_autoplay', array(
        'label'       => __('Reprodução Automática', 'ibp-woocommerce'),
        'description' => __('Alternar slides automaticamente.', 'ibp-woocommerce'),
        'section'     => 'ibp_hero_slider',
        'type'        => 'checkbox',
    ));
    
    $wp_customize->add_setting('ibp_hero_slider_speed', array(
        'default'           => 5000,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('ibp_hero_slider_speed', array(
        'label'       => __('Velocidade do Slider (ms)', 'ibp-woocommerce'),
        'description' => __('Tempo em milissegundos entre cada slide.', 'ibp-woocommerce'),
        'section'     => 'ibp_hero_slider',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1000,
            'max'  => 10000,
            'step' => 500,
        ),
    ));
    
    $wp_customize->add_setting('ibp_hero_slider_dots', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    
    $wp_customize->add_control('ibp_hero_slider_dots', array(
        'label'       => __('Mostrar Indicadores', 'ibp-woocommerce'),
        'description' => __('Mostrar pontos de navegação abaixo do slider.', 'ibp-woocommerce'),
        'section'     => 'ibp_hero_slider',
        'type'        => 'checkbox',
    ));
    
    $wp_customize->add_setting('ibp_hero_slider_arrows', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    
    $wp_customize->add_control('ibp_hero_slider_arrows', array(
        'label'       => __('Mostrar Setas', 'ibp-woocommerce'),
        'description' => __('Mostrar setas de navegação nos lados do slider.', 'ibp-woocommerce'),
        'section'     => 'ibp_hero_slider',
        'type'        => 'checkbox',
    ));
}
add_action('customize_register', 'ibp_hero_slider_customizer');

/**
 * Função para exibir o hero slider
 */
function ibp_hero_slider() {
    $slide_count = get_theme_mod('ibp_hero_slider_count', 3);
    
    if ($slide_count < 1) {
        return;
    }
    
    // Enqueue Slick Slider
    wp_enqueue_script('ibp-slick-js', get_template_directory_uri() . '/assets/js/vendor/slick.min.js', array('jquery'), '1.9.0', true);
    wp_enqueue_style('ibp-slick-css', get_template_directory_uri() . '/assets/css/slick.css', array(), '1.9.0');
    
    // Opções do slider
    $autoplay = get_theme_mod('ibp_hero_slider_autoplay', true);
    $speed = get_theme_mod('ibp_hero_slider_speed', 5000);
    $dots = get_theme_mod('ibp_hero_slider_dots', true);
    $arrows = get_theme_mod('ibp_hero_slider_arrows', true);
    
    // Data attributes para o slider
    $slider_attrs = sprintf(
        'data-autoplay="%s" data-speed="%d" data-dots="%s" data-arrows="%s"',
        $autoplay ? 'true' : 'false',
        $speed,
        $dots ? 'true' : 'false',
        $arrows ? 'true' : 'false'
    );
    
    echo '<div class="hero-slider-container">';
    echo '<div class="hero-slider" ' . $slider_attrs . '>';
    
    for ($i = 1; $i <= $slide_count; $i++) {
        $image_id = get_theme_mod('ibp_hero_slide_image_' . $i, '');
        $link = get_theme_mod('ibp_hero_slide_link_' . $i, '');
        $alt = get_theme_mod('ibp_hero_slide_alt_' . $i, '');
        
        if (!$image_id) {
            continue; // Pula slides sem imagem
        }
        
        echo '<div class="hero-slide">';
        
        if ($link) {
            echo '<a href="' . esc_url($link) . '">';
        }
        
        // Configurando o tamanho da imagem como "full" para obter tamanho original
        $image_atts = array(
            'class' => 'hero-slide-image',
            'alt' => !empty($alt) ? esc_attr($alt) : '',
        );
        
        echo wp_get_attachment_image($image_id, 'full', false, $image_atts);
        
        if ($link) {
            echo '</a>';
        }
        
        echo '</div>'; // hero-slide
    }
    
    echo '</div>'; // hero-slider
    echo '</div>'; // hero-slider-container
    
    // Adicionando script inline para inicializar o slider com configurações melhoradas
    echo '<script>
        jQuery(document).ready(function($) {
            var $heroSlider = $(".hero-slider");
            if ($heroSlider.length) {
                $heroSlider.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: ' . ($autoplay ? 'true' : 'false') . ',
                    autoplaySpeed: ' . $speed . ',
                    arrows: ' . ($arrows ? 'true' : 'false') . ',
                    dots: ' . ($dots ? 'true' : 'false') . ',
                    fade: true,
                    adaptiveHeight: true,
                    infinite: true,
                    cssEase: "linear",
                    prevArrow: "<button type=\"button\" class=\"slick-prev\"><i class=\"fas fa-chevron-left\"></i></button>",
                    nextArrow: "<button type=\"button\" class=\"slick-next\"><i class=\"fas fa-chevron-right\"></i></button>",
                    customPaging: function(slider, i) {
                        return "<button type=\"button\" data-role=\"none\"></button>";
                    },
                    dotsClass: "slick-dots",
                    appendDots: $(".hero-slider-container")
                });
            }
        });
    </script>';
}

/**
 * WooCommerce specific functions
 */
if (class_exists('WooCommerce')) {
    // Remove default WooCommerce styles
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');
    
    // Display 12 products per page
    add_filter('loop_shop_per_page', function () {
        return 12;
    });
    
    // Custom breadcrumb separator
    add_filter('woocommerce_breadcrumb_defaults', function () {
        return array(
            'delimiter'   => ' &raquo; ',
            'wrap_before' => '<nav class="woocommerce-breadcrumb">',
            'wrap_after'  => '</nav>',
            'before'      => '',
            'after'       => '',
            'home'        => _x('Início', 'breadcrumb', 'ibp-woocommerce'),
        );
    });
    
    // Remove o breadcrumb padrão para evitar duplicação nas páginas de produto
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
}

/**
 * Implement custom newsletter signup form
 */
function ibp_newsletter_form() {
    ?>
    <div class="newsletter-section">
        <div class="newsletter-content">
            <div class="newsletter-text">
                <h2><?php esc_html_e('Cadastre-se e receba novidades, ofertas exclusivas e muito mais!', 'ibp-woocommerce'); ?></h2>
                <p><?php esc_html_e('Inscreva-se em nossa lista, para receber lançamentos, cupons de descontos e promoções imperdíveis!', 'ibp-woocommerce'); ?></p>
            </div>
            
            <form class="newsletter-form" method="post">
                <div class="newsletter-form-container">
                    <input type="email" name="email" class="newsletter-input" placeholder="<?php esc_attr_e('Seu e-mail', 'ibp-woocommerce'); ?>" required>
                    <button type="submit" class="newsletter-button"><?php esc_html_e('ASSINAR', 'ibp-woocommerce'); ?></button>
                </div>
            </form>
        </div>
        
        <div class="newsletter-logo">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/ibp-editora-logo-icon.png'); ?>" alt="Logo IBP">
        </div>
    </div>
    <?php
}

/**
 * Adiciona estilos responsivos para o formulário de newsletter
 */
function ibp_newsletter_responsive_styles() {
    $custom_css = '
    /* Layout da seção de newsletter */
    .newsletter-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 40px;
        background-color: #621772;
        margin: 40px 0;
        margin-bottom: 100px
    }
    
    .newsletter-content {
        flex: 1;
        max-width: 70%;
        padding-right: 40px;
    }
    
    .newsletter-text h2 {
        font-size: 36px;
        margin-bottom: 15px;
        color: #FFF;
    }
    
    .newsletter-text p {
        font-size: 18px;
        margin-bottom: 25px;
        color: #FFF;
    }
    
    .newsletter-form-container {
        display: flex;
        gap: 10px;
        max-width: 500px;
    }
    
    .newsletter-input {
        flex: 1;
        border: 1px solid #ddd;
        font-size: 16px;
    }
    
    .newsletter-button {
        padding: 12px 30px;
        background-color: #0066cc;
        color: white;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    
    .newsletter-button:hover {
        background-color:rgb(144, 49, 165);
    }
    
    .newsletter-logo {
        flex: 0 0 auto;
        max-width: 200px;
        text-align: center;
        padding-right: 40px;
    }
    
    .newsletter-logo img {
        max-width: 100%;
        height: auto;
    }
    
    /* Estilos responsivos */
    @media (max-width: 768px) {
        .newsletter-section {
            flex-direction: column;
            padding: 20px;
            text-align: center;
        }
        
        .newsletter-content {
            max-width: 100%;
            padding-right: 0;
            margin-bottom: 30px;
        }
        
        .newsletter-text h2 {
            font-size: 20px;
        }
        
        .newsletter-text p {
            font-size: 14px;
        }
        
        .newsletter-form-container {
            flex-direction: column;
            margin: 0 auto;
        }
        
        .newsletter-input {
            width: 100%;
            margin-bottom: 10px;
        }
        
        .newsletter-button {
            width: 100%;
        }
        
        .newsletter-logo {
            max-width: 150px;
            margin: 20px auto 0;
        }
    }
    ';
    
    wp_add_inline_style('ibp-custom', $custom_css);
}
add_action('wp_enqueue_scripts', 'ibp_newsletter_responsive_styles', 20);

/**
 * Custom recent products function
 * 
 * Exibe os produtos recentes do WooCommerce em um grid com paginação.
 * 
 * @param int $count     Número de produtos por página (padrão: 2)
 * @param int $columns   Número de colunas no grid (valores aceitos: 2, 3, 4, 5 ou 6)
 * @param bool $enabled  Se a seção está habilitada ou não
 * @param string $title  Título personalizado para a seção
 * 
 * Exemplos de uso:
 * - ibp_recent_products(4, 2);    // 4 produtos em 2 colunas
 * - ibp_recent_products(6, 3);    // 6 produtos em 3 colunas
 * - ibp_recent_products(8, 4);    // 8 produtos em 4 colunas
 * - ibp_recent_products(10, 5);   // 10 produtos em 5 colunas
 * - ibp_recent_products(12, 6);   // 12 produtos em 6 colunas
 * 
 * @return void
 */
function ibp_recent_products($count = 2, $columns = 2, $enabled = true, $title = '') {
    if (!$enabled || !class_exists('WooCommerce')) {
        return;
    }
    
    // Título padrão se não for fornecido
    if (empty($title)) {
        $title = esc_html__('Últimos Lançamentos', 'ibp-woocommerce');
    }
    
    // Limitar o número de colunas entre 2 e 6
    $columns = max(2, min(6, absint($columns)));
    
    // Vamos pegar mais produtos para permitir a paginação
    $total_products = $count * 3; // 3 páginas no total
    
    // Data de 30 dias atrás para produtos novos
    $thirty_days_ago = date('Y-m-d H:i:s', strtotime('-30 days'));
    
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $total_products,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    
    $loop = new WP_Query($args);
    
    if ($loop->have_posts()) {
        echo '<div class="product-section recent-launches">';
        echo '<h2>' . esc_html($title) . '</h2>';
        
        // Total de páginas
        $total_pages = ceil($loop->post_count / $count);
        
        // Classe para o grid baseada no número de colunas
        $grid_class = 'product-grid columns-' . $columns;
        
        // Container para os produtos com paginação
        echo '<div class="product-grid-wrapper">';
        
        // Loop através das páginas
        for ($page = 1; $page <= $total_pages; $page++) {
            $page_class = ($page === 1) ? $grid_class . ' product-page active' : $grid_class . ' product-page';
            echo '<div class="' . $page_class . '" data-page="' . $page . '">';
            
            // Índice inicial e final para cada página
            $start = ($page - 1) * $count;
            $end = min($start + $count - 1, $loop->post_count - 1);
            
            // Reposicionar o contador de posts para o início da página
            $loop->rewind_posts();
            for ($i = 0; $i < $loop->post_count; $i++) {
                $loop->the_post();
                
                // Exibir apenas os produtos da página atual
                if ($i >= $start && $i <= $end) {
                    global $product;
                    
                    // Verificar se o produto está em promoção
                    $regular_price = $product->get_regular_price();
                    $sale_price = $product->get_sale_price();
                    $is_on_sale = $product->is_on_sale() && !empty($sale_price);
                    
                    // Verificar se o produto é novo (menos de 30 dias)
                    $post_date = get_the_date('Y-m-d H:i:s');
                    $is_new = strtotime($post_date) > strtotime($thirty_days_ago);
                    
                    echo '<div class="product-card">';
                    
                    // Badge de promoção
                    if ($is_on_sale) {
                        $discount = round((($regular_price - $sale_price) / $regular_price) * 100);
                        echo '<span class="sale-badge">-' . $discount . '%</span>';
                    }
                    
                    // Badge de novo produto
                    if ($is_new) {
                        echo '<span class="new-badge">' . esc_html__('Novo', 'ibp-woocommerce') . '</span>';
                    }
                    
                    echo '<a href="' . get_permalink() . '">';
                    echo '<div class="product-image">';
                    echo woocommerce_get_product_thumbnail();
                    echo '</div>';
                    echo '<div class="product-content">';
                    echo '<h3>' . get_the_title() . '</h3>';
                    echo '<span class="price">' . $product->get_price_html() . '</span>';
                    echo '</div>'; // .product-content
                    echo '</a>';
                    echo '<div class="product-content">';
                    echo '<a href="' . esc_url($product->add_to_cart_url()) . '" class="cta-button">' . esc_html__('Comprar', 'ibp-woocommerce') . '</a>';
                    echo '</div>'; // segundo .product-content para o botão
                    echo '</div>'; // .product-card
                }
            }
            
            echo '</div>'; // .product-grid
        }
        
        echo '</div>'; // .product-grid-wrapper
        
        // Adiciona paginação com dots
        if ($total_pages > 1) {
            echo '<div class="pagination-dots">';
            for ($i = 1; $i <= $total_pages; $i++) {
                $active_class = ($i === 1) ? 'active' : '';
                echo '<span class="pagination-dot ' . $active_class . '" data-page="' . $i . '"></span>';
            }
            echo '</div>';
            
            // Adiciona script para controlar a paginação
            echo '<script>
                jQuery(document).ready(function($) {
                    $(".recent-launches .pagination-dot").on("click", function() {
                        var page = $(this).data("page");
                        
                        // Atualiza o dot ativo
                        $(".recent-launches .pagination-dot").removeClass("active");
                        $(this).addClass("active");
                        
                        // Mostra a página selecionada
                        $(".recent-launches .product-page").removeClass("active");
                        $(".recent-launches .product-page[data-page=" + page + "]").addClass("active");
                    });
                });
            </script>';
        }
        
        echo '</div>'; // .product-section
    }
    
    wp_reset_postdata();
}

// Remover posts recentes do formulário de login
remove_action('woocommerce_after_customer_login_form', 'ibp_recent_products', 20);

/**
 * Free shipping banner
 */
function ibp_banner_livros_transformam_conhecimento_em_oportunidades() {
    echo '<div class="booking-banner">';
    echo esc_html__('LIVROS TRANSFORMAM CONHECIMENTO EM OPORTUNIDADES!', 'ibp-woocommerce');
    echo '</div>';
}

/**
 * Custom Menu Classes
 */
function ibp_menu_classes($classes, $item, $args) {
    if ($args->theme_location == 'primary') {
        $classes[] = 'menu-item';
        
        // Adiciona classe para itens com submenu
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'has-dropdown';
        }
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'ibp_menu_classes', 10, 3);

/**
 * Custom Menu Link Attributes
 */
function ibp_menu_link_attributes($atts, $item, $args) {
    if ($args->theme_location == 'primary') {
        $atts['class'] = isset($atts['class']) ? $atts['class'] . ' menu-link' : 'menu-link';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'ibp_menu_link_attributes', 10, 3);

/**
 * Add arrow to submenu items
 */
function ibp_walker_nav_menu_start_el($item_output, $item, $depth, $args) {
    if ($args->theme_location == 'primary' && in_array('menu-item-has-children', $item->classes)) {
        return $item_output;
    }
    return $item_output;
}
add_filter('walker_nav_menu_start_el', 'ibp_walker_nav_menu_start_el', 10, 4);

/**
 * Customizer para adicionar redes sociais
 */
function ibp_social_customizer($wp_customize) {
    // Seção de Redes Sociais
    $wp_customize->add_section('ibp_social_media', array(
        'title'      => __('Redes Sociais', 'ibp-woocommerce'),
        'priority'   => 30,
    ));
    
    // Instagram
    $wp_customize->add_setting('ibp_instagram_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('ibp_instagram_url', array(
        'label'       => __('URL do Instagram', 'ibp-woocommerce'),
        'section'     => 'ibp_social_media',
        'type'        => 'url',
    ));
    
    // YouTube
    $wp_customize->add_setting('ibp_youtube_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('ibp_youtube_url', array(
        'label'       => __('URL do YouTube', 'ibp-woocommerce'),
        'section'     => 'ibp_social_media',
        'type'        => 'url',
    ));
    
    // LinkedIn
    $wp_customize->add_setting('ibp_linkedin_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('ibp_linkedin_url', array(
        'label'       => __('URL do LinkedIn', 'ibp-woocommerce'),
        'section'     => 'ibp_social_media',
        'type'        => 'url',
    ));
    
    // Facebook
    $wp_customize->add_setting('ibp_facebook_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('ibp_facebook_url', array(
        'label'       => __('URL do Facebook', 'ibp-woocommerce'),
        'section'     => 'ibp_social_media',
        'type'        => 'url',
    ));
    
    // Twitter/X
    $wp_customize->add_setting('ibp_twitter_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('ibp_twitter_url', array(
        'label'       => __('URL do Twitter/X', 'ibp-woocommerce'),
        'section'     => 'ibp_social_media',
        'type'        => 'url',
    ));
    
    // WhatsApp
    $wp_customize->add_setting('ibp_whatsapp_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('ibp_whatsapp_url', array(
        'label'       => __('URL ou Link do WhatsApp', 'ibp-woocommerce'),
        'section'     => 'ibp_social_media',
        'type'        => 'url',
    ));
}
add_action('customize_register', 'ibp_social_customizer');

/**
 * Função para exibir os ícones das redes sociais
 */
function ibp_social_icons() {
    $instagram = get_theme_mod('ibp_instagram_url', '');
    $youtube = get_theme_mod('ibp_youtube_url', '');
    $linkedin = get_theme_mod('ibp_linkedin_url', '');
    $facebook = get_theme_mod('ibp_facebook_url', '');
    $twitter = get_theme_mod('ibp_twitter_url', '');
    
    echo '<div class="social-icons">';
    
    if (!empty($instagram)) {
        echo '<a href="' . esc_url($instagram) . '" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>';
    }
    
    if (!empty($youtube)) {
        echo '<a href="' . esc_url($youtube) . '" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube" aria-hidden="true"></i></a>';
    }
    
    if (!empty($linkedin)) {
        echo '<a href="' . esc_url($linkedin) . '" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>';
    }
    
    if (!empty($facebook)) {
        echo '<a href="' . esc_url($facebook) . '" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>';
    }
    
    if (!empty($twitter)) {
        echo '<a href="' . esc_url($twitter) . '" target="_blank" rel="noopener" aria-label="Twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a>';
    }
    
    echo '</div>';
}

/**
 * Função para exibir os ícones das redes sociais no footer
 */
function ibp_footer_social_icons() {
    $instagram = get_theme_mod('ibp_instagram_url', '');
    $youtube = get_theme_mod('ibp_youtube_url', '');
    $linkedin = get_theme_mod('ibp_linkedin_url', '');
    $facebook = get_theme_mod('ibp_facebook_url', '');
    $twitter = get_theme_mod('ibp_twitter_url', '');
    $whatsapp = get_theme_mod('ibp_whatsapp_url', '');
    
    echo '<div class="footer-social">';
    
    if (!empty($instagram)) {
        echo '<a href="' . esc_url($instagram) . '" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>';
    }
    
    if (!empty($youtube)) {
        echo '<a href="' . esc_url($youtube) . '" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>';
    }
    
    if (!empty($linkedin)) {
        echo '<a href="' . esc_url($linkedin) . '" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>';
    }
    
    if (!empty($facebook)) {
        echo '<a href="' . esc_url($facebook) . '" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>';
    }
    
    if (!empty($twitter)) {
        echo '<a href="' . esc_url($twitter) . '" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a>';
    }
    
    echo '</div>';
}

/**
 * Função para exibir produtos mais vendidos
 * 
 * Exibe os produtos mais vendidos do WooCommerce em um grid com paginação.
 * 
 * @param int $count        Número de produtos por página
 * @param int $columns      Número de colunas (2-6)
 * @param bool $enabled     Se a seção está habilitada
 * @param string $title     Título personalizado para a seção (opcional)
 * 
 * @return void
 */
function ibp_best_sellers($count = 4, $columns = 4, $enabled = true, $title = '') {
    if (!$enabled || !class_exists('WooCommerce')) {
        return;
    }
    
    // Título padrão se não for fornecido
    if (empty($title)) {
        $title = esc_html__('Mais Vendidos', 'ibp-woocommerce');
    }
    
    // Limitar o número de colunas entre 2 e 6
    $columns = max(2, min(6, absint($columns)));
    
    // Vamos pegar mais produtos para permitir a paginação
    $total_products = $count * 3; // 3 páginas no total
    
    // Data de 30 dias atrás para produtos novos
    $thirty_days_ago = date('Y-m-d H:i:s', strtotime('-30 days'));
    
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $total_products,
        'meta_key'       => 'total_sales',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
    );
    
    $loop = new WP_Query($args);
    
    if ($loop->have_posts()) {
        echo '<div class="product-section best-sellers">';
        echo '<h2>' . esc_html($title) . '</h2>';
        
        // Total de páginas
        $total_pages = ceil($loop->post_count / $count);
        
        // Classe para o grid baseada no número de colunas
        $grid_class = 'product-grid columns-' . $columns;
        
        // Container para os produtos com paginação
        echo '<div class="product-grid-wrapper">';
        
        // Loop através das páginas
        for ($page = 1; $page <= $total_pages; $page++) {
            $page_class = ($page === 1) ? $grid_class . ' product-page active' : $grid_class . ' product-page';
            echo '<div class="' . $page_class . '" data-page="' . $page . '">';
            
            // Índice inicial e final para cada página
            $start = ($page - 1) * $count;
            $end = min($start + $count - 1, $loop->post_count - 1);
            
            // Reposicionar o contador de posts para o início da página
            $loop->rewind_posts();
            for ($i = 0; $i < $loop->post_count; $i++) {
                $loop->the_post();
                
                // Exibir apenas os produtos da página atual
                if ($i >= $start && $i <= $end) {
                    global $product;
                    
                    // Verificar se o produto está em promoção
                    $regular_price = $product->get_regular_price();
                    $sale_price = $product->get_sale_price();
                    $is_on_sale = $product->is_on_sale() && !empty($sale_price);
                    
                    // Verificar se o produto é novo (menos de 30 dias)
                    $post_date = get_the_date('Y-m-d H:i:s');
                    $is_new = strtotime($post_date) > strtotime($thirty_days_ago);
                    
                    echo '<div class="product-card">';
                    
                    // Badge de promoção
                    if ($is_on_sale) {
                        $discount = round((($regular_price - $sale_price) / $regular_price) * 100);
                        echo '<span class="sale-badge">-' . $discount . '%</span>';
                    }
                    
                    // Badge de novo produto
                    if ($is_new) {
                        echo '<span class="new-badge">' . esc_html__('Novo', 'ibp-woocommerce') . '</span>';
                    }
                    
                    echo '<a href="' . get_permalink() . '">';
                    echo '<div class="product-content-image">';
                    echo '<div class="product-image">';
                    echo woocommerce_get_product_thumbnail();
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="product-content">';
                    echo '<h3 class="product-title">' . get_the_title() . '</h3>';
                    echo '<a class="product-edicao">' . $product->get_attribute('Edição') . '</a>';
                    echo '<a href="' . esc_url($product->get_attribute('Author URL')) . '" target="_blank" class="product-author">' . $product->get_attribute('Author') . '</a>';
                    echo '<a href="' . esc_url($product->get_attribute('Editora URL')) . '" target="_blank" class="product-editora">' . $product->get_attribute('Editora') . '</a>';
                    echo '<span class="price">' . $product->get_price_html() . '</span>';
                    echo '</div>'; // .product-content
                    echo '</div>'; // .product-card
                    echo '</a>';    
                }
            }
            
            echo '</div>'; // .product-grid
        }
        
        echo '</div>'; // .product-grid-wrapper
        
        // Adiciona paginação com dots
        if ($total_pages > 1) {
            echo '<div class="pagination-dots">';
            for ($i = 1; $i <= $total_pages; $i++) {
                $active_class = ($i === 1) ? 'active' : '';
                echo '<span class="pagination-dot ' . $active_class . '" data-page="' . $i . '"></span>';
            }
            echo '</div>';
            
            // Adiciona script para controlar a paginação
            echo '<script>
                jQuery(document).ready(function($) {
                    $(".best-sellers .pagination-dot").on("click", function() {
                        var page = $(this).data("page");
                        
                        // Atualiza o dot ativo
                        $(".best-sellers .pagination-dot").removeClass("active");
                        $(this).addClass("active");
                        
                        // Mostra a página selecionada
                        $(".best-sellers .product-page").removeClass("active");
                        $(".best-sellers .product-page[data-page=" + page + "]").addClass("active");
                    });
                });
            </script>';
        }
        
        echo '</div>'; // .product-section
    }
    
    wp_reset_postdata();
}

/**
 * Função para exibir todos os produtos
 * 
 * Exibe todos os produtos do WooCommerce em um grid com paginação.
 * 
 * @param int $count        Número de produtos por página
 * @param int $columns      Número de colunas (2-6)
 * @param bool $enabled     Se a seção está habilitada
 * @param string $title     Título personalizado para a seção (opcional)
 * @param array $categories IDs de categorias para filtrar produtos (opcional)
 * 
 * @return void
 */
function ibp_all_products($count = 8, $columns = 4, $enabled = true, $title = '', $categories = array()) {
    if (!$enabled || !class_exists('WooCommerce')) {
        return;
    }
    
    // Título padrão se não for fornecido
    if (empty($title)) {
        $title = esc_html__('Todos os Produtos', 'ibp-woocommerce');
    }
    
    // Limitar o número de colunas entre 2 e 6
    $columns = max(2, min(6, absint($columns)));
    
    // Vamos pegar mais produtos para permitir a paginação
    $total_products = $count * 3; // 3 páginas no total
    
    // Data de 30 dias atrás para produtos novos
    $thirty_days_ago = date('Y-m-d H:i:s', strtotime('-30 days'));
    
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $total_products,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    
    // Adicione filtro de categorias se especificado
    if (!empty($categories) && is_array($categories)) {
        $args['tax_query'] = array(
            array(
                'taxonomy'  => 'product_cat',
                'field'     => 'term_id',
                'terms'     => $categories,
                'operator'  => 'IN',
            ),
        );
    }
    
    $loop = new WP_Query($args);
    
    if ($loop->have_posts()) {
        echo '<div class="product-section all-products">';
        echo '<h2>' . esc_html($title) . '</h2>';
        
        // Total de páginas
        $total_pages = ceil($loop->post_count / $count);
        
        // Classe para o grid baseada no número de colunas
        $grid_class = 'product-grid columns-' . $columns;
        
        // Container para os produtos com paginação
        echo '<div class="product-grid-wrapper">';
        
        // Loop através das páginas
        for ($page = 1; $page <= $total_pages; $page++) {
            $page_class = ($page === 1) ? $grid_class . ' product-page active' : $grid_class . ' product-page';
            echo '<div class="' . $page_class . '" data-page="' . $page . '">';
            
            // Índice inicial e final para cada página
            $start = ($page - 1) * $count;
            $end = min($start + $count - 1, $loop->post_count - 1);
            
            // Reposicionar o contador de posts para o início da página
            $loop->rewind_posts();
            for ($i = 0; $i < $loop->post_count; $i++) {
                $loop->the_post();
                
                // Exibir apenas os produtos da página atual
                if ($i >= $start && $i <= $end) {
                    global $product;
                    
                    // Verificar se o produto está em promoção
                    $regular_price = $product->get_regular_price();
                    $sale_price = $product->get_sale_price();
                    $is_on_sale = $product->is_on_sale() && !empty($sale_price);
                    
                    // Verificar se o produto é novo (menos de 30 dias)
                    $post_date = get_the_date('Y-m-d H:i:s');
                    $is_new = strtotime($post_date) > strtotime($thirty_days_ago);
                    
                    echo '<div class="product-card">';
                    
                    // Badge de promoção
                    if ($is_on_sale) {
                        $discount = round((($regular_price - $sale_price) / $regular_price) * 100);
                        echo '<span class="sale-badge">-' . $discount . '%</span>';
                    }
                    
                    // Badge de novo produto
                    if ($is_new) {
                        echo '<span class="new-badge">' . esc_html__('Novo', 'ibp-woocommerce') . '</span>';
                    }
                    
                    echo '<a href="' . get_permalink() . '">';
                    echo '<div class="product-image">';
                    echo woocommerce_get_product_thumbnail();
                    echo '</div>';
                    echo '<div class="product-content">';
                    echo '<h3>' . get_the_title() . '</h3>';
                    echo '<span class="price">' . $product->get_price_html() . '</span>';
                    echo '</div>'; // .product-content
                    echo '</a>';
                    echo '<div class="product-content">';
                    echo '<a href="' . esc_url($product->add_to_cart_url()) . '" class="cta-button">' . esc_html__('Comprar', 'ibp-woocommerce') . '</a>';
                    echo '</div>'; // segundo .product-content para o botão
                    echo '</div>'; // .product-card
                }
            }
            
            echo '</div>'; // .product-grid
        }
        
        echo '</div>'; // .product-grid-wrapper
        
        // Adiciona paginação com dots
        if ($total_pages > 1) {
            echo '<div class="pagination-dots">';
            for ($i = 1; $i <= $total_pages; $i++) {
                $active_class = ($i === 1) ? 'active' : '';
                echo '<span class="pagination-dot ' . $active_class . '" data-page="' . $i . '"></span>';
            }
            echo '</div>';
            
            // Adiciona script para controlar a paginação
            echo '<script>
                jQuery(document).ready(function($) {
                    $(".all-products .pagination-dot").on("click", function() {
                        var page = $(this).data("page");
                        
                        // Atualiza o dot ativo
                        $(".all-products .pagination-dot").removeClass("active");
                        $(this).addClass("active");
                        
                        // Mostra a página selecionada
                        $(".all-products .product-page").removeClass("active");
                        $(".all-products .product-page[data-page=" + page + "]").addClass("active");
                    });
                });
            </script>';
        }
        
        echo '<div class="view-all-button">';
        echo '<a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '" class="button all-products-btn">' . esc_html__('Ver Todos os Produtos', 'ibp-woocommerce') . '</a>';
        echo '</div>';
        
        echo '</div>'; // .product-section
    }
    
    wp_reset_postdata();
}

/**
 * Customizador para configurar seções de produtos na página inicial
 */
function ibp_product_sections_customizer($wp_customize) {
    // Seção de Produtos da Página Inicial
    $wp_customize->add_section('ibp_product_sections', array(
        'title'       => __('Seções de Produtos da Página Inicial', 'ibp-woocommerce'),
        'description' => __('Configure as seções de produtos exibidas na página inicial.', 'ibp-woocommerce'),
        'priority'    => 35,
    ));
    
    // Lançamentos Recentes - Habilitado
    $wp_customize->add_setting('ibp_recent_enabled', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    
    $wp_customize->add_control('ibp_recent_enabled', array(
        'label'       => __('Habilitar Lançamentos Recentes', 'ibp-woocommerce'),
        'section'     => 'ibp_product_sections',
        'type'        => 'checkbox',
    ));
    
    // Lançamentos Recentes - Título
    $wp_customize->add_setting('ibp_recent_title', array(
        'default'           => __('Últimos Lançamentos', 'ibp-woocommerce'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('ibp_recent_title', array(
        'label'       => __('Título para Lançamentos Recentes', 'ibp-woocommerce'),
        'section'     => 'ibp_product_sections',
        'type'        => 'text',
    ));
    
    // Lançamentos Recentes - Quantidade
    $wp_customize->add_setting('ibp_recent_count', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('ibp_recent_count', array(
        'label'       => __('Quantidade de Produtos Recentes', 'ibp-woocommerce'),
        'section'     => 'ibp_product_sections',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 2,
            'max'  => 12,
            'step' => 1,
        ),
    ));
    
    // Lançamentos Recentes - Colunas
    $wp_customize->add_setting('ibp_recent_columns', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('ibp_recent_columns', array(
        'label'       => __('Número de Colunas para Produtos Recentes', 'ibp-woocommerce'),
        'section'     => 'ibp_product_sections',
        'type'        => 'select',
        'choices'     => array(
            2 => '2 Colunas',
            3 => '3 Colunas',
            4 => '4 Colunas',
            5 => '5 Colunas',
            6 => '6 Colunas',
        ),
    ));
    
    // Mais Vendidos - Habilitado
    $wp_customize->add_setting('ibp_bestsellers_enabled', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    
    $wp_customize->add_control('ibp_bestsellers_enabled', array(
        'label'       => __('Habilitar Produtos Mais Vendidos', 'ibp-woocommerce'),
        'section'     => 'ibp_product_sections',
        'type'        => 'checkbox',
    ));
    
    // Mais Vendidos - Título
    $wp_customize->add_setting('ibp_bestsellers_title', array(
        'default'           => __('Mais Vendidos', 'ibp-woocommerce'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('ibp_bestsellers_title', array(
        'label'       => __('Título para Produtos Mais Vendidos', 'ibp-woocommerce'),
        'section'     => 'ibp_product_sections',
        'type'        => 'text',
    ));
    
    // Mais Vendidos - Quantidade
    $wp_customize->add_setting('ibp_bestsellers_count', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('ibp_bestsellers_count', array(
        'label'       => __('Quantidade de Produtos Mais Vendidos', 'ibp-woocommerce'),
        'section'     => 'ibp_product_sections',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 2,
            'max'  => 12,
            'step' => 1,
        ),
    ));
    
    // Mais Vendidos - Colunas
    $wp_customize->add_setting('ibp_bestsellers_columns', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('ibp_bestsellers_columns', array(
        'label'       => __('Número de Colunas para Mais Vendidos', 'ibp-woocommerce'),
        'section'     => 'ibp_product_sections',
        'type'        => 'select',
        'choices'     => array(
            2 => '2 Colunas',
            3 => '3 Colunas',
            4 => '4 Colunas',
            5 => '5 Colunas',
            6 => '6 Colunas',
        ),
    ));
    
    // Todos os Produtos - Habilitado
    $wp_customize->add_setting('ibp_allproducts_enabled', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    
    $wp_customize->add_control('ibp_allproducts_enabled', array(
        'label'       => __('Habilitar Seção Todos os Produtos', 'ibp-woocommerce'),
        'section'     => 'ibp_product_sections',
        'type'        => 'checkbox',
    ));
    
    // Todos os Produtos - Título
    $wp_customize->add_setting('ibp_allproducts_title', array(
        'default'           => __('Todos os Produtos', 'ibp-woocommerce'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('ibp_allproducts_title', array(
        'label'       => __('Título para Todos os Produtos', 'ibp-woocommerce'),
        'section'     => 'ibp_product_sections',
        'type'        => 'text',
    ));
    
    // Todos os Produtos - Quantidade
    $wp_customize->add_setting('ibp_allproducts_count', array(
        'default'           => 8,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('ibp_allproducts_count', array(
        'label'       => __('Quantidade de Produtos na Seção Todos os Produtos', 'ibp-woocommerce'),
        'section'     => 'ibp_product_sections',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 4,
            'max'  => 24,
            'step' => 4,
        ),
    ));
    
    // Todos os Produtos - Colunas
    $wp_customize->add_setting('ibp_allproducts_columns', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('ibp_allproducts_columns', array(
        'label'       => __('Número de Colunas para Todos os Produtos', 'ibp-woocommerce'),
        'section'     => 'ibp_product_sections',
        'type'        => 'select',
        'choices'     => array(
            2 => '2 Colunas',
            3 => '3 Colunas',
            4 => '4 Colunas',
            5 => '5 Colunas',
            6 => '6 Colunas',
        ),
    ));
}
add_action('customize_register', 'ibp_product_sections_customizer');

/**
 * Remove sidebar from single product pages
 */
function ibp_remove_sidebar_product_pages() {
    if (is_product()) {
        remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    }
}
add_action('wp', 'ibp_remove_sidebar_product_pages');

/**
 * Remove sidebar from shop/archive pages
 */
function ibp_remove_sidebar_shop_pages() {
    if (is_shop() || is_product_category() || is_product_tag()) {
        remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    }
}
add_action('wp', 'ibp_remove_sidebar_shop_pages');

/**
 * Personalizar opções de ordenação do WooCommerce
 */
function ibp_customize_woocommerce_catalog_orderby($options) {
    // Mantém apenas as opções desejadas
    $new_options = array(
        'menu_order' => __('Ordenação padrão', 'ibp-woocommerce'),
        'popularity' => __('Mais vendidos', 'ibp-woocommerce'),
        'date'       => __('Lançamentos', 'ibp-woocommerce'),
        'price'      => __('Preço: menor para maior', 'ibp-woocommerce'),
        'price-desc' => __('Preço: maior para menor', 'ibp-woocommerce'),
    );
    
    return $new_options;
}
add_filter('woocommerce_catalog_orderby', 'ibp_customize_woocommerce_catalog_orderby', 20);

/**
 * Define a ordenação padrão de produtos como 'date' (mais recentes primeiro)
 */
function ibp_default_catalog_orderby($sort_by) {
    return 'date';
}
add_filter('woocommerce_default_catalog_orderby', 'ibp_default_catalog_orderby', 20);

/**
 * Customiza o texto de contagem de resultados para português
 */
function ibp_result_count_text($translated_text, $text, $domain) {
    if ($domain === 'woocommerce') {
        switch ($text) {
            case 'Showing all %d results':
                $translated_text = 'Mostrando todos os %d produtos';
                break;
            case 'Showing 1 result':
                $translated_text = 'Mostrando 1 produto';
                break;
            case 'Showing %1$d&ndash;%2$d of %3$d results':
                $translated_text = 'Mostrando %1$d&ndash;%2$d de %3$d produtos';
                break;
            case 'Showing %1$d&ndash;%2$d of %3$d result':
                $translated_text = 'Mostrando %1$d&ndash;%2$d de %3$d produto';
                break;
            case 'Showing the single result':
                $translated_text = 'Mostrando o único produto';
                break;
            case 'No products were found matching your selection.':
                $translated_text = 'Nenhum produto foi encontrado com os critérios selecionados.';
                break;
        }
    }
    return $translated_text;
}
add_filter('gettext', 'ibp_result_count_text', 20, 3); 

require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

function my_theme_register_required_plugins() {
    $plugins = array(
        array(
            'name'     => 'WooCommerce',
            'slug'     => 'woocommerce',
            'required' => true, // Torna o plugin obrigatório
        ),
    );

    $config = array(
        'id'           => 'my-theme', 
        'default_path' => '', 
        'menu'         => 'tgmpa-install-plugins',
        'has_notices'  => true,
        'dismissable'  => false,
        'is_automatic' => true,
    );

    tgmpa($plugins, $config);
}

add_action('tgmpa_register', 'my_theme_register_required_plugins');

/**
 * Customizer para WhatsApp flutuante
 */
function ibp_whatsapp_customizer($wp_customize) {
    // Seção do WhatsApp
    $wp_customize->add_section('ibp_whatsapp_section', array(
        'title'       => __('WhatsApp Flutuante', 'ibp-woocommerce'),
        'priority'    => 30,
        'description' => __('Configure o botão flutuante do WhatsApp.', 'ibp-woocommerce'),
    ));
    
    // Habilitar em Desktop
    $wp_customize->add_setting('ibp_whatsapp_enable_desktop', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    
    $wp_customize->add_control('ibp_whatsapp_enable_desktop', array(
        'label'    => __('Habilitar WhatsApp em Desktop', 'ibp-woocommerce'),
        'section'  => 'ibp_whatsapp_section',
        'type'     => 'checkbox',
    ));

    // Habilitar em Mobile
    $wp_customize->add_setting('ibp_whatsapp_enable_mobile', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    
    $wp_customize->add_control('ibp_whatsapp_enable_mobile', array(
        'label'    => __('Habilitar WhatsApp em Mobile', 'ibp-woocommerce'),
        'section'  => 'ibp_whatsapp_section',
        'type'     => 'checkbox',
    ));
    
    // Número do WhatsApp
    $wp_customize->add_setting('ibp_whatsapp_number', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('ibp_whatsapp_number', array(
        'label'       => __('Número do WhatsApp', 'ibp-woocommerce'),
        'description' => __('Digite o número com código do país e DDD (ex: 5511999999999)', 'ibp-woocommerce'),
        'section'     => 'ibp_whatsapp_section',
        'type'        => 'text',
    ));
    
    // Mensagem padrão
    $wp_customize->add_setting('ibp_whatsapp_message', array(
        'default'           => __('Olá! Gostaria de mais informações.', 'ibp-woocommerce'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('ibp_whatsapp_message', array(
        'label'       => __('Mensagem Padrão', 'ibp-woocommerce'),
        'description' => __('Mensagem que aparecerá pré-preenchida no WhatsApp', 'ibp-woocommerce'),
        'section'     => 'ibp_whatsapp_section',
        'type'        => 'text',
    ));
    
    // Posição do botão
    $wp_customize->add_setting('ibp_whatsapp_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('ibp_whatsapp_position', array(
        'label'    => __('Posição do Botão', 'ibp-woocommerce'),
        'section'  => 'ibp_whatsapp_section',
        'type'     => 'select',
        'choices'  => array(
            'left'  => __('Esquerda', 'ibp-woocommerce'),
            'right' => __('Direita', 'ibp-woocommerce'),
        ),
    ));
}
add_action('customize_register', 'ibp_whatsapp_customizer');

/**
 * Função para exibir o botão do WhatsApp
 */
function ibp_display_whatsapp_button() {
    $number = get_theme_mod('ibp_whatsapp_number', '');
    if (empty($number)) {
        return;
    }
    
    $message = urlencode(get_theme_mod('ibp_whatsapp_message', __('Olá! Gostaria de mais informações.', 'ibp-woocommerce')));
    $position = get_theme_mod('ibp_whatsapp_position', 'right');
    $enable_desktop = get_theme_mod('ibp_whatsapp_enable_desktop', true);
    $enable_mobile = get_theme_mod('ibp_whatsapp_enable_mobile', true);
    
    // Se ambos estiverem desabilitados, não exibe nada
    if (!$enable_desktop && !$enable_mobile) {
        return;
    }
    
    // Adiciona os estilos CSS
    $custom_css = "
        .whatsapp-button {
            position: fixed;
            bottom: 30px;
            " . ($position === 'right' ? 'right: 30px;' : 'left: 30px;') . "
            z-index: 99999;
            background-color: #25D366;
            color: #ffffff !important;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
            text-decoration: none;
            outline: none;
        }
        
        .whatsapp-button:hover,
        .whatsapp-button:focus {
            transform: scale(1.1) translateY(-5px);
            background-color: #20ba57;
            color: #ffffff !important;
            box-shadow: 0 6px 15px rgba(0,0,0,0.3);
            text-decoration: none;
        }
        
        .whatsapp-button:active {
            transform: scale(0.95);
        }
        
        .whatsapp-button i {
            font-size: 32px;
            color: #ffffff;
        }
        
        /* Desktop */
        @media (min-width: 769px) {
            .whatsapp-button {
                display: " . ($enable_desktop ? 'flex' : 'none') . ";
            }
        }
        
        /* Mobile */
        @media (max-width: 768px) {
            .whatsapp-button {
                display: " . ($enable_mobile ? 'flex' : 'none') . ";
                width: 50px;
                height: 50px;
                bottom: 20px;
                " . ($position === 'right' ? 'right: 20px;' : 'left: 20px;') . "
            }
            
            .whatsapp-button i {
                font-size: 26px;
            }
        }

        /* Animação de pulsar */
        @keyframes whatsapp-pulse {
            0% {
                transform: scale(1);
            }
            15% {
                transform: scale(1.25);
            }
            25% {
                transform: scale(1.15);
            }
            35% {
                transform: scale(1);
            }
            100% {
                transform: scale(1);
            }
        }

        .whatsapp-button {
            animation: whatsapp-pulse 2s infinite;
        }

        .whatsapp-button:hover {
            animation: none;
        }
    ";
    wp_add_inline_style('ibp-custom', $custom_css);
    
    // Exibe o botão
    $whatsapp_url = "https://wa.me/{$number}?text={$message}";
    echo '<a href="' . esc_url($whatsapp_url) . '" class="whatsapp-button" target="_blank" rel="noopener" aria-label="WhatsApp">';
    echo '<i class="fab fa-whatsapp"></i>';
    echo '</a>';
}
add_action('wp_footer', 'ibp_display_whatsapp_button');

function ibp_woocommerce_scripts() {
    // Enqueue WooCommerce specific styles
    wp_enqueue_style('ibp-woocommerce-styles', get_template_directory_uri() . '/assets/css/woocommerce.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'ibp_woocommerce_scripts');