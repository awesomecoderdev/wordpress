<?php

/**
 * The core template class.
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
 * Show cart fragment
 */
add_filter('woocommerce_add_to_cart_fragments', 'lumi_add_to_cart_fragment');
function lumi_add_to_cart_fragment($fragments = [])
{
    global $woocommerce;

    $lumi_cart_fragment = "<svg class=\"mr-1.5 rtl:ml-1.5\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
    <path d=\"M16.651 6.5984C16.651 4.21232 14.7167 2.27799 12.3307 2.27799C11.1817 2.27316 10.0781 2.72619 9.26387 3.53695C8.44968 4.3477 7.992 5.44939 7.992 6.5984M16.5137 21.5H8.16592C5.09955 21.5 2.74715 20.3924 3.41534 15.9348L4.19338 9.89359C4.60528 7.66934 6.02404 6.81808 7.26889 6.81808H17.4474C18.7105 6.81808 20.0469 7.73341 20.5229 9.89359L21.3009 15.9348C21.8684 19.889 19.5801 21.5 16.5137 21.5Z\" stroke=\"currentColor\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\" />
    <path d=\"M15.296 11.102H15.251\" stroke=\"#2D2D2D\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\" />
    <path d=\"M9.46604 11.102H9.42004\" stroke=\"#2D2D2D\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\" />
    </svg>\nbag";

    if ($woocommerce->cart->cart_contents_count) {
        $lumi_cart_fragment .= "<span class=\"absolute -top-2 left-3 h-4 w-4 text-[8px] font-medium flex justify-center items-center rounded-full bg-primary-500 text-white\">{$woocommerce->cart->cart_contents_count}</span>";
    }

    $lumi_cart_mobile_fragment = '<svg class="mr-1.5 rtl:ml-1.5 h-14 w-8" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.651 6.5984C16.651 4.21232 14.7167 2.27799 12.3307 2.27799C11.1817 2.27316 10.0781 2.72619 9.26387 3.53695C8.44968 4.3477 7.992 5.44939 7.992 6.5984M16.5137 21.5H8.16592C5.09955 21.5 2.74715 20.3924 3.41534 15.9348L4.19338 9.89359C4.60528 7.66934 6.02404 6.81808 7.26889 6.81808H17.4474C18.7105 6.81808 20.0469 7.73341 20.5229 9.89359L21.3009 15.9348C21.8684 19.889 19.5801 21.5 16.5137 21.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /><path d="M15.296 11.102H15.251" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /><path d="M9.46604 11.102H9.42004" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg>';

    if ($woocommerce->cart->cart_contents_count) {
        $lumi_cart_mobile_fragment .= "<span class=\"absolute top-2.5 -right-0.5 h-4 w-4 mr-1 mt-0.5 text-[8px] font-medium flex justify-center items-center rounded-full bg-primary-500 text-white\">{$woocommerce->cart->cart_contents_count}</span>";
    }

    $fragments["lumi_cart_fragment"] = $lumi_cart_fragment;
    $fragments["lumi_cart_mobile_fragment"] = $lumi_cart_mobile_fragment;

    return $fragments;
}



/**
 * Tags thumbnail fields.
 */
