<?php 

$video = get_sub_field('video');
$im = get_sub_field('placeholder');

?>

<div class="padding-wrap">
    <div class="bg-box">
        <div class="container-sm">
            <div class="contact-banner">
                <div class="contact-banner__inner">
                    <div class="contact-banner__body">
                        <div class="contact-banner__col-1">
                            <h3 class="contact-banner__title"><?php the_sub_field('title');?></h3>
                            <h4 class="contact-banner__subtitle"><?php the_sub_field('subtitle');?></h4>
                        </div>
                        <div class="contact-banner__col-2">
                            <div class="contact-banner__video">
                                <div class="video-wrap ">
                                    <a href="<?= $video['url'];?>" data-fancybox
                                                        class="video not-hover">
                                        <?php if($im):?>

                                            <div class="video__poster ibg">
                                                <img src="<?= $im['url'];?>" alt="<?= $im['alt'];?>">
                                            </div>

                                        <?php endif;?>

                                        <div class="video__btn">
                                            <div class="btn">
                                                <div class="btn__text-decor">
                                                    <img class="img-svg" src="<?= get_template_directory_uri();?>/img/photo/play-text.svg" alt="">
                                                </div>
                                                <div class="btn__text">Play</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>