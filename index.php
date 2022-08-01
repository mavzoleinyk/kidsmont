<?php

get_header();

$blog = get_option('page_for_posts');

$cats = get_terms('category', ['hide_empty'=>false, 'exclude' => 1]);

?>

	<div class="side-panel faq-items" data-side-panel="blog-filter">

        <script>
        // API
        //sidePanel.open('blog-filter');
        //sidePanel.close('blog-filter');
        </script>


        <div class="side-panel__close" data-side-panel-close>
        	<span></span>
        </div>
        <div class="side-panel__body">
            <div class="side-panel__head">
                <div class="faq-items__title"><?= is_home()? get_the_title($blog):get_queried_object()->name;?></div>
            </div>
            <div class="side-panel__scroll-wrap">
                <ul class="faq-items__list">
                    <li>
                        <a href="<?= get_the_permalink($blog);?>" class="tab-active">All</a>
                    </li>
                     <?php foreach ($cats as $cat):?>
	                    <li>
	                        <a class="<?= get_queried_object_id()==$cat->term_id?'tab-active':'';?>" href="<?= get_term_link($cat->term_id);?>"><?= $cat->name;?></a>
	                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>

	<main class="_page " data-padding-top-header-size data-scroll-section>
        
        <div class="container-sm d-none d-lg-block">
            <?php if(function_exists('bcn_display')):?>
	    	    <ul class="breadcrumbs">
	    	         <?php bcn_display();?>   
	    	    </ul>
	        <?php endif;?>
        </div>
        
        <div class="container-sm">
            <div class="head head--top">
                <h2 class="head__title"><?= is_home()? get_the_title($blog):get_queried_object()->name;?></h2>
            </div>
        </div>


        <div class="blog padding-wrap pt-0">
            <div class="container-sm">
                <ul class="blog__filter">
                    <li>
                        <a class="not-hover blog__filter-item <?= is_home()?'blog__filter-item--active':'';?>" href="<?= get_the_permalink($blog);?>">All</a>
                    </li>
                    <?php foreach ($cats as $cat):?>
	                    <li>
	                        <a class="not-hover blog__filter-item <?= get_queried_object_id()==$cat->term_id?'blog__filter-item--active':'';?>" href="<?= get_term_link($cat->term_id);?>"><?= $cat->name;?></a>
	                    </li>
                    <?php endforeach;?>
                </ul>
                <div class="blog__filter-mob">
                    <button class="blog__filter-mob-btn" data-side-panel-open="blog-filter">all</button>
                </div>
                <div class="blog__list">

                    <?php if(have_posts()):?>

                    	<div class="blog-list" data-blog-list>

                    		<?php while(have_posts()): the_post();?>

			                    <div class="blog-list__item">
			                        <?php get_template_part('parts/post-item');?>
			                    </div>

			                <?php endwhile;?>

						</div>

					<?php endif;?>

                </div>
                <div class="blog__bottom">
					<?php $args = array(
		                    'type'         => 'list',
		                    'show_all'     => false,
		                    'prev_next'    => true,
		                    'end_size'     => 1,
		                    'mid_size'     => 1,
		                    'prev_text'    => '<img class="img-svg" src="'.get_template_directory_uri().'/img/icons/arrow-left.svg" alt="">',
		                    'next_text'    => '<img class="img-svg" src="'.get_template_directory_uri().'/img/icons/arrow-right.svg" alt="">',
		                );
		                                
		                the_posts_pagination($args);?>
                </div>
            </div>
        </div>

	    <div class="carousel  carousel-preview-posts padding-wrap" data-carousel="posts">
	    	<div class="container-sm">
	        	<div class="carousel__head head d-flex align-items-center justify-content-between">
	            	<h3 class="head__title mb-0">UNSERE BESTSELLER</h3>
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
	            		<?php $popularpost = new WP_Query([ 
	                        'posts_per_page' => 8, 
	                        'meta_key' => 'post_views_count', 
	                        'orderby' => 'meta_value_num', 
	                        'order' => 'DESC',
	                        'post__not_in' => array($ids),
	                    ]);

	                    if( $popularpost->have_posts() ):

	                        while ( $popularpost->have_posts() ) : $popularpost->the_post();?>

	                            <div class="swiper-slide">
	                                    
	                                <?php get_template_part('parts/post-item');?>

	                            </div>
	                         
	                        <?php endwhile;

	                    endif;?>
	            	</div>
	            </div>
	        </div>
	    </div>

	</main>


<?php get_footer();?>