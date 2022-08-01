<?php 

/*

Template Name: Constructor Page

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


        <div class="blog padding-wrap pt-0" >
            <div class="blog__content">
            <?php if( have_rows('content') ):

                while ( have_rows('content') ) : the_row();

                    if( get_row_layout() == 'title_text_2_column' ):

                        get_template_part('parts/blocks/title-text-2-column');
                    
                    elseif( get_row_layout() == 'video_section' ): 
                        
                        get_template_part('parts/blocks/video-section');

                    elseif( get_row_layout() == 'text_with_image' ): 
                        
                        get_template_part('parts/blocks/text-with-image');

                    elseif( get_row_layout() == 'title_with_content' ): 
                        
                        get_template_part('parts/blocks/title-with-content');

                    elseif( get_row_layout() == 'information_section' ): 
                        
                        get_template_part('parts/blocks/information-section');

                    elseif( get_row_layout() == 'text_video_banner' ): 
                        
                        get_template_part('parts/blocks/text-video-banner');

                    elseif( get_row_layout() == 'icon_list' ): 
                        
                        get_template_part('parts/blocks/icon-list');    

                    elseif( get_row_layout() == 'usage_preferences' ): 
                        
                        get_template_part('parts/blocks/usage-preferences'); 

                    elseif( get_row_layout() == 'service_preferences' ): 
                        
                        get_template_part('parts/blocks/service-preferences'); 

                    elseif( get_row_layout() == 'advantages_with_image' ): 
                        
                        get_template_part('parts/blocks/advantages-with-image');

                    elseif( get_row_layout() == 'text_reviews' ): 
                        
                        get_template_part('parts/blocks/reviews'); 

                    elseif( get_row_layout() == 'reviews_with_media' ): 
                        
                        get_template_part('parts/blocks/reviews-with-media'); 

                    elseif( get_row_layout() == 'faqs' ): 
                        
                        get_template_part('parts/blocks/faqs');

                    elseif( get_row_layout() == 'gallery' ): 
                        
                        get_template_part('parts/blocks/gallery');

                    endif;

                endwhile;

            endif;?>
        </div>

        </div>

	</main>


<?php get_footer();?>