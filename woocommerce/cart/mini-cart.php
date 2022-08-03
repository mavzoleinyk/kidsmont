<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); 

$cs = WC()->cart->get_cart_contents_count();

if($cs==1){
	$cnum = $cs . ' produkt';
}else{
	$cnum = $cs . ' produkte';
}?>

	<div class="side-panel__body">
		<div class="side-panel__head">
		    <h3 class="selected-products__title">Gesamt</h3>
		    <?php if ( ! WC()->cart->is_empty() ) : ?>
			    <div class="selected-products__count cart_count2"><?=$cnum;?></div>
			<?php endif;?>
		    <div class="side-panel__close side-panel__close--circle" data-side-panel-close><span></span></div>
		</div>
	    <?php if ( ! WC()->cart->is_empty() ) : ?>
		        
		        <div class="side-panel__scroll-wrap">
		            <ul class="selected-products__list basket-cart__products-list">
		                <?php do_action( 'woocommerce_before_mini_cart_contents' );

		                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

		                	$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		                	$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

		                	if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
		                		$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
		                		$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
		                		$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
		                		$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );?>

		                		<li>
				                    <div class="order-card order-card--has-delete">
				                    	<?= apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="order-card__delete" aria-label="%s" data-product_id="%s" data-product_sku="%s"><span></span></a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_html__( 'Remove this item', 'woocommerce' ), esc_attr( $product_id ), esc_attr( $_product->get_sku() )),
	                                        	$cart_item_key); ?>
				                        <div class="order-card__img">
				                            <?php if ( ! $product_permalink ) {
	                                            echo $thumbnail;
	                                        } else {
	                                        	printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
	                                        }?>
				                        </div>
				                        <div class="order-card__inner">
				                            <div class="order-card__title">
	                                            <?php if ( ! $product_permalink ) {
	                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
	                                            } else {
	                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
	                                            }?>
	                                        </div>
				                            <div class="order-card__info-wrap align-items-center">
				                                <div class="order-card__col">
				                                    <div class="quantity">
				                                        <div class="quantity__button quantity__button--minus"></div>
				                                        <div class="quantity__input" data-key="<?= $cart_item_key ?>">

	                                                        <?php if ( $_product->is_sold_individually() ) { 
	                                                        	$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
	                                                        } else {
	                                                            $product_quantity = woocommerce_quantity_input(
	                                                                		array(
																				'input_name'   => "cart[{$cart_item_key}][qty]",
																				'input_value'  => $cart_item['quantity'],
																				'max_value'    => $_product->get_max_purchase_quantity(),
																				'min_value'    => '0',
																				'product_name' => $_product->get_name(),
																			), $_product, false );
	                                                        }

	                                                        echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );?>
	                                                    </div>
				                                        <div class="quantity__button quantity__button--plus"></div>
				                                    </div>
				                                </div>
				                                <div class="order-card__col">
				                                    <div class="order-card__price">
				                                    	<?php $pr = number_format($cart_item['data']->get_price(), 2, ',', ' ');?>
				                                    	<strong>
				                                    		<?= $pr . get_woocommerce_currency_symbol();?>
				                                    	</strong>
				                                    </div>
				                                </div>
				                            </div>
				                        </div>
				                    </div>
				                </li>

				            <?php }
				        }

						do_action( 'woocommerce_mini_cart_contents' );?>
		                
		            </ul>
		        </div>

		        <?php $taxes = number_format(WC()->cart->get_total_tax(), 2, ',', ' ');
		            $total = number_format(WC()->cart->total, 2, ',', ' ');?>

		        <div class="side-panel__bottom">
		            <div class="selected-products__bottom">
		                <div class="selected-products__bottom-row selected-products__bottom-row--1">
		                    <div class="selected-products__bottom-text">
		                        <div class="selected-products__bottom-label">Bezahlen</div>
		                        <p class="tax_tot">Including VAT <?= $taxes. get_woocommerce_currency_symbol();?></p>
		                    </div>
		                    <div class="selected-products__bottom-total tot">
		                        <?= $total.get_woocommerce_currency_symbol(); ?>
		                    </div>
		                </div>
		                <div class="selected-products__bottom-row selected-products__bottom-row--2">
		                    <a href="<?= esc_url( wc_get_cart_url() ); ?>" class="btn-default btn-default--transparent not-hover">Warenkorb ansehen</a>
		                    <a href="<?= esc_url( wc_get_checkout_url() ); ?>" class="btn-default not-hover">Zur kasse</a>
		                </div>
		            </div>
		        </div>
		<?php else : ?>
		    <p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></p>

		<?php endif; ?>
	</div>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
