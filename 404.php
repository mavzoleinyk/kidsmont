<?php get_header();?>

    <main class="_page " data-padding-top-header-size data-scroll-section>
        <div class="message padding-wrap" data-set-full-height>
            <div class="container-sm">
                <div class="message__body">
                    <h2 class="message__title text-center">
                        <span class="d-block text-success"><?php the_field('title_404', 'options');?></span>
                        <?php the_field('subtitle_404', 'options');?>
                    </h2>
                    <div class="message__text text-center">
                        <p><?php the_field('text_404', 'options');?></p>
                    </div>
                    <div class="message__search">
                        <form action="/">
                            <div class="faq__search">
                                <button type="submit" class="faq__search-submit">
                                    <img class="img-svg" src="<?= get_template_directory_uri();?>/img/icons/search.svg" alt="">
                                </button>
                                <input class="faq__search-input" type="text" placeholder="Geben Sie den zu suchenden Text ein...">
                            </div>
                        </form>
                        <a href="#" class="message__search-mob-btn btn-default" data-action="show-main-search">Produktsuche</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php get_footer();?>