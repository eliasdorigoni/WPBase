<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width">
    <!--[if lt IE 9]>
    <script src="<?php echo ASSETS_URI_JS; ?>vendor/html5.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="<?php echo THEME_URI ?>favicon.ico" type="image/x-icon" />
    <link rel="icon" href="<?php echo THEME_URI ?>favicon.ico" type="image/x-icon" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php do_action('pre_header'); ?>
    <a class="skip-link screen-reader-text" href="#contenido">Ir al contenido</a>

    <header class="header">
        <div class="row">
            <div class="column large-4">
                <a class="logo" href="<?php echo HOME_URL; ?>" title="<?php echo bloginfo('name'); ?>">
                    <img srcset="<?= ASSETS_URI_IMG ?>logo.png 1x, <?= ASSETS_URI_IMG ?>logo@2x.png 2x" src="<?= ASSETS_URI_IMG ?>logo.png">
                </a>
            </div>
            <div class="column large-8">
                <?php if (has_nav_menu('principal')): ?>
                    <button class="toggle toggle-navegacion-principal"><i class="icono"></i> Menú</button>
                <?php
                    wp_nav_menu(array(
                        'container'       => 'nav',
                        'container_class' => 'wrapper-navegacion-principal',
                        'menu_class'      => 'navegacion-principal',
                        'theme_location'  => 'principal',
                    ));
                ?>
                <?php endif; ?>
            </div>
        </div>
    </header>
