    <?php
        edit_post_link(
            sprintf(
                'Editar "%s"', get_the_title()
                ),
                '<section class="editar-post"><div class="row column">',
                '</div></section>'
            );
    ?>
	<footer class="footer">
        <?php if (is_active_sidebar('footer')): ?>
            <div class="row large-up-3">
                <?php dynamic_sidebar('footer');?>
            </div>
        <?php endif ?>
        <div class="row">
            <div class="column">
                <p><?php echo bloginfo('name'); ?><br><?php echo date('Y') ?></p>
            </div>
        </div>
	</footer>
    <?php wp_footer(); ?>
</body>
</html>
