<?php get_header(); ?>

<div class="row">
    <div class="column large-8">
        <main role="main" class="main">

            <header class="header-main">
                <h1 class="titulo-pagina">Resultados de búsqueda de: <?php echo get_search_query(); ?></h1>
            </header>

            <?php if (have_posts()): ?>
                <?php while (have_posts()): the_post(); ?>

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
                <?php endwhile ?>

            <?php the_posts_pagination(array(
                'prev_text'          => '&lt; Anterior',
                'next_text'          => 'Siguiente &gt;',
                'before_page_number' => '<span class="meta-nav screen-reader-text">Pagina</span> ',
                )); ?>

        <?php else: ?>

            <p>Sin resultados.</p>

        <?php endif; ?>

        </main>
    </div>
</div>

<?php get_footer(); ?>
