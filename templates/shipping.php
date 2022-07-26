<?php

/*

Template Name: Shipping Page

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
            	<?php if( have_rows('list_information') ):?>

            		<div class="main-table" data-spoller="mob-sm">

            			<?php while ( have_rows('list_information') ) : the_row();?>

            				<div class="main-table__tr">
		                        <div class="main-table__td" data-spoller-trigger>
		                            <h4 class="main-table__title">
		                                <?php the_sub_field('title');?>
		                            </h4>
		                            <div class="main-table__plus"><span></span></div>
		                        </div>
		                        <div class="main-table__td text-content">
		                            <?php the_sub_field('text');?>
		                        </div>
		                    </div>

		                <?php endwhile;?>

		            </div>

		        <?php endif;?>

		    </div>
        </div>

    </main>

<?php get_footer();?>