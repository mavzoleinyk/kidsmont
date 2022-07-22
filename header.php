<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset');?>">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<title><?php echo wp_get_document_title(); ?></title>
		<?php wp_head();?>



	<style>
		/*:root {
			cursor: none !important;
		}

		* {
			cursor: none !important;
		}*/

		body.page-is-load ._preload-body {
			opacity: 0;
			visibility: hidden;
		}

		body.page-is-load ._preload-body:before {
			display: none;
		}

		.mouse-dot {
			font-size: 10px;
			height: 2em;
			width: 2em;
			transition: transform, background-color, height, width .3s ease;
			position: absolute;
			z-index: 99999;
			border-radius: 50%;
			background-color: #222222;
			transform: translate(-50%, -50%) scale(1);
			pointer-events: none;
			left: -30px;
			top: -30px;
			box-shadow: 0 0 15px rgba(243, 241, 239, 0.4);
		}

		.mouse-dot.hide {
			transform: translate(-50%, -50%) scale(0);
		}

		.mouse-dot.hover {}

		._preload-body {
			background-color: #fff;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			z-index: 999;
			transition: all .6s ease .2s;
		}

		._preload-body:before {
			position: absolute;
			content: '';
			z-index: 999;
			top: 50%;
			left: 50%;
			height: 50px;
			width: 50px;
			border-radius: 50%;
			border: 4px solid #6e6e6e;
			border-right: 4px solid #fff;
			transform: translate(-50%, -50%);
			animation: preloadBody 2s linear infinite;
		}

		@keyframes preloadBody {
			from {
				transform: translate(-50%, -50%) rotate(0);
			}

			to {
				transform: translate(-50%, -50%) rotate(360deg);
			}
		}
	</style>
</head>

<?php if($_COOKIE['wish']){

	$arr = explode(',',$_COOKIE['wish']);

	$wish = array_unique($arr);
	$count = count($wish);
		            
}
$current_user = wp_get_current_user();
$name = $current_user->display_name;
?>

<body <?php body_class() ?> <?= !is_checkout()?'data-scroll-container':'';?>>

