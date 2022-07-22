<?php
/**
 * Video Custom
 *

**/

$video = get_field( 'video' );
$img = get_field('video_poster');

if(isset($video)):

?>
     
    <div class="video-wrap">
        <a href="<?= $video['url'];?>" data-fancybox class="video not-hover">
            <div class="video__poster ibg">
                <?php if(isset($img)):?>
                    <img src="<?= $img['url'];?>" alt="<?= $img['alt'];?>">
                <?php endif;?>
            </div>
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
<?php endif;?>