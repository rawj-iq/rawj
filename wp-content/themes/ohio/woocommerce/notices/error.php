<?php
/**
 * Show error messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/error.php.
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
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! $messages ){
	return;
}

?>

<div class="woocommerce-notice-wrap">
	<div class="message-box error woo-message-box">
		<?php foreach ( $messages as $message ) : ?>
			<?php echo wp_kses( $message, 'basic_html' ); ?><br>
		<?php endforeach; ?>
		<div class="clb-close btn-round btn-round-small btn-round-light">
			<i class="ion ion-md-close"></i>
		</div>
	</div>
</div>
