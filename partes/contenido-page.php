<article <?php post_class(); ?>>
    <h1 class="titulo-pagina"><?php the_title(); ?></h1>

    <div class="contenido-pagina">
        <?php the_content(); ?>
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
