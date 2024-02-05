<?php

/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 * @package           lumi
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.

}


?>

<?php get_header(); ?>

<form id="cart" class="<?php echo lumi_container("lg:py-10 py-4 not-prose"); ?> <?php echo count(lumi_get_cart()) == 0 ? "hidden" : "" ?>">
    <div class="relative w-full grid lg:grid-cols-10 gap-8 py-3">
        <!-- start:cart body -->
        <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>

        <div class="relative lg:col-span-7">
            <div class="relative py-4 grid gap-4">
                <div class="relative grid grid-cols-3 gap-4 border-b pb-4 mb-4">
                    <div class="relative flex justify-center items-center">
                        <h2 class="text-base font-semibold"><?php _e("Product", "lumi") ?></h2>
                    </div>
                    <div class="relative flex justify-center items-center">
                        <h2 class="text-base font-semibold"><?php _e("Quantity", "lumi") ?></h2>
                    </div>
                    <div class="relative flex justify-center items-center">
                        <h2 class="text-base font-semibold"><?php _e("Price", "lumi") ?></h2>
                    </div>
                </div>

                <!-- start for large device -->
                <?php foreach (lumi_get_cart() as $key => $item) : ?>
                    <?php
                    // Get product details
                    $product = apply_filters('woocommerce_cart_item_product', $item['data'], $item, $key);
                    // $product = wc_get_product($item["product_id"]);

                    // You can access product data like this:
                    $product_id = apply_filters('woocommerce_cart_item_product_id', $item['product_id'], $item, $key);
                    // $product_id = $product->get_id();
                    // $product_name = $product->get_name();
                    $product_name = apply_filters('woocommerce_cart_item_name', $product->get_name(), $item, $key);

                    $product_price = $product->get_price();
                    $product_sku = $product->get_sku();

                    $color = wc_get_product_terms($product->get_id(), 'pa_color', [
                        "number" => 1,
                        "slug" => isset($item['color']) ? sanitize_text_field($item['color']) : "awesomecoder",
                    ])[0] ?? null;

                    $size = wc_get_product_terms($product->get_id(), 'pa_size', [
                        "number" => 1,
                        "slug" => isset($item['size']) ? sanitize_text_field($item['size']) : "awesomecoder",
                    ])[0] ?? null;

                    ?>

                    <?php if ($product && $product->exists() && $item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $item, $key)) : ?>
                        <?php
                        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $product->is_visible() ? $product->get_permalink($item) : '', $item, $key);
                        ?>
                        <div class="relative add-to-cart-from-wishlist flex justify-between items-end rounded-lg" id="cart-item-<?php echo $product_id ?>">
                            <div class="relative h-full w-full md:grid grid-cols-3 gap-4">
                                <div class="relative flex md:items-center gap-4">
                                    <?php echo str_replace("<img", "<img class=\"rounded-xl xl:aspect-[4/3] lg:aspect-[4/3] md:aspect-[4/3] sm:w-36 w-24 bg-slate-100 dark:bg-slate-400 cursor-pointer\" alt=\"$product_name\"", $product->get_image()); ?>
                                    <div class="relative max-sm:space-y-2">
                                        <h2 class="md:text-lg text-sm font-semibold line-clamp-2 xl:w-56 md:w-40">
                                            <?php
                                            if (!$product_permalink) {
                                                echo wp_kses_post($product_name . '&nbsp;');
                                            } else {
                                                /**
                                                 * This filter is documented above.
                                                 *
                                                 * @since 2.1.0
                                                 */
                                                echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $product->get_name()), $item, $key));
                                            }

                                            do_action('woocommerce_after_cart_item_name', $item, $key);

                                            // Meta data.
                                            echo wc_get_formatted_cart_item_data($item); // PHPCS: XSS ok.

                                            // Backorder notification.
                                            if ($product->backorders_require_notification() && $product->is_on_backorder($item['quantity'])) {
                                                echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                                            }
                                            ?>
                                        </h2>

                                        <div class="relative space-y-2">
                                            <?php if ($color) : ?>
                                                <div class="relative flex items-center justify-between gap-3 w-24 ">
                                                    <span class="font-semibold text-sm"><?php _e('Color', 'lumi') ?>:</span>
                                                    <div class="w-6 h-6 flex justify-center items-center cursor-pointer rounded-full border product-colors-item " style="background: <?php echo get_lumi_product_color($color->term_id) ?>;">
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($size) : ?>
                                                <div class="relative flex items-center justify-between gap-3 w-24 ">
                                                    <span class="font-semibold text-sm"><?php _e('Size', 'lumi') ?> : </span>
                                                    <div class="w-6 h-6 flex justify-center items-center cursor-pointer overflow-hidden rounded-lg border-2 product-sizes-item  ">
                                                        <span class="text-[10px] font-bold"><?php echo strtoupper(substr($size->name, 0, 2)); ?></span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                        </div>
                                        <div class="relative md:hidden flex justify-start items-center">
                                            <span class="text-xl font-medium">
                                                <?php echo wc_price($product_price); ?>
                                            </span>
                                        </div>
                                        <div class="relative md:hidden flex justify-between gap-4">
                                            <div class="relative flex items-center">
                                                <button class="h-5 w-5 border flex justify-center items-center" id="cart-quantity-decrement" data-product="<?php echo $product_id; ?>">-</button>
                                                <!-- <input name="quantity" value="<?php echo $item["quantity"] ?? 1 ?>" id="cart-quantity" class="pointer-events-none p-0 m-0 w-10 h-5 leading-none text-xs px-2 border bg-transparent placeholder:text-primary-300 text-primary-500 font-semibold outline-none border-none border-transparent outline-transparent focus:outline-none focus-visible:outline-none focus:ring-transparent text-center" type="number" min="1"> -->

                                                <?php
                                                if ($product->is_sold_individually()) {
                                                    $min_quantity = 1;
                                                    $max_quantity = 1;
                                                } else {
                                                    $min_quantity = 0;
                                                    $max_quantity = $product->get_max_purchase_quantity();
                                                }

                                                $product_quantity = woocommerce_quantity_input(
                                                    array(
                                                        'input_name'   => "cart[{$key}][qty]",
                                                        'input_value'  => $item['quantity'],
                                                        'max_value'    => $max_quantity,
                                                        'min_value'    => $min_quantity,
                                                        'product_name' => $product_name,
                                                    ),
                                                    $product,
                                                    false
                                                );

                                                echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $key, $item); // PHPCS: XSS ok.
                                                ?>
                                                <button class="h-5 w-5 border flex justify-center items-center" id="cart-quantity-increment" data-product="<?php echo $product_id; ?>">+</button>
                                            </div>

                                            <?php echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                'woocommerce_cart_item_remove_link',
                                                sprintf(
                                                    '<a href="%s" class="remove relative flex justify-center items-center space-x-2" aria-label="%s" data-product_id="%s" data-product_sku="%s">
                                                    <svg class="h-4 w-4 pointer-events-none rtl:ml-2" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12.6001 18H5.31008C3.82508 18 2.65508 16.785 2.65508 15.345V7.2C2.65508 6.93 2.83508 6.75 3.10508 6.75C3.37508 6.75 3.55508 6.93 3.55508 7.2V15.345C3.55508 16.335 4.36508 17.1 5.31008 17.1H12.6001C13.5901 17.1 14.3551 16.29 14.3551 15.345V7.2C14.3551 6.93 14.5351 6.75 14.8051 6.75C15.0751 6.75 15.2551 6.93 15.2551 7.2V15.345C15.2551 16.785 14.0401 18 12.6001 18ZM14.9851 2.205H11.5651C11.3401 0.945 10.2601 0 8.95508 0C7.65008 0 6.57008 0.945 6.34508 2.205H2.92508C1.89008 2.205 1.08008 3.015 1.08008 4.05C1.08008 5.085 1.89008 5.85 2.92508 5.85H15.0301C16.0651 5.85 16.8751 5.04 16.8751 4.005C16.8751 2.97 16.0201 2.205 14.9851 2.205ZM8.95508 0.9C9.76508 0.9 10.4401 1.44 10.6201 2.205H7.24508C7.47008 1.44 8.14508 0.9 8.95508 0.9ZM14.9851 4.95H2.92508C2.43008 4.95 1.98008 4.545 1.98008 4.005C1.98008 3.51 2.38508 3.06 2.92508 3.06H15.0301C15.5251 3.06 15.9751 3.465 15.9751 4.005C15.9301 4.545 15.5251 4.95 14.9851 4.95Z" fill="currentColor" />
                                                        <path d="M5.80498 15.7949C5.53498 15.7949 5.35498 15.6149 5.35498 15.3449V7.82988C5.35498 7.55988 5.53498 7.37988 5.80498 7.37988C6.07498 7.37988 6.25498 7.55988 6.25498 7.82988V15.3449C6.25498 15.5699 6.02998 15.7949 5.80498 15.7949ZM12.105 15.7949C11.835 15.7949 11.655 15.6149 11.655 15.3449V7.82988C11.655 7.55988 11.835 7.37988 12.105 7.37988C12.375 7.37988 12.555 7.55988 12.555 7.82988V15.3449C12.555 15.5699 12.33 15.7949 12.105 15.7949ZM8.95498 15.7949C8.68498 15.7949 8.50498 15.6149 8.50498 15.3449V7.82988C8.50498 7.55988 8.68498 7.37988 8.95498 7.37988C9.22498 7.37988 9.40498 7.55988 9.40498 7.82988V15.3449C9.40498 15.5699 9.17998 15.7949 8.95498 15.7949Z" fill="currentColor" />
                                                    </svg>
                                                    <span class="pointer-events-none">
                                                        ' . __("Remove", "lumi") . '
                                                    </span>
                                                </a>',
                                                    esc_url(wc_get_cart_remove_url($key)),
                                                    /* translators: %s is the product name */
                                                    esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
                                                    esc_attr($product_id),
                                                    esc_attr($product->get_sku())
                                                ),
                                                $key
                                            ); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative md:flex hidden justify-center items-end flex-col space-y-2 cursor-pointer">
                                    <div class="relative flex items-center">
                                        <button class="h-5 w-5 border flex justify-center items-center" id="cart-quantity-decrement" data-product="<?php echo $product_id; ?>">-</button>
                                        <!-- <input name="quantity" value="<?php echo $item["quantity"] ?? 1 ?>" id="cart-quantity" class="pointer-events-none p-0 m-0 w-10 h-5 leading-none text-xs px-2 border bg-transparent placeholder:text-primary-300 text-primary-500 font-semibold outline-none border-none border-transparent outline-transparent focus:outline-none focus-visible:outline-none focus:ring-transparent text-center" type="number" min="1"> -->

                                        <?php
                                        if ($product->is_sold_individually()) {
                                            $min_quantity = 1;
                                            $max_quantity = 1;
                                        } else {
                                            $min_quantity = 0;
                                            $max_quantity = $product->get_max_purchase_quantity();
                                        }

                                        $product_quantity = woocommerce_quantity_input(
                                            array(
                                                'input_name'   => "cart[{$key}][qty]",
                                                'input_value'  => $item['quantity'],
                                                'max_value'    => $max_quantity,
                                                'min_value'    => $min_quantity,
                                                'product_name' => $product_name,
                                            ),
                                            $product,
                                            false
                                        );

                                        echo str_replace('class="input-text qty text"', 'class="cart-quantity pointer-events-none p-0 m-0 w-10 h-5 leading-none text-xs px-2 border bg-transparent placeholder:text-primary-300 text-primary-500 font-semibold outline-none border-none border-transparent outline-transparent focus:outline-none focus-visible:outline-none focus:ring-transparent text-center"', apply_filters('woocommerce_cart_item_quantity', $product_quantity, $key, $item)); // PHPCS: XSS ok.
                                        ?>
                                        <button class="h-5 w-5 border flex justify-center items-center" id="cart-quantity-increment" data-product="<?php echo $product_id; ?>">+</button>
                                    </div>
                                    <?php echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                        'woocommerce_cart_item_remove_link',
                                        sprintf(
                                            '<a href="%s" class="remove relative flex justify-center items-center space-x-2" aria-label="%s" data-product_id="%s" data-product_sku="%s">
                                                    <svg class="pointer-events-none rtl:ml-2" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12.6001 18H5.31008C3.82508 18 2.65508 16.785 2.65508 15.345V7.2C2.65508 6.93 2.83508 6.75 3.10508 6.75C3.37508 6.75 3.55508 6.93 3.55508 7.2V15.345C3.55508 16.335 4.36508 17.1 5.31008 17.1H12.6001C13.5901 17.1 14.3551 16.29 14.3551 15.345V7.2C14.3551 6.93 14.5351 6.75 14.8051 6.75C15.0751 6.75 15.2551 6.93 15.2551 7.2V15.345C15.2551 16.785 14.0401 18 12.6001 18ZM14.9851 2.205H11.5651C11.3401 0.945 10.2601 0 8.95508 0C7.65008 0 6.57008 0.945 6.34508 2.205H2.92508C1.89008 2.205 1.08008 3.015 1.08008 4.05C1.08008 5.085 1.89008 5.85 2.92508 5.85H15.0301C16.0651 5.85 16.8751 5.04 16.8751 4.005C16.8751 2.97 16.0201 2.205 14.9851 2.205ZM8.95508 0.9C9.76508 0.9 10.4401 1.44 10.6201 2.205H7.24508C7.47008 1.44 8.14508 0.9 8.95508 0.9ZM14.9851 4.95H2.92508C2.43008 4.95 1.98008 4.545 1.98008 4.005C1.98008 3.51 2.38508 3.06 2.92508 3.06H15.0301C15.5251 3.06 15.9751 3.465 15.9751 4.005C15.9301 4.545 15.5251 4.95 14.9851 4.95Z" fill="currentColor" />
                                                        <path d="M5.80498 15.7949C5.53498 15.7949 5.35498 15.6149 5.35498 15.3449V7.82988C5.35498 7.55988 5.53498 7.37988 5.80498 7.37988C6.07498 7.37988 6.25498 7.55988 6.25498 7.82988V15.3449C6.25498 15.5699 6.02998 15.7949 5.80498 15.7949ZM12.105 15.7949C11.835 15.7949 11.655 15.6149 11.655 15.3449V7.82988C11.655 7.55988 11.835 7.37988 12.105 7.37988C12.375 7.37988 12.555 7.55988 12.555 7.82988V15.3449C12.555 15.5699 12.33 15.7949 12.105 15.7949ZM8.95498 15.7949C8.68498 15.7949 8.50498 15.6149 8.50498 15.3449V7.82988C8.50498 7.55988 8.68498 7.37988 8.95498 7.37988C9.22498 7.37988 9.40498 7.55988 9.40498 7.82988V15.3449C9.40498 15.5699 9.17998 15.7949 8.95498 15.7949Z" fill="currentColor" />
                                                    </svg>
                                                    <span class="pointer-events-none">
                                                        ' . __("Remove", "lumi") . '
                                                    </span>
                                                </a>',
                                            esc_url(wc_get_cart_remove_url($key)),
                                            /* translators: %s is the product name */
                                            esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
                                            esc_attr($product_id),
                                            esc_attr($product->get_sku())
                                        ),
                                        $key
                                    ); ?>
                                </div>
                                <div class="relative  md:flex hidden justify-center items-center">
                                    <span class="text-xl font-medium">
                                        <?php echo wc_price($product_price); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>

                    <?php endif; ?>

                <?php endforeach; ?>
                <!-- end for large device -->
            </div>
            <!-- end:cart body -->
        </div>
        <!-- start:category sidebar -->
        <div class="relative lg:col-span-3 space-y-3 font-normal " id="lumi-cart-sidebar">
            <!-- start:category sidebar -->
            <?php get_template_part("template/section/cart/sidebar", null, []); ?>
            <!-- start:category sidebar -->
        </div>
        <!-- start:category sidebar -->

    </div>
    <?php do_action('woocommerce_after_cart_table'); ?>

