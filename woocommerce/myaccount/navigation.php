<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>


<div class="tabs__col-1">
    <div class="tabs__nav">
        <div class="tabs__nav-list swiper" data-tabs-nav data-mobile="false">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <a href="#" class="not-hover" data-tab-trigger="0">Meine Details</a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="not-hover" data-tab-trigger="1">Meine Bestellungen</a>
                </div>
            </div>
        </div>
        <button class="tabs__nav-btn" data-side-panel-open="account-tabs">Meine Details</button>
    </div>
</div>
