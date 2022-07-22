<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$current_user = wp_get_current_user();
?>

<div class="tabs__col-2">
	<div class="tabs__content" data-tab-content="0">
		<div class="d-flex flex-column">
            <form class="woocommerce-EditAccountForm edit-account form" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >
            	<?php do_action( 'woocommerce_edit_account_form_start' ); ?><form action="" class="form">
            	<h5 class="form__title">Fülle das Formular aus</h5>
                <div class="form__items">
                    <div class="form__item form__item--half">
                    	<input type="text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $current_user->first_name ); ?>" placeholder="Serhii" class="input">
                    </div>
                    <div class="form__item form__item--half">
                    	<input type="text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $current_user->last_name ); ?>" placeholder="Ihr Nachname" class="input" >
                    </div>
                    <div class="form__item form__item--half">
                        <input type="email" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $current_user->user_email ); ?>" class="input" placeholder="E-mail">
                    </div>
                    <div class="form__item form__item--half">
                    	<input type="text" class="input" placeholder="Handy" name="phone" id="phone" autocomplete="phones" value="<?php echo esc_attr( $current_user->billing_phone ); ?>" />
                    </div>
                    <div class="form__item">
                        <input type="text" name="address" id="address" placeholder="Die Adresse" class="input" value="<?php echo esc_attr( $current_user->billing_address_1 ); ?>">
                    </div>
                </div>
                 <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
                 <input type="hidden" name="action" value="save_account_details" />
                <button type="submit" class="form__submit btn-default align-self-end" name="save_account_details">Speichern</button>
                <?php do_action( 'woocommerce_edit_account_form' );
                do_action( 'woocommerce_edit_account_form_end' );?>
            </form>
            <div class="account__bottom-link"></div>
        </div>
    </div>
    <div class="tabs__content" data-tab-content="1">
    	<?php $customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
    		'numberposts' => $order_count,
    		'meta_key'    => '_customer_user',
    		'meta_value'  => get_current_user_id(),
    		'post_type'   => wc_get_order_types( 'view-orders' ),
    		'post_status' => array_keys( wc_get_order_statuses() ),)));



    	if ( $customer_orders ) : ?>

    		<ul class="orders-list" data-order-list>

	    		<?php foreach ( $customer_orders as $customer_order ) :

	    			$order = wc_get_order( $customer_order );
	    			$item_count = $order->get_item_count();
                    $items = $order->get_items();
                    $ship = number_format($order->get_shipping_total(), 2, ',', ' ');
                    ?>

	    			<li class="orders-list__item">
	    				<div class="orders-list__main-info-row">
	    					<div class="orders-list__main-info-col">
	    						<div>№<?= $order->get_order_number();?></div>
	    						<div><strong><time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time></strong></div>
	    					</div>
	    					<div class="orders-list__main-info-col">
	    						<div>Status:</div>
	    						<div><strong><?= esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></strong></div>
	    					</div>
	    					<div class="orders-list__main-info-col">
	    						<div>Summe:</div>
	    						<div><strong><?= $order->get_formatted_order_total();?></strong></div>
	    					</div>
	    					<div class="orders-list__icon">
	    						<span></span>
	    					</div>
	    				</div>
	    				<div class="orders-list__detail-info-row">

                            <div class="order-detail-card">

                                <?php foreach ( $items as $item ) :
                                    $product_name = $item['name'];
                                    $product_id = $item['product_id'];
                                    $product_variation_id = $item['variation_id'];;

                                    ?>
    	    					
    	    						    <div class="order-detail-card__row-1">
    	    							<div class="order-card">
    	    								<div class="order-card__img">
    	    									<img src="<?= get_the_post_thumbnail_url($product_id);?>" alt="">
    	    								</div>
                                            <div class="order-card__inner">
                                                <div class="order-card__title"><?= $product_name;?>
                                                </div>
                                                <div class="order-card__info-wrap">
                                                    <div class="order-card__col">
                                                        <div>Menge:</div>
                                                        <div><strong><?= $item['quantity'];?></strong></div>
                                                    </div>
                                                    <div class="order-card__col">
                                                        <div>Die Zustellung:</div>
                                                        <div><strong><?= $ship . get_woocommerce_currency_symbol();?></strong></div>
                                                    </div>
                                                    <div class="order-card__col">
                                                        <div>Summe:</div>
                                                        <div><strong><?= number_format($item['total'], 2, ',', ' ').get_woocommerce_currency_symbol();?></strong></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                <?php endforeach;?>
                                <div class="order-detail-card__row-2">
                                    <div class="order-detail-card__col">
                                        Abholung bei der Post(<?= $order->shipping_address_1;?>, <?= $order->shipping_postcode;?> <?= $order->shipping_city;?>)
                                    </div>
                                    <div class="order-detail-card__col">
                                        <?= $order->get_billing_phone();?> 
                                    </div>
                                    <div class="order-detail-card__col">
                                        ТТН 223345454004
                                    </div>
                                </div>
                            </div>
                        </div>
            		</li>

            	<?php endforeach;?>

            </ul>

        <?php endif;?>
        
     <!--    <div class="pagination">
        	<ul class="page-numbers">
                <li><a class="prev page-numbers" href="http://dev1.kidsmont.de/our-blog/"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18" fill="none"
                                            class="img-svg replaced-svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M6.06848 14.7009L6.50892 15.1443L7.39579 14.2634L6.95534 13.82L2.66275 9.49829H18.5559H19.3059V7.99829H18.5559L2.7482 7.99829L6.65317 3.79293L7.07845 3.33494L6.16246 2.48438L5.73718 2.94237L1.0424 7.99829H1.03553V8.00569L0.662613 8.40729L0.254175 8.84715L0.677177 9.27302L6.06848 14.7009Z"
                                                fill="currentColor"></path>
                                        </svg></a></li>          
            </ul>
        </div> -->
    </div>
</div>
