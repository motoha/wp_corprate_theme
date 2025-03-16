<?php
// Add theme support

 
// Enqueue Tailwind CSS and scripts
function my_starter_theme_assets() {
    wp_enqueue_style('my-starter-theme-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));
    wp_enqueue_script('my-starter-theme-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'my_starter_theme_assets');

function my_starter_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'my-starter-theme'),
    ));
}
add_action('after_setup_theme', 'my_starter_theme_setup');
function enqueue_swiper_scripts() {
    // Enqueue Swiper CSS
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css');
    
    // Enqueue Swiper JS
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array(), null, true);
    
    // Enqueue custom initialization script
    wp_enqueue_script('swiper-init', get_template_directory_uri() . '/js/swiper-init.js', array('swiper-js'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_swiper_scripts');


function enqueue_theme_assets() {
    // Enqueue Tailwind CSS (assuming you're using a build process)
    wp_enqueue_style('tailwind', get_template_directory_uri() . '/css/tailwind.css');
    wp_enqueue_style('tailwind', get_template_directory_uri() . '/css/style.css');

    // Enqueue Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');

    // Enqueue Custom JS for Mobile Menu
    wp_enqueue_script('custom-menu', get_template_directory_uri() . '/assets/js/menu.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_theme_assets');


function add_google_fonts() {
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap', false);
}
add_action('wp_enqueue_scripts', 'add_google_fonts');


  

function my_custom_sidebar() {
    register_sidebar( array(
        'name'          => 'Main Sidebar',
        'id'            => 'main-sidebar',
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action( 'widgets_init', 'my_custom_sidebar' );

function register_sidebar_menu() {
    register_nav_menu('sidebar-menu', __('Sidebar Menu'));
}
add_action('init', 'register_sidebar_menu');

function register_custom_sidebar() {
    register_sidebar(array(
        'name'          => __('Custom Sidebar', 'textdomain'),
        'id'            => 'custom-sidebar',
        'description'   => __('A custom sidebar for the theme.', 'textdomain'),
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'register_custom_sidebar');

// Register News Custom Post Type
function create_news_cpt() {
    $args = array(
        'public' => true,
        'label'  => 'News',
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-media-document',
    );
    register_post_type('news', $args);
}
add_action('init', 'create_news_cpt');

// News Widget Class
class News_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'news_widget',
            __('Latest News', 'text_domain'),
            array('description' => __('Displays latest news posts', 'text_domain'))
        );
    }

    // Front-end display
    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        $query_args = array(
            'post_type' => 'news',
            'posts_per_page' => !empty($instance['number']) ? $instance['number'] : 3,
        );

        $news_query = new WP_Query($query_args);

        if ($news_query->have_posts()) : ?>
            <div class="space-y-4">
                <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="h-48 bg-cover bg-center" style="background-image: url('<?php the_post_thumbnail_url('medium'); ?>')"></div>
                        <?php endif; ?>
                        <div class="p-4">
                            <h3 class="text-xl font-semibold mb-2">
                                <a href="<?php the_permalink(); ?>" class="hover:text-blue-600"><?php the_title(); ?></a>
                            </h3>
                            <div class="text-gray-600"><?php the_excerpt(); ?></div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p><?php _e('No news found.', 'text_domain'); ?></p>
        <?php endif;

        wp_reset_postdata();
        echo $args['after_widget'];
    }

    // Back-end form
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Latest News', 'text_domain');
        $number = !empty($instance['number']) ? $instance['number'] : 3;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" 
                   name="<?php echo $this->get_field_name('number'); ?>" type="number" 
                   value="<?php echo esc_attr($number); ?>" min="1" max="10">
        </p>
        <?php 
    }

    // Update widget settings
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? intval($new_instance['number']) : 3;
        return $instance;
    }
}

// Register News Custom Post Type
if (!function_exists('create_news_cpt')) {
    function create_news_cpt(): void {
        $args = array(
            'public' => true,
            'label'  => 'News',
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'menu_icon' => 'dashicons-media-document',
            'rewrite' => array('slug' => 'news'),
            'has_archive' => true,
            'publicly_queryable' => true,
        );
        register_post_type('news', $args);
    }
    add_action('init', 'create_news_cpt');
}

class Services_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'services_widget',
            __('Our Services', 'text_domain'),
            array('description' => __('Displays latest services', 'text_domain'))
        );
    }

    // Front-end display
    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        $query_args = array(
            'post_type' => 'services',
            'posts_per_page' => !empty($instance['number']) ? $instance['number'] : 3,
        );

        $services_query = new WP_Query($query_args);

        if ($services_query->have_posts()) : ?>
            <div class="space-y-4">
                <?php while ($services_query->have_posts()) : $services_query->the_post(); ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="h-48 bg-cover bg-center" style="background-image: url('<?php the_post_thumbnail_url('medium'); ?>')"></div>
                        <?php endif; ?>
                        <div class="p-4">
                            <h3 class="text-xl font-semibold mb-2">
                                <a href="<?php the_permalink(); ?>" class="hover:text-blue-600"><?php the_title(); ?></a>
                            </h3>
                            <div class="text-gray-600"><?php the_excerpt(); ?></div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p><?php _e('No services found.', 'text_domain'); ?></p>
        <?php endif;

        wp_reset_postdata();
        echo $args['after_widget'];
    }

    // Back-end form
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Our Services', 'text_domain');
        $number = !empty($instance['number']) ? $instance['number'] : 3;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of services to show:'); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" 
                   name="<?php echo $this->get_field_name('number'); ?>" type="number" 
                   value="<?php echo esc_attr($number); ?>" min="1" max="10">
        </p>
        <?php 
    }

    // Update widget settings
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? intval($new_instance['number']) : 3;
        return $instance;
    }
}

