<?php 
// Documentación Google Maps: https://developers.google.com/maps/?hl=es-419
namespace Mapa;

if (!defined('\ABSPATH')) exit;

require_once 'enqueue.php';
add_action('init', '\Mapa\enqueue');

require_once 'shortcode.php';
add_shortcode('mapa', '\Mapa\retornarMapa');
add_shortcode('marcador', '\Mapa\retornarMarcador');
