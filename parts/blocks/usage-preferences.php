<?php 

$list = get_sub_field('list');
$i = 1;

?>

<div class="padding-wrap">
    <div class="container-sm">
        <div class="preferences preferences--third">
            <h3 class="preferences__title"><?php the_sub_field('title');?></h3>
            <ul class="preferences__list">

                <?php foreach ($list as $li):?>

                    <li>
                        <div class="preferences__item-img-wrap">
                            <div class="preferences__item-count">0<?= $i;?>.</div>
                            <div class="preferences__item-img">
                                <img src="<?= $li['image']['url'];?>" alt="<?= $li['image']['alt'];?>">
                            </div>
                            <div class="preferences__item-img-bg">
                                <img src="<?= get_template_directory_uri();?>/img/photo/preferences-img-bg.png" alt="">
                            </div>
                        </div>
                        <div class="preferences__item-title"><?= $li['title'];?></div>
                    </li>

                <?php $i++;
                
                endforeach;?>                
            </ul>
        </div>
    </div>
</div>