<?php 

get_header(); 

setPostViews(get_the_ID());

$ids =  get_the_ID();

$cat = get_the_terms($ids, 'category');

$name = $cat[0]->name;

?>

 <main class="_page " data-padding-top-header-size data-scroll-section>

    <div class="container-sm d-none d-lg-block">
        <?php if(function_exists('bcn_display')):?>
    	    <ul class="breadcrumbs">
    	         <?php bcn_display();?>   
    	    </ul>
        <?php endif;?>
	</div>

    <div class="mob-share" data-mob-share>
        <ul class="a2a_kit mob-share__social">
            <li>
                <a href="#" class="a2a_button_facebook">
                    <img src="<?= get_template_directory_uri();?>/img/icons/facebook-2.svg" alt="">
                </a>
            </li>
            <li>
                <a href="#" class="a2a_button_twitter">
                    <img src="<?= get_template_directory_uri();?>/img/icons/twitter-2.svg" alt="">
                </a>
            </li>
            <li>
                <a href="#" class="a2a_button_telegram">
                    <img src="<?= get_template_directory_uri();?>/img/icons/telegram.svg" alt="">
                </a>
            </li>
            <li>
                <div class="mob-share__icon">
                    <img src="<?= get_template_directory_uri();?>/img/icons/share.svg" alt="">
                </div>
            </li>
        </ul>
    </div>


    <a href="#" class="fixed-btn" data-action="mob-share-open">
        Share
        <span class="fixed-btn__icon">
            <img src="<?= get_template_directory_uri();?>/img/icons/share.svg" alt="">
        </span>
    </a>

    <div class="blog-detail padding-wrap pt-0" data-blog-detail>
        <div class="container-sm">
            <div class="blog-detail__body">
                <div class="blog-detail__col-1">
                    <div class="blog-detail__article-head">
                        <h2 class="blog-detail__article-head-title">
                            <?php the_title();?>
                        </h2>
                        <div class="blog-detail__article-head-date">
                            <?php the_time('d.m.Y');?>
                        </div>
                        <div class="blog-detail__article-head-img">
                            <div class="blog-detail__article-head-img-wrap ibg">
                                <img src="<?php the_post_thumbnail_url();?>" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="blog-detail__article-body">
                        <div class="blog-detail__article-side-social">
                            <ul class="a2a_kit blog-detail-social" data-scroll data-scroll-sticky data-scroll-target=".blog-detail__article-side-social">
                                <li><a href="#" class="a2a_button_facebook">Facebook</a></li>
                                <li><a href="#" class="a2a_button_twitter">Twitter</a></li>
                                <li><a href="#" class="a2a_button_telegram">Telegram</a></li>
                            </ul>
                        </div>
                        <div class="blog-detail__article-content">
                            <div class="blog-detail__article-text text-content">

                                <?php the_content();?>

                            </div>
                            <div class="blog-detail__article-sliders">
                                <?php if( have_rows('category_gallery') ):
                                    
                                    $i=1;

                                    while ( have_rows('category_gallery') ) : the_row();

                                        $cats = get_sub_field('category');

                                        if(!empty($cats)):?>

                                            <div class="article-slider" data-article-slider>
                                                <div class="article-slider__head">
                                                    <h4 class="article-slider__title text-uppercase"><?= $i;?>. <?php the_sub_field('title');?></h4>
                                                    <div class="slider-buttons">
                                                        <div class="slider-button slider-button--prev hover" data-action="btn-prev">
                                                            <img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-left.svg" alt="">
                                                        </div>
                                                        <div class="slider-button slider-button--next hover" data-action="btn-next">
                                                            <img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-right.svg" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="article-slider__slider swiper">
                                                    <div class="swiper-wrapper">

                                                        <?php foreach ($cats as $cat):

                                                            $kat = get_term_by('id', $cat, 'product_cat');

                                                            $thumbnail_id = get_woocommerce_term_meta( $kat->term_id, 'thumbnail_id', true );
                                                            $image = wp_get_attachment_url( $thumbnail_id );

                                                            ?>
                                                        
                                                            <div class="swiper-slide">
                                                                <a href="<?php //get_term_link($cat);?>" class="article-slider-card not-hover">
                                                                    <div class="article-slider-card__img ibg">
                                                                        <img src="<?= $image;?>" alt="<?= $kat->name;?>">
                                                                    </div>
                                                                    <div class="article-slider-card__title"><?= $kat->name;?></div>
                                                                </a>
                                                            </div>

                                                        <?php endforeach;?>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                    <?php endif;

                                    $i++;

                                    endwhile;

                                endif;?>
                            
                    </div>

                    <div class="blog-detail__article-bottom">
                        <?php $prev = get_previous_post_link( '%link', '
                            <img class="img-svg" src="'.get_template_directory_uri().'/img/icons/arrow-left.svg" alt=""><span>Previous post</span>', true ); 

                        echo str_replace( '<a ', '<a class="blog-detail__article-bottom-link" ', $prev );?>

                        <?php $next = get_next_post_link( '%link', '<span>Next post</span>
                            <img class="img-svg" src="'.get_template_directory_uri().'/img/icons/arrow-right.svg" alt="">', true ); 

                        echo str_replace( '<a ', '<a class="blog-detail__article-bottom-link" ', $next );?>

                            
                        </a>
                        </div>

                            </div>
                        </div>
                    </div>
                    <div class="blog-detail__col-2">
                        <div class="blog-detail__col-2-inner">
                        	<?php $last = new WP_Query([ 
								'posts_per_page' => 3, 
								'orderby' => 'date', 
								'order' => 'DESC',
								'post__not_in' => array($ids),
							]);

                            if( $last->have_posts() ):?>

                                <ul class="blog-detail__side-posts" data-scroll data-scroll-sticky data-scroll-target=".blog-detail__col-2-inner">

                                    <?php while ( $last->have_posts() ) : $last->the_post();?>

                                        <li>
                                            <a href="<?php the_permalink();?>" class="post-card not-hover">
                                                <div class="post-card__img ibg">
                                                    <img src="<?php the_post_thumbnail_url();?>" alt="">
                                                </div>
                                                <div class="post-card__date"><?php the_time('d.m.Y');?></div>
                                                <div class="post-card__title"><?php the_title();?></div>
                                                <div class="post-card__text text-content"><?php the_excerpt();?></div>
                                            </a>
                                        </li>
						 
						            <?php endwhile;?>

                                </ul>

                            <?php endif;?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="carousel  carousel-preview-posts padding-wrap" data-carousel="posts">
            <div class="container-sm">
                <div class="carousel__head head d-flex align-items-center justify-content-between">
                    <h3 class="head__title mb-0">Popular</h3>
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

<script async src="https://static.addtoany.com/menu/page.js"></script>
<?php get_footer();?>