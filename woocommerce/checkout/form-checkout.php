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
            	<?php //do_action( 'woocommerce_before_checkout_form', $checkout );?>
                <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

                	<div class="shopping-cart__body">

                		<div class="shopping-cart__col-1">

                			<h2 class="checkout__title" data-da=".shopping-cart__col-2,991.98,first"><?php the_title();?></h2>
<?php /* ?>
                			<div class="checkout__head">
		                        <h4 class="checkout__head-title">Express Kasse</h4>
		                       <div class="checkout__head-buttons">
		                            <?php do_action( 'woocommerce_checkout_before_customer_details' );?>
		                            
		                            <script src="https://www.paypal.com/sdk/js?client-id=ASVkUYKOeBAAhMnsJ8nZYrbF2UNBZa2ljxe_V3Fif2G3_V317G9A8WbkVE4DNME--rq3QxQJRNN78utE&currency=EUR"></script>

		                            <div id="paypal-button-container"></div>
								    <script>
								      paypal.Buttons({
								      	 style: {
										    layout: 'horizontal',
										    color:  'gold',
										    shape:  'rect',
										    label:  'paypal'
										  },
								        createOrder: (data, actions) => {
								          return actions.order.create({
								            "amount": {
								            	"currency_code": "EUR",
								            	"value": "<?= WC()->cart->total;?>",
								            	"breakdown": {
								            		"item_total": {
								            			"currency_code": "EUR",
								            			"value": "<?= WC()->cart->total;?>"
								            		}
								            	}
								            },
								            "items": [
								            <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
								            	$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );?>
									            {
									            	"name": '<?= $_product->get_name();?>',
									            	"unit_amount": {
									            		"currency_code": "EUR",
									            		"value": "<?= $_product->regular_price;?>"
									            	},
									            	"quantity": "<?= $cart_item['quantity'];?>"
									            },
									        <?php }?>
								            ]
								          });
								        },
								        // Finalize the transaction after payer approval
								        onApprove: (data, actions) => {
								          return actions.order.capture().then(function(orderData) {
								            // Successful capture! For dev/demo purposes:
								            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
								            const transaction = orderData.purchase_units[0].payments.captures[0];
								            alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
								            // When ready to go live, remove the alert and show a success message within this page. For example:
								            // const element = document.getElementById('paypal-button-container');
								            // element.innerHTML = '<h3>Thank you for your payment!</h3>';
								            // Or go to another URL:  actions.redirect('thank_you.html');
								          });
								        }
								      }).render('#paypal-button-container');
								    </script>
		                        </div>
		                        <div class="checkout__head-bottom">
		                        	<span>or</span>
		                        </div>
		                    </div>
<?php */ ?>
		                    <?php if ( $checkout->get_checkout_fields() ) :
		                    	// do_action( 'woocommerce_checkout_before_customer_details' ); 

		                    	?>

		                    	<div class="checkout__steps steps-checkout">
	                            
	                            
	                             <div class="steps-checkout__step steps-checkout__step--open" data-step="0">
		                                <div class="steps-checkout__head">
		                                    <h4 class="steps-checkout__title" data-trigger-step><span>1.</span>Zahlungsmethode</h4>
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
		                                        	<?php if ( WC()->cart->needs_payment() ) : ?>
														<ul class="wc_payment_methods payment_methods methods steps-checkout__list">
															<?php $WC_Payment_Gateways = new WC_Payment_Gateways();
															$available_gateways = $WC_Payment_Gateways->get_available_payment_gateways();
															if ( ! empty( $available_gateways ) ) {
																foreach ( $available_gateways as $gateway ) {
																	wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
																}
															} else {
																echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Entschuldigung, es scheint, dass für Ihr Bundesland keine Zahlungsmethoden verfügbar sind. Bitte kontaktieren Sie uns, wenn Sie Hilfe benötigen oder alternative Vorkehrungen treffen möchten.', 'woocommerce' ) : esc_html__( 'Bitte geben Sie oben Ihre Daten ein, um die verfügbaren Zahlungsmethoden anzuzeigen.', 'woocommerce' ) ) . '</li>';
															}
															?>
														</ul>
													<?php endif; ?>
		                                    </div>
		                                        
		                                    <div class="steps-checkout__row">
		                                        <h4 class="steps-checkout__title-2">Rechnungsadresse</h4>

		                                        <div class="form">
		                                            <div class="form__items form__items--align-top">
		                                                    <div class="form__item">
		                                                        <div class="select-wrap">
		                                                        	<?php $countries_obj   = new WC_Countries();
		                                                        	$countries   = $countries_obj->get_allowed_countries();
		                                                        	$selected_country = WC()->customer->get_country( );
		                                                        	?>
		                                                            <select name="billing_country" class="_select">
		                                                                <?php foreach ($countries as $key => $country) {?>
		                                                                	<option <?php selected($selected_country, $key) ?> value="<?= $key ?>"><?= $country ?></option>
		                                                                <?php } ?>
		                                                            </select>
		                                                        </div>
		                                                    </div>
		                                                    <div class="form__item form__item--half">

		                                                        <input type="text" class="input" name="billing_first_name" placeholder="Ihr  Name" value="<?= WC()->checkout->get_value('billing_first_name');?>" autocomplete="given-name">
		                                                    </div>
		                                                    <div class="form__item form__item--half">
		                                                        <input type="text" class="input" name="billing_last_name" id="billing_last_name" placeholder="Full  Nachname" value="<?= WC()->checkout->get_value('billing_last_name');?>" autocomplete="given-name">
		                                                    </div>
		                                                    <div class="form__item">
		                                                      	<div class="select-wrap" id="bill-ajax">
		                                                            <?php $stb = WC()->customer->get_billing_state();
		                                                        	$country_codeb = WC()->customer->get_billing_country();
		                                                        	$states_arrayb = WC()->countries->get_states( $country_codeb );
		                                                        	if(!empty($states_arrayb)):?>
			                                                            <select name="billing_state" class="_select">
			                                                            	<?php foreach ($states_arrayb as $kodb => $stateb) {?>
			                                                                	<option <?php selected($stb, $kodb) ?> value="<?= $kod ?>"><?= $stateb ?></option>
			                                                                <?php } ?>
			                                                            </select>
			                                                        <?php endif;?>
		                                                        </div>
		                                                    </div>
		                                                    <div class="form__item">
		                                                        <input type="text" class="input" name="billing_address_1" id="billing_address_1" placeholder="Address" value="">
		                                                    </div>
		                                                    <div class="form__item form__item--half" data-mask="9{*}">
		                                                        <input type="text" class="input input--sm" name="billing_postcode" id="billing_postcode" placeholder="Zipcode" value="<?= WC()->checkout->get_value('billing_postcode');?>">
		                                                    </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                </div>
		                            </div>
	                            
	                            
	                            
	                            
		                            <div class="steps-checkout__step" data-step="1">
		                            	<div class="steps-checkout__head">
		                            		<h4 class="steps-checkout__title" data-trigger-step><span>2.</span>Kontaktinformationen</h4>
		                            		<?php if(!is_user_logged_in()):?>
			                            		<div class="steps-checkout__subtitle"> Sie haben bereits ein Konto? <a href="#entry" data-popup="open-popup">Einloggen</a>
			                            		</div>
			                            	<?php endif;?>
		                            		<ul class="steps-checkout__result-list">
		                                        <li>Martha Weber, tel. +38(099) 550-55-60, Berlin</li>
		                                    </ul>
		                                    <button class="steps-checkout__change">Change</button>
		                                </div>
		                                <div class="steps-checkout__collapse" data-collapse-step>
		                                        <div class="steps-checkout__row">
		                                            <div class="form">
		                                                <div class="form__items">
		                                                    <div class="form__item form__item--half">
		                                                        <input type="text" class="input" name="billing_first_name" id="billing_first_name" placeholder="Vollständiger Name" value="<?= WC()->checkout->get_value('billing_first_name');?>" autocomplete="given-name">
		                                                    </div>
		                                                    <div class="form__item form__item--half"
		                                                        data-mask="+9(999)-999-99-99">
		                                                        <input type="text" class="input" name="billing_phone" id="billing_phone" placeholder="Telefon" value="<?= WC()->checkout->get_value('billing_phone');?>">
		                                                    </div>
		                                                    <div class="form__item form__item--half">
		                                                        <input type="email" class="input" name="billing_email" id="billing_email" placeholder="Email" value="<?= WC()->checkout->get_value('billing_email');?>">
		                                                    </div>
		                                                    <div class="form__item form__item--half">
		                                                        <input type="text" class="input" name="billing_city" id="billing_city" placeholder="Stadt" value="<?= WC()->checkout->get_value('billing_city');?>">
		                                                    </div>
		                                                </div>
		                                            </div>
		                                        </div>
		                                        <div class="steps-checkout__row">
		                                            <div class="checkout-social">
		                                                <div class="checkout-social__title">Registrieren mit</div>
		                                                <div class="checkout-social__buttons">
		                                                    <a href="<?= get_site_url();?>/wp-json/wslu-social-login/type/facebook" class="btn-default btn-default--transparent not-hover">Facebook</a>
		                                                    <a href="<?= get_site_url();?>/wp-json/wslu-social-login/type/google" class="btn-default btn-default--transparent not-hover">Google</a>

		                                                </div>
		                                            </div>
		                                        </div>
		                                </div>
		                            </div>

	                            
	                            
	                            
	                            
		                            <div class="steps-checkout__step" data-step="2">
		                                <div class="steps-checkout__head">
		                                    <h4 class="steps-checkout__title" data-trigger-step><span>3.</span>Lieferung</h4>
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
		                                            		<?php //do_action( 'woocommerce_review_order_before_cart_contents' );

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

		                                        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
		                                        	<div class="steps-checkout__row">
		                                            	<h4 class="steps-checkout__title-2">Versandart</h4>

		                                            	<?php wc_cart_totals_shipping_html();?>

		                                            </div>

		                                        <?php endif; ?>
		                                        
		                                        <div class="steps-checkout__row">
		                                            <h4 class="steps-checkout__title-2">Lieferanschrift</h4>
		                                            <div class="form">
		                                                <div class="form__items form__items--align-top">
		                                                   	<div class="form__item">
		                                                        <div class="select-wrap">
		                                                        	<?php $countries_obj = new WC_Countries();
		                                                        	$countries   = $countries_obj->get_allowed_countries();
		                                                        	$selected_country = WC()->customer->get_country();

		                                                        	?>
		                                                            <select name="shipping_country" class="_select">
		                                                                <?php foreach ($countries as $key => $country) {?>
		                                                                	<option <?php selected($selected_country, $key) ?> value="<?= $key ?>"><?= $country ?></option>
		                                                                <?php } ?>
		                                                            </select>
		                                                        </div>
		                                                    </div>
		                                                    <div class="form__item">
		                                                        <div class="select-wrap" id="ship-ajax">
		                                                        	<?php 
		                                                        	$st = WC()->customer->get_shipping_state();
		                                                        	$country_code = WC()->customer->get_shipping_country();
		                                                        	
		                                                        	$states_array = WC()->countries->get_states( $country_code );

		                                                        	if(!empty($states_array)):
		                                                        	?>
			                                                          	<select name="shipping_city" class="_select">
			                                                            	<?php foreach ($states_array as $kod => $state) {?>
			                                                                	<option <?php selected($st, $kod) ?> value="<?= $kod ?>"><?= $state ?></option>
			                                                                <?php } ?>
			                                                            </select>
			                                                        <?php endif;?>
		                                                        </div>
		                                                    </div> 
		                                                    <div class="form__item">
		                                                        <input type="text" class="input" name="shipping_state" id="shipping_state" placeholder="Ort / Stadt" value="">
		                                                    </div>
		                                                    <div class="form__item form__item--half" data-mask="9{*}">
		                                                        <input type="text" class="input input--sm" name="shipping_postcode" id="shipping_postcode" placeholder="Zipcode" value="<?= WC()->checkout->get_value('shipping_postcode');?>">
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
		                                                            <input type="checkbox" class="instal" name="billing_installation" value="<?php the_field('installation_cost', 'options');?>">
		                                                            <div class="checkbox-radio__square"></div>
		                                                            <div class="checkbox-radio__text"><?php the_field('installation_text', 'options');?> <strong><?php the_field('installation_cost', 'options');?>€</strong></div>
		                                                        </label>
		                                                    </div>
		                                                    <div class="form__item form__item--has-icon" data-datepicker>
		                                                        <img src="<?= get_template_directory_uri();?>/img/icons/date.svg" alt="">
		                                                        <input class="input" type="text" name="billing_installation_date" placeholder="Installationsdatum auswählen">
		                                                    </div>
		                                                </div>
		                                                <div class="form__warning-text">
		                                                    <?php the_field('installation_warning_text', 'options');?>
		                                                </div>
		                                            </div>

													<div class="steps-checkout__message">
														<p>Alle Hauptfelder sind ausgefüllt</p>
														<button type="button" class="steps-checkout__next-step btn-default">Gehen Sie zum nächsten Schritt</button>
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
						    $shipping = number_format(WC()->cart->shipping_total, 2, ',', ' ');
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

                                                <?php do_action( 'woocommerce_checkout_order_review' ); ?>

						        				
						        				<div class="payment-cart__agreed">
						                            <label class="checkbox-radio">
						                                <input type="checkbox">
						                                <div class="checkbox-radio__square"></div>
						                                <div class="checkbox-radio__text">Mit Ihrer Bestellung erklären Sie sich mit unseren <a href="https://dev1.kidsmont.de/agb/" target="_blank">Allgemeinen Geschäftsbedingungen</a>, <a href="https://dev1.kidsmont.de/widerrufsrecht/" target="_blank">Widerrufsbestimmungen</a> und <a href="https://dev1.kidsmont.de/datenschutzbelehrung/" target="_blank">Datenschutzbestimmungen</a> einverstanden.</div>
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