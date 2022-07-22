<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

if($_COOKIE['wish']){

    $arr = explode(',',$_COOKIE['wish']);

    $wish = array_unique($arr);
            
}
if ($product->is_type( 'variable' )) {
    $variations = ($product->get_available_variations());
    $default_attributes = get_field('_default_attributes' );
    $variations_attr = ($product->get_variation_attributes());
    $variative = 'variative';
}



?>

<div class="product-card">
    	
    <?php woocommerce_show_product_loop_sale_flash();?>
        
    <a href="#" 
    data-wish="<?= $product->get_id();?>" 
    <?php if(isset($_COOKIE['wish'])):?>
        class="<?= in_array(get_the_ID(), $wish)?'un-wish product-card__like':'product-card__like add-wish';?>"<?php else:?> class="product-card__like add-wish"<?php endif;?>></a> 

    <a href="<?php the_permalink();?>" class="product-card__img-wrap">
        <div class="product-card__img">
            <?php woocommerce_template_loop_product_thumbnail();?>
        </div>
        <div class="product-card__center-icon">
            <img src="<?= get_template_directory_uri();?>/img/icons/bag-circle-green.svg" alt="">
        </div>
    </a>
    <a href="<?php the_permalink();?>" class="product-card__title"><?php the_title();?></a>
    <div class="product-card__bottom">
        <div class="product-card__price"><?php woocommerce_template_single_price() ?></div>
        <?php if (isset($variations_attr['pa_color'])) { ?>
            <ul class="color-picker">
                <?php foreach ($variations as  $variation) {
                    $colors[] = $variation['attributes']['attribute_pa_color'];
                }

                $colors = array_unique($colors);

                if ($colors)
                    foreach ($colors as  $variation) {
                        $color = get_term_by('slug', $variation , 'pa_color');
                        $c = get_field('color', 'pa_color_'.$color->term_id);
                        ?>
                        
                        <li title="<?= $color->name ?>" data-color="<?= $color->slug ?>" class="color-picker__item <?= $default_attributes['pa_color'] == $color->slug ? 'color-picker__item--active' : '' ?>"><a class="color-picker__item " style="background-color: <?= $c;?>;" href="#"></a></li>
                    <?php } ?>
               
            </ul>
        <?php } ?>
    </div>
</div>