function add_tags_fields()
{
?>
    <div class="form-field term-display-type-wrap">
        <label for="display_type"><?php esc_html_e('Display type', 'woocommerce'); ?></label>
        <select id="display_type" name="display_type" class="postform">
            <option value=""><?php esc_html_e('Default', 'woocommerce'); ?></option>
            <option value="products"><?php esc_html_e('Products', 'woocommerce'); ?></option>
            <option value="subcategories"><?php esc_html_e('Subcategories', 'woocommerce'); ?></option>
            <option value="both"><?php esc_html_e('Both', 'woocommerce'); ?></option>
        </select>
    </div>
    <div class="form-field term-thumbnail-wrap">
        <label><?php esc_html_e('Thumbnail', 'woocommerce'); ?></label>
        <div id="product_cat_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" width="60px" height="60px" /></div>
        <div style="line-height: 60px;">
            <input type="hidden" id="product_cat_thumbnail_id" name="product_cat_thumbnail_id" />
            <button type="button" class="upload_image_button button"><?php esc_html_e('Upload/Add image', 'woocommerce'); ?></button>
            <button type="button" class="remove_image_button button"><?php esc_html_e('Remove image', 'woocommerce'); ?></button>
        </div>
        <script type="text/javascript">
            // Only show the "remove image" button when needed
            if (!jQuery('#product_cat_thumbnail_id').val()) {
                jQuery('.remove_image_button').hide();
            }

            // Uploading files
            var file_frame;

            jQuery(document).on('click', '.upload_image_button', function(event) {

                event.preventDefault();

                // If the media frame already exists, reopen it.
                if (file_frame) {
                    file_frame.open();
                    return;
                }

                // Create the media frame.
                file_frame = wp.media.frames.downloadable_file = wp.media({
                    title: '<?php esc_html_e('Choose an image', 'woocommerce'); ?>',
                    button: {
                        text: '<?php esc_html_e('Use image', 'woocommerce'); ?>'
                    },
                    multiple: false
                });

                // When an image is selected, run a callback.
                file_frame.on('select', function() {
                    var attachment = file_frame.state().get('selection').first().toJSON();
                    var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

                    jQuery('#product_cat_thumbnail_id').val(attachment.id);
                    jQuery('#product_cat_thumbnail').find('img').attr('src', attachment_thumbnail.url);
                    jQuery('.remove_image_button').show();
                });

                // Finally, open the modal.
                file_frame.open();
            });

            jQuery(document).on('click', '.remove_image_button', function() {
                jQuery('#product_cat_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
                jQuery('#product_cat_thumbnail_id').val('');
                jQuery('.remove_image_button').hide();
                return false;
            });

            jQuery(document).ajaxComplete(function(event, request, options) {
                if (request && 4 === request.readyState && 200 === request.status &&
                    options.data && 0 <= options.data.indexOf('action=add-tag')) {

                    var res = wpAjax.parseAjaxResponse(request.responseXML, 'ajax-response');
                    if (!res || res.errors) {
                        return;
                    }
                    // Clear Thumbnail fields on submit
                    jQuery('#product_cat_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
                    jQuery('#product_cat_thumbnail_id').val('');
                    jQuery('.remove_image_button').hide();
                    // Clear Display type field on submit
                    jQuery('#display_type').val('');
                    return;
                }
            });
        </script>
        <div class="clear"></div>
    </div>
<?php
}


/**
 * Modify Product Summary add colors
 */
add_action('woocommerce_single_product_summary', 'lumi_single_product_color_attributes', 62);
if (!function_exists("lumi_single_product_color_attributes")) {
    function lumi_single_product_color_attributes()
    {
        ob_start();
        include_once LUMI_THEME_PATH . "/template/section/product/attributes/color.php";
        $output = ob_get_contents();
        ob_end_clean();
        echo $output;
    }
}

/**
 * Modify Product Summary add sizes
 */
add_action('woocommerce_single_product_summary', 'lumi_single_product_size_attributes', 61);
if (!function_exists("lumi_single_product_size_attributes")) {
    function lumi_single_product_size_attributes()
    {
        ob_start();
        include_once LUMI_THEME_PATH . "/template/section/product/attributes/size.php";
        $output = ob_get_contents();
        ob_end_clean();
        echo $output;
    }
}



// remove add to cart from the single page summary
remove_action("woocommerce_simple_add_to_cart", "woocommerce_simple_add_to_cart", 30);

// add to cart from the single page summary
add_action("woocommerce_single_product_cart", "woocommerce_simple_add_to_cart", 62);

// show all notices action
add_action("lumi_show_all_notices", "woocommerce_output_all_notices");


// remove all woocommerce style
add_action('wp_enqueue_scripts', 'remove_woocommerce_styles', 100);
function remove_woocommerce_styles()
{
    if (class_exists('woocommerce')) {
        // Remove the WooCommerce stylesheets
        wp_dequeue_style('woocommerce-general');
        wp_dequeue_style('woocommerce-layout');
        wp_dequeue_style('woocommerce-smallscreen');
    }
}

// Add a custom metabox for the Additional Information
add_action('add_meta_boxes', 'add_additional_information_metabox');
function add_additional_information_metabox()
{
    add_meta_box(
        'short_description_metabox',
        __("Additional Information", "lumi"),
        'render_additional_information_metabox',
        'product',
        'normal',
        'high'
    );
}

// Render the HTML editor for the Additional Information metabox
function render_additional_information_metabox($post)
{
    // Get the current Additional Information content
    $short_description = get_post_meta($post->ID, '_additional_information', true);

    // Output the HTML editor
    wp_editor($short_description, 'short_description_editor', array(
        'textarea_name' => '_additional_information',
        'media_buttons' => true,
        'textarea_rows' => 10,
    ));
}

// Save the content from the HTML editor to the Additional Information field
add_action('save_post', 'save_additional_information_metabox');
function save_additional_information_metabox($post_id)
{
    if (isset($_POST['_additional_information'])) {
        update_post_meta($post_id, '_additional_information', wp_kses_post($_POST['_additional_information']));
    }
}


// Save the metadata from cart to order
add_filter('woocommerce_checkout_create_order_line_item', 'copy_cart_item_metadata_to_order', 10, 4);
function copy_cart_item_metadata_to_order($item, $cart_item_key, $values, $order)
{
    if (isset($values["product_id"])) {
        $product_id = $values["product_id"];

        if (isset($values["color"], $values["color_id"])) {
            $color = wc_get_product_terms($product_id, 'pa_color', [
                "number" => 1,
                "term_id" => isset($values['color_id']) ? sanitize_text_field($values['color_id']) : "awesomecoder",
            ])[0] ?? null;
            $color_code = get_lumi_product_color($color->term_id);
            $item->add_meta_data('Color',  "<div style='display:flex;'> <span>$color->name</span> <div style='height:20px;width:20px;border:1px solid;border-radius:100%;background: $color_code;'></div></div>", true);
        }

        if (isset($values["size"], $values["size_id"])) {
            $size = wc_get_product_terms($product_id, 'pa_size', [
                "number" => 1,
                "term_id" => isset($values['size_id']) ? sanitize_text_field($values['size_id']) : "awesomecoder",
            ])[0] ?? null;
            $item->add_meta_data('Size', strtoupper(substr($size->name, 0, 2)), true);
        }
    }


    // if (isset($values["color"])) {
    //     $item->add_meta_data('_color', $values["color"], true);
    // }
    // if (isset($values["color_id"])) {
    //     $item->add_meta_data('_color_id', $values["color_id"], true);
    // }
    // if (isset($values["size"])) {
    //     $item->add_meta_data('_size', $values["size"], true);
    // }
    // if (isset($values["size_id"])) {
    //     $item->add_meta_data('_size_id', $values["size_id"], true);
    // }
    return $item;
}


/**
 *  Save the custom field data when the product is added to the cart
 *
 * @since    1.0.0
 *
 */

add_filter('woocommerce_add_cart_item_data', 'save_gift_wrapping_field', 10, 2);
function save_gift_wrapping_field($cart_item_data, $product_id)
{
    // Get product details
    $product = wc_get_product($product_id);
    $size = wc_get_product_terms($product->get_id(), 'pa_size', [
        "number" => 1,
        "slug" => isset($_POST['size']) ? sanitize_text_field($_POST['size']) : "awesomecoder",
    ])[0] ?? null;

    $color = wc_get_product_terms($product->get_id(), 'pa_color', [
        "number" => 1,
        "slug" => isset($_POST['color']) ? sanitize_text_field($_POST['color']) : "awesomecoder",
    ])[0] ?? null;

    if ($color) {
        $cart_item_data['color'] = $color->slug;
        $cart_item_data['color_id'] = $color->term_id;
    }

    if ($size) {
        $cart_item_data['size'] = $size->slug;
        $cart_item_data['size_id'] = $size->term_id;
    }

    return $cart_item_data;
}


// Display the custom field in the cart and checkout
// add_filter('woocommerce_get_item_data', 'display_gift_wrapping_cart', 10, 2);
function display_gift_wrapping_cart($data, $cart_item)
{
    echo "<pre>";
    print_r($cart_item);
    echo "</pre>";

    $data[] = array(
        'key'   => 'Custom Key',
        'value' => "sadfasdf",
    );

    if (isset($cart_item['color'])) {
        $data[] = array(
            'key'   => __('Color', 'lumi'),
            'value' => $cart_item['color'],
        );
    }

    if (isset($cart_item['size'])) {
        $data[] = array(
            'key'   => __('Size', 'lumi'),
            'value' => $cart_item['size'],
        );
    }

    return $data;
}

// Save the custom field data to the order
// add_action('woocommerce_after_order_itemmeta', 'save_gift_wrapping_to_order', 10, 3);
function save_gift_wrapping_to_order($item_id, $item, $product)
{
    // Check if the product has the custom data
    // $custom_data = get_post_meta($product->get_id(), 'color', true);

    echo "<pre>";
    print_r($item);
    echo "</pre>";

    // if (isset($values['color'])) {
    //     wc_add_order_item_meta($item_id, __('Color', 'lumi'), $values['color']);
    // }
}

/**
 * ======================================================================================
 * 		removing elements from archive-product.php
 * ======================================================================================
 */
/**
 * remove woocommerce sidebar
 *
 * @since    1.0.0
 *
 */
// remove_action("woocommerce_sidebar", "woocommerce_get_sidebar");


/**
 * remove woocommerce breadcrumb
 *
 * @since    1.0.0
 *
 */
// remove_action("woocommerce_before_main_content", "woocommerce_breadcrumb", 20);


/**
 * remove woocommerce result_count
 *
 * @since    1.0.0
 *
 */
// remove_action("woocommerce_before_shop_loop", "woocommerce_result_count", 20);



/**
 * remove woocommerce ordering
 *
 * @since    1.0.0
 *
 */
// remove_action("woocommerce_before_shop_loop", "woocommerce_catalog_ordering", 30);


/**
 * Removes the "shop" title on the main shop page
 *
 * @since    1.0.0
 *
 */
// add_filter('woocommerce_show_page_title', '__return_false');

/**
 * ======================================================================================
 * 		set posisiton of the single product page contents
 * ======================================================================================
 */


/**
 * move the rating location on single product page
 *
 * @since    1.0.0
 *
 */
// remove_action("woocommerce_single_product_summary", "woocommerce_template_single_rating", 10);
// add_action("woocommerce_single_product_summary", "woocommerce_template_single_rating", 25);


/**
 *  move the price location on single product page
 *
 * @since    1.0.0
 *
 */
// remove_action("woocommerce_single_product_summary", "woocommerce_template_single_price", 10);
// add_action("woocommerce_single_product_summary", "woocommerce_template_single_price", 26);


/**
 * ======================================================================================
 * 		set posisiton of the single product page contents
 * ======================================================================================
 */

/**
 *  Rggister customize settings
 *
 * @since    1.0.0
 *
 */
// add_action("customize_register", 'ac_restaurant_customize_register');
function ac_restaurant_customize_register($wp_customize)
{

    /**
     *  Add section
     *
     * @since    1.0.0
     *
     */
    $wp_customize->add_section("sec_copyright", array(
        "title"             => "Copyright Settings",
        "description"       => "This is copyright section.",
    ));

    /**
     * ======================================================================================
     * 		 Add settings on customize
     * ======================================================================================
     */

    /**
     *  adding copyright text
     *
     * @since    1.0.0
     *
     */
    $wp_customize->add_setting("copyright_text", array(
        "type" => "theme_mod",
        "default" => get_bloginfo("title"),
        "sanitize_callback" => "sanitize_text_field",
    ));
    $wp_customize->add_control("copyright_text", array(
        "label" => "Copyright",
        "description" => "Please fill the copyright text field.",
        "section" => "sec_copyright",
        "type" => "text",
    ));


    /**
     *  adding copyright year
     *
     * @since    1.0.0
     *
     */
    $wp_customize->add_setting("copyright_year", array(
        "type" => "theme_mod",
        "default" => "",
        "sanitize_callback" => "sanitize_text_field",
    ));
    $wp_customize->add_control("copyright_year", array(
        "label" => "Year",
        "description" => "Please fill the copyright year field.",
        "section" => "sec_copyright",
        "type" => "number",
    ));


    /**
     *  adding hover color
     *
     * @since    1.0.0
     *
     */
    $wp_customize->add_setting("text_color", array(
        "type" => "theme_mod",
        "default" => "",
        "sanitize_callback" => "sanitize_text_field",
    ));
    $wp_customize->add_control("text_color", array(
        "label" => "Text Color",
        "section" => "colors",
        "type" => "color",
    ));




    /**
     *  adding hover color
     *
     * @since    1.0.0
     *
     */
    $wp_customize->add_setting("first_color", array(
        "type" => "theme_mod",
        "default" => "",
        "sanitize_callback" => "sanitize_text_field",
    ));
    $wp_customize->add_control("first_color", array(
        "label" => "Font Color",
        "section" => "colors",
        "type" => "color",
    ));


    /**
     *  adding hover color
     *
     * @since    1.0.0
     *
     */
    $wp_customize->add_setting("hover_color", array(
        "type" => "theme_mod",
        "default" => "",
        "sanitize_callback" => "sanitize_text_field",
    ));

    $wp_customize->add_control("hover_color", array(
        "label" => "Hover Color",
        "section" => "colors",
        "type" => "color",
    ));
}
