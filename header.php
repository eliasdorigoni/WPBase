<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <!--[if lt IE 9]>
    <script src="<?php echo esc_url(THEME_URI); ?>/js/html5.js"></script>
    <![endif]-->
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header class="container">
        <div class="row">
            <div class="column large-6">
                <a href="<?php echo HOME_URL; ?>">WWW</a>
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
    <section class="site-content">
