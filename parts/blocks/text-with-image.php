<?php

$placement = get_sub_field('text_placement');
$two_images = get_sub_field('two_images');
$bg = get_sub_field('background');

$im = get_sub_field('image');
$im2 = get_sub_field('image_second');

?>


<div class="padding-wrap">
    <div class="<?= $bg?'bg-box':'';?> bg-box--with-padding">
        <div class="container-sm">
            <div class="ergonomics ergonomics--second <?= $placement?'ergonomics--revers':'';?>">
                <div class="ergonomics__inner">
                    <div class="ergonomics__body">
                        <div class="ergonomics__col-1">
                            <h3 class="ergonomics__title"><?php the_sub_field('title');?></h3>
                            <div class="ergonomics__text text-content"><?php the_sub_field('text');?></div>
                        </div>
                        <div class="ergonomics__col-2">

                            <?php if(!$two_images):?>

                                <div class="ergonomics__img ibg">
                                    <img src="<?= $im['url'];?>" alt="<?= $im['alt'];?>">
                                </div>

                            <?php else:?>

                                <div class="ergonomics__images">
                                    <div class="ergonomics__img-1 ibg">
                                        <img src="<?= $im['url'];?>" alt="<?= $im['alt'];?>">
                                    </div>
                                    <div class="ergonomics__img-2 ibg">
                                        <img src="<?= $im2['url'];?>" alt="<?= $im2['alt'];?>">
                                    </div>
                                </div>

                            <?php endif;?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>