<?php
/**
 * Login Form
 *
 * @package IBP_WooCommerce_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_customer_login_form'); ?>

<div class="account-forms-container">
    <div class="account-tabs">
        <button class="tab-button active" data-tab="login"><?php esc_html_e('Login', 'ibp-woocommerce-theme'); ?></button>
        <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>
            <button class="tab-button" data-tab="register"><?php esc_html_e('Criar Conta', 'ibp-woocommerce-theme'); ?></button>
        <?php endif; ?>
    </div>

    <div class="tab-content">
        <div class="tab-pane active" id="login">
            <div class="login-form-container">
                <div class="form-header">
                    <h2><?php esc_html_e('Acessar Conta', 'ibp-woocommerce-theme'); ?></h2>
                    <p class="form-subtitle"><?php esc_html_e('Entre com suas credenciais para acessar sua conta.', 'ibp-woocommerce-theme'); ?></p>
                </div>

                <form class="woocommerce-form woocommerce-form-login login" method="post">
                    <div class="form-row-container">
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="username"><?php esc_html_e('Email ou usuário', 'ibp-woocommerce-theme'); ?>&nbsp;<span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" placeholder="<?php esc_attr_e('Digite seu email ou usuário', 'ibp-woocommerce-theme'); ?>" />
                        </p>

                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="password"><?php esc_html_e('Senha', 'ibp-woocommerce-theme'); ?>&nbsp;<span class="required">*</span></label>
                            <span class="password-input">
                                <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_attr_e('Digite sua senha', 'ibp-woocommerce-theme'); ?>" />
                    
                            </span>
                        </p>

                        <div class="login-actions">
                            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                                <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
                                <span><?php esc_html_e('Lembrar-me', 'ibp-woocommerce-theme'); ?></span>
                            </label>
                            <p class="lost_password">
                                <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Esqueceu sua senha?', 'ibp-woocommerce-theme'); ?></a>
                            </p>
                        </div>

                        <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                        <button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e('Entrar', 'ibp-woocommerce-theme'); ?>">
                            <i class="fas fa-sign-in-alt"></i> <?php esc_html_e('Entrar', 'ibp-woocommerce-theme'); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>
            <div class="tab-pane" id="register">
                <div class="register-form-container">
                    <div class="form-header">
                        <h2><?php esc_html_e('Criar Nova Conta', 'ibp-woocommerce-theme'); ?></h2>
                        <p class="form-subtitle"><?php esc_html_e('Preencha os dados abaixo para criar sua conta.', 'ibp-woocommerce-theme'); ?></p>
                    </div>

                    <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action('woocommerce_register_form_tag'); ?>>
                        <div class="form-row-container">
                            <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>
                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                    <label for="reg_username"><?php esc_html_e('Nome de usuário', 'ibp-woocommerce-theme'); ?>&nbsp;<span class="required">*</span></label>
                                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" placeholder="<?php esc_attr_e('Escolha um nome de usuário', 'ibp-woocommerce-theme'); ?>" />
                                </p>
                            <?php endif; ?>

                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                <label for="reg_email"><?php esc_html_e('Email', 'ibp-woocommerce-theme'); ?>&nbsp;<span class="required">*</span></label>
                                <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" placeholder="<?php esc_attr_e('Digite seu melhor email', 'ibp-woocommerce-theme'); ?>" />
                            </p>

                            <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>
                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                    <label for="reg_password"><?php esc_html_e('Senha', 'ibp-woocommerce-theme'); ?>&nbsp;<span class="required">*</span></label>
                                    <span class="password-input">
                                        <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" placeholder="<?php esc_attr_e('Crie uma senha forte', 'ibp-woocommerce-theme'); ?>" />
                                        <span class="show-password-input"></span>
                                    </span>
                                </p>
                            <?php endif; ?>

                            <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                            <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e('Criar Conta', 'ibp-woocommerce-theme'); ?>">
                                <i class="fas fa-user-plus"></i> <?php esc_html_e('Criar Conta', 'ibp-woocommerce-theme'); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabPanes = document.querySelectorAll('.tab-pane');

    // Função para alternar as abas
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));
            
            this.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Função para mostrar/ocultar senha
    const togglePasswordButtons = document.querySelectorAll('.show-password-input');
    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.closest('.password-input').querySelector('input');
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.classList.toggle('display-password');
        });
    });
});
</script>

<?php do_action('woocommerce_after_customer_login_form'); ?> 