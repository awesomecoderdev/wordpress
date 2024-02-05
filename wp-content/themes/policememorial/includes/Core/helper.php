<?php

/**
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 * @package           lumi
 *
 *
 * ======================================================================================
 * 		The Core Function of Helpers
 * ======================================================================================                                                              _
 *                                                             | |
 *    __ ___      _____  ___  ___  _ __ ___   ___  ___ ___   __| | ___ _ __
 *   / _` \ \ /\ / / _ \/ __|/ _ \| '_ ` _ \ / _ \/ __/ _ \ / _` |/ _ \ '__|
 *  | (_| |\ V  V /  __/\__ \ (_) | | | | | |  __/ (_| (_) | (_| |  __/ |
 *   \__,_| \_/\_/ \___||___/\___/|_| |_| |_|\___|\___\___/ \__,_|\___|_|
 *
 */

if (!class_exists("Lumi")) {
    require __DIR__ . "/lumi.php";
}


use AwesomeCoder\Lumi\Core\Lumi;

/**
 * The loader of the Theme.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('lami')) {
    function lami()
    {
        $instance = new Lumi();
        return $instance;
    }
}


/**
 * The loader of the Theme.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('lami_version')) {
    function lami_version($file, $version)
    {
        if ($file && file_exists(get_template_directory("$file"))) {
            $version = filemtime(get_template_directory("$file"));
        }
        return $version;
    }
}



/**
 * The url builder.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('url')) {
    /**
     * Generate a url for the application.
     *
     * @param  string|null  $path
     * @param  mixed  $parameters
     */
    function url($path = null, $parameters = [])
    {
        $params = http_build_query($parameters);

        if (!is_null($path)) {
            if (defined("LUMI_THEME_URL")) {
                $path = LUMI_THEME_URL . "assets/$path";
            } else {
                $path = "wp-content/themes/lumi/$path";
            }
        } else {
            $path = "wp-content/themes/lumi/";
        }

        if (strpos($path, "?") !== false) {
            $path = "$path&";
        } else {
            $path = $params ? "$path?" : $path;
        }

        return $path . $params;
    }
}


/**
 * The dump and die function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('dd')) {
    /**
     * @return never
     */
    function dd(...$vars): void
    {
        if (!in_array(\PHP_SAPI, ['cli', 'phpdbg'], true) && !headers_sent()) {
            header('HTTP/1.1 500 Internal Server Error');
        }

        foreach ($vars as $v) {
            echo "<pre>";
            print_r($v);
            echo "</pre>";
        }

        exit(1);
    }
}


