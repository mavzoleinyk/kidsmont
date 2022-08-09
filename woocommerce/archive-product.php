<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( );

$title = get_field('seo_title', get_option( 'woocommerce_shop_page_id' ));
$title_tax = get_field('seo_title', 'product_cat_'.get_queried_object()->term_id);

$text = get_field('seo_text', get_option( 'woocommerce_shop_page_id' ));
$text_tax = get_field('seo_text', 'product_cat_'.get_queried_object()->term_id);

$image = get_field('seo_image', get_option( 'woocommerce_shop_page_id' ));
$image_tax = get_field('seo_image', 'product_cat_'.get_queried_object()->term_id);

$seo = get_field('seo', get_option( 'woocommerce_shop_page_id' ));
$seo_tax = get_field('seo', 'product_cat_'.get_queried_object()->term_id);

$prices = get_filtered_price();
$min_pr = $prices['min'];
$max_pr = $prices['max'];

if (get_queried_object()->taxonomy){
    $link = get_term_link(get_queried_object()->term_id);
}else{
    $link = get_permalink(get_option( 'woocommerce_shop_page_id' ));
}


$order = [
    'menu_order' => 'Top-Produkte',
    'popularity' => 'aufsteigend',
    'date' => 'absteigend',
    'price-desc' => 'neu eingetroffen',
    //'price' => 'Von günstig bis teuer',
];


$args['post_type'] = 'product';
$args['posts_per_page'] = 12;
$args['paged'] = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

$args['tax_query'] = [ 'relation' => 'AND'];

if($_GET['s']){
    $args['s'] = $_GET['s'];
}

if (get_queried_object()->taxonomy){
    $args['tax_query'][] = [
        'taxonomy' => 'product_cat',
        'field' => 'id',
        'terms' => get_queried_object()->term_id,
        'operator' => 'IN',
    ];
}

  if($_GET['color']){
    $args['tax_query'][] = [
        'taxonomy' => 'pa_farbe',
        'field' => 'id',
        'terms' => $_GET['color'],
        'operator' => 'IN',
    ];
}

  if($_GET['size']){
    $args['tax_query'][] = [
        'taxonomy' => 'pa_size',
        'field' => 'id',
        'terms' => $_GET['size'],
        'operator' => 'IN',
    ];
  }

  if($_GET['material']){
    $args['tax_query'][] = [
        'taxonomy' => 'pa_material',
        'field' => 'id',
        'terms' => $_GET['material'],
        'operator' => 'IN',
    ];
  }

  if($_GET['groesse']){
    $args['tax_query'][] = [
        'taxonomy' => 'pa_groesse',
        'field' => 'id',
        'terms' => $_GET['groesse'],
        'operator' => 'IN',
    ];
  }

  if($_GET['hoehe']){
    $args['tax_query'][] = [
        'taxonomy' => 'pa_hoehe',
        'field' => 'id',
        'terms' => $_GET['hoehe'],
        'operator' => 'IN',
    ];
  }

  if($_GET['model']){
    $args['tax_query'][] = [
        'taxonomy' => 'pa_model',
        'field' => 'id',
        'terms' => $_GET['model'],
        'operator' => 'IN',
    ];
  }


  if ($_GET['price']) {
    $args['meta_query'] = [ 'relation' => 'AND'];
    $a = $_GET['price'];

    $arr = explode(';', $a);

    $meta_query = [

        [
          'key' => '_price',
          'value' => array($arr[0], $arr[1]),
          'compare' => 'BETWEEN',
          'type' => 'NUMERIC'
        ]
      ];
    $args['meta_query'] = $meta_query  ;
  }



   if ($_GET['orderby']) {
        switch ($_GET['orderby']) :
            case 'menu_order' :

            break;
            case 'popularity' :
                $args['orderby'] = 'meta_value';
                $args['order'] = 'DESC';
                $args['meta_key'] = 'total_sales';             
            break;
            case 'date' :
                $args['orderby'] = 'date';
                $args['order'] = 'ASC';
            break;
            case 'price-desc' :
                $args['orderby'] = 'meta_value';
                $args['order'] = 'DESC';
                $args['meta_key'] = '_price';             
            break;
            case 'price' :
                $args['orderby'] = 'meta_value';
                $args['order'] = 'ASC';
                $args['meta_key'] = '_price';
            break;
        endswitch;
    }
