<?php 

$list = get_sub_field('list');
$image = get_sub_field('image');

?>

<div class="padding-wrap">
    <div class="container-sm">
        <h3 class="default-title-indent"><?php the_sub_field('title');?></h3>
    </div>
    <div class="bg-box">
        <div class="container-sm">
            <div class="banner banner--second">
                <div class="banner__col-2">

                    <div class="banner__column">

                        <?php if(!empty($list)):?>

                            <div class="banner__text text-content">

                                <?php foreach ($list as $li):?>
                    
                                    <div class="banner__text-row">
                                        <h4><?= $li['title'];?></h4>
                                        <p><?= $li['text'];?></p>
                                    </div>

                                <?php endforeach;?>

                            </div>

                        <?php endif;?>

                    </div>
                    <div class="banner__column">

                        <?php if($image):?>
                            <div class="banner__img ibg">
                                <img src="<?= $image['url'];?>" alt="<?= $image['alt'];?>">
                            </div>
                        <?php endif;?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>