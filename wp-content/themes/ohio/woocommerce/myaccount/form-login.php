<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
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
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="u-columns col2-set" id="customer_login">
	<div class="u-column1 col-1">

	<?php endif; ?>
		<div class="vc_row">
			<div class="vc_col-lg-12 woo-c_login">
				<div class="ohio-tabs-sc tab" data-ohio-tab-box="true">
					<div class="tabNav_wrapper">
						<ul class="tabNav <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'no' ){ echo single;}?>" role="tablist">
							<li class="tabNav_line brand-bg-color"></li>

							<li class="tabNav_link active second-title text-left font-titles">
								<?php esc_html_e( 'Sign in', 'ohio' ); ?>
							</li>
							<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) { ?>
								<li class="tabNav_link title text-left font-titles">
									<?php esc_html_e( 'Sign Up', 'ohio' ); ?>
								</li>
							<?php } ?>
						</ul>
					</div>

					<div class="tabItems" role="tabpanel">
						<div class="tabItems_item active" data-title="<?php esc_html_e( 'Sign In', 'ohio' ); ?>">
							<form method="post" class="login">
								<fieldset>
									<?php do_action( 'woocommerce_login_form_start' ); ?>
										<div class="woocommerce-FormRow woocommerce-FormRow--wide form-row">
											<label for="username" class="field-label"><?php esc_attr_e( 'Username or email address', 'ohio' ); ?></label>
											<input type="text" placeholder="<?php esc_attr_e( 'Username or email address', 'ohio' ); ?>"  name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
										</div>
										<div class="woocommerce-FormRow woocommerce-FormRow--wide form-row password-field">
											<label for="password" class="field-label"><?php esc_attr_e( 'Password', 'ohio' ); ?></label>
											<input placeholder="<?php esc_attr_e( 'Password', 'ohio' ); ?>" type="password" name="password" id="password" />
										</div>
									<?php do_action( 'woocommerce_login_form' ); ?>
									<div class="form-row form-row_btn">
										<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
										<div class="form-row_btn_remember_container">
											<label for="rememberme" class="inline">
												<input class="woocommerce-Input woocommerce-Input--checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e( 'Remember me', 'ohio' ); ?>
											</label>
											<a class="lost-link" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'ohio' ); ?></a>
										</div>

										<button type="submit" class="btn" name="login" value="<?php esc_attr_e( 'Sign In', 'ohio' ); ?>">
											<?php esc_attr_e( 'Sign In', 'ohio' ); ?> <i class="ion-right ion"><svg class="arrow-icon" width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 7H16M16 7L11 1M16 7L11 13" stroke-width="2"/></svg></i>
										</button>
									</div>
									<?php do_action( 'woocommerce_login_form_end' ); ?>
								</fieldset>
							</form>
						</div>

						<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
						<div class="tabItems_item" data-title="<?php esc_html_e( 'Registration', 'ohio' ); ?>">
							<form method="post" class="register">
								<fieldset>

									<?php do_action( 'woocommerce_register_form_start' ); ?>

									<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

									<div class="woocommerce-FormRow woocommerce-FormRow--wide form-row">
										<label for="username" class="field-label"><?php esc_attr_e( 'Username', 'ohio' ); ?></label>
										<input type="text" placeholder="<?php esc_attr_e( 'Username', 'ohio' ); ?>" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
									</div>

									<?php endif; ?>

									<div class="woocommerce-FormRow woocommerce-FormRow--wide form-row">
										<label for="reg_email" class="field-label"><?php esc_attr_e( 'Email address', 'ohio' ); ?></label>
										<input type="email" placeholder="<?php esc_attr_e( 'Email address', 'ohio' ); ?>" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
									</div>

									<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

									<div class="woocommerce-FormRow woocommerce-FormRow--wide form-row password-field">
										<label for="password" class="field-label"><?php esc_attr_e( 'Password', 'ohio' ); ?></label>
										<input type="password" placeholder="<?php esc_attr_e( 'Password', 'ohio' ); ?>" name="password" id="reg_password" />
									</div>

									<?php endif; ?>

									<!-- Spam Trap -->
									<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php esc_html_e( 'Anti-spam', 'ohio' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

									<?php do_action( 'register_form' ); ?>

									<div class="woocomerce-FormRow form-row">
										<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
										<button type="submit" class="btn" name="register" value="<?php esc_attr_e( 'Sign Up', 'ohio' ); ?>">
										<?php esc_attr_e( 'Sign Up', 'ohio' ); ?> <i class="ion-right ion"><svg class="arrow-icon" width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 7H16M16 7L11 1M16 7L11 13" stroke-width="2"/></svg></i>
										</button>
									</div>

									<?php do_action( 'woocommerce_register_form_end' ); ?>
								</fieldset>
							</form>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>