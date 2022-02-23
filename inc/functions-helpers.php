<?php

use Elementor\Plugin;

if (! defined('ABSPATH')) {
    exit; // Direct access not allowed.
}

if (! function_exists('hello_block_get_html_block')) {
    /**
     * Retrieve content
     *
     * @since 1.0.0
     * @param [type] $id
     * @return void
     */
    function hello_block_get_html_block($id)
    {
        $id = apply_filters('wpml_object_id', $id, 'hello_block', true);
        $post = get_post($id);
        $content = '';

        if (! $post || $post->post_type != 'hello_block' || ! $id) {
            return;
        }

        if (hello_block_is_elementor_installed() && Plugin::$instance->documents->get($id)->is_built_with_elementor()) {
            $content .= hello_block_elementor_get_content_css($id);
            $content .= hello_block_elementor_get_content($id);
        } else {
            $content .= do_shortcode($post->post_content);
        }

        return $content;
    }
}

if (! function_exists('hello_block_elementor_get_content_css')) {
    /**
     * Retrieve Elementor builder content css.
     *
     * @since 1.0.0
     *
     * @param integer $id The post ID.
     *
     * @return string
     */
    function hello_block_elementor_get_content_css($id)
    {
        $post = new Elementor\Core\Files\CSS\Post($id);
        $meta = $post->get_meta();

        ob_start();

        if ($post::CSS_STATUS_FILE === $meta['status'] && apply_filters('hello_block_elementor_content_file_css', true)) {
            ?>
			<link rel="stylesheet" id="elementor-post-<?php echo esc_attr($id); ?>-css" href="<?php echo esc_url($post->get_url()); ?>" type="text/css" media="all">
			<?php
        } else {
            echo '<style>' . $post->get_content() . '</style>';
            Plugin::$instance->frontend->print_fonts_links();
        }

        return ob_get_clean();
    }
}


if (! function_exists('hello_block_elementor_get_content')) {
    /**
     * Retrieve builder content for display.
     *
     * @since 1.0.0
     *
     * @param integer $id The post ID.
     *
     * @return string
     */
    function hello_block_elementor_get_content($id)
    {
        ob_start();

        echo Plugin::$instance->frontend->get_builder_content_for_display($id);

        wp_deregister_style('elementor-post-' . $id);
        wp_dequeue_style('elementor-post-' . $id);

        return ob_get_clean();
    }
}
