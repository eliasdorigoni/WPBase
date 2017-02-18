<?php get_header(); ?>

<div class="row">
    <div class="column large-8">
        <main role="main" class="main">
            <?php if (have_posts()) : ?>

                <?php if (!is_front_page()) : ?>
                    <header class="header-main">
                        <h1 class="titulo-pagina"><?php single_post_title(); ?></h1>
                    </header>
                <?php endif; ?>

                <?php while (have_posts()) : the_post(); ?>
                    <?php the_content(); ?>
                    <hr>
                    <?php get_template_part('demo'); ?>
                <?php endwhile; ?>

                <?php if (comments_open() || get_comments_number()): ?>
                    <?php comments_template(); ?>
                <?php endif; ?> 

                <?php the_posts_pagination(array(
                    'prev_text' => '&lt; Anterior',
                    'next_text' => 'Siguiente &gt;',
                    'before_page_number' => '<span class="meta-nav screen-reader-text">Pagina </span>',
                )); ?>

            <?php else: // !have_posts() ?>

                <p>Sin contenido.</p>

            <?php endif; ?>

        </main>
    </div>
    <div class="column large-4">
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
