<?php get_header(); ?>

<div class="row">
    <div class="column large-8">
        <main role="main" class="<?php post_class() ?>">
            <?php if (have_posts()): ?>
                <?php while (have_posts()) : the_post(); ?>

                    <?php if (!is_front_page()) : ?>
                        <h1 class="titulo-pagina"><?php the_title(); ?></h1>
                    <?php endif; ?>

                    <?php the_content(); ?>

                <?php endwhile; ?>

                <?php if (comments_open() || get_comments_number()) comments_template(); ?>

                <?php the_posts_pagination(array(
                    'prev_text' => '&lt; Anterior',
                    'next_text' => 'Siguiente &gt;',
                    'before_page_number' => '<span class="meta-nav screen-reader-text">Pagina </span>',
                )); ?>

            <?php else: // !have_posts() ?>

                <p>Sin contenido.</p>

            <?php endif; ?>

            <?php get_template_part('demo'); ?>

        </main>
    </div>
    <div class="column large-4">
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
