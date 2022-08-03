<?php

/*

Template Name: Feedback Page

*/

get_header();

$title = get_field('title');

$img = get_field('gallery');

$title2 = get_field('title_1');
?>


	<main class="_page " data-padding-top-header-size data-scroll-section>

        <div class="container-sm d-none d-lg-block">
            <?php if(function_exists('bcn_display')):?>
	    	    <ul class="breadcrumbs">
	    	         <?php bcn_display();?>   
	    	    </ul>
	        <?php endif;?>
        </div>

        <a href="#leaveComment" class="fixed-btn" data-popup="open-popup" >
            <?php the_field('mobile_button');
            $imb = get_field('mobile_button_icon');
            if($imb):?>
		        <span class="fixed-btn__icon">
		            <img src="<?= $imb['url'];?>" alt="<?= $imb['alt'];?>">
		        </span>
		    <?php endif;?>
        </a>

        <div class="container-sm">
            <div class="head pt-4 pt-lg-0">
                <h2 class="head__title"><?php the_title();?></h2>
            </div>
        </div>

        <?php $wp_query = new WP_Query([
        	'post_type' => 'reviews',
        	'posts_per_page' => 5,
        	'paged' => get_query_var('paged'),
        ]);?>

        <div class="container-sm padding-wrap pt-0">

        	<?php if($wp_query->have_posts()):?>
            	
            	<ul class="reviews-list">

            		<?php while($wp_query->have_posts()): $wp_query->the_post();

            			$images = get_field('gallery');

                        $c = count($images);

                        ?>
		                
		                <li>
		                    <div class="reviews-list-card">
							    <div class="reviews-list-card__col-1">
							        <div class="reviews-list-card__text text-content"><?php the_field('text_reviews');?></div>
							        <div class="reviews-list-card__author"><?php the_title();?></div>
							    </div>
							    <div class="reviews-list-card__col-2">
							        <?php if( $c > 1 ):?>
							            
							        	<div class="reviews-list-card__slider swiper" data-reviews-list-card-slider>
							                <button class="reviews-list-card__btn reviews-list-card__btn--next">Next</button>
							                <div class="swiper-wrapper">
							                    <?php foreach( $images as $im ): ?>
							                        <div class="swiper-slide ibg">
							                        	<img src="<?= $im['url'];?>" alt="<?= $im['alt'];?>">
							                        </div>
							                    <?php endforeach;?>
							                </div>
							            </div>

							        <?php else:?>

							        	<div class="reviews-list-card__img ibg">
							                <?php foreach( $images as $im ): ?>
                                                <img src="<?= $im['url'];?>" alt="<?= $im['alt'];?>">
                                                <?php endforeach;?>
							            </div>

							        <?php endif;?>
							    </div>
							</div>
		                </li>

		            <?php endwhile;?>

		        </ul>

		    <?php endif;?>

		    <?php wp_reset_postdata();?>

        </div>
        <?php $max_pages = $wp_query->max_num_pages;
        $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;  

        if( $paged < $max_pages ) {  ?> 
            <div class="d-none d-md-block">
                <div class="see-more-ban padding-wrap type-3">
                    <a href="#" class="swiper" id="loadmore" data-slider="see-more-ban" data-max_pages="<?= $max_pages;?>" data-paged="<?= $paged;?>">
                        <div class="swiper-wrapper">
                            
                            <div class="swiper-slide">
                                    
                                    <div class="see-more-ban__circle">
                                        <span>
                                            Mehr sehen
                                        </span>
                                    </div>
                                    <span>MEHR</span>
                                    <strong>
                                        SEHEN
                                    </strong>
                            </div>
                            <div class="swiper-slide">
                                    
                                    <div class="see-more-ban__circle">
                                        <span>
                                            Mehr sehen
                                        </span>
                                    </div>
                                    <span>MEHR</span>
                                    <strong>
                                        SEHEN
                                    </strong>
                            </div>
                            <div class="swiper-slide">
                                    
                                    <div class="see-more-ban__circle">
                                        <span>
                                            Mehr sehen
                                        </span>
                                    </div>
                                    <span>MEHR</span>
                                    <strong>
                                        SEHEN
                                    </strong>
                            </div>
                            
                        </div>
                    </a>
                </div>
            </div> 
        <?php }?>

        <div class="gallery-carousel padding-wrap pb-0-mob" data-gallery-carousel>
    		<div class="gallery-carousel__inner">
        		<div class="container-sm">
            		<div class="gallery-carousel__head head d-flex align-items-center justify-content-between">
               			<h3 class="head__title mb-0"><?= $title;?></h3>
                		<div class="slider-buttons">
    						<div class="slider-button slider-button--prev hover" data-action="btn-prev">
    							<img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-left.svg" alt="">
    						</div>
						    <div class="slider-button slider-button--next hover" data-action="btn-next">
						        <img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-right.svg" alt="">
						    </div>
						</div>
					</div>
					<?php if( $img ):?>

						<div class="gallery-carousel__slider swiper">
							<div class="swiper-wrapper">

					   			<?php foreach( $img as $im ): ?>

					   				<div class="swiper-slide">
				                        <a class="gallery-carousel__slider-item ibg" data-fancybox href="<?= $im['url'];?>">
				                            <img src="<?= $im['url'];?>" alt="<?= $im['alt'];?>">
				                        </a>
				                    </div>
					        
					    		<?php endforeach;?>

					    	</div>
					    </div>

					<?php endif; ?>
		               
        		</div>
        		<div class="d-none d-md-block">
                    <div class="see-more-ban padding-wrap type-3">
                        <a href="#" class="swiper" data-slider="see-more-ban">
                            <div class="swiper-wrapper">
                                

                                
                                
                                    <div class="swiper-slide">
                                        
                                        <div class="see-more-ban__circle">
                                            <span>
                                                Mehr sehen
                                            </span>
                                        </div>
                                        <span>MEHR</span>
                                        <strong>
                                            SEHEN
                                        </strong>
                                    </div>
                                    <div class="swiper-slide">
                                        
                                        <div class="see-more-ban__circle">
                                            <span>
                                                Mehr sehen
                                            </span>
                                        </div>
                                        <span>MEHR</span>
                                        <strong>
                                            SEHEN
                                        </strong>
                                    </div>
                                    <div class="swiper-slide">
                                        
                                        <div class="see-more-ban__circle">
                                            <span>
                                                Mehr sehen
                                            </span>
                                        </div>
                                        <span>MEHR</span>
                                        <strong>
                                            SEHEN
                                        </strong>
                                    </div>
                                
                            </div>
                        </a>
                    </div>
                </div>
    		</div>
		</div>

        <div class="leave-comment padding-wrap d-none d-md-block">
            <div class="container-sm">
                <h3 class="leave-comment__title"><?= $title2;?></h3>
                <form class="dropzone" method="GET" id="addreview">
                	<input type="hidden" name="action" value="add_review">
                    <input type="hidden" name="media_ids">
                    <div class="leave-comment__body">
                        <div class="leave-comment__col-1">
                            <div class="drop-zone" data-drop-zone id="dZUpload">
							    <input class="drop-zone__input" type="file" multiple="multiple" >
							    <div class="drop-zone__fraction">
							        0/10
							    </div>
							    <div class="drop-zone__body">
							        <div class="drop-zone__title">Legen Sie Ihre Dateien hier ab</div>
							        <span>or</span>
							        <div class="btn">
									    <div class="btn__text-decor">
									        <img class="img-svg" src="<?= get_template_directory_uri();?>/img/photo/upload-photo-text.svg" alt="">
									    </div>
									    <div class="btn__text">Fotos hochladen</div>
									</div>
							    </div>
							    <div class="drop-zone__preview dropzone-previews"></div>
							</div>
                        </div>
                        <div class="leave-comment__col-2">
                            <div class="form">
                                <div class="form__items">
                                    <div class="form__item">
                                        <input class="input required" name="name" type="text" placeholder="Name">
                                    </div>
                                    <div class="form__item">
                                        <textarea data-textarea class="textarea required" placeholder="Kommentar" name="text"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="form__submit btn-default w-100">Hinterlasse einen Kommentar</button>
                            </div>
                        </div>
                    </div>

                    <div class="message-text"></div>
                </form>
            </div>
        </div>  

	</main>


<?php get_footer();?>