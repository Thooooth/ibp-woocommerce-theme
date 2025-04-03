<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <header id="masthead" class="site-header">
        <div class="container">
            <div class="header-content">
                <div class="header-left">
                    <div class="search-box">
                        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                            <input type="search" class="search-field" placeholder="<?php echo esc_attr_x('Buscar...', 'placeholder', 'ibp-woocommerce'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                            <button type="submit" class="search-submit"><i class="fas fa-search"></i></button>
                            <?php
                            // Adiciona o campo oculto para pesquisar apenas produtos
                            if (class_exists('WooCommerce')) {
                                echo '<input type="hidden" name="post_type" value="product" />';
                            }
                            ?>
                        </form>
                    </div>
                </div>

                <div class="site-branding">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-logo"><?php the_custom_logo(); ?></div>
                    <?php else : ?>
                        <div class="site-identity">
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/ibp-editora-logo.png" alt="<?php bloginfo('name'); ?>" class="logo-img">
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="header-right">
                    <?php ibp_social_icons(); ?>
                </div>
            </div>
        </div>
    </header><!-- #masthead -->

    <nav id="site-navigation" class="main-navigation">
        <div class="container">
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <i class="fas fa-bars"></i>
                <?php esc_html_e('Menu', 'ibp-woocommerce'); ?>
            </button>
            
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'fallback_cb'    => false,
                )
            );
            ?>
        </div>
    </nav><!-- #site-navigation -->

    <div id="content" class="site-content">
        <div class="container"><?php // Abrir container, será fechado no footer ?> 