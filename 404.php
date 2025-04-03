<?php
/**
 * Template para exibir páginas de erro 404 (Não Encontrado)
 *
 * @package IBP WooCommerce Theme
 */

get_header();
?>

<div class="error-404 not-found">
    <div class="container">
        <div class="error-content">
            <div class="error-text">
                <div class="error-header">
                    <h1 class="error-title">
                        <span class="error-number">4</span>
                        <span class="error-zero">
                            <svg viewBox="0 0 100 100" class="error-planet" role="img" aria-label="Zero animado">
                                <circle cx="50" cy="50" r="40" class="planet-circle"/>
                                <path class="planet-ring" d="M25,50 a25,10 0 1,0 50,0 a25,10 0 1,0 -50,0"/>
                            </svg>
                        </span>
                        <span class="error-number">4</span>
                    </h1>
                </div>

                <div class="error-message">
                    <h2><?php esc_html_e('Ops! Página não encontrada', 'ibp-woocommerce-theme'); ?></h2>
                    <p><?php esc_html_e('A página que você está procurando parece ter se perdido no espaço.', 'ibp-woocommerce-theme'); ?></p>
                </div>

                <div class="error-search">
                    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <input type="search" class="search-field" 
                               placeholder="<?php echo esc_attr_x('Buscar...', 'placeholder', 'ibp-woocommerce'); ?>" 
                               value="<?php echo get_search_query(); ?>" name="s" />
                        <button type="submit" class="search-submit">
                            <i class="fas fa-search"></i>
                        </button>
                        <?php if (class_exists('WooCommerce')) : ?>
                            <input type="hidden" name="post_type" value="product" />
                        <?php endif; ?>
                    </form>
                </div>

                <div class="error-actions">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-home">
                        <i class="fas fa-home" aria-hidden="true"></i>
                        <span><?php esc_html_e('Página Inicial', 'ibp-woocommerce-theme'); ?></span>
                    </a>
                    <?php if (class_exists('WooCommerce')) : ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-shop">
                            <i class="fas fa-shopping-bag" aria-hidden="true"></i>
                            <span><?php esc_html_e('Nossa Loja', 'ibp-woocommerce-theme'); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-404 {
    min-height: calc(100vh - 300px);
    display: flex;
    align-items: center;
    position: relative;
    padding: 60px 0;
    margin: 0;
}

.error-content {
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
}

.error-text {
    color: var(--text-color);
}

.error-header {
    margin-bottom: 2rem;
}

.error-title {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    margin: 0;
}

.error-number {
    font-size: 8rem;
    font-weight: var(--font-weight-700);
    line-height: 1;
    color: var(--primary-color);
    font-family: var(--font-family);
    background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
    -webkit-text-fill-color: transparent;
}

.error-zero {
    width: 120px;
    height: 120px;
    position: relative;
}

.error-planet {
    width: 100%;
    height: 100%;
}

.planet-circle {
    fill: var(--accent-color);
}

.planet-ring {
    fill: none;
    stroke: var(--accent-color);
    stroke-width: 4;
    opacity: 0.7;
    animation: rotateRing 10s linear infinite;
}

.error-message {
    margin-bottom: 3rem;
}

.error-message h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
    font-weight: var(--font-weight-600);
    color: var(--primary-color);
}

.error-message p {
    font-size: 1.2rem;
    opacity: 0.8;
    line-height: 1.6;
    color: var(--text-color);
}

.error-search {
    max-width: 500px;
    margin: 0 auto 3rem;
}

.error-search .search-form {
    display: flex;
    background: white;
    border-radius: 30px;
    padding: 0.5rem;
    border: 2px solid var(--primary-color);
}

.error-search .search-field {
    flex: 1;
    background: transparent;
    border: none;
    padding: 1rem 1.5rem;
    color: var(--text-color);
    font-size: 1rem;
    outline: none;
    font-family: var(--font-family);
}

.error-search .search-field::placeholder {
    color: rgba(0,0,0,0.4);
}

.error-search .search-submit {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.error-search .search-submit:hover {
    background: var(--dark-purple);
}

.error-actions {
    display: flex;
    justify-content: center;
    gap: 2rem;
}

.btn-home,
.btn-shop {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    padding: 1rem 2rem;
    border-radius: 30px;
    text-decoration: none;
    font-weight: var(--font-weight-600);
    transition: all 0.3s ease;
    font-family: var(--font-family);
}

.btn-home {
    background: var(--primary-color);
    color: white;
    border: 2px solid var(--primary-color);
}

.btn-shop {
    background: transparent;
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
}

.btn-home:hover,
.btn-shop:hover {
    transform: translateY(-2px);
    background: var(--dark-purple);
    color: white;
    border-color: var(--dark-purple);
}

@keyframes rotateRing {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@media (max-width: 768px) {
    .error-404 {
        padding: 30px 15px;
    }

    .error-message h2 {
        font-size: 1.5rem;
    }

    .error-message p {
        font-size: 1rem;
    }

    .error-actions {
        flex-direction: column;
        gap: 1rem;
    }

    .btn-home,
    .btn-shop {
        width: 100%;
        justify-content: center;
    }

    .error-search .search-form {
        flex-direction: column;
        gap: 1rem;
        padding: 1rem;
    }

    .error-search .search-submit {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .error-number {
        font-size: 4rem;
    }

    .error-zero {
        width: 60px;
        height: 60px;
    }
}
</style>

<?php
get_footer();
