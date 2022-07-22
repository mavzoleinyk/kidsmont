<?php

/*

Template Name: Category Page

*/

get_header();

$cats = get_field('categories');

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
                <h2 class="head__title"><?php the_title();?></h2>
            </div>
        </div>


        <div class="category padding-wrap pt-0">
            <div class="container-sm">
                <?php if(isset($cats)):?>
                	
                	<ul class="category__list">

                		<?php foreach ($cats as $term):
                			$thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
                			$image = wp_get_attachment_url( $thumbnail_id );
                			?>
		                    <li>
		                        <a href="<?= get_term_link($term->term_id);?>" class="category-card not-hover">
		                            <div class="category-card__img">
		                                <img src="<?= $image;?>" alt="<?= $term->name;?>">
		                            </div>
		                            <div class="category-card__text-wrap">
		                                <div class="category-card__title"><?= $term->name;?></div>
		                                <div class="category-card__subtitle"><?= $term->description;?></div>
		                            </div>
		                        </a>
		                    </li>
                   		<?php endforeach;?>

                	</ul>

                <?php endif;?>
            </div>
        </div>

        <div class="padding-wrap pb-0" data-last-section>
            <div class="text-tabel" data-text-table>
                <div class="container-sm">
                    <div class="main-table">
                        <div class="text-tabel__preview">
                            <div class="main-table__tr">
                                <div class="main-table__td">
                                    <h3 class="main-table__title">
                                        <?php the_field('title_text');?>
                                    </h3>
                                </div>
                                <div class="main-table__td text-content">
                                    <?php the_field('text');?>
                                </div>
                            </div>
                        </div>
                        <?php if( have_rows('more_info') ):?>

                        	<div class="text-tabel__collapse">

                        		<?php while ( have_rows('more_info') ) : the_row();?>
		                            
		                            <div class="main-table__tr">
		                                <div class="main-table__td">
		                                    <h4 class="main-table__title">
		                                        <?php the_sub_field('title');?>
		                                    </h4>
		                                    <?php $im = get_sub_field('image');?>
		                                    <img src="<?= $im['url'];?>" alt="<?= $im['alt'];?>">
		                                </div>
		                                <div class="main-table__td text-content">
		                                    <?php the_sub_field('text');?>
		                                </div>
		                            </div>

	                            <?php endwhile;?>
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

<?php get_footer();?>