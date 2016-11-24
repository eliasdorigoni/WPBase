<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width">
    <!--[if lt IE 9]>
    <script src="<?php echo THEME_URI; ?>/js/html5.js"></script>
    <![endif]-->
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php if (false != ($ua = get_option('google_analytics', false))): ?>
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', '<?php echo $ua ?>', 'auto');
          ga('send', 'pageview');

        </script>
    <?php endif ?>
    <a class="skip-link screen-reader-text" href="#content">Ir al contenido</a>
    <header class="header">
        <div class="row">
            <div class="column large-6">
                <a href="<?php echo HOME_URL; ?>" title="<?php echo bloginfo('name'); ?>">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php else: ?>
                    <?php echo bloginfo('name'); ?>
                <?php endif ?>
                </a>
            </div>
            <div class="column large-6">
                <?php if (has_nav_menu('principal')): ?>
                <nav role="navigation">
                <?php
                    $args = array(
                        'menu_class'     => 'nav-menu',
                        'theme_location' => 'principal',
                    );
                    wp_nav_menu($args);
                ?>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </header>
