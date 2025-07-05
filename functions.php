<?php
function buildcraft_theme_setup() {
    // Add theme support
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('align-wide');
    add_theme_support('wp-block-styles');
    add_theme_support('editor-styles');
    add_theme_support('responsive-embeds');
    
    // Block editor support
    add_theme_support('editor-color-palette', array(
        array(
            'name' => 'Primary Blue',
            'slug' => 'primary-blue',
            'color' => '#0d47a1',
        ),
        array(
            'name' => 'Electric Orange',
            'slug' => 'electric-orange',
            'color' => '#ff6b35',
        ),
        array(
            'name' => 'Neon Green',
            'slug' => 'neon-green',
            'color' => '#00e676',
        ),
        array(
            'name' => 'Deep Purple',
            'slug' => 'deep-purple',
            'color' => '#7c4dff',
        ),
    ));
    
    // Add custom block patterns
    add_theme_support('core-block-patterns');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'buildcraft-pro'),
        'footer' => __('Footer Menu', 'buildcraft-pro'),
    ));
}
add_action('after_setup_theme', 'buildcraft_theme_setup');

// Enqueue styles and scripts
function buildcraft_enqueue_assets() {
    wp_enqueue_style('buildcraft-style', get_stylesheet_uri(), array(), '1.0');
    wp_enqueue_style('buildcraft-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0');
    
    wp_enqueue_script('buildcraft-main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0', true);
    
    // Localize script for AJAX
    wp_localize_script('buildcraft-main', 'buildcraft_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('buildcraft_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'buildcraft_enqueue_assets');

// Custom block styles
function buildcraft_register_block_styles() {
    register_block_style('core/heading', array(
        'name' => 'glow-heading',
        'label' => __('Glow Effect', 'buildcraft-pro'),
    ));
    
    register_block_style('core/button', array(
        'name' => 'neon-button',
        'label' => __('Neon Button', 'buildcraft-pro'),
    ));
    
    register_block_style('core/group', array(
        'name' => 'glass-card',
        'label' => __('Glass Card', 'buildcraft-pro'),
    ));
}
add_action('init', 'buildcraft_register_block_styles');

// Custom post types
function buildcraft_register_post_types() {
    register_post_type('projects', array(
        'labels' => array(
            'name' => __('Projects', 'buildcraft-pro'),
            'singular_name' => __('Project', 'buildcraft-pro'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true,
    ));
    
    register_post_type('testimonials', array(
        'labels' => array(
            'name' => __('Testimonials', 'buildcraft-pro'),
            'singular_name' => __('Testimonial', 'buildcraft-pro'),
        ),
        'public' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'buildcraft_register_post_types');

// Custom Gutenberg blocks
function buildcraft_register_blocks() {
    wp_register_script(
        'buildcraft-hero-block',
        get_template_directory_uri() . '/assets/js/main.js',
        array('wp-blocks', 'wp-element', 'wp-editor'),
        '1.0'
    );
    
    register_block_type('buildcraft/hero-section', array(
        'editor_script' => 'buildcraft-hero-block',
    ));
}
add_action('init', 'buildcraft_register_blocks');

// Theme customizer
function buildcraft_customize_register($wp_customize) {
    $wp_customize->add_section('buildcraft_colors', array(
        'title' => __('Theme Colors', 'buildcraft-pro'),
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('primary_color', array(
        'default' => '#0d47a1',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label' => __('Primary Color', 'buildcraft-pro'),
        'section' => 'buildcraft_colors',
    )));
}
add_action('customize_register', 'buildcraft_customize_register');

// AJAX handlers
function buildcraft_load_more_projects() {
    check_ajax_referer('buildcraft_nonce', 'nonce');
    
    $paged = $_POST['page'] + 1;
    $query = new WP_Query(array(
        'post_type' => 'projects',
        'paged' => $paged,
        'posts_per_page' => 6,
    ));
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/project-card');
        }
    }
    
    wp_die();
}

function theme_enqueue_scripts() {
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], null, true);
    wp_enqueue_script('custom-modal', get_template_directory_uri() . '/assets/js/modal.js', ['swiper'], null, true);
  }

add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');  
add_action('wp_ajax_load_more_projects', 'buildcraft_load_more_projects');
add_action('wp_ajax_nopriv_load_more_projects', 'buildcraft_load_more_projects');