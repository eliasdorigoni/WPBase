<article <?php post_class(); ?>>
    <h1 class="titulo-entrada"><?php the_title(); ?></h1>
    <div class="contenido-entrada">
        <?php the_content(); ?>
        <?php
            wp_link_pages( array(
                'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfifteen' ) . '</span>',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
                'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>%',
                'separator'   => '<span class="screen-reader-text">, </span>',
            ) );
        ?>
    </div>
    <?php
        edit_post_link(
            sprintf(
                'Editar <span class="screen-reader-text">"%s"</span>',
                get_the_title()
            ),
            '<footer class="metadatos"><span class="edit-link">',
            '</span></footer>'
        );
    ?>

</article>
