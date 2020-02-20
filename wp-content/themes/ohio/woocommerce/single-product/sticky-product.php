<?php
    global $product;

    $available = OhioOptions::get( 'woocommerce_product_sticky', true );
?>
<?php if ($available): ?>
    <div class="sticky-product">
        <?php if ( has_post_thumbnail() ) {
            $url = wp_get_attachment_image_url( $product->get_image_id(), 'thumbnail' ) ?>
            <div class="sticky-product-img" style="background-image: url(<?php echo esc_url($url) ?>)"></div>
        <?php } else { ?>
            <div class="sticky-product-img" style="background-image: url(<?php echo wc_placeholder_img_src() ?>)"></div>
        <?php } ?>
        <div class="sticky-product-desc">
            <a href="<?php the_permalink() ?>" class="title"><span class="price"><?php echo get_woocommerce_currency_symbol() . $product->get_price() ?></span><span class="sticky-product-title"><?php the_title();?></span></a>
            <div class="category-holder">
                <?php
                $cats = get_the_terms( $post->ID, 'product_cat' );
                $cat_count = sizeof( $cats );
                if ($cat_count) {
                    $i = 0;
                    foreach ($cats as $cat) {
                        ?>
                        <a href="<?php echo get_term_link($cat->term_id) ?>" class="category"><?php echo esc_html($cat->name) ?></a>
                        <?php
                        $i++;
                    }
                }
                ?> 
            </div> 

            <?php if( $product->is_type( 'variable' ) ):?>
                <div class="variations_button sticky-product-btn">
                    <a href="#variation_form_anchor" class="variation_anchor_link btn btn-link alt sticky-product-cart btn-loading-disabled">
                        <?php echo esc_html('Add to Cart') ?>
                    </a>
                </div>
            <?php else: ?>
                <form class="cart woocommerce-add-to-cart" method="post" enctype='multipart/form-data'>
                    <?php if ( $product->is_in_stock() ) : ?>
                        <div class="simple-qty" style="display: none">
                            <?php if ( ! $product->is_sold_individually() ) {
                                woocommerce_quantity_input( array( 'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 ) );
                            } ?>
                        </div>
                        <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
                        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
                        <input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
                        <input type="hidden" name="variation_id" class="variation_id" value="0" />
                        <div class="variations_button sticky-product-btn">
                            <a class="single_add_to_cart_button btn btn-link alt sticky-product-cart btn btn-loading-disabled">
                                <?php echo esc_html('Add to Cart') ?>
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="sticky-product-btn">
                            <a class="btn btn-link alt sticky-product-out-of-stock">
                                <?php echo esc_html('Out of Stock') ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </form>
            <?php endif; ?>
        </div>
        <div class="close-bar">
            <div class="btn-round btn-round-small btn-round-light clb-close sticky-product-close" tabindex="0">
                <i class="ion ion-md-close"></i>
            </div>   
        </div>
    </div>
<?php endif; ?>
