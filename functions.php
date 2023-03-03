<?php
/**
 * Functions
 */


// Helpers function
require_once get_stylesheet_directory() . '/inc/helpers.php';
// SVG Support
include_once get_stylesheet_directory() . '/inc/svg-support.php';
// Dynamic admin
include_once get_stylesheet_directory() . '/inc/class-dynamic-admin.php';


// Support for Featured Images
add_theme_support( 'post-thumbnails' );

// Add HTML5 elements
add_theme_support( 'html5', array(
    'comment-list',
    'search-form',
    'comment-form',
    'gallery',
    'caption'
) );

// Register Navigation Menu
register_nav_menus( array(
    'header-menu' => 'Header Menu',
    'footer-menu' => 'Footer Menu',
    'footer-collections-menu' => 'Footer Collections Menu',
    'sitebar-menu' => 'SiteBar Menu'
) );


// Custom Logo
add_theme_support( 'custom-logo', array(
    'height'      => '150',
    'flex-height' => true,
    'flex-width'  => true,
) );

// Custom Header
add_theme_support( 'custom-header', array(
    'default-image' => get_template_directory_uri() . '/images/logo.png',
    'height'        => '200',
    'flex-height'   => true,
    'uploads'       => true,
    'header-text'   => false
) );


function show_custom_logo() {
    if ( $custom_logo_id = get_theme_mod( 'custom_logo' ) ) {
        $attachment_array = wp_get_attachment_image_src( $custom_logo_id, 'medium' );
        $logo_url         = $attachment_array[0];
    } else {
        $logo_url = get_stylesheet_directory_uri() . '/images/custom-logo.png';
    }
    $logo_image = '<img src="' . $logo_url . '" class="custom-logo" itemprop="siteLogo" alt="' . get_bloginfo( 'name' ) . '">';
    $html       = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" title="%2$s" itemscope>%3$s</a>', esc_url( home_url( '/' ) ), get_bloginfo( 'name' ), $logo_image );
    echo apply_filters( 'get_custom_logo', $html );
}


// Customize Login Screen
function wordpress_login_styling() {
    if ( $custom_logo_id = get_theme_mod( 'custom_logo' ) ) {
        $custom_logo_img = wp_get_attachment_image_src( $custom_logo_id, 'medium' );
        $custom_logo_src = $custom_logo_img[0];
    } else {
        $custom_logo_src = 'wp-admin/images/wordpress-logo.svg?ver=20131107';
    }
    ?>
    <style type="text/css">
        .login #login h1 a {
            background-image: url('<?php echo $custom_logo_src; ?>');
            background-size: contain;
            background-position: 50% 50%;
            width: auto;
            height: 120px;
        }

        body.login {
            background-color: #f1f1f1;
        <?php if ($bg_image = get_background_image()) {?>
            background-image: url('<?php echo $bg_image; ?>') !important;
        <?php } ?>
            background-repeat: repeat;
            background-position: center center;
        }
    </style>
<?php }

add_action( 'login_enqueue_scripts', 'wordpress_login_styling' );

function admin_logo_custom_url() {
    $site_url = get_bloginfo( 'url' );
    return ( $site_url );
}

add_filter( 'login_headerurl', 'admin_logo_custom_url' );






/******************************************************************************************************************************
 * Enqueue Scripts and Styles for Front-End
 *******************************************************************************************************************************/

