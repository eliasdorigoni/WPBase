<?php
/*
Plugin Name: WPBase
Plugin URI: http://eliasdorigoni.com
Description: Plugin!
Author: Elias Dorigoni
Version: 0.1
Author URI: http://eliasdorigoni.com
*/

define('WPBASE_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));

require_once(WPBASE_PLUGIN_DIR_PATH . 'shortcodes.php');
require_once(WPBASE_PLUGIN_DIR_PATH . 'galeria/metabox-galeria.php');
require_once(WPBASE_PLUGIN_DIR_PATH . 'customizer/index.php');
