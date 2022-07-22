<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}

$attachment_ids = $product->get_gallery_image_ids();
$cross = $product->get_cross_sell_ids();

$video = get_field('video');
$placeholder = get_field('placeholder');
$faq = get_field('faq');
$instruction = get_field('video_instruction');
$pi = get_field('placeholder_instruction');
$vpc = get_field('video_choose_up');
$pc = get_field('placeholder_choose_up');
$reviews = get_field('reviews');


if ($product->is_type( 'variable' )) {
    $variations = ($product->get_available_variations());
    $default_attributes = get_field('_default_attributes' );
    $variations_attr = ($product->get_variation_attributes());
    $variative = 'variative';
}


if( $product->is_type('variable') ){
    $default_attributes = $product->get_default_attributes();
    foreach($product->get_available_variations() as $variation_values ){
        foreach($variation_values['attributes'] as $key => $attribute_value ){
            $attribute_name = str_replace( 'attribute_', '', $key );
            $default_value = $product->get_variation_default_attribute($attribute_name);
            if( $default_value == $attribute_value ){
                $is_default_variation = true;
            } else {
                $is_default_variation = false;
                break;
            }
        }
        if( $is_default_variation ){
            $variation_id = $variation_values['variation_id'];
            break;
        }
    }
}

if($_COOKIE['wish']){

    $arr = explode(',',$_COOKIE['wish']);

    $wish = array_unique($arr);
            
}

?>
    
    <main class="_page " data-padding-top-header-size data-scroll-section>

        <div class="container-sm d-none d-lg-block">
            <?php if(function_exists('bcn_display')):?>
                <ul class="breadcrumbs">
                     <?php bcn_display();?>   
                </ul>
            <?php endif;?>
        </div>

        <div class="mobile-bottom-price">
            <div class="mobile-bottom-price__col-1">
                <div class="mobile-bottom-price__label">
                    Price
                </div>
                <div class="mobile-bottom-price__price">
                    <?php woocommerce_template_single_price();?>
                </div>
            </div>
            <div class="mobile-bottom-price__col-2">
                <a href="#" data-product_id="<?= $product->get_id(); ?>" class="btn-default add-to-cart" <?php if( $product->is_type('variable') && $variation_id){ echo 'data-variation_id="'.$variation_id.'"';}?>>Buy now</a>
            </div>
        </div>

        <div class="product-detail padding-wrap pt-0">
            <div class="container-sm">
                <div class="product-detail__body">
                    <div class="product-detail__col-1">
                        <div class="product-detail__mob-head"></div>
                        <div class="product-detail__gallery">
                            <div class="gallery-product-detail swiper" data-gallery-product-detail data-mobile="false">
                                <div class="gallery-product-detail__label-group">
                                    <div class="gallery-product-detail__label card-label">hit</div>
                                </div>
                                <a href="#" class="product-card__like"></a> 
                                <!-- use  product-card__like--active -->
                                <div class="swiper-wrapper">
                                    <?php if ( $product->get_image_id() ):?>

                                        <div class="swiper-slide">
                                            <div class="gallery-product-detail__item">
                                                <div class="gallery-product-detail__img">
                                                    <img src="<?php the_post_thumbnail_url();?>" alt="">
                                                </div>
                                            </div>
                                        </div>

                                    <?php endif;
                                    
                                    if ( $attachment_ids ):

                                        foreach ( $attachment_ids as $attachment_id ):?>

                                            <div class="swiper-slide">
                                                <div class="gallery-product-detail__item">
                                                    <div class="gallery-product-detail__img gallery-product-detail__img--cover ">
                                                        <img src="<?= wp_get_attachment_image_src( $attachment_id, 'large' )[0];?>" alt="">
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endforeach;

                                    endif;

                                    if ( $video ):?>
                                    
                                        <div class="swiper-slide">
                                            <div class="gallery-product-detail__item">
                                                <div class="gallery-product-detail__video">
                                                    <a href="<?= $video['url'];?>" data-fancybox class="video not-hover">
                                                        <?php if($placeholder):?>
                                                            <div class="video__poster ibg">
                                                                <img src="<?= $placeholder['url'];?>" alt="<?= $placeholder['alt'];?>">
                                                            </div>
                                                        <?php endif;?>
                                                        <div class="video__btn">
                                                            <div class="btn">
                                                                <div class="btn__text-decor">
                                                                    <img class="img-svg" src="<?= get_template_directory_uri();?>/img/photo/play-text.svg" alt="">
                                                                </div>
                                                                <div class="btn__text">Play</div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endif;?>
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="product-detail__col-2">
                        <div class="product-detail__main-info product-detail-main-info"
                            data-da=".product-detail__col-1,991.98,2" data-scroll data-scroll-sticky
                            data-scroll-target=".product-detail__col-2">
                            <h3 class="product-detail-main-info__title" data-da=".product-detail__mob-head,991.98,0">
                                Sprossenwand 5-in-1 aus Kiefer Naturholz
                            </h3>
                            <div class="product-detail-main-info__text text-content">
                                <p>
                                    Only from 20 to 23 December! Place your order before 14:00 and your parcel will be
                                    with you by 18:00 tomorrow. Find out more about the promotion here.
                                </p>
                            </div>
                            <table class="product-detail-main-info__table">
                                <tr>
                                    <td>
                                        <div class="product-detail-main-info__table-label">
                                            Color
                                        </div>
                                    </td>
                                    <td>
                                        <div class="product-detail-main-info__color">
                                            <ul class="color-picker">
                                                <li>
                                                    <a class="color-picker__item color-picker__item--active"
                                                        style="background-color: #E5C985;" href="#"></a>
                                                </li>
                                                <li>
                                                    <a class="color-picker__item" style="background-color: #8E4612;"
                                                        href="#"></a>
                                                </li>
                                                <li>
                                                    <a class="color-picker__item" style="background-color: #5A574F;"
                                                        href="#"></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>


                                </tr>
                                <tr>
                                    <td>
                                        <div class="product-detail-main-info__table-label">
                                            Size
                                        </div>
                                    </td>
                                    <td>
                                        <div class="product-detail-main-info__size options-list">
                                            <a class="options-list__btn options-list__btn--active not-hover"
                                                href="#">1.60 x
                                                2.20</a>
                                            <a class="options-list__btn not-hover" href="#">2.10 x 3.20</a>
                                            <a class="options-list__btn not-hover" href="#">3.10 x 3.20</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="product-detail-main-info__table-label">
                                            Material
                                        </div>
                                    </td>
                                    <td>
                                        <div class="product-detail-main-info__material options-list">
                                            <a class="options-list__btn options-list__btn--active" href="#">Wood</a>
                                            <a class="options-list__btn" href="#">Metal</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="product-detail-main-info__table-row-price">
                                    <td>
                                        <div class="product-detail-main-info__table-label">
                                            Price
                                        </div>
                                    </td>
                                    <td>
                                        <div class="product-detail-main-info__price"
                                            data-da=".product-detail__mob-head,991.98,1">
                                            501,00€ – 595,00€
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div class="product-detail-main-info__buttons">
                                <a href="#" class="btn-default not-hover btn-default--transparent">Add to Wishlist</a>
                                <a href="#" class="btn-default not-hover">Buy now</a>
                            </div>
                            <div class="product-detail-main-info__bottom text-content">
                                Delivery in Germany within 1-3 days. <a href="#">View delivery to other countries</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


<?php do_action( 'woocommerce_after_single_product' ); ?>
