<a href="<?php the_permalink();?>" class="post-card not-hover">
    <div class="post-card__img ibg">
        <img src="<?php the_post_thumbnail_url();?>" alt="">
    </div>
    <div class="post-card__date"><?php the_time('d.m.Y');?></div>
    <div class="post-card__title"><?php the_title();?></div>
    <div class="post-card__text text-content">
        <?php the_excerpt();?>
    </div>
</a>