<?php $logo = get_field('logo_header', 'options');?>

	<div class="_preload-body"></div>

	<header class="header " data-header data-popup="add-right-padding">
	    <div class="container">
	        <div class="header__body">
	            <div class="header__burger burger" data-side-panel-open="menu-mobile">
	                <span class="burger__cross"></span>
	                <span class="burger__cross"></span>
	                <span class="burger__cross"></span>
	                <span class="burger__cross"></span>
	            </div>
	            <div class="header__logo">
	                <?php if(is_front_page()):?>
	                    <img src="<?= $logo['url'];?>" alt="<?= $logo['alt'];?>">
	                <?php else:?>
	                	<a href="<?= get_home_url();?>">
		                    <img src="<?= $logo['url'];?>" alt="<?= $logo['alt'];?>">
		                </a>
		            <?php endif;?>
	            </div>
	            <?php if(!is_page(33)):?>
		            <nav class="header__menu menu">
		            	<?php wp_nav_menu([
						    'theme_location' => 'main-menu',
						    'container' => false,
						    'menu_class' => 'menu__list',
						    'walker' => new Main_Menu(),
	                    ]);?>
		               
		            </nav>
		        <?php endif;?>

	            	<a href="tel:<?= phone_clear(get_field('phone', 'options'));?>" class="header__phone"><?php the_field('phone', 'options');?></a>
	            <?php if(!is_page(33)):?>
		            <div class="header__search">
		                <a href="#" data-action="show-main-search">
		                    <img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/search.svg" alt="">
		                </a>
		            </div>
		            <div class="header__actions">
		                <div class="header-actions">
		                    <div class="header-actions__item header-actions__item--user">
		                    	<?php if(is_user_logged_in()):?>
		                        	<a class="header-actions__link" href="<?= get_permalink(get_option( 'woocommerce_myaccount_page_id' ));?>">
		                        <?php else:?>
		                        	<a class="header-actions__link" href="#entry" data-popup="open-popup">
		                        <?php endif;?>
		                            <img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/user.svg" alt="">
		                        </a>
		                    </div>
		                    <div class="header-actions__item header-actions__item--like">
		                    	<?php if($_COOKIE['wish']):?>
			                    	<div class="header-actions__count"><?= $count;?></div>
			                    <?php endif;?>
		                        <a class="header-actions__link" href="#" data-side-panel-open="favorites">
		                            <img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/like.svg" alt=""> 
		                        </a>
		                    </div>
		                     <div class="header-actions__item header-actions__item--basket">
		                    	<div class="header-actions__count cart_count"><?= WC()->cart->get_cart_contents_count();?></div>
		                        <a class="header-actions__link" href="<?= WC()->cart->get_cart_url(); ?>" data-side-panel-open="basket">
		                            <img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/bag.svg" alt="">
		                        </a>
		                    </div>
		                </div>
		            </div>
		        <?php endif;?>
	        </div>
	    </div>
	</header>

	<div class="main-search" data-main-search>
	    <form action="<?= get_permalink( wc_get_page_id( 'shop' ) );?>" >
	        <div class="main-search__body container">
	            <button class="main-search__submit">
	                <img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/search.svg" alt="">
	            </button>
	            <input type="text" class="main-search__input" placeholder="Enter text to search..." name="s" id="s">
	            <div class="main-search__close" data-action="hide-main-search"><span></span></div>
	        </div>
	    </form>
	</div>

	<div class="side-panel menu-mobile" data-side-panel="menu-mobile">
	    <div class="side-panel__close" data-side-panel-close><span></span></div> 
	    <div class="side-panel__body">
	        <div class="side-panel__head">
	            <div class="menu-mobile__logo">
	            	<?php if(is_front_page()):?>
	                    <img src="<?= $logo['url'];?>" alt="<?= $logo['alt'];?>">
	                <?php else:?>
	                	<a href="<?= get_home_url();?>">
		                    <img src="<?= $logo['url'];?>" alt="<?= $logo['alt'];?>">
		                </a>
		            <?php endif;?>
	            </div>
	            <a href="tel:<?= phone_clear(get_field('phone', 'options'));?>" class="menu-mobile__phone"><?php the_field('phone', 'options');?></a>
	            <div class="menu-mobile__back-btn" data-action="hide-next-list">
	                back
	            </div>
	        </div>
	        <div class="side-panel__scroll-wrap">
	            <div class="swiper" data-mobile-menu-slider>
	            	<div class="swiper-wrapper">
	                    <div class="swiper-slide">
	                        <ul class="menu-mobile__actions">
	                            <li>
	                                <div class="menu-mobile__actions-item" data-action="show-next-list">
	                                    <div class="menu-mobile__actions-item-icon">
	                                        <img src="<?= get_template_directory_uri();?>/img/icons/catalog.svg" alt="">
	                                    </div>
	                                    <div class="menu-mobile__actions-item-text">Catalog</div>
	                                    <div class="menu-mobile__actions-item-arrow"></div>
	                                </div>
	                            </li>
	                            <?php if(is_user_logged_in()):?>
		                            <li>
		                                <div class="menu-mobile__actions-item" data-action="show-next-list">
		                                    <div class="menu-mobile__actions-item-icon menu-mobile__actions-item-icon--user" style="background-color: #99C6E5; color: #fff">
		                                        <?= $name[0];?>
		                                    </div>
		                                    <div class="menu-mobile__actions-item-text"><?= $name;?></div>
		                                </div>
		                            </li>
		                        <?php endif;?>
	                            <li>
	                                <div class="menu-mobile__actions-item" data-side-panel-open="basket">
	                                    <div class="menu-mobile__actions-item-icon">
	                                        <img src="<?= get_template_directory_uri();?>/img/icons/basket.svg" alt=""> 
	                                    </div>
	                                    <div class="menu-mobile__actions-item-text">Basket</div>
	                                    <div class="menu-mobile__actions-item-count cart_count"><?= WC()->cart->get_cart_contents_count();?></div>
	                                </div>
	                            </li>
	                            <li>
	                                <div class="menu-mobile__actions-item" data-side-panel-open="favorites">
	                                    <div class="menu-mobile__actions-item-icon">
	                                        <img src="<?= get_template_directory_uri();?>/img/icons/favorites.svg" alt="">
	                                    </div>
	                                    <div class="menu-mobile__actions-item-text">Favorites</div>
	                                    <?php if($_COOKIE['wish']):?>
					                    	<div class="menu-mobile__actions-item-count d-none"><?= $count;?></div>
					                    <?php endif;?>
	                                </div>
	                            </li>
	                        </ul>
	                        <?php wp_nav_menu([
							    'theme_location' => 'mob-menu',
							    'container' => false,
							    'menu_class' => 'menu-mobile__list',
							    'walker' => new Mob_Menu(),
		                    ]);?>
		                    <?php if(!is_user_logged_in()):?>
		                        <div class="menu-mobile__bottom">
		                            <a href="#registration" class="btn-default" data-popup="open-popup">Join Us</a>
		                            <a href="#entry" class="btn-default btn-default--transparent" data-popup="open-popup">Sign in</a>
		                        </div>
		                    <?php else:?>
	                       
		                        <div class="menu-mobile__bottom menu-mobile__bottom--sign-out">
		                            <a href="<?= wp_logout_url(); ?>" class="btn-default btn-default--transparent">Sign out</a>
		                        </div>
		                    <?php endif;?>
	                    </div>
	                    <div class="swiper-slide">
	                    	<?php wp_nav_menu([
							    'theme_location' => 'cat-menu',
							    'container' => false,
							    'menu_class' => 'menu-mobile__list menu-mobile__list--catalog',
							    'add_a_class' => 'menu-mobile__link',
		                    ]);?>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="side-panel side-panel--right selected-products basket" data-side-panel="basket">
		<?php wc_get_template('cart/mini-cart.php');?>
	</div>

	<div class="side-panel side-panel--right selected-products favorites" data-side-panel="favorites">	
	    <div class="side-panel__body">
	        <div class="side-panel__head">
	            <h3 class="selected-products__title">Favorites</h3>
	            <?php if($count>0):?>
	            	<div class="selected-products__count"><?= $count==1?$count.' product':$count.' products';?></div>
	            <?php endif;?>
	            <div class="side-panel__close side-panel__close--circle" data-side-panel-close><span></span></div> 
	        </div>
	        <div class="side-panel__scroll-wrap">
	        	<?php if($_COOKIE['wish']): ?>
		            <ul class="selected-products__list">
		            	<?php 
		            	$sum = [];
		            	foreach ($wish as $id):
		            		$product = wc_get_product( $id );
		            		$sum[] = intval($product->get_price());
		            		?>
			                <li>
			                	<div class="order-card order-card--has-like-btn">
			                        <a href="<?php get_permalink($id);?>" class="order-card__like order-card__like--active"></a>
			                        <div class="order-card__img">
			                            <a href="<?php get_permalink($id);?>">
			                                <img src="<?= get_the_post_thumbnail_url($id);?>" alt="">
			                            </a>
			                        </div>
			                        <div class="order-card__inner pt-0  pb-0">
			                            <div class="order-card__text">
			                                <a href="<?= get_permalink($id);?>">
			                                    <?= get_the_title($id);?>
			                                </a>
			                            </div>
			                            <div class="order-card__info-wrap flex-row  flex-md-column justify-content-between align-items-center align-items-md-end justify-content-md-start">
			                                <div class="order-card__price"><strong><?= $product->get_price();?>€</strong></div>
			                                <a href="#" data-product_id="<?= $product->get_id(); ?>" class="order-card__add-to-cart add-to-cart">Add to Cart</a>
			                            </div>
			                        </div>
			                    </div>
			                </li>
		                <?php endforeach;?>
		            </ul>
		        <?php endif;?>
	        </div>
	        <div class="side-panel__bottom">
	            <div class="selected-products__bottom">
	                <div class="selected-products__bottom-row selected-products__bottom-row--2">
	                    <a href="<?= get_permalink( wc_get_page_id( 'shop' ) );?>" class="btn-default btn-default--transparent not-hover">Continue Shopping</a>
	                    <a href="#" data-product_id="<?= $_COOKIE['wish']; ?>" class="btn-default not-hover fav-to-cart">Add all to cart</a>
	                </div>
	            </div>
	        </div>
	        <div class="side-panel__bottom">
	            <div class="selected-products__bottom">
	                <div class="selected-products__bottom-col"><a href="<?= get_permalink( wc_get_page_id( 'shop' ) );?>" class="side-panel__close-link" data-side-panel-close></a></div>
	                <div class="selected-products__bottom-col">
	                    <div class="selected-products__total">
	                    	<?php $s = array_sum($sum);?>
	                        Total: <strong><?= $s;?>€</strong>
	                    </div>
	                </div>
	                <div class="selected-products__bottom-col">
	                    <a href="#" class="btn-default not-hover">In den warenkorb legen</a>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="side-panel faq-items" data-side-panel="faq-items">
	    <div class="side-panel__close" data-side-panel-close><span></span></div>
	    <div class="side-panel__body">
	        <div class="side-panel__head">
	            <div class="faq-items__title">Sort by</div>
	        </div>
	        <div class="side-panel__scroll-wrap">
	            <ul class="faq-items__list" data-tabs-outside-nav>
	            	<?php $cats = get_terms('category_faq');

	            	$j=0;

	            	foreach ($cats as $cat):?>
                       
                        <li>
		                    <a href="#" <?= $j==0?'class="tab-active"':'';?> data-tab-trigger="<?= $cat->term_id;?>"><?= $cat->name;?></a>
		                </li>

		            <?php $j++;

		        	endforeach;?>
	                
	            </ul>
	        </div>
	    </div>
	</div>

	<div class="side-panel faq-items" data-side-panel="account-tabs">
	    <div class="side-panel__close" data-side-panel-close><span></span></div>
	    <div class="side-panel__body">
	        <div class="side-panel__head">
	            <div class="faq-items__title">
	                Persönliches Büro

	                </div>
	        </div>
	        <div class="side-panel__scroll-wrap">
	            <ul class="faq-items__list" data-tabs-outside-nav>
	                <li>
	                    <a href="#" class="tab-active" data-tab-trigger="0">Meine Details</a>
	                </li>
	                <li>
	                    <a href="#" data-tab-trigger="1">Meine Bestellungen</a>
	                </li>
	            </ul>
	        </div>
	    </div>
	</div>

	<?php $order = [
		'menu_order' => 'Standaard',
		'popularity' => 'Populariteit',
		'date' => 'Nieuwste',
		'price-desc' => 'Aflopende prijs',
		'price' => 'Prijsverhoging',
	];?>
	    <div class="side-panel products-sort" data-side-panel="products-sort">
		    <div class="side-panel__close" data-side-panel-close><span></span></div>
		    <div class="side-panel__body">
		        <div class="side-panel__head">
		            <div class="products-sort__title">Sort by</div>
		        </div>
		        <div class="side-panel__scroll-wrap">
		            <ul class="products-sort__list">
		            	<?php foreach ($order as $key => $value):?>
		            		<li>
		            			<a href="#" data-key="<?= $key;?>"><?= $value;?></a>
							</li>
						<?php endforeach;?>
		            </ul>
		        </div>
		    </div>

		</div>
