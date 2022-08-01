<?php 

$list = get_sub_field('reviews_list');
$link = get_sub_field('link');

?>

<div class="padding-wrap">
	<div class="container-sm">
		<div class="main-table main-table--third">
			<div class="main-table__tr">
				<div class="main-table__td">
					<h3 class="main-table__title"><?php the_sub_field('title');?></h3>
				</div>
				<div class="main-table__td">
					<div class="reviews reviews--has-list">

						<?php if( $list ): ?>
    
                            <ul class="reviews__list">

                                <?php foreach ($list as $post): setup_postdata($post); ?>
                                        
                                    <li>
                                    	<div class="reviews__list-text text-content"><?php the_field('text_reviews');?></div>
                                    	<div class="reviews__list-meta">
                                    		<div class="reviews__list-author"><?php the_title();?></div>
                                    		<div class="reviews__list-date"><?= meks_time_ago();?></div>
                                    	</div>
                                    </li>
                                
                                <?php endforeach;
                                wp_reset_postdata();?>

                            </ul>

                        <?php endif;?>

                        <div class="reviews__bottom">

                        	<?php if( $link ): 
								$link_url = $link['url'];
								$link_title = $link['title'];
								$link_target = $link['target'] ? $link['target'] : '_self';
								?>
								<a class="btn-with-arrow not-hover" href="<?= esc_url($link_url); ?>" target="<?= esc_attr($link_target); ?>"><?= esc_html($link_title); ?><span><img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/arrow-right.svg" alt=""></span></a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>