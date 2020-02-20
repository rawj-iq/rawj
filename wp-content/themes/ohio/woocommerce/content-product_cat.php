<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
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
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<li <?php wc_product_cat_class( '', $category ); ?>>
	<div class="wrap">
		<?php
		/**
		 * woocommerce_before_subcategory hook.
		 *
		 * @hooked woocommerce_template_loop_category_link_open - 10
		 */
		//do_action( 'woocommerce_before_subcategory', $category );

		/**
		 * woocommerce_before_subcategory_title hook.
		 *
		 * @hooked woocommerce_subcategory_thumbnail - 10
		 */
		//do_action( 'woocommerce_before_subcategory_title', $category );

		// Thumbnail
		$small_thumbnail_size	= apply_filters( 'subcategory_archive_thumbnail_size', 'shop_catalog' );
		$thumbnail_id			= get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );

		if ( $thumbnail_id ) {
			$image = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size  );
			if ( is_array( $image ) ) {
				$image = $image[0];
			}
		} else {
			$image = wc_placeholder_img_src();
		}

		if ( $image ) {
			$image = str_replace( ' ', '%20', $image );
			echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" />';
		}
		?>

		<?php if ( true ) : ?> <!-- second sytle -->

			<div class="info-wrap style-2"> <!-- .text-center .text-right -->
				<div class="center-aligned">
					<div class="wrap">
						<div class="description">
							<?php echo category_description( $category ); ?>
						</div>
						<h3 class="second-title">
							<a href="<?php echo esc_url( get_category_link ( $category ) ); ?>">
								<?php echo esc_attr( $category->name ); ?>
							</a>
						</h3><br>
						<?php do_action( 'woocommerce_after_subcategory_title', $category ); ?>
						<a href="<?php echo esc_url( get_category_link ( $category ) ); ?>" class="shop-now btn btn-outline<?php if ( true /* not dark */ ) { echo ' btn-white'; } ?>">
							<?php esc_html_e( 'Shop now', 'ohio' ); ?>
						</a>
					</div>
				</div>
			</div>

		<?php else : ?>

			<div class="info-wrap">
				<div class="wrap-bg">
					<div class="description">
						<?php echo category_description( $category ); ?>
					</div>
					<h3 class="second-title">
						<a href="<?php echo esc_url( get_category_link ( $category ) ); ?>">
							<?php echo esc_attr( $category->name ); ?>
						</a>
					</h3><br>
					<?php do_action( 'woocommerce_after_subcategory_title', $category ); ?>
					<a href="<?php echo esc_url( get_category_link( $category ) ); ?>" class="shop-now">
						<?php esc_html_e( 'Shop now', 'ohio' ); ?>
					</a>
					<span class="plus ion-ios-plus-empty"></span>
				</div>
			</div>

		<?php endif; ?>
	</div>
</li>
