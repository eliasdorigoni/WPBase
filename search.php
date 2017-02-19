<?php get_header(); ?>

<div class="row">
    <div class="column large-8">
        <main role="main" class="main">

            <header class="header-main">
                <h1 class="titulo-pagina">Resultados de búsqueda de: <?php echo get_search_query(); ?></h1>
            </header>

            <?php if (have_posts()): ?>
                <?php while (have_posts()): the_post(); ?>

                <?php get_template_part('templates/contenido', 'busqueda'); ?>

                <?php endwhile ?>

            <?php the_posts_pagination(array(
                'prev_text'          => '&lt; Anterior',
                'next_text'          => 'Siguiente &gt;',
                'before_page_number' => '<span class="meta-nav screen-reader-text">Pagina</span> ',
                )); ?>

        <?php else: ?>

            <?php get_template_part( 'templates/contenido', 'vacio' ); ?>

        <?php endif; ?>

        </main>
    </div>
</div>

<?php get_footer(); ?>
