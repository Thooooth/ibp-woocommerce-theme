<form role="search" method="get" class="search-form custom-search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="screen-reader-text" for="s"><?php echo _x('Buscar por:', 'label', 'ibp-woocommerce'); ?></label>
    <div class="search-input-wrapper">
        <input type="search" id="s" class="search-field" placeholder="<?php echo esc_attr_x('Digite o que você procura...', 'placeholder', 'ibp-woocommerce'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
        <button type="submit" class="search-submit">
            <i class="fas fa-search"></i>
            <span class="screen-reader-text"><?php echo _x('Buscar', 'submit button', 'ibp-woocommerce'); ?></span>
        </button>
    </div>
    <?php
    // Se estiver na loja WooCommerce, adiciona o campo oculto para pesquisar apenas produtos
    if (class_exists('WooCommerce')) {
        echo '<input type="hidden" name="post_type" value="product" />';
    }
    ?>
</form> 