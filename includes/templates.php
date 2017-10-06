<?php
if (!defined('ABSPATH')) exit;

function registrarRewriteTemplate() {
    add_rewrite_rule('demo/?', 'index.php?template=demo', 'top' );
}
add_action('init', 'registrarRewriteTemplate');

function registrarQueryVarTemplate($vars) {
    $vars[] = 'template';
    return $vars;
}
add_filter('query_vars', 'registrarQueryVarTemplate');

function redireccionarTemplates() {
    $template = get_query_var('template');
    if ($template && $template === 'demo') {
        add_filter('template_include', function() {
            return THEME_DIR . 'templates/demo.php';
        });
    }
}
add_action('template_redirect', 'redireccionarTemplates');
