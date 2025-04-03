            <?php ibp_newsletter_form(); ?>
        </div><!-- .container -->
        
    </div><!-- #content -->

    

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/ibp-editora-logo.png" alt="<?php bloginfo('name'); ?>">
                        </a>
                    <?php endif; ?>
                </div>

                <div class="footer-widgets">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <div class="footer-column">
                            <?php dynamic_sidebar('footer-1'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <div class="footer-column">
                            <?php dynamic_sidebar('footer-2'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="footer-info">
                    <address>
                        <?php echo esc_html__('Alameda Rio Negro, 500, 12º andar', 'ibp-woocommerce'); ?><br>
                        <?php echo esc_html__('Torre 2  |  Alphaville  |  Barueri  |  SP', 'ibp-woocommerce'); ?><br>
                        <?php echo esc_html__('Tel: +55 (11) 4040-1240', 'ibp-woocommerce'); ?><br>
                         <?php echo esc_html__('Email: contato@ibpeditora.com.br', 'ibp-woocommerce'); ?>
                    </address>
                </div>
            </div><!-- .footer-content -->

<!-- .footer-bottom -->
        </div><!-- .container -->
        
    </footer><!-- #colophon -->
    <div class="footer-bottom">
                <div class="copyright">
                    <?php
                    /* translators: %s: current year */
                    printf(esc_html__('© Copyright %s - IBP EDITORA', 'ibp-woocommerce'), date('Y'));
                    ?>
                </div>
            </div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html> 