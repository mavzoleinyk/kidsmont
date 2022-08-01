<?php 

$list = get_sub_field('reviews_list');

?>
<div class="padding-wrap">
	<div class="container-sm">
		<div class="head pt-4 pt-lg-0">
			<h2 class="head__title"><?php the_sub_field('title');?></h2>
		</div>
	</div>
	<div class="container-sm">

		<?php if( $list ): ?>

			<ul class="reviews-list">

				<?php foreach ($list as $post): setup_postdata($post); 

					$images = get_field('gallery');

                    $c = count($images);?>

					<li>
						<div class="reviews-list-card">
							<div class="reviews-list-card__col-1">
								<div class="reviews-list-card__text text-content"><?php the_field('text_reviews');?></div>
							    <div class="reviews-list-card__author"><?php the_title();?></div>
							</div>
							<div class="reviews-list-card__col-2">
								<?php if( $c > 1 ):?>
							            
							        <div class="reviews-list-card__slider swiper" data-reviews-list-card-slider>
							            <button class="reviews-list-card__btn reviews-list-card__btn--next">Next</button>
							            <div class="swiper-wrapper">
							                <?php foreach( $images as $im ): ?>
							                    <div class="swiper-slide ibg">
							                    	<img src="<?= $im['url'];?>" alt="<?= $im['alt'];?>">
							                    </div>
							                <?php endforeach;?>
							            </div>
							        </div>

							    <?php else:?>

							        <div class="reviews-list-card__img ibg">
							            <?php foreach( $images as $im ): ?>
							            	<img src="<?= $im['url'];?>" alt="<?= $im['alt'];?>">
							            <?php endforeach;?>
							        </div>
							    <?php endif;?>
							</div>
						</div>

					</li>

				<?php endforeach;
				wp_reset_postdata();?>

			</ul>

		<?php endif;?>
	<div>
</div></div></div>