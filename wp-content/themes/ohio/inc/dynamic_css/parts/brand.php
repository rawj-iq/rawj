<?php
/*
	Brand color
*/

$brand_color = OhioOptions::get_global( 'page_brand_color' );

if ( $brand_color ) {
    $_selector = [
        '.brand-color',
        '.brand-color-i',
        '.brand-color-hover-i:hover',
        '.brand-color-hover:hover',
        '.has-brand-color-color',
        '.is-style-outline .has-brand-color-color',
        'a:hover',
        '.blog-grid:hover h3 a',
        '.portfolio-item.grid-2:hover h4.title',
        '.fullscreen-nav li a:hover',
        '.socialbar.inline a:hover',
        '.gallery .expand .ion:hover',
        '.close .ion:hover',
        '.accordionItem_title:hover',
        '.tab .tabNav_link:hover',
        '.widget .socialbar a:hover',
        '.social-bar .socialbar a:hover',
        '.share-bar .links a:hover',
        '.widget_shopping_cart_content .buttons a.button:first-child:hover',
        'span.page-numbers.current',
        'a.page-numbers:hover',
        '.main-nav .nav-item.active-main-item > .menu-link',
        '.comment-content a',
        '.page-headline .subtitle b:before',
        'nav.pagination li .page-numbers.active',
        '#mega-menu-wrap > ul .sub-menu > li > a:hover',
        '#mega-menu-wrap > ul .sub-sub-menu > li > a:hover',
        '#mega-menu-wrap > ul > .current-menu-ancestor > a',
        '#mega-menu-wrap > ul .sub-menu:not(.sub-menu-wide) .current-menu-ancestor > a',
        '#mega-menu-wrap > ul .current-menu-item > a',
        '#fullscreen-mega-menu-wrap > ul .current-menu-ancestor > a',
        '#fullscreen-mega-menu-wrap > ul .current-menu-item > a',
        '.woocommerce .woo-my-nav li.is-active a',
        '.portfolio-sorting li a.active',
        '.team-member .socialbar a:hover',
        '.widget_nav_menu .current-menu-item > a',
        '.widget_pages .current-menu-item > a',
        '.portfolio-item-fullscreen .portfolio-details-date:before',
        '.btn.btn-link:hover',
        '.blog-grid-content .category-holder:after',
        '.clb-page-headline .post-meta-estimate:before',
        '.comments-area .comment-date-and-time:after',
        '.post .entry-content a:not(.wp-block-button__link)',
        '.project-page-content .date:before',
        '.pagination li .btn.active',
        '.pagination li .btn.current',
        '.pagination li .page-numbers.active',
        '.pagination li .page-numbers.current',
        '.category-holder:after'
    ];
    $_css = 'color:' . $brand_color . ';';
    OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );

    $_selector = [
        '.brand-border-color',
        '.brand-border-color-hover',
        '.has-brand-color-background-color',
        '.is-style-outline .has-brand-color-color',
        '.wp-block-button__link:hover',
        '.custom-cursor .circle-cursor--outer',
        '.btn-brand',
        '.btn-brand:active',
        '.btn-brand:focus',
        '.btn:hover',
        '.btn.btn-flat:hover',
        '.btn.btn-flat:focus',
        '.btn.btn-outline:hover'
    ];
    $_css = 'border-color:' . $brand_color . ';';
    OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );

    $_selector = [
        '.brand-bg-color',
        '.brand-bg-color-after',
        '.brand-bg-color-before',
        '.brand-bg-color-hover',
        '.brand-bg-color-i',
        '.brand-bg-color-hover-i',
        '.btn-brand:not(.btn-outline)',
        '.has-brand-color-background-color',
        'a.brand-bg-color',
        '.wp-block-button__link:hover',
        '.widget_price_filter .ui-slider-range',
        '.widget_price_filter .ui-slider-handle:after',
        '.main-nav .nav-item:before',
        '.main-nav .nav-item.current-menu-item:before',
        '.widget_calendar caption',
        '.tag:hover',
        '.page-headline .tags .tag',
        '.radio input:checked + .input:after',
        '.menu-list-details .tag',
        '.custom-cursor .circle-cursor--inner',
        '.custom-cursor .circle-cursor--inner.cursor-link-hover',
        '.btn-round:before',
        '.btn:hover',
        '.btn.btn-flat:hover',
        '.btn.btn-flat:focus',
        '.btn.btn-outline:hover',
        'nav.pagination li .btn.active:hover',
    ];
    $_css = 'background-color:' . $brand_color . ';';
    OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );
}