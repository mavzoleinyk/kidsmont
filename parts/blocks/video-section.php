<?php 

$video = get_sub_field('video');
$im = get_sub_field('placeholder');

?>

<div class="padding-wrap">
    <div class="container-sm">
        <div class="video-wrap video-wrap--second">
            <a href="<?= $video['url'];?>" data-fancybox class="video not-hover">

                <?php if($im):?>

                    <div class="video__poster ibg">
                        <img src="<?= $im['url'];?>" alt="<?= $im['alt'];?>">
                    </div>

                <?php endif;?>

                <div class="video__btn">
                    <div class="btn">
                        <div class="btn__text-decor">
                            <img class="img-svg" src="<?= get_template_directory_uri();?>/img/photo/play-text.svg" alt="play">
                        </div>
                        <div class="btn__text">Play</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>