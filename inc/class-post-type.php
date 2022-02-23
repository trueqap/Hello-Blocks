<?php
/**
 * Post types file.
 *
 * @package HelloBlocks
 */

namespace HELLOBLOCKS;

if (! defined('ABSPATH')) {
    exit; // Direct access not allowed.
}

/**
 * Hello Blocks Post types class.
 */
class Hello_Blocks_Post_Types
{
    /**
     * Instance.
     *
     * @var null
     */
    public static $instance = null;

    /**
     * Instance.
     *
     * @return Post_Types|null
     */
    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        add_action('init', array( $this, 'register_hello_block_post_type' ), 10);
        // Add shortcode column to block list
        add_filter('manage_edit-hello_block_columns', array( $this, 'edit_hello_blocks_columns' ));
        add_action('manage_hello_block_posts_custom_column', array( $this, 'manage_hello_blocks_columns' ), 10, 2);
    }

    public function register_hello_block_post_type()
    {
        $labels = array(
            'name'               => esc_html__('Hello Blocks', 'hello-blocks'),
            'singular_name'      => esc_html__('Hello Block', 'hello-blocks'),
            'menu_name'          => esc_html__('Hello Blocks', 'hello-blocks'),
            'parent_item_colon'  => esc_html__('Parent Item:', 'hello-blocks'),
            'all_items'          => esc_html__('All Items', 'hello-blocks'),
            'view_item'          => esc_html__('View Item', 'hello-blocks'),
            'add_new_item'       => esc_html__('Add New Item', 'hello-blocks'),
            'add_new'            => esc_html__('Add New', 'hello-blocks'),
            'edit_item'          => esc_html__('Edit Item', 'hello-blocks'),
            'update_item'        => esc_html__('Update Item', 'hello-blocks'),
            'search_items'       => esc_html__('Search Item', 'hello-blocks'),
            'not_found'          => esc_html__('Not found', 'hello-blocks'),
            'not_found_in_trash' => esc_html__('Not found in Trash', 'hello-blocks'),
        );

        $args = array(
            'label'               => esc_html__('hello_block', 'hello-blocks'),
            'description'         => esc_html__('Use HTML or Visual Editor content anywhere as Shortcode', 'hello-blocks'),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor' ),
            'hierarchical'        => false,
            'public'              => true,
            'publicly_queryable'  => is_user_logged_in(),
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 29,
            'menu_icon'           => 'dashicons-layout',
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'rewrite'             => false,
            'capability_type'     => 'page',
        );

        register_post_type('hello_block', $args);

        $labels = array(
            'name'                  => esc_html__('Hello Block categories', 'hello-blocks'),
            'singular_name'         => esc_html__('Hello Block category', 'hello-blocks'),
            'search_items'          => esc_html__('Search categories', 'hello-blocks'),
            'popular_items'         => esc_html__('Popular categories', 'hello-blocks'),
            'all_items'             => esc_html__('All categories', 'hello-blocks'),
            'parent_item'           => esc_html__('Parent category', 'hello-blocks'),
            'parent_item_colon'     => esc_html__('Parent category', 'hello-blocks'),
            'edit_item'             => esc_html__('Edit category', 'hello-blocks'),
            'update_item'           => esc_html__('Update category', 'hello-blocks'),
            'add_new_item'          => esc_html__('Add New category', 'hello-blocks'),
            'new_item_name'         => esc_html__('New category', 'hello-blocks'),
            'add_or_remove_items'   => esc_html__('Add or remove categories', 'hello-blocks'),
            'choose_from_most_used' => esc_html__('Choose from most used', 'hello-blocks'),
            'menu_name'             => esc_html__('Category', 'hello-blocks'),
        );

        $args = array(
            'labels'            => $labels,
            'public'            => true,
            'show_in_nav_menus' => true,
            'show_admin_column' => false,
            'hierarchical'      => true,
            'show_tagcloud'     => true,
            'show_ui'           => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'hello_block_cat' ),
            'capabilities'      => array(),
            'show_in_rest'      => true,
        );

        register_taxonomy('hello_block_cat', array( 'hello_block' ), $args);
    }

    /**
     * Add New Columns for Hello Blocks
     *
     * @param [type] $columns
     * @return void
     */
    public function edit_hello_blocks_columns($columns)
    {
        unset($columns['date']);

        $new_columns = array(
            'shortcode'     => esc_html__('Shortcode', 'hello-blocks'),
            'wd_categories' => esc_html__('Categories', 'hello-blocks'),
            'date'          => esc_html__('Date', 'hello-blocks'),
        );

        $columns = $columns + $new_columns;
        return $columns;
    }

    /**
     * Add content to columns
     *
     * @param [type] $column
     * @param [type] $post_id
     * @return void
     */
    public function manage_hello_blocks_columns($column, $post_id)
    {
        switch ($column) {
            case 'shortcode':
                echo '<strong>[hello_block id="' . $post_id . '"]</strong>';
                break;
            case 'wd_categories':
                $terms     = wp_get_post_terms($post_id, 'hello_block_cat');
                $post_type = get_post_type($post_id);
                $keys      = array_keys($terms);
                $last_key  = end($keys);

                if (! $terms) {
                    echo '—';
                }

                foreach ($terms as $key => $term) :
                $name = $term->name;

                if ($key !== $last_key) {
                    $name .= ',';
                }

                ?>

				<a href="<?php echo esc_url('edit.php?post_type=' . $post_type . '&hello_block_cat=' . $term->slug); ?>">
					<?php echo esc_html($name); ?>
				</a>
			<?php endforeach;
                break;
        }
    }
}

Hello_Blocks_Post_Types::get_instance();
