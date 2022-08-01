<?php 

$list = get_sub_field('list');

?>

<div class="padding-wrap">
    <div class="container-sm">
        <div class="preferences">
            <h3 class="preferences__title"><?php the_sub_field('title');?></h3>
            <ul class="preferences__list">

                <?php foreach ($list as $li):?>

                    <li>
                        <div class="preferences__item-icon">
                            <img src="<?= $li['icon']['url'];?>" alt="<?= $li['icon']['alt'];?>">
                        </div>
                        <div class="preferences__item-title"><?= $li['title'];?>
                        </div>
                    </li>

                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>