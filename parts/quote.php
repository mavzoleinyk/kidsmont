<?php
/**
 * Blockquote
 *

**/

$text = get_field( 'text' );
$img = get_field('author_image');
$name = get_field( 'author_name' );
$position = get_field('author_position');

?>
     
    <div class="quote">
        <?php if(isset($text)):?>
            <div class="quote__icon">
                <img src="<?= get_template_directory_uri();?>/img/icons/quote.svg" alt="quote">
            </div>
            <div class="quote__text"><?= $text;?></div>
        <?php endif;?>
        <div class="quote__author">
            <?php if(isset($img)):?>
                <div class="quote__author-img ibg">
                    <img src="<?= $img['url'];?>" alt="<?= $img['alt'];?>">
                </div>
            <?php endif;?>
            <div class="quote__author-inner">
                <?php if(isset($name)):?>
                    <div class="quote__author-name"><?= $name;?></div>
                <?php endif;?>
                <?php if(isset($position)):?>
                    <div class="quote__author-position"><?= $position;?></div>
                 <?php endif;?>
             </div>
         </div>
     </div>