// Register Services Custom Post Type
if (!function_exists('create_services_cpt')) {
    function create_services_cpt(): void {
        $args = array(
            'public' => true,
            'label'  => 'Services',
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'menu_icon' => 'dashicons-hammer',
            'rewrite' => array('slug' => 'services', 'with_front' => false), // Ensure permalinks work properly
            'has_archive' => true,
            'publicly_queryable' => true,
            'show_in_nav_menus' => true
        );
        register_post_type('services', $args);
    }
    add_action('init', 'create_services_cpt');
}


// Register the Widget
function register_services_widget() {
    register_widget('Services_Widget');
}
add_action('widgets_init', 'register_services_widget');


function custom_breadcrumbs() {
    global $post; // Add this line to access the global $post object

    $delimiter = '<span class="mx-2 text-gray-400">/</span>';
    $home = 'Home';
    $before = '<span class="text-gray-600">';
    $after = '</span>';

    echo '<nav class="my-4 text-sm" aria-label="Breadcrumb">';
    echo '<div class="container mx-auto flex flex-wrap items-center">';

    // Home link
    echo '<a href="' . home_url() . '" class="hover:text-blue-600">' . $home . '</a>';

    if (!is_home() && !is_front_page() || is_paged()) {
        echo $delimiter;

        // Category/archive
        if (is_category()) {
            $cat = get_category(get_query_var('cat'), false);
            echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;

        // Single post
        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                echo '<a href="' . get_post_type_archive_link(get_post_type()) . '" class="hover:text-blue-600">' . $post_type->labels->name . '</a>';
                echo $delimiter . $before . get_the_title() . $after;
            } else {
                echo $before . get_the_title() . $after;
            }

        // Page
        } elseif (is_page() && !empty($post) && !$post->post_parent) { // Add !empty($post) check
            echo $before . get_the_title() . $after;

        // Child page
        } elseif (is_page() && !empty($post) && $post->post_parent) { // Add !empty($post) check
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                if ($page) { // Add check for valid page
                    $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '" class="hover:text-blue-600">' . get_the_title($page->ID) . '</a>';
                    $parent_id = $page->post_parent;
                }
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) echo $crumb . $delimiter;
            echo $before . get_the_title() . $after;

        // Attachment
        } elseif (is_attachment() && !empty($post)) { // Add !empty($post) check
            $parent = get_post($post->post_parent);
            if ($parent) { // Add check for valid parent
                echo '<a href="' . get_permalink($parent) . '" class="hover:text-blue-600">' . $parent->post_title . '</a>';
                echo $delimiter . $before . get_the_title() . $after;
            }

        // Custom post type archive
        } elseif (is_post_type_archive()) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->name . $after;

        // Custom post type single
        } elseif (is_single() && get_post_type() != 'post') {
            $post_type = get_post_type_object(get_post_type());
            echo '<a href="' . get_post_type_archive_link(get_post_type()) . '" class="hover:text-blue-600">' . $post_type->labels->name . '</a>';
            echo $delimiter . $before . get_the_title() . $after;

        // Search
        } elseif (is_search()) {
            echo $before . 'Search results for "' . get_search_query() . '"' . $after;

        // 404
        } elseif (is_404()) {
            echo $before . 'Error 404' . $after;

        // Taxonomy
        } elseif (is_tax()) {
            $term = get_term_by("slug", get_query_var("term"), get_query_var("taxonomy"));
            echo $before . $term->name . $after;
        }
    }
    echo '</div></nav>';
}

class Tailwind_Walker_Nav_Menu extends Walker_Nav_Menu {
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="absolute left-0 top-full mt-0 w-48 bg-blue-700 shadow-lg rounded-md py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-opacity duration-200 z-50">';
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= '</ul>';
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $has_children = in_array("menu-item-has-children", $item->classes) ? "group relative" : "";

        $output .= '<li class="relative ' . $has_children . '">';
        $output .= '<a href="' . esc_url($item->url) . '" class="block px-4 py-2 text-white hover:bg-blue-500">' . esc_html($item->title) . '</a>';
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= '</li>';
    }
}

