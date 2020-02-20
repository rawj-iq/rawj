<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $woocommerce_loop;

if ( ! $crosssells = WC()->cart->get_cross_sells() ) {
	return;
}

$products_in_row = OhioSettings::get( 'woocommerce_products_in_row', 'global' );
if ( is_string( $products_in_row ) ) {
	$products_in_row = json_decode( $products_in_row );
}

if( $products_in_row == NULL ){
	$products_in_row = (object) array(
		"large" => "3",
		"medium" => "2",
		"small" => "2"
	);
}

$product_now = 0;

$row_class = '';
if ( is_object( $products_in_row ) ) {
	$row_class = ' columns-' . $products_in_row->large;
	$row_class .= ' columns-md-' . $products_in_row->medium;
	$row_class .= ' columns-sm-' . $products_in_row->small;
}

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => apply_filters( 'woocommerce_cross_sells_total', $posts_per_page ),
	'orderby'             => $orderby,
	'post__in'            => $crosssells,
	'meta_query'          => WC()->query->get_meta_query()
);

$products                    = new WP_Query( $args );
$woocommerce_loop['name']    = 'cross-sells';
$woocommerce_loop['columns'] = apply_filters( 'woocommerce_cross_sells_columns', $columns );

if ( $products->have_posts() ) : ?>
	<section class="woo-c_cross_sells">
		<h4 class="heading-md"><?php esc_html_e( 'You may be interested in', 'ohio' ) ?></h4>
		<div class="<?php echo esc_attr( $row_class ); ?>">
			<?php woocommerce_product_loop_start(); ?>
				<?php while ( $products->have_posts() ) : $products->the_post(); ?>
					<?php wc_get_template_part( 'content', 'product' ); ?>
				<?php endwhile; // end of the loop. ?>
			<?php woocommerce_product_loop_end(); ?>
		</div>
	</section>
<?php endif;
wp_reset_query();