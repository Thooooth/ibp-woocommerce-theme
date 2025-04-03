/**
 * Main JavaScript file for IBP WooCommerce Theme
 */

(function($) {
    'use strict';

    // Document ready
    $(document).ready(function() {
        
        // Mobile menu toggle
        $('.menu-toggle').on('click', function() {
            const $nav = $(this).closest('.main-navigation');
            $nav.toggleClass('toggled');
            
            // Update ARIA attributes
            if ($nav.hasClass('toggled')) {
                $(this).attr('aria-expanded', 'true');
            } else {
                $(this).attr('aria-expanded', 'false');
            }
        });

        // Handle sub-menu toggles for mobile
        if (window.matchMedia('(max-width: 768px)').matches) {
            $('.menu-item-has-children > a').after('<button class="sub-menu-toggle"><i class="fas fa-chevron-down"></i></button>');
            
            $('.sub-menu-toggle').on('click', function(e) {
                e.preventDefault();
                $(this).toggleClass('active');
                $(this).siblings('.sub-menu').slideToggle(200);
            });
        }

        // Close menu when clicking outside
        $(document).on('click', function(event) {
            if (!$(event.target).closest('.main-navigation').length) {
                $('.main-navigation').removeClass('toggled');
                $('.menu-toggle').attr('aria-expanded', 'false');
            }
        });

        // Reinicializar o menu ao redimensionar a janela
        $(window).on('resize', function() {
            if (window.matchMedia('(min-width: 769px)').matches) {
                $('.main-navigation').removeClass('toggled');
                $('.menu-toggle').attr('aria-expanded', 'false');
                $('.sub-menu').removeAttr('style');
            }
        });

        // Add smooth scrolling to all links
        $('a[href*="#"]').not('[href="#"]').not('[href="#0"]').not('[href*="#tab-"]').click(function(event) {
            if (
                location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') &&
                location.hostname === this.hostname
            ) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 800);
                }
            }
        });

        // Back to top button
        $(window).scroll(function() {
            if ($(this).scrollTop() > 200) {
                $('.back-to-top').fadeIn();
            } else {
                $('.back-to-top').fadeOut();
            }
        });

        $('.back-to-top').click(function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop: 0}, 800);
            return false;
        });

        // Newsletter form submission
        $('.newsletter-form').submit(function(e) {
            e.preventDefault();
            
            // In a real implementation, this would send the data to the server
            // For demonstration, we'll just show an alert
            alert('Obrigado por se inscrever na nossa newsletter!');
            $(this).find('input[type="email"]').val('');
        });

        // Product image zoom effect (if not using WooCommerce's zoom)
        $('.product-image').hover(function() {
            $(this).addClass('zoom');
        }, function() {
            $(this).removeClass('zoom');
        });

        // Initialize any sliders or carousels if needed
        if ($.fn.slick) {
            $('.hero-slider').slick({
                dots: true,
                infinite: true,
                speed: 500,
                fade: true,
                cssEase: 'linear',
                autoplay: true,
                autoplaySpeed: 5000
            });
        }

        // Handle WooCommerce quantity buttons
        $(document).on('click', '.quantity .plus, .quantity .minus', function() {
            var $qty = $(this).closest('.quantity').find('.qty');
            var currentVal = parseFloat($qty.val());
            var max = parseFloat($qty.attr('max'));
            var min = parseFloat($qty.attr('min'));
            var step = parseFloat($qty.attr('step'));

            if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
            if (max === '' || max === 'NaN') max = '';
            if (min === '' || min === 'NaN') min = 0;
            if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;

            if ($(this).is('.plus')) {
                if (max && (max === currentVal || currentVal > max)) {
                    $qty.val(max);
                } else {
                    $qty.val(currentVal + step);
                }
            } else {
                if (min && (min === currentVal || currentVal < min)) {
                    $qty.val(min);
                } else if (currentVal > 0) {
                    $qty.val(currentVal - step);
                }
            }

            // Trigger change event
            $qty.trigger('change');
        });
    });

    // Verifica se os ícones do Font Awesome foram carregados corretamente
    document.addEventListener('DOMContentLoaded', function() {
        // Função para verificar se o Font Awesome está carregado
        function isFontAwesomeLoaded() {
            var span = document.createElement('span');
            span.className = 'fa';
            span.style.display = 'none';
            document.body.insertBefore(span, document.body.firstChild);
            var loaded = window.getComputedStyle(span).fontFamily === 'FontAwesome';
            document.body.removeChild(span);
            return loaded;
        }

        // Se o Font Awesome não estiver carregado, tenta carregar localmente
        if (!isFontAwesomeLoaded()) {
            var link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = '/wp-content/themes/ibp-woocommerce-theme/assets/css/fontawesome/all.min.css';
            link.type = 'text/css';
            document.head.appendChild(link);
        }
    });

})(jQuery); 