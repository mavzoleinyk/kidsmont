<?php 

$im = get_sub_field('image');
$iml = get_sub_field('image_left');
$imr = get_sub_field('image_right');

?>

<div class="padding-wrap">
    <div class="container-sm">
        <div class="about about--second">
            <div class="about__body ">
                <div class="about__top-banner">
                    <div class="img-full-width">
                        <img src="<?= $im['url'];?>" alt="<?= $im['alt'];?>">
                    </div>
                </div>
                <div class="about__big-text">
                    <?php the_sub_field('title');?>
                </div>
                <div class="about__content about__content--col-2">
                    <div class="about__content-col-1">
                        <div class="about__content-col-1-img">
                            <img src="<?= $iml['url'];?>" alt="<?= $iml['alt'];?>">
                        </div>
                    </div>
                    <div class="about__content-col-2">
                        <div class="about__text-wrap text-content">
                            <?php the_sub_field('text');?>
                        </div>
                        <div class="img-full-width">
                            <img src="<?= $imr['url'];?>" alt="<?= $imr['alt'];?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>