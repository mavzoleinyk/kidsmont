<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;


//do_action( 'woocommerce_review_order_after_order_total' ); ?>

 <div class="shop_table woocommerce-checkout-review-order-table">

<ul class="payment-cart__list">
    <li>
        <p>Zwischensumme:</p>
        <p><strong class="subtot"><?php wc_cart_totals_subtotal_html(); ?></strong></p>
    </li>
    <li>
        <p>Versand </p>
        <p><strong class="shipp"> <?= WC()->cart->get_cart_shipping_total() ?></strong></p>
    </li>

    <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
        <li class="fee">
            <p><?php echo esc_html( $fee->name ); ?></p>
            <p><strong><?php wc_cart_totals_fee_html( $fee ); ?></strong></p>
        </li>
    <?php endforeach; ?>


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
        <form class="woocommerce-form-coupon payment-cart__coupon-input" method="post">
                <input type="text" name="coupon_code" class="input" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Gutscheincode', 'woocommerce' ); ?>" /><button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>">Gutschein anwenden</button>
            <?php do_action( 'woocommerce_cart_coupon' ); ?>
        </form>
    </div>

<?php } ?>

<div class="payment-cart__total">
    <div class="payment-cart__total-col-1">
        <p>Bezahlen</p>
        <p class="tax_tot">inkl. MwSt.  <?= wc_cart_totals_taxes_total_html() ?></p>
    </div>
    <div class="order-total payment-cart__total-col-2 tot"><?php wc_cart_totals_order_total_html(); ?></div>
</div>

 </div> 

