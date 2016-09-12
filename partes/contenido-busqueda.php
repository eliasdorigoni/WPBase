<article <?php post_class(); ?>>
    <header class="header-entrada">
        <h2 class="titulo-entrada"><a href="<?php esc_url(get_permalink()); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
    </header>

    <?php if (has_post_thumbnail()): ?>
        <?php the_post_thumbnail('thumbnail'); ?>
    <?php endif ?>

    <?php the_excerpt(); ?>

    <footer class="footer-entrada">
        <?php
            edit_post_link(
                sprintf(
                    'Editar <span class="screen-reader-text">"%s"</span>',
                    get_the_title()
                    ),
                '<span class="edit-link">',
                '</span>'
                );
        ?>
    </footer>
</article><!-- #post-## -->

