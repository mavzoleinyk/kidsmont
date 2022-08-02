<?php 

$cats = get_sub_field('list_category');

?>

<div class="padding-wrap">
    <div class="faq">
        <div class="container-sm" data-tabs="has-outside-navigation" data-tabs-sub>
            
                <div class="faq__body tabs" >
                    <div class="tabs__col-1">
                        <div class="tabs__nav">
                            <div class="tabs__nav-list swiper d-none d-md-block" data-tabs-nav data-mobile="false">
                                <div class="swiper-wrapper">
                                    <?php $i=0;
                                    foreach ($cats as $cat2):

                                        $cat = $cat2['faqs_category'][0];?>
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

                        foreach ($cats as $cat2):
                            $cat = $cat2['faqs_category'][0];?>

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
</div>