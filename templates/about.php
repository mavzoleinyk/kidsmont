<?php

/*

Template Name: About Page

*/

get_header();

?>

    <main class="_page " data-padding-top-header-size data-scroll-section>

        <div class="container-sm d-none d-lg-block">
            <?php if(function_exists('bcn_display')):?>
	    	    <ul class="breadcrumbs">
	    	         <?php bcn_display();?>   
	    	    </ul>
	        <?php endif;?>
        </div>

        <div class="container-sm">
            <div class="head pt-4 pt-lg-0">
                <h1 class="head__title"><?php the_title();?></h1>
            </div>
        </div>


        <div class="about padding-wrap pt-0">
            <div class="about__body container-sm">
                <div class="about__top-banner">
                    <div class="img-full-width">
                        <img src="<?php the_post_thumbnail_url();?>" alt="">
                    </div>
                </div>
                <div class="about__big-text">
                    <?php the_field('title');?>
                </div>
                <?php $col1 = get_field('column_1');?>
                <?php $col2 = get_field('column_2');?>
                <div class="about__content about__content--col-2">
                    <div class="about__content-col-1">
                        <div class="about__content-col-1-img">
                            <img src="<?= $col1['image'];?>" alt="">
                        </div>
                    </div>
                    <div class="about__content-col-2">
                        <div class="about__text-wrap text-content">
                            <?= $col2['text'];?>
                        </div>

                        <div class="img-full-width">
                            <img src="<?= $col2['image_2']['url'];?>" alt="<?= $col2['image_2']['alt'];?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="benefits padding-wrap">
            <div class="container">
                <h3 class="benefits__title"><?php the_field('title_1');?></h3>
                <?php if( have_rows('list') ):?>

                	<div class="benefits__list swiper" data-slider="benefits-list" data-mobile="false">
                        <div class="swiper-wrapper">

                    		<?php while ( have_rows('list') ) : the_row();
                    			$im = get_sub_field('icon');
                    			?>

                    			<div class="swiper-slide">
    		                        <div class="benefits__list-icon">
    		                            <img src="<?= $im['url'];?>" alt="<?= $im['alt'];?>">
    		                        </div>
    		                        <h4 class="benefits__list-title"><?php the_sub_field('title');?></h4>
    		                        <div class="benefits__list-text"><?php the_sub_field('description');?></div>
    		                    </div>

    		                <?php endwhile;?>

    		            </div>
                        <div class="swiper-pagination"></div>
                    </div>

				<?php endif;?>
                
            </div>
        </div>

        <div class="about-bottom padding-wrap">
            <div class="about-bottom__inner">
                <div class="container">
                    <div class="about-bottom__body">
                        <div class="about-bottom__row about-bottom__row--1 about-bottom__row--has-col">
                            <div class="about-bottom__col">
                                <h3 class="about-bottom__title"><?php the_field('title_2');?></h3>
                            </div>
                            <div class="about-bottom__col">
                                <div class="about-bottom__text text-content">
                                    <p>
                                        <?php the_field('subtitle');?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="about-bottom__row about-bottom__row--2">
                            <div class="img-full-width">
                            	<?php $im = get_field('image');?>
                                <img src="<?= $im['url'];?>" alt="<?= $im['alt'];?>">
                            </div>
                        </div>
                        <div class="about-bottom__row about-bottom__row--3 about-bottom__row--has-col">
                            <div class="about-bottom__col">
                                <div class="about-bottom__text text-content">
                                    <p><?php the_field('text_left');?></p>
                                </div>
                            </div>
                            <div class="about-bottom__col">
                                <div class="about-bottom__text text-content">
                                    <p><?php the_field('text_right');?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>


<?php get_footer();?>