function foundation_scripts_and_styles() {
    if ( ! is_admin() ) {

        // Load Stylesheets
        //core
//        wp_enqueue_style( 'foundation', get_template_directory_uri() . '/css/foundation.min.css', null, '6.3.0' );

        //plugins
//        wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/plugins/fontawesome.min.css', null, '5.3.1' );
        wp_enqueue_style( 'slick', get_template_directory_uri() . '/css/plugins/slick.css', null, '1.6.0' );
//        wp_enqueue_style( 'fancybox.v2', get_template_directory_uri() . '/css/plugins/jquery.fancybox.v2.css', null, '2.1.5' );
		wp_enqueue_style( 'fancybox.v3', get_template_directory_uri() . '/css/plugins/jquery.fancyboxv3.css', null, '3.4.1' );

        //system
        wp_enqueue_style( 'custom', get_template_directory_uri() . '/css/main.css', null, '2.0.3' );/*3rd priority*/
//        wp_enqueue_style( 'media-screens', get_template_directory_uri() . '/css/media-screens.css', null, '2.0.3' );/*2nd priority*/
        wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css', null, null );/*1st priority*/

//        if(is_page_template('templates/template-service.php') ) {
//            wp_enqueue_style( 'devins-style', get_template_directory_uri() . '/css/devins-style.css', null, null );/*1st priority*/
//        }


        // Load JavaScripts
        //core
        wp_enqueue_script( 'jquery' );
//        wp_enqueue_script( 'foundation.min', get_template_directory_uri() . '/js/foundation.min.js', null, '6.3.0', true );
//        wp_enqueue_script( 'isotope.min', get_template_directory_uri() . '/js/plugins/isotope.pkgd.min.js', null, null, true );

        //plugins
//        wp_enqueue_script( 'html5shiv-respond', get_template_directory_uri() . '/js/plugins/html5shiv_respond.js', null, null, false );
//        wp_script_add_data( 'html5shiv-respond', 'conditional', 'lt IE 9' );
        wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/plugins/slick.min.js', null, '1.6.0', true );
//        wp_enqueue_script( 'matchHeight', get_template_directory_uri() . '/js/plugins/jquery.matchHeight-min.js', null, '0.7.0', true );
        wp_enqueue_script( 'fancybox.v3', get_template_directory_uri() . '/js/plugins/jquery.fancybox.v3.js', null, '2.1.5', true );

        wp_enqueue_script( 'google.maps.api', 'https://maps.googleapis.com/maps/api/js?key=' . (get_theme_mod( 'google_maps_api' ) ?: 'AIzaSyCE8WEPWLLzUmOEAd9D14NFkqe0jOkO-MY') . '&v=3.exp', null, null, true );
        //custom javascript
        wp_enqueue_script( 'global', get_template_directory_uri() . '/js/global.js', null, null, true ); /* This should go first */




//        wp_localize_script('global', 'myajax',
//            array(
//                'url' => admin_url('admin-ajax.php'),
//            )
//        );

    }
}

add_action( 'wp_enqueue_scripts', 'foundation_scripts_and_styles' );

// Set Google Map API key

function set_custom_google_api_key() {
    acf_update_setting( 'google_api_key', get_theme_mod( 'google_maps_api' ) ?: 'AIzaSyCE8WEPWLLzUmOEAd9D14NFkqe0jOkO-MY' );
}


// ACF Pro Options Page

if ( function_exists( 'acf_add_options_page' ) ) {

    acf_add_options_page( array(
        'page_title' => 'Theme General Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug'  => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect'   => false
    ) );

}


// Disable Emoji

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
add_filter( 'tiny_mce_plugins', 'disable_wp_emojis_in_tinymce' );
function disable_wp_emojis_in_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}




//function lita_change_real_estate_permalink( $permalink, $post ) {
//    if ( 'real_estate' === $post->post_type && in_array( $post->post_status, array( 'publish', 'pending', 'draft' ) ) ) {
//        $terms = wp_get_post_terms( $post->ID, 'type_of_agreement' );
//        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
//            $taxonomy_slug = $terms[0]->slug;
//        } else {
//            $taxonomy_slug = 'sale';
//        }
//        $permalink = str_replace( 'type_of_agreement', $taxonomy_slug, $permalink );
//    }
//    return $permalink;
//}
//add_filter( 'post_type_link', 'lita_change_real_estate_permalink', 10, 2 );

function create_type_of_agreement() {
    $labels = array(
        'name' => __('Type of agreement', 'test'),
        'singular_name' => __('Type of agreementy', 'test'),
        'search_items' => __('Search Type of agreement', 'test'),
        'all_items' => __('All Type of agreement', 'test'),
        'parent_item' => __('Parent Type of agreement', 'test'),
        'parent_item_colon' => __('Parent Type of agreementy:', 'test'),
        'edit_item' => __('Edit Type of agreement', 'test'),
        'update_item' => __('Update Type of agreement', 'test'),
        'add_new_item' => __('Add New Type of agreement', 'test'),
        'new_item_name' => __('New Type of agreement Name', 'test'),
        'menu_name' => __('Type of agreement', 'test')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => '', 'with_front' => false ),
    );

    register_taxonomy('type_of_agreement', 'real_estate', $args);
}

add_action('init', 'create_type_of_agreement');


function create_types_of_real_estate() {
    $labels = array(
        'name' => __('Types of real estate', 'test'),
        'singular_name' => __('Types of real estate', 'test'),
        'search_items' => __('Search Types of real estate', 'test'),
        'all_items' => __('All Types of real estate', 'test'),
        'parent_item' => __('Parent Types of real estate', 'test'),
        'parent_item_colon' => __('Parent Types of real estate:', 'test'),
        'edit_item' => __('Edit Types of real estate', 'test'),
        'update_item' => __('Update Types of real estate', 'test'),
        'add_new_item' => __('Add New Types of real estate', 'test'),
        'new_item_name' => __('New Types of real estate', 'test'),
        'menu_name' => __('Types of real estate', 'test')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => '%type_of_agreement%', 'with_front' => false ),
    );

    register_taxonomy('types_of_real_estate', 'real_estate', $args);
}

