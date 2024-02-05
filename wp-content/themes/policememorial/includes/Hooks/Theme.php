<?php

/**
 * The theme support.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this template as well as the current
 * version of the template.
 *
 * @since      1.0.0
 * @package    Lumi
 * @subpackage Lumi/includes
 * @author     Md Ibrahim Kholil <awesomecoder.org@gmail.com>
 *
 *                                                              _
 *                                                             | |
 *    __ ___      _____  ___  ___  _ __ ___   ___  ___ ___   __| | ___ _ __
 *   / _` \ \ /\ / / _ \/ __|/ _ \| '_ ` _ \ / _ \/ __/ _ \ / _` |/ _ \ '__|
 *  | (_| |\ V  V /  __/\__ \ (_) | | | | | |  __/ (_| (_) | (_| |  __/ |
 *   \__,_| \_/\_/ \___||___/\___/|_| |_| |_|\___|\___\___/ \__,_|\___|_|
 *
 */



/**
 * ======================================================================================
 * 		product after before contents
 * ======================================================================================
 */

/**
 * Register the nav menu for the admin area.
 *
 * @since    1.0.0
 */
register_nav_menus(array(
    'primary' => __('( Restaurant ) Primary Menu', 'ac-restaurant'),
));

/**
 * Register custom class for nav items.
 *
 * @since    1.0.0
 */
function add_class_on_nav_menu_list_items($classes, $item, $args)
{
    if ('primary' === $args->theme_location) {
        $classes[] = "nav__item " . "nav_" . strtolower($item->title);
    }

    if (!in_array('active-link', $classes)) {
        if (!in_array('current-menu-item', $classes)) {
            if (in_array('current_page_item', $classes)) {
                $classes[] = 'active-link ';
            }
        } else {
            $classes[] = 'active-link ';
        }
    }

    return $classes;
}

add_filter("nav_menu_css_class", "add_class_on_nav_menu_list_items", 10, 3);

/**
 * Register custom class for nav links.
 *
 * @since    1.0.0
 */
function add_class_on_nav_menu_list_items_link($classes, $item, $args)
{
    if ('primary' === $args->theme_location) {

        $classes["class"] = "nav__link ";
    }
    return $classes;
}
add_filter("nav_menu_link_attributes", "add_class_on_nav_menu_list_items_link", 10, 3);

/**
 * ======================================================================================
 * 		Theme Support Functions
 * ======================================================================================
 */

/**
 * Register dynamic title.
 *
 * @since    1.0.0
 */
add_theme_support('title-tag');


/**
 * Register dynamic logo.
 *
 * @since    1.0.0
 */
add_theme_support('custom-logo', array(
    'height'               => 50,
    'width'                => 180,
    'flex-height'          => true,
    'flex-width'           => true,
    'header-text'          => array('site-title', 'site-description'),
    'unlink-homepage-logo' => true,
));


/**
 * Register the thumbnail theme support for the admin area.
 *
 * @since    1.0.0
 */
add_theme_support("post-thumbnail");


/**
 * Register the background theme support for the admin area.
 *
 * @since    1.0.0
 */
// add_theme_support("custom-background");


/**
 * Register the header theme support for the admin area.
 *
 * @since    1.0.0
 */
add_theme_support("custom-header");

/**
 * Register the sidebar theme support for the admin area.
 *
 * @since    1.0.0
 */
// function awesomecoder_custom_sidebar()
// {
// 	register_sidebar(array(
// 		'name'          => 'Restaurant Sidebar',
// 		'id'            => 'awesomecoder_sidebar',
// 		'description'   => 'Widgets in this area will be shown on all posts and pages.',
// 		'before_widget' => '<li id="%1$s" class="widget %2$s">',
// 		'after_widget'  => '</li>',
// 		'before_title'  => '<h2 class="widgettitle">',
// 		'after_title'   => '</h2>',
// 	));
// }
// add_action('widgets_init', 'awesomecoder_custom_sidebar');

/**
 * ======================================================================================
 * 		Woocommerce Theme Support Functions
 * ======================================================================================
 */

/**
 * Register the woocommerce theme support for the admin area.
 *
 * @since    1.0.0
 */
add_theme_support('woocommerce', array(
    'thumbnail_image_width' => 150,
    'single_image_width'    => 300,
    'product_grid'          => array(
        'default_rows'    => 3,
        'min_rows'        => 3,
        'max_rows'        => 5,
        'default_columns' => 4,
        'min_columns'     => 3,
        'max_columns'     => 4,
    ),
));


/**
 * Enable single product zoom.
 *
 * @since    1.0.0
 */
add_theme_support('wc-product-gallery-zoom');


/**
 * Enable single product lightbox.
 *
 * @since    1.0.0
 */
add_theme_support('wc-product-gallery-lightbox');


/**
 * Enable single product slider.
 *
 * @since    1.0.0
 */
add_theme_support('wc-product-gallery-slider');
