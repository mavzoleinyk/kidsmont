<?php

/*

Template Name: Compliant Page

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
                <h2 class="head__title"><?php the_title();?></h2>
            </div>
        </div>

        <div class="padding-wrap pt-0">
            <div class="container-sm">
                <div class="main-table" data-spoller="mob-sm">
                    <div class="main-table__tr">
                        <div class="main-table__td" data-spoller-trigger>
                            <h4 class="main-table__title"><?php the_field('title');?></h4>
                            <div class="main-table__plus"><span></span></div>
                        </div>
                        <div class="main-table__td text-content">
                           <?php the_content();?>
                        </div>
                    </div>
                    <div class="main-table__tr pb-0 border-bottom-0">
                        <div class="main-table__td">
                            <h4 class="main-table__title"><?php the_field('title_form');?></h4>
                        </div>
                        <div class="main-table__td">
                            <?= do_shortcode(''.get_field('form').'');?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

<?php get_footer();?>