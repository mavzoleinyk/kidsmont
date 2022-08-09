<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>

    <main class="_page checkout-page" data-padding-top-header-size>
        <div class="checkout shopping-cart padding-wrap pt-0" data-checkout>
            <div class="container-sm">
            	<?php do_action( 'woocommerce_before_checkout_form', $checkout );?>
                <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

                	<div class="shopping-cart__body">

                		<div class="shopping-cart__col-1">

                			<h2 class="checkout__title" data-da=".shopping-cart__col-2,991.98,first">Kasse</h2>

                			<div class="checkout__head">
		                        <h4 class="checkout__head-title">Express Kasse</h4>
		                       <div class="checkout__head-buttons">
		                            <a href="#" class="btn-default g-pay">
		                                <img src="<?= get_template_directory_uri();?>/img/icons/google-pay.svg" alt="">
		                            </a>
		                            <a href="#" class="btn-default pay-pal">
		                            	<img src="<?= get_template_directory_uri();?>/img/icons/pay-pal.svg" alt="">
		                            </a>
		                        </div>
		                        <div class="checkout__head-bottom">
		                        	<span>or</span>
		                        </div>
		                    </div>

		                    <?php if ( $checkout->get_checkout_fields() ) :
		                    	do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		                    	<div class="checkout__steps steps-checkout">
		                            <div class="steps-checkout__step steps-checkout__step--open" data-step="0">
		                            	<div class="steps-checkout__head">
		                            		<h4 class="steps-checkout__title" data-trigger-step><span>1.</span>Kontaktinformationen</h4>
		                            		<div class="steps-checkout__subtitle"> Sie haben bereits ein Konto? <a href="#entry" data-popup="open-popup">Einloggen</a>
		                            		</div>
		                            		<ul class="steps-checkout__result-list">
		                                        <li>Martha Weber, tel. +38(099) 550-55-60, Berlin</li>
		                                    </ul>
		                                    <button class="steps-checkout__change">Veränderung</button>
		                                </div>
		                                <div class="steps-checkout__collapse" data-collapse-step>
		                                    <div class="steps-checkout__row">
		                                            <div class="form">
		                                                <div class="form__items">
		                                                    <div class="form__item form__item--half">
		                                                        <input type="text" class="input" name="billing_first_name" id="billing_first_name" placeholder="Vollständiger Name" value="<?= $_POST['billing_first_name']; ?>" autocomplete="given-name">
		                                                    </div>
		                                                    <div class="form__item form__item--half"
		                                                        data-mask="+9(999)-999-99-99">
		                                                        <input type="text" class="input" name="billing_phone" id="billing_phone" placeholder="Telefon" value="<?= $_POST['billing_phone'];?>">
		                                                    </div>
		                                                    <div class="form__item form__item--half">
		                                                        <input type="email" class="input" name="billing_email" id="billing_email" placeholder="Email" value="<?= $_POST['billing_email'];?>">
		                                                    </div>
		                                                    <div class="form__item form__item--half">
		                                                        <input type="text" class="input" name="billing_city" id="billing_city" placeholder="Stadt" value="<?= $_POST['billing_city'];?>">
		                                                    </div>
		                                                </div>
		                                            </div>
		                                    </div>
		                                    <div class="steps-checkout__row">
		                                            <div class="checkout-social">
		                                                <div class="checkout-social__title">Registrieren mit</div>
		                                                <div class="checkout-social__buttons">
		                                                    <a href="#" class="btn-default btn-default--transparent not-hover">
		                                                        Facebook
		                                                    </a>
		                                                    <a href="#" class="btn-default btn-default--transparent not-hover">
		                                                        Google
		                                                    </a>
		                                                </div>
		                                            </div>
		                                    </div>
		                                </div>
		                            </div>
		                            <div class="steps-checkout__step" data-step="1">
		                                    <div class="steps-checkout__head">
		                                        <h4 class="steps-checkout__title" data-trigger-step><span>2.</span>Lieferung</h4>
		                                        <ul class="steps-checkout__result-list">
		                                            <li>DPD EXPRESS: <strong>15,52€</strong></li>
		                                            <li>Schillerstrasse 56</li>
		                                            <li>Stadt:  Egling</li>
		                                            <li>Staat/Provinz/Gebiet:   Freistaat Bayern</li>
		                                        </ul>
		                                        <button class="steps-checkout__change">
		                                            Veränderung
		                                        </button>
		                                    </div>
		                                    <div class="steps-checkout__collapse" data-collapse-step>
		                                        <div class="steps-checkout__row">
		                                            <div class="checkout-order">
														<table class="checkout-order__table order-table">

															<tr>
																<th><h4 class="steps-checkout__title-2">Bestellübersicht</h4></th>
																<th>Menge:</th>
																<th>Preis:</th>
																<th>Summe:</th>
															</tr>
		                                            		<?php do_action( 'woocommerce_review_order_before_cart_contents' );

															foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
																$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

																if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
																	?>
																	
				                                                    <tr>
				                                                        <td>
				                                                            <div class="d-flex">
				                                                                <div class="order-table__img">
				                                                                    <?php $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

										                                                if ( ! $product_permalink ) {
										                                                	echo $thumbnail;
										                                                } else {

										                                                	printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
										                                                }?>
				                                                                </div>
				                                                                <div class="order-table__title">
				                                                                    <?php if ( ! $product_permalink ) {
								                                                		echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
								                                                	} else {
								                                                		echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
								                                                	}

								                                                	do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );?>
				                                                                </div>
				                                                            </div>
				                                                        </td>
				                                                        <td><?= $cart_item['quantity'];?></td>
				                                                        <td><?= apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );?></td>
				                                                        <td><strong><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );?></strong></td>
				                                                    </tr>
																	<?php
																}
															}

															do_action( 'woocommerce_review_order_after_cart_contents' );
															?>
		                                                
		                                                </table>
		                                                <h4 class="checkout-order__title-mob steps-checkout__title-2">Bestellübersicht</h4>
		                                                <ul class="checkout-order__mob-list">
		                                                	<?php do_action( 'woocommerce_review_order_before_cart_contents' );

															foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
																$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

																if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
																	?>

																	<li>
				                                                        <div class="order-card">
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
				                                                                <div class="order-card__info-wrap">
				                                                                    <div class="order-card__col">
				                                                                        <div>Menge:</div>
				                                                                        <div><strong><?= $cart_item['quantity'];?></strong></div>
				                                                                    </div>
				                                                                    <div class="order-card__col">
				                                                                        <div>Die Zustellung:</div>
				                                                                        <div><strong><?= apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );?></strong></div>
				                                                                    </div>
				                                                                    <div class="order-card__col">
				                                                                        <div>Summe:</div>
				                                                                        <div><strong><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );?></strong></div>
				                                                                    </div>
				                                                                </div>
				                                                            </div>
				                                                        </div>
				                                                    </li>
																	
																	<?php
																}
															}

															do_action( 'woocommerce_review_order_after_cart_contents' );
															?>
		                                                    
		                                                </ul>
		                                            </div>
		                                        </div>
		                                        <div class="steps-checkout__row">
		                                            <h4 class="steps-checkout__title-2">Versandart</h4>
		                                            <!-- <ul class="steps-checkout__list">
		                                                <li>
		                                                    <label class="checkbox-radio checkbox-radio--radio checkbox-radio--xs">
		                                                        <input type="radio" name="delivery-method">
		                                                        <div class="checkbox-radio__square"></div>
		                                                        <div class="checkbox-radio__text">Abholung in unserem Laden</div>
		                                                    </label>
		                                                </li>
		                                                <li>
		                                                    <label class="checkbox-radio checkbox-radio--radio checkbox-radio--xs" data-collapse-trigger="1">
		                                                        <input type="radio" name="delivery-method" checked>
		                                                        <div class="checkbox-radio__square"></div>
		                                                        <div class="checkbox-radio__text">Kurierlieferung</div>
		                                                    </label>

		                                                    <ul data-collapse="1">
		                                                        <li>
		                                                            <label class="checkbox-radio checkbox-radio--xs">
		                                                                <input type="checkbox">
		                                                                <div class="checkbox-radio__square"></div>
		                                                                <div class="checkbox-radio__text">DPD CLASSIC: <strong>6,59€</strong></div>
		                                                            </label>
		                                                        </li>
		                                                        <li>
		                                                            <label class="checkbox-radio checkbox-radio--xs">
		                                                                <input type="checkbox" checked>
		                                                                <div class="checkbox-radio__square"></div>
		                                                                <div class="checkbox-radio__text">DPD EXPRESS: <strong>15,52€</strong></div>
		                                                            </label>
		                                                        </li>
		                                                    </ul>
		                                                </li>
		                                            </ul> -->

		                                            <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : 

		                                            	wc_cart_totals_shipping_html();


													endif; ?>
		                                        </div>
		                                        <div class="steps-checkout__row">
		                                            <h4 class="steps-checkout__title-2">Lieferanschrift</h4>
		                                            <div class="form">
		                                                <div class="form__items form__items--align-top">
		                                                    <div class="form__item">
		                                                        <div class="select-wrap">
		                                                        	<?php $countries_obj   = new WC_Countries();
		                                                        	$countries   = $countries_obj->get_allowed_countries();
		                                                        	$selected_country = WC()->customer->get_country( );
		                                                        	?>
		                                                            <select name="" class="_select">
		                                                                <?php foreach ($countries as $key => $country) {?>
		                                                                	<option <?php selected($selected_country, $key) ?> value="<?= $key ?>"><?= $country ?></option>
		                                                                <?php } ?>
		                                                            </select>
		                                                        </div>
		                                                    </div>
		                                                    <div class="form__item">
		                                                        <div class="select-wrap">
		                                                        	<?php $st = WC()->customer->get_billing_state();

		                                                        	$country_code = WC()->customer->get_shipping_country();
		                                                        	$states_array = WC()->countries->get_states( $country_code );?>
		                                                            <select name="" class="_select">
		                                                            	<?php foreach ($states_array as $kod => $state) {?>
		                                                                	<option <?php selected($st, $kod) ?> value="<?= $kod ?>"><?= $state ?></option>
		                                                                <?php } ?>
		                                                            </select>
		                                                        </div>
		                                                    </div>
		                                                    <div class="form__item">
		                                                        <input type="text" class="input" name="billing_state" id="billing_state" placeholder="Ort / Stadt" value="<?= $_POST['billing_state'];?>">
		                                                    </div>
		                                                    <div class="form__item form__item--half" data-mask="9{*}">
		                                                        <input type="text" class="input input--sm" name="billing_postcode" id="billing_postcode" placeholder="Zipcode" value="<?= $_POST['billing_postcode'];?>">
		                                                    </div>
		                                                </div>
		                                            </div>
		                                        </div>
		                                        <div class="steps-checkout__row">
		                                            <h4 class="steps-checkout__title-2">Installation</h4>
		                                            <div class="form">
		                                                <div class="form__items mb-4">
		                                                    <div class="form__item">
		                                                        <label class="checkbox-radio checkbox-radio--xs">
		                                                            <input type="checkbox" checked>
		                                                            <div class="checkbox-radio__square"></div>
		                                                            <div class="checkbox-radio__text">Installation beinhalten: <strong>59,52€</strong></div>
		                                                        </label>
		                                                    </div>
		                                                    <div class="form__item form__item--has-icon" data-datepicker>
		                                                        <img src="img/icons/date.svg" alt="">
		                                                        <input class="input" type="text" placeholder="Installationsdatum auswählen">
		                                                    </div>
		                                                </div>
		                                                <div class="form__warning-text">
		                                                    (Bitte beachten Sie, dass die Montage nur innerhalb Berlins und 20 km entfernt möglich ist! Die Kosten für Lieferung und Montage in Ihre Stadt können wir individuell berechnen)
		                                                </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                            </div>
		                            <div class="steps-checkout__step" data-step="2">
		                                    <div class="steps-checkout__head">
		                                        <h4 class="steps-checkout__title" data-trigger-step><span>3.</span>Zahlungsmethode</h4>
		                                        <ul class="steps-checkout__result-list">
		                                            <li>DPD EXPRESS: <strong>15,52€</strong></li>
		                                            <li>Schillerstrasse 56</li>
		                                            <li>Stadt:  Egling</li>
		                                            <li>Staat/Provinz/Gebiet:   Freistaat Bayern</li>
		                                        </ul>
		                                        <button class="steps-checkout__change">
		                                            Veränderung
		                                        </button>
		                                    </div>
		                                    <div class="steps-checkout__collapse" data-collapse-step>
		                                        <div class="steps-checkout__row">
		                                            <ul class="steps-checkout__list">
		                                                <li>
		                                                    <label class="checkbox-radio checkbox-radio--radio checkbox-radio--xs">
		                                                        <input type="radio" name="payment-method">
		                                                        <div class="checkbox-radio__square"></div>
		                                                        <div class="checkbox-radio__text">PayPal</div>
		                                                    </label>
		                                                </li>
		                                                <li>
		                                                    <label class="checkbox-radio checkbox-radio--radio checkbox-radio--xs">
		                                                        <input type="radio" name="payment-method">
		                                                        <div class="checkbox-radio__square"></div>
		                                                        <div class="checkbox-radio__text">Ratenkauf</div>
		                                                    </label>
		                                                </li>
		                                                <li>
		                                                    <label class="checkbox-radio checkbox-radio--radio checkbox-radio--xs">
		                                                        <input type="radio" name="payment-method">
		                                                        <div class="checkbox-radio__square"></div>
		                                                        <div class="checkbox-radio__text">Sofort Bezahlen</div>
		                                                    </label>
		                                                </li>
		                                                <li>
		                                                    <label class="checkbox-radio checkbox-radio--radio checkbox-radio--xs">
		                                                        <input type="radio" name="payment-method">
		                                                        <div class="checkbox-radio__square"></div>
		                                                        <div class="checkbox-radio__text">Rechnung</div>
		                                                    </label>
		                                                </li>
		                                                <li>
		                                                    <label class="checkbox-radio checkbox-radio--radio checkbox-radio--xs">
		                                                        <input type="radio" name="payment-method">
		                                                        <div class="checkbox-radio__square"></div>
		                                                        <div class="checkbox-radio__text">PayPal, Lastschrift, Kreditkarte</div>
		                                                    </label>
		                                                </li>
		                                                <li>
		                                                    <label class="checkbox-radio checkbox-radio--radio checkbox-radio--xs">
		                                                        <input type="radio" name="payment-method">
		                                                        <div class="checkbox-radio__square"></div>
		                                                        <div class="checkbox-radio__text">Kreditkarten (Stripe)</div>
		                                                    </label>
		                                                </li>
		                                                <li>
		                                                    <label class="checkbox-radio checkbox-radio--radio checkbox-radio--xs">
		                                                        <input type="radio" name="payment-method" checked>
		                                                        <div class="checkbox-radio__square"></div>
		                                                        <div class="checkbox-radio__text">Kreditkarten</div>
		                                                    </label>
		                                                </li>
		                                            </ul>
		                                        </div>
		                                        <div class="steps-checkout__row">
		                                            <h4 class="steps-checkout__title-2">Zahlung</h4>
		                                            <div class="steps-checkout__subtitle mb-5 ps-0">Alle Transaktionen sind sicher und verschlüsselt.</div>

		                                            <div class="payment-card">
		                                                <div class="form">
		                                                    <div class="form__items form__items--align-top">
		                                                        <div class="form__item form__item--has-icon-right" data-mask="9999-9999-9999-9999">
		                                                            <img src="img/icons/lock.svg" alt="">
		                                                            <input class="input" type="text" placeholder="Card number">
		                                                        </div>
		                                                        <div class="form__item">
		                                                            <input class="input" type="text" placeholder="Name on card">
		                                                        </div>
		                                                        <div class="form__item form__item--half" data-mask="99/99">
		                                                            <input class="input" type="text" placeholder="Expiration date (MM/YY)">
		                                                        </div>
		                                                        <div class="form__item form__item--half form__item--has-icon-right" data-mask="999">
		                                                            <img src="img/icons/question.svg" data-tooltip="Lorem ipsum dolor sit amet." alt="">
		                                                            <input class="input" type="text" placeholder="Secure Code">
		                                                        </div>
		                                                    </div>
		                                                </div>
		                                            </div>
		                                        </div>
		                                        <div class="steps-checkout__row">
		                                            <h4 class="steps-checkout__title-2">Rechnungsadresse</h4>

		                                            <div class="form">
		                                                <div class="form__items form__items--align-top">
		                                                    <div class="form__item">
		                                                        <div class="select-wrap">
		                                                            <select name="" class="_select">
		                                                                <option value="" selected>Land/Region</option>
		                                                                <option value="1">Lorem, ipsum dolor.</option>
		                                                                <option value="2">Lorem, ipsum dolor.</option>
		                                                            </select>
		                                                        </div>
		                                                    </div>
		                                                    <div class="form__item form__item--half">
		                                                        <input class="input" type="text" placeholder="Ihr Name">
		                                                    </div>
		                                                    <div class="form__item form__item--half">
		                                                        <input class="input" type="text" placeholder="Ihr Nachname">
		                                                    </div>
		                                                    <div class="form__item">
		                                                        <div class="select-wrap">
		                                                            <select name="" class="_select">
		                                                                <option value="" selected>Bundesland / Landkreis</option>
		                                                                <option value="1">Lorem, ipsum dolor.</option>
		                                                                <option value="2">Lorem, ipsum dolor.</option>
		                                                            </select>
		                                                        </div>
		                                                    </div>
		                                                    <div class="form__item">
		                                                        <input class="input" type="text" placeholder="Ort / Stadt">
		                                                    </div>
		                                                    <div class="form__item form__item--half" data-mask="9{*}">
		                                                        <input class="input input--sm" type="text" placeholder="Zipcode">
		                                                    </div>
		                                                </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                            </div>
		                        </div>
		                   

		                    <?php do_action( 'woocommerce_checkout_after_customer_details' );

		                	endif;?>
		                </div>

		                <?php $taxes = number_format(WC()->cart->get_total_tax(), 2, ',', ' ');
						    $sub = number_format(WC()->cart->subtotal, 2, ',', ' ');
						    $total = number_format(WC()->cart->total, 2, ',', ' ');
						?>

		                <div class="shopping-cart__col-2">
						        	<div class="payment-cart" data-cart>
						        		<div class="payment-cart__main-box">
						        			<div class="payment-cart__mob-head">
						        				<h5 class="payment-cart__mob-head-title" data-text="hide order summary">Bestellübersicht anzeigen</h5>
						        				<div class="payment-cart__mob-head-total-price subtot"><?= $sub. get_woocommerce_currency_symbol(); ?></div>
						        			</div>
						        			<div class="payment-cart__body">
						        				<h4 class="payment-cart__title">Einkaufszusammenfassung</h4>
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
							        							<span>Haben Sie einen Gutscheincode?</span>
							        						</div>
							        					</label>
							        					<div class="payment-cart__coupon-input">
							        						<input type="text" name="coupon_code" class="input" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Your code', 'woocommerce' ); ?>" /><button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"></button>
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
						        					<a href="<?= esc_url( wc_get_checkout_url() ); ?>" class="checkout-button wc-forward payment-cart__submit btn-default">Die Bestellung wird bestätigt</a>
						        				</div>
						        				<div class="payment-cart__agreed">
						                            <label class="checkbox-radio">
						                                <input type="checkbox">
						                                <div class="checkbox-radio__square"></div>
						                                <div class="checkbox-radio__text">Mit der Registrierung stimmen Sie der <a href="#">Nutzungsvereinbarung zu</a></div>
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
               
				</form>

				<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

            </div>
        </div>
    </main>