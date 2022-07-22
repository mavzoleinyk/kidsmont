<?php

/*

Template Name: Home Page

*/

get_header();

$btn = get_field('buttontext');

if( $btn ){
	$btn_url = $btn['url'];
	$btn_title = $btn['title'];
	$btn_target = $btn['target'] ? $btn['target'] : '_self';
}

?>
	


<main class="_page home-page" data-padding-top-header-size data-scroll-section>

	<section class="promo-header padding-wrap pt-0" data-scroll-sticky>
	    <div class="promo-header__body" data-set-font-size>
	        <div class="promo-header__title-wrap">
	            <div class="promo-header__title-container">
	                <div class="container">
	                    <a class="not-hover" href="<?= esc_url($btn_url); ?>" target="<?= esc_attr($btn_target); ?>">
	                    	<?php if( have_rows('title') ):?>

		            			<h1 class="promo-header__title promo-header__title--layer-1" data-promo-title data-scroll>

		                    		<?php while ( have_rows('title') ) : the_row();?>

		                    			<strong><span><?php the_sub_field('word');?></span></strong>

		                    		<?php endwhile;?>

		                    	</h1>

							<?php endif;?>
	                        <div class="promo-header__mob-btn">
	                            <?= esc_html($btn_title); ?>
	                        </div>
	                    </a>
	                </div>
	            </div>
	            <div class="promo-header__title-mask">
	                <span class="promo-header__title-discover"><?= esc_html($btn_title); ?></span>
	                <div class="promo-header__title-container">
	                    <div class="container">
	                        <?php if( have_rows('title') ):?>

		            			<h1 class="promo-header__title promo-header__title--layer-2" data-promo-title data-scroll>

		                    		<?php while ( have_rows('title') ) : the_row();?>

		                    			<strong><span><?php the_sub_field('word');?></span></strong>

		                    		<?php endwhile;?>

		                    	</h1>

							<?php endif;?>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>

	    <?php $imv = get_field('video_poster');
	    	$v = get_field('video');?>

	    <div class="promo-header__bg">
	        <div class="promo-header__img">
	            <video poster="<?= $imv['url'];?>" data-media-mobile="<?= $v;?>" autoplay="" muted="" loop="" playsinline="" controlslist="nodownload" crossorigin="anonymous">
	                <source src="<?= $v;?>" type="video/mp4; codecs=&quot;avc1.42E01E, mp4a.40.2&quot;">
	            </video>
	        </div>
	    </div>
	</section>

	<section class="padding-wrap pb-0-mob product-carousel" data-slider="product-carousel">
	    <div class="container-sm">
	        <div class="product-carousel__head d-flex align-items-center justify-content-between">
	            <h3 class="product-carousel__title"><?php the_field('title_popular');?></h3>
	            <div class="slider-buttons">
	    			<div class="slider-button slider-button--prev hover" data-action="btn-prev">
	        			<img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-left.svg" alt="">
	    			</div>
				    <div class="slider-button slider-button--next hover" data-action="btn-next">
				        <img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-right.svg" alt="">
				    </div>
				</div>
	        </div>
	    </div>
	    <?php $pop = get_field('popular_products');

	    global $product;

	    if( $pop ): ?>

	    	<div class="product-carousel__slider swiper" data-scroll data-scroll-offset="0%,100">
	    		<div class="swiper-wrapper">

	    			<?php foreach( $pop as $post): setup_postdata($post); ?>
        
		        		<div class="swiper-slide">
			                <a href="<?php the_permalink(); ?>" class="product-carousel-card not-hover">
			                    <div class="product-carousel-card__center-icon">
			                        <img src="<?= get_template_directory_uri();?>/img/icons/bag-circle-green.svg" alt="">
			                    </div>
			                    <div class="product-carousel-card__col-1">
			                        <div class="product-carousel-card__title"><?php the_title(); ?></div>
			                        <div class="product-carousel-card__price"><?= $product->get_price_html();?></div>
			                    </div>
			                    <div class="product-carousel-card__col-2">
			                        <div class="product-carousel-card__img">
			                            <img src="<?php the_post_thumbnail_url();?>" alt="<?php the_title(); ?>">
			                        </div>
			                    </div>
			                </a>
			            </div>

			        <?php endforeach; 

			        wp_reset_postdata(); ?>

			    </div>
			</div>

		<?php endif; ?>

		<div class="container-sm">
	        <div class="product-carousel__bottom">
	        	<?php  $link = get_field('products_button');

				if( $link ): 
					$link_url = $link['url'];
					$link_title = $link['title'];
					$link_target = $link['target'] ? $link['target'] : '_self';
					?>
					<div class="product-carousel__btn-desk"><a class="btn-with-arrow not-hover" href="<?= esc_url($link_url); ?>" target="<?= esc_attr($link_target); ?>"><?= esc_html($link_title); ?><span><img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-right.svg" alt=""></span></a></div>
				<?php endif; ?>
	            
	            <?php  $link = get_field('products_button_mob');

				if( $link ): 
					$link_url = $link['url'];
					$link_title = $link['title'];
					$link_target = $link['target'] ? $link['target'] : '_self';
					?>
					<div class="product-carousel__btn-mob"><a class="btn-default" href="<?= esc_url($link_url); ?>" target="<?= esc_attr($link_target); ?>"><?= esc_html($link_title); ?></a></div>
				<?php endif; ?>
	            
	        </div>
	    </div> 
	</section>

	<div class="see-more-ban padding-wrap">
	    <a href="#" class="swiper" data-slider="see-more-ban">
	        <div class="swiper-wrapper">
	        	<?php for ($i=1; $i <= 3; $i++):?>
	                <div class="swiper-slide">
	                    <span><?php the_field('ticker_italic_text');?></span> 
	                    <strong>
	                        <?php the_field('ticker_strong_text');?>
	                    </strong>
	                </div>
	            <?php endfor;?>
	        </div>
	    </a>
	</div>

	<section class="advantages padding-wrap">
		<div class="container-sm">
			<div class="advantages__body"> 
				<?php if( have_rows('advantages') ):?>

					<ul class="advantages__list">

						<?php while ( have_rows('advantages') ) : the_row();

							$im = get_sub_field('icon');

							?>

        					<li>
								<div class="advantages__item">
									<div class="advantages__item-icon">
										<img src="<?= $im['url'];?>" alt="<?= $im['alt'];?>">
									</div>
									<div class="advantages__title"><?php the_sub_field('title');?></div>
									<div class="advantages__text"><?php the_sub_field('text');?></div>
								</div>
							</li>

						<?php endwhile;?>

					</ul>

				<?php endif;?>
				
			</div>
		</div>
	</section>

	<section class="products-preview padding-wrap">
		<div class="container-sm">
			<div class="products-preview__head head">
				<h3 class="products-preview__title">
					<?php the_field('categories_title');?>
				</h3>
				<div class="products-preview__text">
					<?php the_field('categories_text');?>
				</div>
			</div>
			<ul class="products-preview__list">

				<?php if( have_rows('categories') ):

					$t=1;

					while ( have_rows('categories') ) : the_row();
						$im = get_sub_field('image');
						$link = get_sub_field('link');

						if( $link ){
							$link_url = $link['url'];
							$link_title = $link['title'];
							$link_target = $link['target'] ? $link['target'] : '_self';
						}
						?>

						<li <?= $t==3?'class="big"':'';?>>
							<a class="products-preview__item not-hover" href="<?= esc_url($link_url); ?>" target="<?= esc_attr($link_target); ?>">
								<div class="products-preview__item-img ibg" <?= $t==3?'data-scroll data-scroll-offset="30%,100"':'';?>>
									<img src="<?= $im['url'];?>" alt="<?= $im['alt'];?>">
								</div>
								<div class="products-preview__item-title">
									<?php the_sub_field('title');?>
								</div>
							</a>
						</li>

        

					<?php $t++;

					endwhile;

				endif;
				
				$link = get_field('categories_link');

				if( $link ): 
					$link_url = $link['url'];
					$link_title = $link['title'];
					$link_target = $link['target'] ? $link['target'] : '_self';
					?>
					<li class="has-btn"><a class="products-preview__btn not-hover" href="<?= esc_url($link_url); ?>" target="<?= esc_attr($link_target); ?>"><span><?= esc_html($link_title); ?></span></a></li>
				<?php endif; ?>
					
			</ul>
			<?php if( $link ): 
				$link_url = $link['url'];
				$link_title = $link['title'];
				$link_target = $link['target'] ? $link['target'] : '_self';
			?>
				<div class="products-preview__mob-btn">
					<a class="btn-with-arrow not-hover" href="<?= esc_url($link_url); ?>" target="<?= esc_attr($link_target); ?>"><?= esc_html($link_title); ?><span><img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-right.svg" alt=""></span></a>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<div class="see-more-ban padding-wrap">
	    <a href="#" class="swiper" data-slider="see-more-ban">
	        <div class="swiper-wrapper">
	            <?php for ($i=1; $i <= 3; $i++):?>
	                <div class="swiper-slide">
	                    <span><?php the_field('ticker_italic_text_reviews');?></span> 
	                    <strong>
	                        <?php the_field('ticker_strong_text_reviews');?>
	                    </strong>
	                </div>
	            <?php endfor;?>      
	        </div>
	    </a>
	</div>

	<section class="reviews padding-wrap pb-0-mob" data-slider="reviews">
    	<div class="container-sm">
        	<div class="reviews__head d-flex align-items-center justify-content-between">
            	<h3 class="reviews__title"><?php the_field('reviews_title');?></h3>
            	<div class="slider-buttons">
            		<div class="slider-button slider-button--prev hover" data-action="btn-prev">
            			<img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-left.svg" alt="">
            		</div>
            		<div class="slider-button slider-button--next hover" data-action="btn-next">
            			<img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-right.svg" alt="">
            		</div>
            	</div>
        	</div>
        	<?php $rev = get_field('reviews');

			if( $rev ): ?>

				<div class="reviews__slider swiper" data-scroll  data-scroll-offset="0%,100">
	            	<div class="swiper-wrapper">
			    
			    		<?php foreach( $rev as $post): setup_postdata($post); ?>

			    			<div class="swiper-slide">
			                    <div class="reviews-card">
			                        <div class="reviews-card__icon">
			                            <img src="<?= get_template_directory_uri();?>/img/icons/quote.svg" alt="">
			                        </div>
			                        <div class="reviews-card__text text-content">
			                            <?php the_field('text_reviews');?>
			                        </div>
			                        <div class="reviews-card__author">
			                            <?php the_title();?>
			                        </div>
			                    </div>
			                </div>
			        
			    		<?php endforeach;

			    		wp_reset_postdata(); ?>

			    	</div>
	        	</div>

			<?php endif; ?>

			<div class="reviews__bottom">
				<?php  $link = get_field('reviews_button');

				if( $link ): 
					$link_url = $link['url'];
					$link_title = $link['title'];
					$link_target = $link['target'] ? $link['target'] : '_self';
					?>
					<div class="reviews__btn-desk">
						<a class="btn-with-arrow not-hover" href="<?= esc_url($link_url); ?>" target="<?= esc_attr($link_target); ?>">
							<?= esc_html($link_title); ?>
							<span>
		                        <img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-right.svg" alt="">
		                    </span>
		                </a>
		            </div>
				<?php endif; ?>

				<?php  $link = get_field('reviews_button_mob');

				if( $link ): 
					$link_url = $link['url'];
					$link_title = $link['title'];
					$link_target = $link['target'] ? $link['target'] : '_self';
					?>
					<div class="reviews__btn-mob">
						<a class="btn-default" href="<?= esc_url($link_url); ?>" target="<?= esc_attr($link_target); ?>"><?= esc_html($link_title); ?></a>
					</div>
				<?php endif; ?>

	        </div>
	            
	    </div>
	</section>

	<section class="ergonomics padding-wrap">
		<div class="ergonomics__inner">
			<div class="container-sm">
				<div class="ergonomics__body">
					<div class="ergonomics__col-1">
						<h3 class="ergonomics__title"><?php the_field('ergonomics_title');?></h3>
						<div class="ergonomics__text text-content">
							<?php the_field('ergonomics_text');?>
						</div>
					</div>
					<div class="ergonomics__col-2">
						<div class="ergonomics__images" data-scroll data-scroll-offset="10%,100">
							<div class="ergonomics__decor">
								<img src="<?= get_template_directory_uri();?>/img/photo/ergonomics-text.svg" alt="ergonomics-text">
							</div>
							<?php 
								$im1 = get_field('ergonomics_big_image');
								$im2 = get_field('ergonomics_image');

							if($im1):?>
								<div class="ergonomics__img-1 ibg">
									<img src="<?= $im1['url'];?>" alt="<?= $im1['alt'];?>">
								</div>
							<?php endif;
							if($im2):?>
								<div class="ergonomics__img-2 ibg">
									<img src="<?= $im2['url'];?>" alt="<?= $im2['alt'];?>">
								</div>
							<?php endif;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="blog-preview padding-wrap" data-slider="blog-preview">
		<div class="container-sm">
			<div class="blog-preview__head head d-flex align-items-center justify-content-between">
				<h3 class="head__title"><?php the_field('blog_title');?></h3>
				<div class="slider-buttons">
                    <div class="slider-button slider-button--prev hover" data-action="btn-prev">
                        <img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-left.svg" alt="">
                    </div>
                    <div class="slider-button slider-button--next hover" data-action="btn-next">
                    	<img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-right.svg" alt="">
                    </div>
                </div>
            </div>
            <div class="blog-preview__list swiper" data-mobile="false">
            	<div class="swiper-wrapper">
            		<?php $pp = new WP_Query([
						'post_type' => 'post',
						'posts_per_page' => 3,
						'orderby' => 'date',
						'order' => 'ASC',
					]);

					if($pp->have_posts()):
						while($pp->have_posts()): $pp->the_post();?>
	                        <div class="swiper-slide">
	                        	<a href="<?php the_permalink();?>" class="blog-preview-card">
									<div class="blog-preview-card__col-1">
										<div class="blog-preview-card__img ibg">
											<img src="<?php the_post_thumbnail_url();?>" alt="<?php the_title();?>">
										</div>
									</div>
									<div class="blog-preview-card__col-2">
										<div class="blog-preview-card__arrow">
											<img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-right.svg" alt="arrow">
										</div>
										<div class="blog-preview-card__date"><?php the_time('d.m.Y');?></div>
										<div class="blog-preview-card__title">
											<?php the_title();?>
										</div>
										<div class="blog-preview-card__text">
											<?= get_the_excerpt();?>
										</div>
									</div>
								</a>
	                        </div>
	                    <?php endwhile; 

						wp_reset_postdata();

					endif; ?>
					
                    </div>
                </div>
                <div class="blog-preview__bottom">
                	<?php  $link = get_field('blog_link');

					if( $link ): 
						$link_url = $link['url'];
						$link_title = $link['title'];
						$link_target = $link['target'] ? $link['target'] : '_self';
						?>
						<div class="blog-preview__btn-desk"><a class="btn-with-arrow not-hover" href="<?= esc_url($link_url); ?>" target="<?= esc_attr($link_target); ?>"><?= esc_html($link_title); ?><span><img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-right.svg" alt=""></span></a></div>
					<?php endif; ?>
                    <?php  $link = get_field('blog_link_mob');

					if( $link ): 
						$link_url = $link['url'];
						$link_title = $link['title'];
						$link_target = $link['target'] ? $link['target'] : '_self';
						?>
						<div class="blog-preview__btn-mob"><a class="btn-default" href="<?= esc_url($link_url); ?>" target="<?= esc_attr($link_target); ?>"><?= esc_html($link_title); ?></a></div>
					<?php endif; ?>
                    
                </div>
            </div>
        </section>

	</main>



<?php get_footer();?>