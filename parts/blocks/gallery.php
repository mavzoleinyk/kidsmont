<?php 

$option = get_sub_field('option');
$gallery = get_sub_field('gallery');

?>

<div class="padding-wrap">
    <div class="container-sm">

        <?php if($option == 'Option 1'):?>

            <div class="gallery">

        <?php elseif($option == 'Option 2'):?>
             
            <div class="gallery gallery--second">

        <?php elseif($option == 'Option 3'):?>

            <div class="gallery gallery--third">
                            
        <?php endif;?>

            <?php foreach ($gallery as $gal):?>

                <div class="gallery__item">
                    <div class="gallery__img ibg">
                        <img src="<?= $gal['url'];?>" alt="<?= $gal['alt'];?>">
                    </div>
                </div>

            <?php endforeach;?>

        </div>

    </div>
</div>