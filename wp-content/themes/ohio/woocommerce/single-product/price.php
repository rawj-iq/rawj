<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>
<p class="price">

<?php

$price='';

$args =array(
    'decimals' => wc_get_price_decimals()
);

if ( '' === $product->get_price() ) {
    $price = apply_filters( 'woocommerce_empty_price_html', '', $product );
} else {
    $is_sale_tag = OhioOptions::get( 'woocommerce_product_sale_tag', true );
    if ( ( $is_sale_tag ) && ( $product->is_on_sale() ) ) {
        if ( $product->is_type( 'variable' ) ) {
            $price = wc_format_sale_price( wc_get_price_to_display( $product, array( 'price' => $product->get_variation_regular_price( 'max') ) ), wc_get_price_to_display( $product, array( 'price' => $product->get_variation_sale_price( 'min') ) ) ) . $product->get_price_suffix();
        } else {
            $price = wc_format_sale_price( wc_get_price_to_display( $product, array( 'price' => $product->get_regular_price() ) ), wc_get_price_to_display( $product ) ) . $product->get_price_suffix();
        }
    } else {
        $price = '<ins>' .wc_price(wc_get_price_to_display( $product ) ).$product->get_price_suffix().'</ins>';
    }
}

vprintf('%s', $price);
?>


</p>
