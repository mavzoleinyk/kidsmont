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


        <div class="product-detail padding-wrap pt-0">
            <div class="container-sm">
                <div class="product-detail__body">
                    <div class="product-detail__col-1">
                        <div class="product-detail__gallery">
                            <div class="gallery-product-detail swiper" data-gallery-product-detail data-mobile="false">
							    <div class="gallery-product-detail__label-group">
							        <div class="gallery-product-detail__label card-label">hit</div>
							    </div>
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
                        <div class="product-detail__info product-detail-info">
                            <div class="product-detail-info__row">
                                <div class="product-detail-info__text text-content">
                                    <?= $product->description;?>
                                </div>
                            </div>
                            <?php if($faq):?>
                                <div class="product-detail-info__row">
                                    <h3 class="product-detail-info__title"><?php the_field('title_faq');?></h3>
                                    <ul class="accordion" data-spoller>
                                        <?php foreach( $faq as $post): setup_postdata($post); ?>
                                            <li>
                                                <div class="accordion__title" data-spoller-trigger>
                                                    <?php the_title(); ?>
                                                    <div class="accordion__icon">
                                                        <img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-top-right.svg" alt="">
                                                    </div>
                                                </div>
                                                <div class="accordion__collapse text-content">
                                                    <?php the_content();?>
                                                </div>
                                            </li>

                                        <?php endforeach; 

                                        wp_reset_postdata(); ?>

                                    </ul>
                                </div>
                            <?php endif;?>

                            <?php if($instruction):?>
                                <div class="product-detail-info__row">
                                    <h3 class="product-detail-info__title"><?php the_field('title_instruction');?></h3>

                                    <div class="video-wrap">
                                        <a href="<?= $instruction['url'];?>" data-fancybox class="video not-hover">
                                            <?php if($pi):?>
                                                <div class="video__poster ibg">
                                                    <img src="<?= $pi['url'];?>" alt="<?= $pi['alt'];?>">
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
                            <?php endif;?>

                            <div class="product-detail-info__row">
                                <?php if(get_field('title_choose_up')):?>
                                    <h3 class="product-detail-info__title"><?php the_field('title_choose_up');?></h3>
                                <?php endif;?>
                                <?php if($vpc):?>
                                    <div class="video-wrap">
                                        <a href="<?= $vpc['url'];?>" data-fancybox class="video not-hover">
                                            <?php if($pc):?>
                                                <div class="video__poster ibg">
                                                    <img src="<?= $pc['url'];?>" alt="<?= $pc['alt'];?>">
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
                                <?php endif;

                                if( have_rows('choose_us') ):?>

                                    <div class="bg-secondary">
                                        <ul class="text-col-3 text-content">

                                            <?php while ( have_rows('choose_us') ) : the_row();?>

                                                <li>
                                                    <h5 class="text-uppercase"><?php the_sub_field('title');?></h5>
                                                    <p><?php the_sub_field('description');?></p>
                                                </li>

                                            <?php endwhile;?>

                                        </ul>
                                    </div>

                                <?php endif;?>       
                            </div>

                            <?php if($reviews):?>
                                <div class="product-detail-info__row">
                                    <div class="reviews reviews--has-list">
                                        <div class="reviews__head d-flex align-items-center justify-content-between">
                                            <h3 class="reviews__title"><?php the_field('title_reviews');?></h3>
                                            <a href="<?= get_permalink(149)?>#addreview" class="btn-with-arrow not-hover">
                                                Leave review
                                                <span>
                                                    <img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-right.svg" alt="">
                                                </span>
                                            </a>
                                        </div>
                                        <ul class="reviews__list">
                                            <?php foreach( $reviews as $post): setup_postdata($post); ?>

                                                <li>
                                                    <div class="reviews__list-text text-content">
                                                        <?php the_field('text_reviews');?>
                                                    </div>
                                                    <div class="reviews__list-meta">
                                                        <div class="reviews__list-author"><?php the_title(); ?></div>
                                                        <div class="reviews__list-date"><?= meks_time_ago()?></div>
                                                    </div>
                                                </li>
        
                                            <?php endforeach; 

                                            wp_reset_postdata(); ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif;?>

                            <?php if(!empty($cross)):

                                $cr = new WP_Query([
                                    'post_type' => 'product',
                                    'posts_per_page' => -1,
                                    'post__in' => $cross,
                                ]);?>

                                <div class="product-detail-info__row">
                                    <div class="carousel carousel--fixed-width carousel-preview-products"
                                        data-carousel="fixed-width">
                                        <div class="carousel__head head d-flex align-items-center justify-content-between">
                                            <h3 class="head__title mb-0">Buy together</h3>
                                            <div class="slider-buttons">
                                                <div class="slider-button slider-button--prev hover" data-action="btn-prev">
                                                    <img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-left.svg" alt="">
                                                </div>
                                                <div class="slider-button slider-button--next hover" data-action="btn-next">
                                                    <img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-right.svg" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="carousel__slider swiper">
                                            <div class="swiper-wrapper">

                                                <?php while($cr->have_posts()): $cr->the_post();?>
                                                    
                                                    <div class="swiper-slide">

                                                        <?php wc_get_template_part( 'content', 'product' );?>

                                                    </div>

                                                <?php endwhile;

                                                wp_reset_postdata();?>
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endif;?>
                        </div>
                    </div>

                    <div class="product-detail__col-2">
                        <div class="product-detail__main-info product-detail-main-info"
                            data-da=".product-detail__col-1,991.98,1" data-scroll data-scroll-sticky
                            data-scroll-target=".product-detail__col-2">
                            <h3 class="product-detail-main-info__title">
                                <?php the_title();?>
                            </h3>
                            <div class="product-detail-main-info__text text-content">
                                <p>
                                    <?= $product->short_description;?>
                                </p>
                            </div>
                            <table class="product-detail-main-info__table">
                                <?php if (isset($variations_attr['pa_color'])) { ?>
                                    <tr>
                                        <td>
                                            <div class="product-detail-main-info__table-label">
                                                Color
                                            </div>
                                        </td>
                                        <td>
                                            <div class="product-detail-main-info__color">
                                                <ul class="color-picker">

                                                    <?php foreach ($variations as  $variation) {
                                                        $colors[] = $variation['attributes']['attribute_pa_color'];
                                                    }

                                                    $colors = array_unique($colors);

                                                    if ($colors){
                                                        foreach ($colors as  $variation) {
                                                            $color = get_term_by('slug', $variation , 'pa_color');

                                                            $c = get_field('color', 'pa_color_'.$color->term_id);?>
                                                            <li>
                                                                <a data-color="<?= $color->slug ?>" class="color-picker__item <?= $default_attributes['pa_color'] == $color->slug ? 'color-picker__item--active' : '' ?>"
                                                                    style="background-color: <?= $c;?>" href="#"></a>
                                                            </li>

                                                        <?php }

                                                    }?>

                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php }

                                if ( isset($variations_attr['pa_size'])) {?>
                                    <tr>
                                        <td>
                                            <div class="product-detail-main-info__table-label">
                                                Size
                                            </div>
                                        </td>
                                        <td>
                                            <div class="product-detail-main-info__size options-list">
                                                <?php foreach ($variations as  $variation) {
                                                    $sizes[] = $variation['attributes']['attribute_pa_size'];
                                                }

                                                $sizes = array_unique($sizes);

                                                if ($sizes){
                                                    foreach ($sizes as $variation) {
                                                        $size = get_term_by('slug', $variation , 'pa_size');?>
                                                        <a data-size="<?= $size->slug ?>" class="option-size options-list__btn not-hover <?= $default_attributes['pa_size'] == $size->slug ? 'options-list__btn--active' : '' ?> "
                                                    href="#"><?= $size->name ?></a>

                                                    <?php }

                                                }?>

                                            </div>
                                        </td>
                                    </tr>

                                <?php }

                                if ( isset($variations_attr['pa_material'])) {?>
                                    <tr>
                                        <td>
                                            <div class="product-detail-main-info__table-label">
                                                Material
                                            </div>
                                        </td>
                                        <td>
                                            <div class="product-detail-main-info__material options-list">
                                                <?php foreach ($variations as  $variation) {
                                                    $materials[] = $variation['attributes']['attribute_pa_material'];
                                                }

                                                $materials = array_unique($materials);

                                                if ($materials){
                                                    foreach ($materials as $variation) {
                                                        $material = get_term_by('slug', $variation , 'pa_material');?>
                                                <a data-material="<?= $material->slug ?>" class="option-material options-list__btn <?= $default_attributes['pa_material'] == $material->slug ? 'options-list__btn--active' : '' ?>" href="#"><?= $material->name;?></a>
                                                <?php }

                                                }?>

                                            </div>
                                        </td>
                                    </tr>
                                <?php }?>
                                <tr>
                                    <td>
                                        <div class="product-detail-main-info__table-label">
                                            Price
                                        </div>
                                    </td>
                                    <td>
                                        <div class="product-detail-main-info__price">
                                            <?php woocommerce_template_single_price();?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <?php if( $product->is_type('variable')){
                                woocommerce_template_single_add_to_cart(); 
                            }?>
                            <div class="product-detail-main-info__buttons">
                                <a href="#" data-wish="<?= $product->get_id();?>" class="btn-default not-hover btn-default--transparent wishlist <?= in_array(get_the_ID(), $wish)?'un-wish':'add-wish';?>">Add to Wishlist</a>
                                <a href="#" data-product_id="<?= $product->get_id(); ?>" class="btn-default not-hover add-to-cart" 
                                    <?php if( $product->is_type('variable') && $variation_id){ echo 'data-variation_id="'.$variation_id.'"';}?>>Buy now</a>   
                            </div>
                            <?php if(get_field('delivery_product_text', 'options')):?>
                                <div class="product-detail-main-info__bottom text-content">
                                    <?php the_field('delivery_product_text', 'options');?>
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php do_action( 'woocommerce_after_single_product' ); ?>
