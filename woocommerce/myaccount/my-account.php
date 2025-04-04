<?php
/**
 * My Account page
 *
 * @package IBP_WooCommerce_Theme
 */

defined('ABSPATH') || exit;

/**
 * My Account navigation.
 */
 ?>

<div class="woocommerce-MyAccount-content">
    <?php if (is_user_logged_in()) : ?>
        <?php $logout = '<a class="highlight"href="'.wp_logout_url().'">Sair</a>'; ?>
        <p class="account-intro"><?php printf(esc_html__('Olá, %s (não é %s? %s)', 'ibp-woocommerce-theme'), wp_get_current_user()->display_name, wp_get_current_user()->display_name, $logout); ?></p>
    <?php endif; ?>

    <p class="account-intro">
        <?php 
        printf(
            esc_html__('A partir do %1$s de sua %2$s, você pode ver e acompanhar.', 'ibp-woocommerce-theme'),
            '<span class="highlight">painel de controle</span>',
            '<span class="highlight">conta</span>'
        );
        ?>
    </p>

    <div class="account-cards-container">
        <!-- Card 1: Acompanhar compras -->
        <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>" class="account-card">
            <div class="card-icon">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <h3><?php esc_html_e('Acompanhar compras recentes', 'ibp-woocommerce-theme'); ?></h3>
        </a>

        <!-- Card 2: Gerenciar endereços -->
        <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-address')); ?>" class="account-card">
            <div class="card-icon">
                <i class="fa-solid fa-truck fa-flip-horizontal"></i>
            </div>
            <h3><?php 
            printf(
                esc_html__('Gerenciar seus endereços de entrega%se cobrança', 'ibp-woocommerce-theme'),
                '<br>'
            ); 
            ?></h3>
        </a>

        <!-- Card 3: Editar senha -->
        <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-account')); ?>" class="account-card">
            <div class="card-icon">
                <i class="fa-solid fa-unlock"></i>
            </div>
            <h3><?php 
            printf(
                esc_html__('Editar sua senha e detalhes%sda conta.', 'ibp-woocommerce-theme'),
                '<br>'
            ); 
            ?></h3>
        </a>

        <!-- Card 4: Downloads -->
        <a href="<?php echo esc_url(wc_get_account_endpoint_url('downloads')); ?>" class="account-card">
            <div class="card-icon">
                <i class="fa-solid fa-download"></i>
            </div>
            <h3><?php esc_html_e('Downloads', 'ibp-woocommerce-theme'); ?></h3>
        </a>

        <!-- Card 5: Pagamentos -->
        <a href="<?php echo esc_url(wc_get_account_endpoint_url('payment-methods')); ?>" class="account-card">
            <div class="card-icon">
                <i class="fa-solid fa-credit-card"></i>
            </div>
            <h3><?php esc_html_e('Métodos de Pagamento', 'ibp-woocommerce-theme'); ?></h3>
        </a>
    </div>

</div>

<style>
.woocommerce-MyAccount-content {
    padding: 2rem;
    background: #f9f9f9;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.account-intro {
    margin-bottom: 2rem;
    font-size: 1.1rem;
    color: #555;
    text-align: center;
}

.highlight {
    font-weight: bold;
    color: #4A154B;
    position: relative;
    display: inline-block;
    text-decoration: none;
}

.highlight::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, #4A154B, #8c1d53);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.highlight:hover::after {
    transform: scaleX(1);
}

.account-cards-container {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 1rem;
    margin: 2rem 0;
    padding: 1rem;
}

.account-card {
    background: #fff;
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    display: block;
    color: inherit;
    border: 2px solid transparent;
    position: relative;
    overflow: hidden;
    border: 1px solid #4A154B;
}

.account-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, #4A154B, #8c1d53);
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 1;
}

.account-card:hover {
    transform: translateY(-5px);
    text-decoration: none;
    color: inherit;
    border-color: #4A154B;
    box-shadow: 0 8px 16px rgba(74, 21, 75, 0.1);
}

.account-card:hover::before {
    opacity: 0.03;
}

.card-icon {
    margin-bottom: 1rem;
    color: #4A154B;
    font-size: 3rem;
    position: relative;
    z-index: 2;
    transition: transform 0.3s ease;
}

.account-card:hover .card-icon {
    transform: scale(1.1);
}

.account-card h3 {
    margin: 0;
    font-size: 1.1rem;
    color: #4A154B;
    line-height: 1.4;
    position: relative;
    z-index: 2;
    transition: color 0.3s ease;
}

@media (max-width: 1200px) {
    .account-cards-container {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .account-cards-container {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        padding: 0.5rem;
    }

    .account-card {
        padding: 1rem;
    }

    .card-icon {
        font-size: 2rem;
    }

    .account-card h3 {
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .account-cards-container {
        grid-template-columns: 1fr;
    }
}
</style> 