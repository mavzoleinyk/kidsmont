<?php

/*

Template Name: Reklam Page

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

        <a href="#contact" class="fixed-btn" data-popup="open-popup" >
            <?php the_field('mobile_button');
            $mbi = get_field('mobile_button_icon');
            if($mbi):?>
                <span class="fixed-btn__icon">
                    <img src="<?= $mbi['url'];?>" alt="<?= $mbi['alt'];?>">
                </span>
            <?php endif;?>
        </a>

        <div class="container-sm">
            <div class="head pt-4 pt-lg-0">
                <h1 class="head__title"><?php the_title();?></h1>
            </div>
        </div>
		<div class="contact padding-wrap pt-0">
            <div class="container-sm">
<?php the_content('');?>
				 </div>
        </div>
      

        <div class="contact padding-wrap d-none d-md-block">
            <div class="container-sm">
                <div class="main-table border-top-0">
                    <div class="main-table__tr pt-0">
                        <div class="main-table__td">
                            <h4 class="main-table__title"><?php the_field('title_2');?></h4>
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