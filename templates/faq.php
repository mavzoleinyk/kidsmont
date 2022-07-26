<?php

/*

Template Name: FAQ Page

*/

get_header();

$cats = get_terms('category_faq');

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


        <div class="faq padding-wrap pt-0">
            <div class="container-sm" data-tabs="has-outside-navigation">
                <div class="faq__head">
                    <form action="/">
                        <div class="faq__search" data-faq-search data-da="body,767.98,first">
                            <button type="submit" class="faq__search-submit">
                                <img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/search.svg" alt="">
                            </button>
                            <input class="faq__search-input" type="text" placeholder="Suchen" name="q">
                            <div class="main-search__close" data-action="hide-faq-search"><span></span></div>
                        </div>
                    </form>
                    <div class="search-result"></div>
                    <button class="faq__mob-search-btn" data-action="show-faq-search">
                        <img src="<?= get_template_directory_uri();?>/img/icons/search.svg" alt="">
                        Search
                    </button>
                    <button class="faq__mob-select" data-side-panel-open="faq-items">
                        <img src="<?= get_template_directory_uri();?>/img/icons/menu.svg" alt="">
                        Iteams
                    </button>
                </div>
                <div class="faq__body tabs" >
                    <div class="tabs__col-1">
                        <div class="tabs__nav">
                            <div class="tabs__nav-list swiper d-none d-md-block" data-tabs-nav data-mobile="false">
                                <div class="swiper-wrapper">
                                    <?php $i=0;
                                    foreach ($cats as $cat):?>
                                        <div class="swiper-slide">
                                            <a href="#" class="not-hover" data-tab-trigger="<?= $cat->term_id;?>" id="tab<?= $cat->term_id;?>"><?= $cat->name;?></a>
                                        </div>
                                    <?php $i++;

                                    endforeach;?>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="tabs__col-2">
                        <?php $l=0;

                        foreach ($cats as $cat):?>

                            <div class="tabs__content" data-tab-content="<?= $cat->term_id;?>">
                                <ul class="accordion" data-spoller>
                                    <?php $f = new WP_Query([
                                        'post_type' => 'faq',
                                        'posts_per_page' => -1,
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => 'category_faq',
                                                'field' => 'id',
                                                'terms' => $cat->term_id
                                            ),
                                        ),
                                    ]);

                                    while($f->have_posts()): $f->the_post();?>

                                        <li id="<?= 'faq_'.get_the_ID();?>">
                                            <div class="accordion__title" data-spoller-trigger>
                                                <?php the_title();?>
                                                <div class="accordion__icon">
                                                    <span></span>
                                                </div>
                                            </div>
                                            <div class="accordion__collapse text-content">
                                                <?php the_content();?>
                                            </div>
                                        </li>

                                    <?php endwhile;

                                    wp_reset_postdata();?>

                                </ul>
                            </div>

                        <?php $l++;

                        endforeach;?>
                    </div>
                </div>
            </div>
        </div>

    </main>

<?php get_footer();?>