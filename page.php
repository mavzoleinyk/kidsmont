<?php 

get_header(); 

if(is_cart()){
	$class = 'shopping-cart cart-wrap';
}elseif(is_checkout()){
	$class = 'checkout shopping-cart';
}


?>

    <main class="_page " data-padding-top-header-size data-scroll-section>

        <?php if ( is_checkout() || !empty( is_wc_endpoint_url('order-received') ) ):
            the_content();

        elseif(is_account_page() ):?>

            <div class="container-sm d-none d-lg-block">
                <?php if(function_exists('bcn_display')):?>
                    <ul class="breadcrumbs">
                         <?php bcn_display();?>   
                    </ul>
                <?php endif;?>
            </div>

            <div class="container-sm">
                <div class="head pt-4 pt-lg-0">
                    <h1 class="head__title d-flex align-items-center justify-content-between">
                        <?= get_the_title();?>

                        <div class="d-flex align-items-center justify-content-center justify-content-md-start"
                            data-da=".account__bottom-link,767.98,0">
                            <a href="<?= wp_logout_url( home_url() ); ?>" class="go-out-link">
                                Hinausgehen
                                <img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/go-out.svg" alt="">
                            </a>
                        </div>
                    </h1>
                </div>
            </div>

            <?php the_content();

        else:?>

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

            <div class="<?= $class;?> padding-wrap pt-0">
                <div class="container-sm">

                	<?php the_content();?>

                </div>
            </div>
        <?php endif;?>
	</main>


<?php get_footer();?>