add_action('init', 'create_types_of_real_estate');





function create_bedrooms() {
    $labels = array(
        'name' => __( 'Bedrooms', 'test' ),
        'singular_name' => __( 'Bedroom', 'test' ),
        'search_items' => __('Search Bedrooms', 'test'),
        'all_items' => __('All Bedrooms', 'test'),
        'parent_item' => __('Parent Bedrooms', 'test'),
        'parent_item_colon' => __('Parent Bedrooms:', 'test'),
        'edit_item' => __('Edit Bedrooms', 'test'),
        'update_item' => __('Update Bedrooms', 'test'),
        'add_new_item' => __('Add New Bedroom', 'test'),
        'new_item_name' => __('New Bedrooms', 'test'),
        'menu_name' => __( 'Bedrooms', 'test' ),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => '%type_of_agreement%/%types_of_real_estate%', 'with_front' => false ),
    );
    register_taxonomy( 'bedrooms', 'real_estate', $args );
}
add_action( 'init', 'create_bedrooms');



//add_filter( 'term_link', 'custom_term_link', 10, 2 );
//function custom_term_link( $termlink, $term ) {
//    if ( 'buy' === $term->taxonomy ) {
//        $termlink = str_replace( '/buy/buy/', '/buy/', $termlink );
//    }
//    return $termlink;
//}



//function bedrooms_permalink( $post_link, $post ) {
//    if ( false !== strpos( $post_link, '%type_of_agreement%' ) && false !== strpos( $post_link, '%types_of_real_estate%' ) && false !== strpos( $post_link, '%bedrooms%' ) ) {
//        $terms = wp_get_object_terms( $post->ID, 'types_of_real_estate' );
//        if ( $terms ) {
//            $taxonomies = array();
//            foreach ( $terms as $term ) {
//                // Check if the term has a parent and is not a duplicate
//                if ( !empty( $term->parent ) && !in_array( $term->parent, wp_list_pluck( $terms, 'term_id' ) ) ) {
//                    $ancestors = get_ancestors( $term->term_id, 'bedrooms' );
//                    foreach ( $ancestors as $ancestor ) {
//                        $ancestor_term = get_term( $ancestor, 'bedrooms' );
//                        $taxonomies[] = $ancestor_term->slug;
//                    }
//                } elseif ( empty( $term->parent ) ) {
//                    $taxonomies[] = $term->slug;
//                }
//            }
//            $post_link = str_replace( '%type_of_agreement%/' . '%types_of_real_estate%/' . '%bedrooms%', implode( '/', $taxonomies ), $post_link );
//        }
//    }
//    return $post_link;
//}
//add_filter( 'post_link', 'bedrooms_permalink', 1, 2 );




function type_of_agreement_permalink( $post_link, $post ) {
    if ( false !== strpos( $post_link, '%type_of_agreement%' )  ) {
        $terms = wp_get_object_terms( $post->ID, 'types_of_real_estate' );
        if ( $terms ) {
            $taxonomies = array();
            foreach ( $terms as $term ) {
                // Check if the term has a parent and is not a duplicate
                if ( !empty( $term->parent ) && !in_array( $term->parent, wp_list_pluck( $terms, 'term_id' ) ) ) {
                    $ancestors = get_ancestors( $term->term_id, 'type_of_agreement' );
                    foreach ( $ancestors as $ancestor ) {
                        $ancestor_term = get_term( $ancestor, 'type_of_agreement' );
                        $taxonomies[] = $ancestor_term->slug;
                    }
                } elseif ( empty( $term->parent ) ) {
                    $taxonomies[] = $term->slug;
                }
            }
            $post_link = str_replace( '%type_of_agreement%/', implode( '/', $taxonomies ), $post_link );
        }
    }
    return $post_link;
}
add_filter( 'post_link', 'type_of_agreement_permalink', 1, 3 );





/*********************** PUT YOU FUNCTIONS BELOW ********************************/

add_image_size( 'full_hd', 1920, 1080, array('center', 'center'));
add_image_size( 'medium', 300, 300, array('center', 'center'));

/* remove Gutenberg*/
add_filter('use_block_editor_for_post_type', '__return_false');