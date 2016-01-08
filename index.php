<?php get_header(); ?>
    <main class="site-main column large-8" role="main">
        <?php if ( have_posts() ) : ?>
            <?php if ( is_home() && ! is_front_page() ) : ?>
                <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
            <?php endif; ?>
            <?php
            while (have_posts()) : the_post();
                get_template_part( 'contenido', get_post_format() );
            endwhile;

            the_posts_pagination(array(
                'prev_text'          => 'Pagina anterior',
                'next_text'          => 'Pagina siguiente',
                'before_page_number' => '<span class="meta-nav screen-reader-text">Pagina </span>',
            ));
        else :
            get_template_part( 'contenido', 'none' );
        endif;
        ?>
    </main>
    <?php 
get_sidebar();
get_footer();
