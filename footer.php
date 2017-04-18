    <?php
        edit_post_link(
            sprintf(
                'Editar "%s"', get_the_title()
                ),
                '<section><div class="row"><div class="column"><span class="editar-post">',
                '</span></div></div></section>'
            );
    ?>
	<footer class="footer">
        <div class="row">
            <div class="column">
                <p><?php echo bloginfo('name'); ?><br><?php echo date('Y') ?></p>
            </div>
        </div>
	</footer>
    <?php wp_footer(); ?>
</body>
</html>
