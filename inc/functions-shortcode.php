<?php

if (! defined('ABSPATH')) {
    exit; // Direct access not allowed.
}


if (! function_exists('hello_block_is_elementor_installed')) {
    /**
     * Check if Elementor is activated
     * @since 1.0.0
     * @return boolean
     */
    function hello_block_is_elementor_installed()
    {
        return did_action('elementor/loaded');
    }
}

add_shortcode('hello_block', 'hello_block_shortcode');

if (! function_exists('hello_block_shortcode')) {
    /**
     * Allow to use ShortCode. For Example: [hello_block id="$id"]
     *
     * @param [type] $atts
     * @return void
     */
    function hello_block_shortcode($atts)
    {
        extract(
            shortcode_atts(
                array(
                    'id' => 0,
                ),
                $atts
            )
        );

        return hello_block_get_html_block($id);
    }
}