/**
 * The lumi_resource function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('lumi_resource')) {
    function lumi_resource(string $view = null, bool $echo = true, array $atts = [])
    {

        $path = LUMI_THEME_PATH . "app/Backend/partials/$view.php";
        if ($view != null && file_exists($path)) {
            ob_start();
            include_once $path;
            $output = ob_get_contents();
            ob_end_clean();
        } else {
            $output = '<div id="lumiLoadingScreen" class="fixed inset-0 z-[99999999999] h-screen overflow-hidden block bg-white duration-500"></div>';
            // $output .= '<script>const lumiLoadingScreen=document.getElementById("lumiLoadingScreen"),plStyles=document.querySelectorAll("link"),plScripts=document.querySelectorAll("script"),plStyleTags=document.querySelectorAll("style");plStyles.forEach((e=>{const t=e.getAttribute("rel"),l=e.getAttribute("id");"stylesheet"==t&&"wp-plagiarism-backend-css"!=l&&e.remove()})),plStyleTags.forEach((e=>{e.remove()})),plScripts.forEach((e=>{e.getAttribute("src")&&e.remove()})),setTimeout((()=>{lumiLoadingScreen&&(lumiLoadingScreen.classList.add("opacity-0"),lumiLoadingScreen.remove())}),1e3);</script>';
        }

        if ($echo) {
            echo $output;
            die;
        } else {
            return $output;
            die;
        }
    }
}

/**
 * The is_shop function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('is_shop')) {
    function is_shop()
    {
        return is_front_page();
    }
}


/**
 * The is_account_page function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
// if (!function_exists('is_account_page')) {
//     function is_account_page()
//     {
//         return lumi_path("my-account");
//     }
// }


/**
 * The is_cart function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('is_cart')) {
    function is_cart()
    {
        return false;
    }
}


/**
 * The wp_is_tablet function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('wp_is_tablet')) {
    function wp_is_tablet()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];

        // Check for common tablet User-Agent strings
        $tabletUserAgents = array(
            'iPad',
            'Android',
            'Kindle',
            'SamsungTablet',
            'Nexus 7',
            // Add more tablet user agents as needed
        );

        foreach ($tabletUserAgents as $agent) {
            if (stripos($userAgent, $agent) !== false) {
                return true;
            }
        }

        return false;
    }
}

/**
 * The lumi_path function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('lumi_path')) {
    function lumi_path($path = false)
    {
        $url = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : (isset($_SERVER["PHP_SELF"]) ? $_SERVER["PHP_SELF"] : "/");
        $slug = explode("/", $url, 3);
        $slug = isset($slug[0]) && !empty($slug[0]) ? $slug[0] : (isset($slug[1]) && !empty($slug[1]) ? $slug[1] : $url);

        return $path ? ($slug == $path) : $slug;
    }
}


/**
 * The lumi_scheme function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('lumi_scheme')) {
    function lumi_scheme()
    {
        try {
            $url = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : (isset($_SERVER["PHP_SELF"]) ? $_SERVER["PHP_SELF"] : "/");
            $slug = explode("/", $url);
            $slug = array_unique($slug);
            $slug =  array_filter($slug, function ($value) {
                return !empty($value);
            });
            $slug[] = "";
            return $slug;
        } catch (\Throwable $th) {
            //throw $th;
            return [];
        }
    }
}


/**
 * The get_lumi_categories function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('get_lumi_categories')) {
    function get_lumi_categories($args = [])
    {
        $default = array(
            'taxonomy'      => 'product_cat', // Taxonomy for product categories
            'title_li'      => '', // Remove the default title
            'orderby'       => 'count', // Order by the number of products
            'order'         => 'DESC',  // Descending order (most products first)
            // 'child_of'      => 0,
            // 'parent'        => 0,
            'fields'        => 'all',
            'hide_empty'    => false,
            'number'        => 4,
        );

        $args = array_merge($default, $args);

        $categories = new \WP_Term_Query($args);
        // $terms = get_terms($args);
        $terms = $categories->terms;
        // $terms = $categories;

        return $terms ?? [];
    }
}

/**
 * The get_lumi_product_color function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('get_lumi_product_color')) {
    function get_lumi_product_color($id = false)
    {
        $default = "green";

        if ($id) {
            $term = get_term($id);
            $color = get_term_meta($id, "color", true);

            if ($color) {
                return $color;
            } else {
                $term = get_term($id);
                if ($term?->slug) {
                    $color =  $term?->slug;
                }
            }
        }

        return $color ?? $default;
    }
}


/**
 * The get_lumi_filter_url function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('get_lumi_filter_url')) {
    function get_lumi_filter_url($term = null)
    {
        $query = [];
        $object = get_queried_object();
        $url = $object && is_a($object, 'WP_Term') ? get_term_link($object) : site_url("/");
        $color = isset($_GET["colors"]) && !empty($_GET["colors"]) ? sanitize_text_field(strtolower($_GET["colors"])) : null;
        $search = isset($_GET["s"]) && !empty($_GET["s"]) ? sanitize_text_field(get_search_query()) : null;
        if ($color) {
            $colors = explode(",", $color);

            $colors = array_values(array_unique($colors));

            if (isset($term->slug)) {
                if (!in_array("$term->slug", $colors)) {
                    $colors = array_merge($colors, [$term->slug]);
                } else {
                    unset($colors[array_search("$term->slug", $colors)]);
                }
                $query["colors"] = is_array($colors) ? implode(",", $colors) : "$term->slug";
            } else {
                if (is_array($colors)) {
                    $query["colors"] = implode(",", $colors);
                }
            }
        } else {
            if (isset($term->slug)) {
                $query["colors"] = "$term->slug";
            }
        }


        if ($term) {
            if ($search) {
                $query["s"] = $search;
            }
        }


        $params = http_build_query($query);


        if (strpos($url, "?") !== false) {
            $url = "$url&";
        } else {
            $url = $params ? "$url?" : $url;
        }

        $params = str_replace("%2C", ",", $params);

        return $url . $params;
    }
}


/**
 * The get_lumi_request_colors function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('get_lumi_request_colors')) {
    function get_lumi_request_colors()
    {
        $color = isset($_GET["colors"]) && !empty($_GET["colors"]) ? sanitize_text_field(strtolower($_GET["colors"])) : null;
        if ($color) {
            $colors = explode(",", $color);
            $colors = array_values(array_unique($colors));

            return $colors;
        }

        return [];
    }
}

/**
 * The clog function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('clog')) {
    function clog($log = false)
    {
        echo "<script>console.log('======================================================================');</script>";
        if (is_array($log) || is_object($log)) {
            $log = json_encode($log, JSON_PRETTY_PRINT);
            echo "<script>console.log([$log]);</script>";
        } else {
            echo "<script>console.log('$log');</script>";
        }
        echo "<script>console.log('======================================================================');</script>";
    }
}

/**
 * The lumi_get_wishlist function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('lumi_get_wishlist')) {
    function lumi_get_wishlist($extra = "")
    {
        // $items = [];
        // foreach (range(1, 10) as $key => $item) {
        //     $session_wishlist = isset($_SESSION["lumi_wishlist"]) ? $_SESSION["lumi_wishlist"] : [];
        //     $items[] = $item;
        // }
        // $_SESSION["lumi_wishlist"] = $items;
        // $_SESSION["lumi_wishlist"] = [33, 34, 26];

        $session_wishlist = isset($_SESSION["lumi_wishlist"]) && is_array($_SESSION["lumi_wishlist"]) ? $_SESSION["lumi_wishlist"] : [];

        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $wishlist = get_option("lumi_wishlist_$user_id", $session_wishlist);
            $wishlist = is_array($wishlist) ? $wishlist : $session_wishlist;

            // $unique_wishlist = array_merge($session_wishlist, $wishlist);
            // $new_wishlist = array_unique(array_values($unique_wishlist));

            $new_wishlist = array_unique(array_values($wishlist));

            update_option("lumi_wishlist_$user_id", $new_wishlist);
        } else {
            $wishlist = is_array($session_wishlist) ? $session_wishlist : [];
            $new_wishlist = array_unique(array_values($session_wishlist));
        }

        return array_merge(["lumi"], $new_wishlist);
    }
}

/**
 * The lumi_get_cart function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('lumi_get_cart')) {
    function lumi_get_cart()
    {
        try {
            global $woocommerce;

            return $woocommerce?->cart?->get_cart() ?? [];
        } catch (\Exception $e) {
            //throw $e;
        }

        return [];
    }
}

/**
 * The lumi_cart function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('lumi_cart')) {
    function lumi_cart()
    {
        try {

            return $cart = WC()?->cart;
        } catch (\Exception $e) {
            //throw $e;
        }

        return null;
    }
}


/**
 * The lumi_get_cart_total function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('lumi_get_cart_total')) {
    function lumi_get_cart_total($default = 0)
    {
        try {
            // Get the cart instance
            $cart = WC()?->cart;

            // Get the cart total
            return $cart?->get_cart_contents_total() ?? $default;
        } catch (\Exception $e) {
            //throw $e;
        }

        return $default;
    }
}

/**
 * The WC function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('WC')) {
    function WC()
    {
        return null;
    }
}

/**
 * The lumi_get_cart_count function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('lumi_get_cart_count')) {
    function lumi_get_cart_count()
    {
        try {
            global $woocommerce;
            return $woocommerce?->cart?->cart_contents_count ?? 0;
        } catch (\Exception $e) {
            //throw $e;
        }

        return 0;
    }
}

/**
 * The lumi_get_products function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('lumi_get_products')) {
    function lumi_get_products($args = [])
    {
        $default = array(
            'post_type'         => 'product',
            'posts_per_page'    => -1, // Set to -1 to get all products
            'order_by'          => "name",
            'order'             => "ASC"
        );

        $args = array_merge($default, $args);

        $products = new \WP_Query($args);

        return $products;
    }
}



/**
 * The wc_price function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('wc_price')) {
    function wc_price($price = 0)
    {
        return $price;
    }
}




/**
 * The get_lumi_categories_image function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('get_lumi_categories_image')) {
    function get_lumi_categories_image($id = false)
    {
        if ($id) {
            $thumbnail_id = get_term_meta($id, 'thumbnail_id', true);
            $image = wp_get_attachment_url($thumbnail_id);

            if (!empty($image)) {
                return $image;
            }
        }

        return url('img/category/lumi.png');
    }
}


/**
 * The lumi_container function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('lumi_container')) {
    function lumi_container($extra = "")
    {
        $default = "relative container prose dark:prose-invert min-h-[calc(60vh-112px)] lg:px-8 sm:px-7 xs:px-5 px-4 xl:overflow-visible overflow-hidden";

        return "$default $extra";
    }
}


/**
 * The lumi_response function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('lumi_response')) {
    function lumi_response(array $contents = [], $status = 200, array $headers = [])
    {
        $response = [
            "success" => true,
            "status" => $status,
            "message" => "Successfully Authorized.",
        ];

        $response = array_merge($response, $contents);

        // Set the HTTP response code
        http_response_code($status);

        // Set the response headers
        foreach ($headers as $header) {
            header($header);
        }

        // Encode the content as JSON and send it as the response body
        header('Content-Type: application/json');
        echo json_encode($response);
        wp_die();
    }
}


/**
 * The lumi_cart_sidebar function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('lumi_cart_sidebar')) {
    function lumi_cart_sidebar()
    {
        ob_start();
        include_once LUMI_THEME_PATH . "/template/section/cart/sidebar.php";
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}


/**
 * The get_product_gallery_images function.
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 *
 */
if (!function_exists('get_product_gallery_images')) {
    function get_product_gallery_images($id = false)
    {
        $output = [];
        try {
            $id = $id ? $id : get_the_ID();
            $product = wc_get_product($id);
            $images = $product->get_gallery_image_ids();

            $output[] = get_the_post_thumbnail_url($id);

            foreach ($images as $key => $attachment) {
                // Display the image URL
                $output[] = wp_get_attachment_url($attachment);
                // $output[$key]["original"] = wp_get_attachment_url($attachment);

                // Display Image instead of URL
                // $output[$key]["full"] = wp_get_attachment_image($attachment, 'full');
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        if (count($output) <= 3) {
            $range = range((count($output)), 2);
            foreach ($range as $key => $value) {
                $output[] = esc_url(wc_placeholder_img_src());
            }
        }

        return $output;
    }
}
