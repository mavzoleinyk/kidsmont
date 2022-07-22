<?php
/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

$formatted_destination    = isset( $formatted_destination ) ? $formatted_destination : WC()->countries->get_formatted_address( $package['destination'], ', ' );
$has_calculated_shipping  = ! empty( $has_calculated_shipping );
$show_shipping_calculator = ! empty( $show_shipping_calculator );
$calculator_text          = '';


if ( $available_methods ) :


 ?>
	<ul class="steps-checkout__list">



		<li>
			<ul>
		        <?php foreach ( $available_methods as $method ) :

		        ?>

					<li>
						<label class="checkbox-radio checkbox-radio--xs">

							<?php if ( 1 < count( $available_methods ) ) {
									printf( '<input type="radio" name="shipping_method[%1$d]" class="shipping_method" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" %4$s />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ) );
								} else {
									printf( '<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ) );
								}

						

							?>
						
							<div class="checkbox-radio__square"></div>
							<div class="checkbox-radio__text"><?= wc_cart_totals_shipping_method_label( $method );?></div>
							<?php do_action( 'woocommerce_after_shipping_rate', $method, $index );?>
						</label>
					</li>

				<?php endforeach; ?>
		    </ul>
		</li>
	</ul>

<?php endif;?>