woocommerce_output_all_notices();
?>
<main class="_page page-catalog" data-padding-top-header-size data-scroll-section>

        <div class="container-sm d-none d-lg-block">
            <?php if(function_exists('bcn_display')):?>
	    	    <ul class="breadcrumbs">
	    	         <?php bcn_display();?>   
	    	    </ul>
	        <?php endif;?>
        </div>

        <div class="container-sm">
            <div class="head pt-4 pt-lg-0">
                <h1 class="head__title"><?php woocommerce_page_title(); ?></h1>
            </div>
        </div>


        <div class="products padding-wrap pt-0">
            <div class="container-sm">
                <div class="products__body">
                    <div class="products__filter">
                        <div class="side-panel products-filter" data-side-panel="products-filter"
                            data-da="body,991.98,first">
                            <form action="<?= $link;?>" id="filter">
                                <input type="hidden" name="action" value="filter">
                                <input type="hidden" name="orderby" value="" id="sorting">
                                <div class="side-panel__close" data-side-panel-close><span></span></div>
                                <div class="side-panel__body">
                                    <div class="side-panel__head">
                                        <div class="products-filter__title">Produkte filtern</div>
                                    </div>
                                    <div class="side-panel__scroll-wrap">
                                        <div class="products-filter__body">
                                            <div class="products-filter__list" data-spoller>
                                                <?php $mats = get_terms('pa_material');

                                                if(!empty($mats) && taxonomy_exists('pa_material')):?>

                                                    <div class="products-filter__list-item">
                                                        <div class="products-filter__list-item-title active"
                                                            data-spoller-trigger>Material</div>
                                                        <div class="products-filter__list-item-body">

                                                            <?php foreach ($mats as $mat):?>
                                                                <div class="products-filter__item">
                                                                    <label class="checkbox-radio">
                                                                        <input type="checkbox" <?php checked(1, in_array($mat->term_id, $_GET['material'] ?? [])) ?> name="material[]" value="<?= $mat->term_id;?>">
                                                                        <div class="checkbox-radio__square"></div>
                                                                        <div class="checkbox-radio__text"><?= $mat->name;?></div>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach;?>
                                                        </div>
                                                    </div>

                                                <?php endif;
                                                
                                                $sizes = get_terms('pa_size');

                                                if(!empty($sizes) && taxonomy_exists('pa_size')):?>

                                                    <div class="products-filter__list-item">
                                                        <div class="products-filter__list-item-title active"
                                                            data-spoller-trigger>Size</div>
                                                        <div class="products-filter__list-item-body">

                                                            <?php foreach ($sizes as $size):?>
                                                                <div class="products-filter__item">
                                                                    <label class="checkbox-radio">
                                                                        <input type="checkbox" <?php checked(1, in_array($size->term_id, $_GET['size'] ?? [])) ?> name="size[]" value="<?= $size->term_id;?>">
                                                                        <div class="checkbox-radio__square"></div>
                                                                        <div class="checkbox-radio__text"><?= $size->name;?></div>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach;?>
                                                        </div>
                                                    </div>

                                                <?php endif;

                                                $groesses = get_terms('pa_groesse');

                                                if(!empty($groesses) && taxonomy_exists('pa_groesse')):?>

                                                    <div class="products-filter__list-item">
                                                        <div class="products-filter__list-item-title active"
                                                            data-spoller-trigger>Größe</div>
                                                        <div class="products-filter__list-item-body">

                                                            <?php foreach ($groesses as $groesse):?>
                                                                <div class="products-filter__item">
                                                                    <label class="checkbox-radio">
                                                                        <input type="checkbox" <?php checked(1, in_array($groesse->term_id, $_GET['groesse'] ?? [])) ?> name="groesse[]" value="<?= $groesse->term_id;?>">
                                                                        <div class="checkbox-radio__square"></div>
                                                                        <div class="checkbox-radio__text"><?= $groesse->name;?></div>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach;?>
                                                        </div>
                                                    </div>

                                                <?php endif;

                                                $models = get_terms('pa_model');

                                                if(!empty($models) && taxonomy_exists('pa_model')):?>

                                                    <div class="products-filter__list-item">
                                                        <div class="products-filter__list-item-title active"
                                                            data-spoller-trigger>Modell</div>
                                                        <div class="products-filter__list-item-body">

                                                            <?php foreach ($models as $model):?>
                                                                <div class="products-filter__item">
                                                                    <label class="checkbox-radio">
                                                                        <input type="checkbox" <?php checked(1, in_array($model->term_id, $_GET['model'] ?? [])) ?> name="model[]" value="<?= $model->term_id;?>">
                                                                        <div class="checkbox-radio__square"></div>
                                                                        <div class="checkbox-radio__text"><?= $model->name;?></div>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach;?>
                                                        </div>
                                                    </div>

                                                <?php endif;

                                                $hoehes = get_terms('pa_hoehe');

                                                if(!empty($hoehes) && taxonomy_exists('pa_hoehe')):?>

                                                    <div class="products-filter__list-item">
                                                        <div class="products-filter__list-item-title active"
                                                            data-spoller-trigger>Höhe</div>
                                                        <div class="products-filter__list-item-body">

                                                            <?php foreach ($hoehes as $hoehe):?>
                                                                <div class="products-filter__item">
                                                                    <label class="checkbox-radio">
                                                                        <input type="checkbox" <?php checked(1, in_array($hoehe->term_id, $_GET['hoehe'] ?? [])) ?> name="hoehe[]" value="<?= $hoehe->term_id;?>">
                                                                        <div class="checkbox-radio__square"></div>
                                                                        <div class="checkbox-radio__text"><?= $hoehe->name;?></div>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach;?>
                                                        </div>
                                                    </div>

                                                <?php endif;?>



                                                <div class="products-filter__list-item">
                                                    <div class="products-filter__list-item-title active"
                                                        data-spoller-trigger>Preis</div>
                                                    <div class="products-filter__list-item-body">
                                                        <div class="products-filter__item">
                                                            <div class="price-range" data-price-range value="<?= $_GET['price'] ?>" data-min="<?= $min_pr ?>" data-max="<?= $max_pr ?>" data-start="<?= $min_pr ?>" data-end="<?= $max_pr ?>" data-step="1">
                                                                <input type="hidden" name="price" id="priceRange">
															    <div class="price-range__slider"></div>
															    <div class="price-range__values" data-mask="9{*}">
															        <input type="text" class="price-range__input price-range__input--start">
															        <span></span>
															        <input type="text" class="price-range__input price-range__input--end">
															    </div>
															</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <?php $colors = get_terms('pa_farbe');

                                                if(!empty($colors) && taxonomy_exists('pa_farbe')):?>

                                                    <div class="products-filter__list-item">
                                                        <div class="products-filter__list-item-title active"
                                                            data-spoller-trigger>Farbe</div>
                                                        <div class="products-filter__list-item-body">

                                                            <?php foreach ($colors as $color):?>
                                                                <div class="products-filter__item">
                                                                    <label class="checkbox-radio">
                                                                        <input type="checkbox" <?php checked(1, in_array($color->term_id, $_GET['color'] ?? [])) ?> name="color[]" value="<?= $color->term_id;?>">
                                                                        <div class="checkbox-radio__square"></div>
                                                                        <div class="checkbox-radio__text"><?= $color->name;?></div>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach;?>
                                                        </div>
                                                    </div>

                                                <?php endif;?>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="side-panel__bottom">
                                        <div class="products-filter__bottom">
                                            <button type="reset" onclick="location.href='<?= $link;?>'" data-button-reset
                                                class="products-filter__rest btn-default btn-default--transparent">Klar
                                                (<span>4</span>)</button>
                                            <button type="submit"
                                                class="products-filter__submit btn-default">Sich bewerben</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="products__content">
                        <div class="products__top">

                        	<?php woocommerce_result_count();?>
                            
                            <div class="products__sort">
                                <label for="sort">Sortieren:</label>
                                <div class="select-wrap">
                                    <select id="sort" name="sort" class="_select" data-select="price">
                                        <?php foreach ($order as $key => $value):?>
                                            <option value="<?= $key;?>"><?= $value;?></option>
                                    <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="products__mobile">
                                <button class="products__mobile-btn" data-side-panel-open="products-filter">
                                    <img src="<?= get_template_directory_uri();?>/img/icons/filter.svg" alt="">
                                    Filter
                                </button>
                                <button class="products__mobile-btn" data-side-panel-open="products-sort">
                                    <img src="<?= get_template_directory_uri();?>/img/icons/sort.svg" alt="">
                                    Sortieren nach
                                </button>
                            </div>

                        </div>
                        <div class="content">
                            <ul class="products__list">

                            	<?php 

                                $wp_query = new WP_Query($args);

                                if($wp_query->have_posts()){

                                    while ( $wp_query->have_posts() ) {
                                        $wp_query->the_post();

                                        echo '<li>';

                                        wc_get_template_part( 'content', 'product' );

                                        echo '</li>';

                                    }
                                }else {

                                    do_action( 'woocommerce_no_products_found' );

                                } ?>

                            </ul>
                            <div class="products__bottom">
                                
                            	<?php woocommerce_pagination();?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if( !empty( $_COOKIE[ 'woocommerce_recently_viewed_2' ] ) ):

            $viewed_products = (array) explode( '|', $_COOKIE[ 'woocommerce_recently_viewed_2' ] );?>

            <div class="carousel  carousel-preview-products padding-wrap" data-carousel="">
                <div class="container-sm">
                    <div class="carousel__head head d-flex align-items-center justify-content-between">
                        <h3 class="head__title mb-0">Produkte angesehen</h3>
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

                            <?php $view = new WP_Query([
                                'post_type' => 'product',
                                'posts_per_page' => 8,
                                'post__in' => $viewed_products,
                            ]);

                            while($view->have_posts()): $view->the_post();?>
                            
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

        <div class="padding-wrap pb-0" data-last-section>
            <div class="text-tabel" data-text-table>
                <div class="container-sm">
                    <div class="main-table">
                        <div class="text-tabel__preview">
                            <div class="main-table__tr">
                                <div class="main-table__td">
                                    <h3 class="main-table__title">
                                        <?= $title_tax?$title_tax:$title;?>
                                    </h3>
                                    <?php if($image_tax):?>
                                        <img src="<?= $image_tax['url'];?>" alt="<?= $image_tax['alt'];?>">
                                    <?php else:?>
                                        <img src="<?= $image['url'];?>" alt="<?= $image['alt'];?>">
                                    <?php endif;?>
                                </div>
                                <div class="main-table__td text-content">
                                    <?= $text_tax?$text_tax:$text;?>
                                </div>
                            </div>
                        </div>
                        <?php if($seo_tax):?>
                            <div class="text-tabel__collapse">
                                <?php foreach($seo_tax as $st):?>
                                    <div class="main-table__tr">
                                        <div class="main-table__td">
                                            <h4 class="main-table__title">
                                                <?= $st['title'];?>
                                            </h4>

                                            <img src="<?= $st['image']['url'];?>" alt="<?= $st['image']['alt'];?>">
                                        </div>
                                        <div class="main-table__td text-content">
                                            <?= $st['text'];?>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            </div>
                            <div class="text-tabel__bottom">
                                <div class="main-table__tr ">
                                    <div class="main-table__td">
                                    </div>
                                    <div class="main-table__td text-content">
                                        <p>
                                            <a href="#" class="link-see-more" data-text="Zeige weniger">Zeig mehr</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php else:?>
                            <div class="text-tabel__collapse">
                                <?php foreach($seo as $s):?>
                                    <div class="main-table__tr">
                                        <div class="main-table__td">
                                            <h4 class="main-table__title">
                                                <?= $s['title'];?>
                                            </h4>

                                            <img src="<?= $s['image']['url'];?>" alt="<?= $s['image']['alt'];?>">
                                        </div>
                                        <div class="main-table__td text-content">
                                            <?= $s['text'];?>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            </div>
                            <div class="text-tabel__bottom">
                                <div class="main-table__tr ">
                                    <div class="main-table__td">
                                    </div>
                                    <div class="main-table__td text-content">
                                        <p>
                                            <a href="#" class="link-see-more" data-text="Zeige weniger">Zeig mehr</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                    <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php get_footer();
