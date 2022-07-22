<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="message padding-wrap pb-0-mob" data-set-full-height>
	<div class="container-sm">
		<div class="message__body">
			<h2 class="message__title text-center">Thank you for your purchase</h2>
			<div class="message__text text-center">
				<p>Your order number is <strong>#<?= $order->get_order_number();?></strong></p>
				<p>We send you order details on <?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ): ?>
					<a href="mailto:<?= $order->get_billing_email();?>"><?= $order->get_billing_email();?></a>
					</li>
				<?php endif; ?></p>
			</div>
			<div class="message__buttons">
				<a href="<?= get_permalink(wc_get_page_id( 'myaccount' ));?>" class="btn-default not-hover">Auftragsstatus verfolgen</a>
				<a href="<?= get_permalink(wc_get_page_id( 'shop' ));?>" class="btn-default btn-default--transparent not-hover">Continue Shopping</a>
			</div>
		</div>
	</div>
</div>
