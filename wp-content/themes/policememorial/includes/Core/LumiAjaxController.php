<?php

namespace AwesomeCoder\Lumi\Core;

class LumiAjaxController
{
    /**
     * Handle the wishlist for functionality.
     *
     * @since    1.0.0
     */
    public function wishlist()
    {
        try {
            $request = json_decode(file_get_contents('php://input'));
            // $product_id = $request->product_id;
            $product_id = $_REQUEST["product_id"];
            // global $woocommerce;
            // echo $count;
            // $user =  wp_get_current_user()->data;

            // send not allowed error
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                return lumi_response([
                    "success" => false,
                    "message" => __('Method Not Allowed.', 'lumi'),
                ], 405);
            }

            // send not allowed error
            if (!$product_id) {
                return lumi_response([
                    "success" => false,
                    "message" => __('Unacceptable Entries.', 'lumi'),
                    "errors"  => [
                        "product_id" => [
                            "Product ID can't be empty!"
                        ]
                    ]
                ], 422);
            }


            // $items = [];
            // foreach (range(1, 10) as $key => $item) {
            //     $session_wishlist = isset($_SESSION["lumi_wishlist"]) ? $_SESSION["lumi_wishlist"] : [];
            //     $items[] = $item;
            // }
            // $_SESSION["lumi_wishlist"] = $items;
            // $_SESSION["lumi_wishlist"] = [33, 34, 26];

            // get wishlist
            $session_wishlist = isset($_SESSION["lumi_wishlist"]) && is_array($_SESSION["lumi_wishlist"]) ? $_SESSION["lumi_wishlist"] : [];

            if (is_user_logged_in()) {
                $user_id = get_current_user_id();
                $wishlist = get_option("lumi_wishlist_$user_id", $session_wishlist);
                $wishlist = is_array($wishlist) ? $wishlist : $session_wishlist;

                if (in_array($product_id, $wishlist)) {
                    unset($wishlist[array_search($product_id, $wishlist)]);
                    $new_wishlist = array_unique(array_values($wishlist));
                } else {
                    $new_wishlist = array_unique(array_merge([$product_id], $wishlist));
                }

                update_option("lumi_wishlist_$user_id", $new_wishlist);
            } else {
                if (in_array($product_id, $session_wishlist)) {
                    unset($session_wishlist[array_search($product_id, $session_wishlist)]);
                    $new_wishlist = array_unique(array_values($session_wishlist));
                } else {
                    $new_wishlist = array_unique(array_merge([$product_id], $session_wishlist));
                }
            }

            // set session wishlist
            $_SESSION["lumi_wishlist"] = $new_wishlist;

            return lumi_response([
                "message" => __("Successfully updated to wishlist.", "lumi"),
                "data"    => [
                    "wishlist" => $new_wishlist,
                    // "request" => $_REQUEST,
                    // "wishlist" => $wishlist,
                    // "user" => $user,
                    // "woocommerce" => $woocommerce
                ]
            ]);
        } catch (\Exception $e) {
            return lumi_response([
                "success" => false,
                "message" => $e->getMessage(),
            ], 405);
        }
    }

    /**
     * Handle the remove from cart.
     *
     * @since    1.0.0
     */
    public function removeFromCart()
    {
        try {
            $product_id = $_REQUEST["product_id"];

            // send not allowed error
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                return lumi_response([
                    "success" => false,
                    "message" => __('Method Not Allowed.', 'lumi'),
                ], 405);
            }

            // send not allowed error
            if (!$product_id) {
                return lumi_response([
                    "success" => false,
                    "message" => __('Unacceptable Entries.', 'lumi'),
                    "errors"  => [
                        "product_id" => [
                            "Product ID can't be empty!"
                        ]
                    ]
                ], 422);
            }

            // Loop through cart items and remove the one with the specified product ID
            foreach (lumi_get_cart() as $key => $item) {
                if ($item['product_id'] == $product_id) {
                    WC()?->cart->remove_cart_item($key);
                    break; // Exit the loop after removing the item
                }
            }

            return lumi_response([
                "message" => __("Successfully updated to wishlist.", "lumi"),
                "data" => [
                    "fragments" => $this->lumi_cart_fragment(WC()?->cart?->cart_contents_count ?? 0),
                    "empty" => WC()?->cart?->cart_contents_count == 0,
                    "sidebar" => lumi_cart_sidebar()
                ]
            ]);
        } catch (\Exception $e) {
            return lumi_response([
                "success" => false,
                "message" => $e->getMessage(),
            ], 405);
        }
    }

    /**
     * Handle the fragment
     *
     * @since    1.0.0
     */
    function lumi_cart_fragment($count = 0)
    {

        $lumi_cart_fragment = "<svg class=\"mr-1.5 rtl:ml-1.5\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M16.651 6.5984C16.651 4.21232 14.7167 2.27799 12.3307 2.27799C11.1817 2.27316 10.0781 2.72619 9.26387 3.53695C8.44968 4.3477 7.992 5.44939 7.992 6.5984M16.5137 21.5H8.16592C5.09955 21.5 2.74715 20.3924 3.41534 15.9348L4.19338 9.89359C4.60528 7.66934 6.02404 6.81808 7.26889 6.81808H17.4474C18.7105 6.81808 20.0469 7.73341 20.5229 9.89359L21.3009 15.9348C21.8684 19.889 19.5801 21.5 16.5137 21.5Z\" stroke=\"currentColor\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\" /><path d=\"M15.296 11.102H15.251\" stroke=\"#2D2D2D\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\" /><path d=\"M9.46604 11.102H9.42004\" stroke=\"#2D2D2D\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\" /></svg>\nbag";

        if ($count > 0) {
            $lumi_cart_fragment .= "<span class=\"absolute -top-2 left-3 h-4 w-4 text-[8px] font-medium flex justify-center items-center rounded-full bg-primary-500 text-white\">{$count}</span>";
        }

        $lumi_cart_mobile_fragment = '<svg class="mr-1.5 rtl:ml-1.5 h-14 w-8" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.651 6.5984C16.651 4.21232 14.7167 2.27799 12.3307 2.27799C11.1817 2.27316 10.0781 2.72619 9.26387 3.53695C8.44968 4.3477 7.992 5.44939 7.992 6.5984M16.5137 21.5H8.16592C5.09955 21.5 2.74715 20.3924 3.41534 15.9348L4.19338 9.89359C4.60528 7.66934 6.02404 6.81808 7.26889 6.81808H17.4474C18.7105 6.81808 20.0469 7.73341 20.5229 9.89359L21.3009 15.9348C21.8684 19.889 19.5801 21.5 16.5137 21.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /><path d="M15.296 11.102H15.251" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /><path d="M9.46604 11.102H9.42004" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg>';

        if ($count > 0) {
            $lumi_cart_mobile_fragment .= "<span class=\"absolute top-2.5 -right-0.5 h-4 w-4 mr-1 mt-0.5 text-[8px] font-medium flex justify-center items-center rounded-full bg-primary-500 text-white\">{$count}</span>";
        }

        $fragments["lumi_cart_fragment"] = $lumi_cart_fragment;
        $fragments["lumi_cart_mobile_fragment"] = $lumi_cart_mobile_fragment;

        return $fragments;
    }

    /**
     * Handle the updated the cart.
     *
     * @since    1.0.0
     */
    public function updateCart()
    {
        try {
            $product_id = isset($_REQUEST["product_id"]) ? intval($_REQUEST["product_id"]) : null;
            $quantity = isset($_REQUEST["quantity"]) ? intval($_REQUEST["quantity"]) : 1;

            // send not allowed error
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                return lumi_response([
                    "success" => false,
                    "message" => __('Method Not Allowed.', 'lumi'),
                ], 405);
            }

            // send not allowed error
            if (!$product_id) {
                return lumi_response([
                    "success" => false,
                    "message" => __('Unacceptable Entries.', 'lumi'),
                    "errors"  => [
                        "product_id" => [
                            "Product ID can't be empty!"
                        ]
                    ]
                ], 422);
            }

            // get cart
            $cart = WC()?->cart;

            // Loop through cart items and remove the one with the specified product ID
            foreach (lumi_get_cart() as $key => $item) {
                if ($item['product_id'] == $product_id) {
                    if ($quantity < 1) {
                        $cart->remove_cart_item($key);
                    } else {
                        // Update the quantity for the specific cart item
                        $cart->set_quantity($key, $quantity);
                    }
                    break; // Exit the loop after removing the item
                }
            }

            // Save the cart to persist the changes
            // $cart->calculate_totals();
            // $cart->save();

            return lumi_response([
                "message" => __("Successfully updated to wishlist.", "lumi"),
                "data" => [
                    "fragments" => $this->lumi_cart_fragment(WC()?->cart?->cart_contents_count ?? 0),
                    "empty" => WC()?->cart?->cart_contents_count == 0,
                    "sidebar" => lumi_cart_sidebar()
                ]
            ]);
        } catch (\Exception $e) {
            return lumi_response([
                "success" => false,
                "message" => $e->getMessage(),
            ], 405);
        }
    }

    /**
     * Handle the login.
     *
     * @since    1.0.0
     */
    public function login()
    {
        try {
            $email = isset($_REQUEST["email"]) ? sanitize_email($_REQUEST["email"]) : null;
            $password = isset($_REQUEST["password"]) ? $_REQUEST["password"] : null;

            // send not allowed error
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                return lumi_response([
                    "success" => false,
                    "message" => __('Method Not Allowed.', 'lumi'),
                ], 405);
            }

            // send not allowed error
            if (!$email || !$password) {
                return lumi_response([
                    "success" => false,
                    "message" => __('Unacceptable Entries.', 'lumi'),
                    "errors"  => [
                        __("Please fill all required fields.")
                    ]
                ], 422);
            }

            $creds = array(
                'user_login'    => $email,
                'user_password' => $password,
                'remember'      => isset($_REQUEST["rememberme"]) ? 'true' : 'false'
            );

            $user = wp_signon($creds, false);

            if (!is_wp_error($user)) {
                return lumi_response([
                    "message" => __("You have successfully logged in.", "lumi"),
                ]);
            } else {
                return lumi_response([
                    "success" => false,
                    "message" => __('Unacceptable Entries.', 'lumi'),
                    "errors"  => [$user->get_error_message()]
                ], 422);
            }
        } catch (\Exception $e) {
            return lumi_response([
                "success" => false,
                "message" => $e->getMessage(),
            ], 405);
        }
    }
}
