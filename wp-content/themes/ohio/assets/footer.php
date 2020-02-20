<?php
	$header_menu_style = StockieSettings::header_menu_style();
?>
		</div><!-- #content -->
		<?php get_template_part( 'parts/elements/footer' ); ?>
	</div><!-- #page -->

	<?php if ( $header_menu_style == 'style6' ) : ?>
	</div><!--.content-right-->
	<?php endif; ?>

	<?php if ( StockieSettings::page_is_boxed() ) : ?>
	</div> <!-- .boxed-container -->
	<?php endif; ?>

	<div class="modal-window container-loading">
		<div class="close btn-round round-animation">
			<i class="ion ion-md-close"></i>
		</div>
		<div class="btn-loading-disabled"></div>
		<div class="modal-content container-loading">
			
		</div>
	</div>

	<?php
		StockieLayout::get_footer_buffer_content( true );
		wp_footer();
	?>

	<!-- Purchase button -->
	<a target="_blank" class="purchase-theme btn vc_hidden-xs" href="https://1.envato.market/0164P"><i class="icon"><img src="https://colabrio.ams3.cdn.digitaloceanspaces.com/stockie/st__envato.svg" alt="envato icon"></i> Buy Stockie <span></span> $39</a>

	<!-- Link custom fonts -->
	<style>@font-face{font-family:'proxima_nova';font-display:auto;src:url('https://colabrio.ams3.cdn.digitaloceanspaces.com/stockie/assets/fonts/proxima-nova/proximanova-bold-webfont.woff2') format('woff2'), url('https://colabrio.ams3.cdn.digitaloceanspaces.com/stockie/assets/fonts/proxima-nova/proximanova-bold-webfont.woff') format('woff');font-weight:bold;font-style:normal}@font-face{font-family:'proxima_nova';font-display:auto;src:url('https://colabrio.ams3.cdn.digitaloceanspaces.com/stockie/assets/fonts/proxima-nova/proximanova-medium-webfont.woff2') format('woff2'), url('https://colabrio.ams3.cdn.digitaloceanspaces.com/stockie/assets/fonts/proxima-nova/proximanova-medium-webfont.woff') format('woff');font-weight:500;font-style:normal}</style>

	<!--Promo banner-->
	<div class="promo-banner"><b>HUGE WINTER SALE!</b> <span class="vc_hidden-xs">Purchase Stockie Theme with a special price.</span><a href="https://1.envato.market/0164P" target="_blank">Save Now</a></div><style>html{margin-top:41px !important}@media screen and (max-width: 768px){html{margin-top:64px !important}}.promo-banner{padding:6px 0px;position:absolute;top:0px;left:0px;width:100%;font-size:15.6px;color:#fff;text-align:center;font-family:-apple-system,BlinkMacSystemFont,Roboto,"Segoe UI",Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";background:#0A0E6B;background:-webkit-linear-gradient(left, #0A0E6B, #0A0E6B);background:linear-gradient(to right, #0A0E6B, #0A0E6B);background-image:url(https://assets.banners.envato-static.com/header_banner/background_image/defa5ad6ee.gif);background-repeat:repeat-x}.promo-banner a{display:inline-block;padding:4px 15px;border-radius:3px;color:#fff;background:#17161A;font-weight:600;font-size:14px;margin-left:20px;vertical-align:middle}</style>
	</body>
</html>