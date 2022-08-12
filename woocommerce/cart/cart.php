<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

$cs = WC()->cart->get_cart_contents_count();

if($cs==1){
	$cnum = $cs . ' produkt';
}else{
	$cnum = $cs . ' produkte';
}

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<div class="shopping-cart__body">
		<div class="shopping-cart__col-1">
			<div class="shopping-cart__products">
				<div class="shopping-cart__products-head">
					<h4>Zwischensumme</h4>
					<p class="cart_count2"><?= $cnum;?></p>
				</div>
				<ul class="shopping-cart__products-list selected-products__list">
					<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );?>
                                    <li>
                                        <div class="order-card order-card--has-delete">
                                        	<?= apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="order-card__delete" aria-label="%s" data-product_id="%s" data-product_sku="%s"><span></span></a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_html__( 'Remove this item', 'woocommerce' ), esc_attr( $product_id ), esc_attr( $_product->get_sku() )),
                                        	$cart_item_key); ?>

                                            <div class="order-card__img">
                                                <?php $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                                                if ( ! $product_permalink ) {
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
                                                	}

                                                	do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );?>
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

                                                                echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
                                                                ?>
                                                            </div>
                                                            <div class="quantity__button quantity__button--plus"></div>
                                                        </div>


                                                    </div>
                                                    <div class="order-card__col">
                                                    	<div class="order-card__price"><strong><?= apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );?></strong></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                        <?php }
                    }
                    ?>

                </ul>
            </div>
        </div>

        <?php 

            $taxes = number_format(WC()->cart->get_total_tax(), 2, ',', ' ');
            $sub = number_format(WC()->cart->subtotal, 2, ',', ' ');
            $total = number_format(WC()->cart->total, 2, ',', ' ');

        ?>
        <div class="shopping-cart__col-2">
             <div class="shopping-cart__sticky-wrap">
                <div class="shopping-cart__sticky-inner" data-scroll data-scroll-sticky data-scroll-target=".shopping-cart__col-2" data-scroll-offset="-120, 120">
                	<div class="payment-cart" data-cart>
                		<div class="payment-cart__main-box">
                			<div class="payment-cart__mob-head">
                				<h5 class="payment-cart__mob-head-title" data-text="hide order summary">Bestellübersicht anzeigen</h5>
                				<div class="payment-cart__mob-head-total-price subtot"><?= $sub. get_woocommerce_currency_symbol(); ?></div>
                			</div>
                			<div class="payment-cart__body">
                				<h4 class="payment-cart__title">Gesamtsumme</h4>
                				<ul class="payment-cart__list">
                					<li>
                						<p>Zwischensumme:</p>
                						<p><strong class="subtot"><?= $sub. get_woocommerce_currency_symbol(); ?></strong></p>
                					</li>
                					<li>
                						<p>Versand </p>
                						<p><strong>Wird im nächsten Schritt berechnet</strong></p>
                					</li>
                				</ul>
                				<?php if ( wc_coupons_enabled() ) { ?>
                					<div class="payment-cart__coupon">
        	        					<label class="payment-cart__coupon-checkbox">
        	        						<input type="checkbox">
        	        						<div class="payment-cart__coupon-checkbox-text">
        	        							<img src="<?= get_template_directory_uri();?>/img/icons/coupon-icon.svg" alt="">
        	        							<span>Gutscheinecode</span>
        	        						</div>
        	        					</label>
        	        					<div class="payment-cart__coupon-input">
        	        						<input type="text" name="coupon_code" class="input not-label" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Gutscheincode', 'woocommerce' ); ?>" /><button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Gutschein anwenden', 'woocommerce' ); ?>">Gutschein anwenden</button>
        								<?php do_action( 'woocommerce_cart_coupon' ); ?>
        	        					</div>
        	        				</div>
        							 
        						<?php } ?>
                				
                				<div class="payment-cart__total">
                					<div class="payment-cart__total-col-1">
                						<p>Bezahlen</p>
                						<p class="tax_tot">inkl. MwSt. <?= $taxes. get_woocommerce_currency_symbol();?></p>
                					</div>
                					<div class="payment-cart__total-col-2 tot"><?= $total. get_woocommerce_currency_symbol(); ?></div>
                				</div>
                				<div data-da=".payment-cart,991.98,first">
                				
                				
                				<input type="button" class="checkout-button wc-forward payment-cart__submit btn-default" onclick="location.href='<?= esc_url( wc_get_checkout_url() ); ?>';" value="Die Bestellung wird bestätigt" />
                				
                				</div>
                				<div class="payment-cart__agreed">
                                    <label class="checkbox-radio">
                                        <input type="checkbox" id="checkb">
                                        <div class="checkbox-radio__square"></div>
                                        <div class="checkbox-radio__text">Mit Ihrer Bestellung erklären Sie sich mit unseren <a href="https://kidsmont.de/agb/" target="_blank">Allgemeinen Geschäftsbedingungen</a>, <a href="https://kidsmont.de/widerrufsrecht/" target="_blank">Widerrufsbestimmungen</a> und <a href="https://kidsmont.de/datenschutzbelehrung/" target="_blank">Datenschutzbestimmungen</a> einverstanden.</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                       
                        <div class="payment-cart__bottom">
                        	<p>Wir akzeptieren:</p>
                            <ul class="payment-cart__accept-list">
                                <li>
                                    <img src="<?= get_template_directory_uri();?>/img/icons/accept-icon-1.svg" alt="">
                                </li>
                                <li>
                                	<img src="<?= get_template_directory_uri();?>/img/icons/accept-icon-2.svg" alt="">
                                </li>
                                <li>
                                	<img src="<?= get_template_directory_uri();?>/img/icons/accept-icon-3.svg" alt="">
                                </li>
                                <li>
                                	<img src="<?= get_template_directory_uri();?>/img/icons/accept-icon-4.svg" alt="">
                                </li>
                                <li>
                                	<img src="<?= get_template_directory_uri();?>/img/icons/accept-icon-5.svg" alt="">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="shopping-cart__bottom-btn">
                    	<a href="<?= get_permalink( wc_get_page_id( 'shop' ) );?>" class="btn-default btn-default--transparent not-hover">Mit dem Einkaufen fortfahren</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
