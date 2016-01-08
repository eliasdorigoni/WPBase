<?php get_header(); ?>
    <main class="site-main column" role="main">
        <section class="error-404 not-found">
            <h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'twentyfifteen' ); ?></h1>
            <div class="page-content">
                <p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'twentyfifteen' ); ?></p>
                <?php get_search_form(); ?>
            </div>
        </section>
    </main>
<?php get_footer(); ?>
