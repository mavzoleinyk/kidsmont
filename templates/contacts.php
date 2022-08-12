<?php

/*

Template Name: Contact Page

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
<?php //the_content('');?>
				 </div>
        </div>
       <!-- --> <div class="contact padding-wrap pt-0">
            <div class="container-sm">
                <div class="main-table">
                    <div class="main-table__tr">
                        <div class="main-table__td">
                            <h4 class="main-table__title"><?php the_field('title');?></h4>
                        </div>
                        <div class="main-table__td text-content">
                        	<?php if( have_rows('information') ):

                        		while ( have_rows('information') ) : the_row();?>

        							<h5><?php the_sub_field('title');?></h5>
        							<?php if(get_sub_field('list')):?>

        								<table class="contact-tabel">
        									<?php foreach (get_sub_field('list') as $li):?>
				                                <tr>
				                                    <td><?= $li['label'];?></td>
				                                    <td><?= $li['text'];?></td>
				                                </tr>
				                            <?php endforeach;?>
		                            	</table>

		                            <?php endif;

							    endwhile;

							endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="contact-banner padding-wrap">
            <div class="contact-banner__inner">
                <div class="container-sm">
                    <div class="contact-banner__body">
                        <div class="contact-banner__col-1">
                            <h3 class="contact-banner__title">
                                <?php the_field('title_1');?>
                            </h3>
                            <h4 class="contact-banner__subtitle"><?php the_field('subtitle');?></h4>
                            <?php $imd = get_field('icon_animation');?>
                            <?php $imb = get_field('image_banner');?>
                            <div class="contact-banner__decor">
                                <img src="<?= $imd['url'];?>" alt="<?= $imd['alt'];?>">
                            </div>
                        </div>
                        <div class="contact-banner__col-2">
                            <div class="contact-banner__img ibg">
                                <img src="<?= $imb['url'];?>" alt="<?= $imb['alt'];?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- -->

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