</form>


<section id="empty-cart-page" class="relative py-10 md:mt-14 mt-10 prose dark:prose-invert min-h-[calc(60vh-112px)] lg:px-8 sm:px-7 xs:px-5 px-4 xl:overflow-visible overflow-hidden not-prose bg-[#F4FFFB] flex justify-center items-center <?php echo count(lumi_get_cart()) != 0 ? "hidden" : "" ?>">
    <div class="relative container h-full flex justify-center items-center gap-4">
        <svg width="99" height="69" viewBox="0 0 99 69" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M87.9076 69H11.1934L22.2859 6.47522H99.0001L87.9076 69Z" fill="#92B193" />
            <path d="M48.5411 0H23.4343L22.2856 6.47518H49.1542L48.5411 0Z" fill="#92B193" />
            <g opacity="0.1">
                <path d="M87.9076 69H11.1934L22.2859 6.47522H99.0001L87.9076 69Z" fill="#F7F8F6" />
                <path d="M48.5411 0H23.4343L22.2856 6.47518H49.1542L48.5411 0Z" fill="#F7F8F6" />
            </g>
            <path d="M20.7256 2.64166V0.463745" stroke="#575757" stroke-miterlimit="10" />
            <path d="M18.4947 3.28273L17.3989 1.39661" stroke="#575757" stroke-miterlimit="10" />
            <path d="M16.8848 4.94662L14.9873 3.85779" stroke="#575757" stroke-miterlimit="10" />
            <path d="M16.328 7.18762H14.1367" stroke="#575757" stroke-miterlimit="10" />
            <path d="M16.9734 9.40503L15.0757 10.4939" stroke="#575757" stroke-miterlimit="10" />
            <path d="M18.6475 11.0046L17.5518 12.8905" stroke="#575757" stroke-miterlimit="10" />
            <path d="M20.9023 11.558V13.7359" stroke="#575757" stroke-miterlimit="10" />
            <path d="M23.1333 10.9169L24.2288 12.803" stroke="#575757" stroke-miterlimit="10" />
            <path d="M24.7427 9.25269L26.6404 10.3415" stroke="#575757" stroke-miterlimit="10" />
            <path d="M25.2998 7.01196H27.4911" stroke="#575757" stroke-miterlimit="10" />
            <path d="M24.6543 4.79452L26.552 3.70569" stroke="#575757" stroke-miterlimit="10" />
            <path d="M22.98 3.19496L24.0755 1.30884" stroke="#575757" stroke-miterlimit="10" />
            <path d="M87.7949 68.9999H10.9153L0 8.74487H76.8797L87.7949 68.9999Z" fill="#92B193" />
            <path d="M29.8357 42.4036C29.8357 43.0317 29.6483 43.6457 29.2972 44.168C28.9461 44.6903 28.447 45.0973 27.8631 45.3377C27.2792 45.5781 26.6367 45.641 26.0169 45.5184C25.397 45.3959 24.8276 45.0934 24.3808 44.6493C23.9339 44.2051 23.6295 43.6392 23.5062 43.0232C23.3829 42.4071 23.4462 41.7685 23.6881 41.1882C23.9299 40.6079 24.3395 40.1119 24.865 39.7629C25.3905 39.4139 26.0083 39.2277 26.6403 39.2277C27.4878 39.2277 28.3005 39.5623 28.8998 40.1579C29.499 40.7535 29.8357 41.5613 29.8357 42.4036Z" fill="#575757" />
            <path d="M55.097 42.4036C55.097 43.0318 54.9096 43.6459 54.5585 44.1682C54.2074 44.6906 53.7083 45.0977 53.1244 45.3381C52.5404 45.5786 51.8979 45.6415 51.278 45.519C50.658 45.3964 50.0886 45.094 49.6417 44.6498C49.1947 44.2056 48.8903 43.6397 48.767 43.0235C48.6437 42.4074 48.7069 41.7688 48.9488 41.1884C49.1907 40.608 49.6003 40.112 50.1258 39.763C50.6513 39.4139 51.2692 39.2277 51.9013 39.2277C52.7488 39.2277 53.5616 39.5623 54.1609 40.1579C54.7602 40.7534 55.0969 41.5612 55.097 42.4036Z" fill="#575757" />
            <path d="M43.8604 46.0865L43.6842 45.7537C43.668 45.7239 42.0173 42.6912 38.6957 42.6912C35.6665 42.6912 34.928 45.5467 34.898 45.6679L34.8084 46.032L34.0757 45.8568L34.1638 45.4927C34.1724 45.4574 35.0639 41.9414 38.696 41.9414C42.4821 41.9414 44.2786 45.265 44.3532 45.4063L44.5294 45.7389L43.8604 46.0865Z" fill="#575757" />
        </svg>

        <div class="relative grid">
            <h2 class="text-sm font-semibold">Your shopping cart is empty.</h2>
            <a class="text-primary-500 underline hover:underline" href="<?php echo site_url("/shop") ?>">
                Continue shopping.
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>