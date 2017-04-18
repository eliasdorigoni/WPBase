<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width">
    <!--[if lt IE 9]>
    <script src="<?php echo ASSETS_JS_URI; ?>html5.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="<?php echo THEME_URI ?>favicon.ico" type="image/x-icon" />
    <link rel="icon" href="<?php echo THEME_URI ?>favicon.ico" type="image/x-icon" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php if (false != ($ua = get_option('google-analytics', false))): ?>
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
    <?php SVG::mostrarSprite() ?>
    <header class="header">
        <div class="row">
            <div class="column large-4">
                <a class="logo" href="<?php echo HOME_URL; ?>" title="<?php echo bloginfo('name'); ?>">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php elseif (is_file(ASSETS_IMG_DIR . 'logo.jpg')): ?>
                    <img src="<?php echo ASSETS_IMG_URI . 'logo.jpg'; ?>">
                <?php else: ?>
                    <?php echo bloginfo('name'); ?>
                <?php endif ?>
                </a>
            </div>
            <div class="column large-8">
                <?php if (has_nav_menu('principal')): ?>
                    <button class="toggle toggleNavCabecera">Menú</button>
                <nav role="navigation">
                <?php
                    $args = array(
                        'menu_class'     => 'nav-cabecera',
                        'theme_location' => 'principal',
                    );
                    wp_nav_menu($args);
                ?>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </header>
