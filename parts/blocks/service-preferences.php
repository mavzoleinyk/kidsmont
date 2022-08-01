<?php 

$list = get_sub_field('list');

?>

<div class="padding-wrap">
    <div class="container-sm">
        <div class="banner">
            <div class="banner__col-2">
                <div class="banner__column">
                    <div class="banner__text text-content">
                        <h3><?php the_sub_field('title');?></h3>
                        <p><?php the_sub_field('description');?></p>
                    </div>
                </div>
                <div class="banner__column">
                    <div class="preferences preferences--fourth">

                        <?php if(!empty($list)):?>

                            <ul class="preferences__list">

                                <?php foreach ($list as $li):?>

                                    <li>
                                        <div class="preferences__item-icon">
                                            <img src="<?= $li['icon']['url'];?>" alt="<?= $li['icon']['alt'];?>">
                                        </div>
                                        <div class="preferences__item-title"><?= $li['text'];?></div>
                                    </li>

                                <?php endforeach;?>

                            </ul>

                        <?php endif;?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>