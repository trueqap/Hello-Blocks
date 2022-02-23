<?php
/*
* Plugin Name: Hello Blocks
* Plugin URI:  https://github.com/trueqap/Hello-Blocks
* Description: Use HTML or Visual Editor content anywhere as Shortcode
* Version:     1.0.0
* Author:      trueqap
* Author URI:  https://github.com/trueqap/Hello-Blocks
* Text Domain: hello-blocks
* License:     GPL-2.0
* License URI: http://www.gnu.org/licenses/gpl-2.0.txt
* Domain Path: /languages
*/

if (! defined('ABSPATH')) {
    exit; // Direct access not allowed.
}

define('HELLO_BLOCKS_VERSION', '1.0.0');
define('HELLO_BLOCKS_PATH', plugin_dir_path(__FILE__));

require_once 'inc/class-post-type.php';
require_once 'inc/functions-helpers.php';
require_once 'inc/functions-shortcode.php';


if (! function_exists('hello_blocks_lang')) {

    /**
     * Add langs
     *
     * @return void
     */
    function hello_blocks_lang()
    {
        load_plugin_textdomain('hello-blocks', false, basename(dirname(__FILE__)) . '/languages/');
    }
    add_action('plugins_loaded', 'hello_blocks_lang');
}
