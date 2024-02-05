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

// global $woocommerce;
// $products = $woocommerce->cart->get_cart();

$categories = lumi_get_products([
    'post_type' => 'page',
    'post_status' => 'publish',
    'post_name__in' => ['man', 'woman', 'kids'], // Replace with your slugs
    'orderby' => 'title', // Order by post title (name)
    'order' => 'DESC',     // Order in ascending order
]);

// echo "<pre>";
// print_r($categories->posts);
// echo "</pre>";

// die;

// echo "<pre>";
// print_r(get_lumi_categories(["number" => 8]));
// echo "</pre>";
// die;

?>

<?php get_header(); ?>

<main id="main" class="<?php echo lumi_container("py-10 not-prose md:block hidden"); ?>">
    <?php $the_categories_index = 0; ?>
    <?php if ($categories->have_posts()) : ?>
        <div class="relative grid grid-cols-10 gap-5 ">
            <a href="<?php
                        echo site_url("/categories/woman")

                        //echo get_the_permalink($categories->posts[0]->ID);
                        ?>" class="relative col-span-6">
                <img class="h-full w-full hidden  bg-gray-200 bg-contain bg-center bg-no-repeat rounded-xl aspect-[4/4]" sr="<?php echo get_the_post_thumbnail_url($categories->posts[0]->ID); ?>)" src="https://images.unsplash.com/photo-1504903953708-1a3669833567?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1662&q=80">
                </img>
                <div class="relative bg-gray-200 overflow-hidden bg-img-cover bg-center bg-no-repeat rounded-xl h-full w-full aspect-[4/4]" style="background: url(https://images.unsplash.com/photo-1504903953708-1a3669833567?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1662&q=80);">
                </div>
                <h2 class="text-6xl text-white absolute bottom-[10%] left-1/2 transform translate-x-[-50%] font-semibold"><?php echo get_the_title($categories->posts[0]->ID) ?></h2>
            </a>
            <div class="relative col-span-4 h-full w-full">
                <div class="relative grid gap-5">
                    <a class="relative" href="<?php
                                                echo site_url("/categories/man")

                                                //echo get_the_permalink($categories->posts[1]->ID);
                                                ?>">
                        <img class="h-full hidden w-full bg-gray-200 bg-contain bg-center bg-no-repeat rounded-xl aspect-[4/3]" sr="<?php echo get_the_post_thumbnail_url($categories->posts[1]->ID); ?>)" src="https://plus.unsplash.com/premium_photo-1672857822411-ad82b8180078?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2787&q=80">
                        </img>
                        <div class="relative bg-gray-200 overflow-hidden bg-img-cover bg-center bg-no-repeat rounded-xl h-full w-full aspect-[4/3]" style="background: url(https://plus.unsplash.com/premium_photo-1672857822411-ad82b8180078?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2787&q=80);">
                        </div>
                        <h2 class="text-6xl text-white absolute bottom-[10%] left-1/2 transform translate-x-[-50%] font-semibold"><?php echo get_the_title($categories->posts[1]->ID) ?></h2>

                    </a>
                    <a class="relative" href="<?php
                                                echo site_url("/categories/kids")
                                                // echo get_the_permalink($categories->posts[2]->ID);

                                                ?>">
                        <img class="h-full hidden w-full bg-gray-200 bg-contain bg-center bg-no-repeat rounded-xl aspect-[4/3]" src="<?php echo get_the_post_thumbnail_url($categories->posts[2]->ID); ?>)">
                        </img>
                        <div class="relative bg-gray-200 overflow-hidden bg-img-cover bg-center bg-no-repeat rounded-xl h-full w-full aspect-[4/3]" style="background: url(https://images.unsplash.com/photo-1607453998774-d533f65dac99?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2787&q=80);">
                        </div>
                        <h2 class="text-6xl text-white absolute bottom-[10%] left-1/2 transform translate-x-[-50%] font-semibold"><?php echo get_the_title($categories->posts[2]->ID) ?></h2>
                    </a>

                </div>
            </div>
        </div>

        <!-- end of the loop -->
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
</main>



<section class="relative pt-4 md:hidden">
    <div class="relative">
        <img class="h-full w-full  bg-gray-200 bg-contain bg-center bg-no-repeat aspect-[6/2]" src="<?php echo url("img/category/banner.png"); ?>)">
        </img>
    </div>

    <div class="relative flex justify-between items-center p-4">
        <h2 class="font-semibold"><?php _e("Explore Categories", "lumi"); ?></h2>

        <a class="text-primary-500 flex items-center space-x-2" href="<?php echo site_url("/categories"); ?>">
            <?php _e("View All", "lumi"); ?>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.8299 11.2899L10.5899 7.04995C10.497 6.95622 10.3864 6.88183 10.2645 6.83106C10.1427 6.78029 10.012 6.75415 9.87994 6.75415C9.74793 6.75415 9.61723 6.78029 9.49537 6.83106C9.37351 6.88183 9.26291 6.95622 9.16994 7.04995C8.98369 7.23731 8.87915 7.49076 8.87915 7.75495C8.87915 8.01913 8.98369 8.27259 9.16994 8.45995L12.7099 11.9999L9.16994 15.5399C8.98369 15.7273 8.87915 15.9808 8.87915 16.2449C8.87915 16.5091 8.98369 16.7626 9.16994 16.9499C9.26338 17.0426 9.3742 17.116 9.49604 17.1657C9.61787 17.2155 9.74834 17.2407 9.87994 17.2399C10.0115 17.2407 10.142 17.2155 10.2638 17.1657C10.3857 17.116 10.4965 17.0426 10.5899 16.9499L14.8299 12.7099C14.9237 12.617 14.9981 12.5064 15.0488 12.3845C15.0996 12.2627 15.1257 12.132 15.1257 11.9999C15.1257 11.8679 15.0996 11.7372 15.0488 11.6154C14.9981 11.4935 14.9237 11.3829 14.8299 11.2899Z" fill="currentColor" />
            </svg>
        </a>
    </div>

    <div class="relative grid grid-cols-4 px-4 gap-4">
        <?php foreach (get_lumi_categories(["number" => 8]) as $key => $category) : ?>
            <a class="relative flex justify-center items-center flex-col" href="<?php echo get_term_link($category); ?>">
                <img class="rounded-full h-14 w-14 bg-gray-100 shadow" src="<?php echo get_lumi_categories_image($category->term_id) ?>" alt="">
                <span class="truncate w-16 text-center"><?php echo $category->name; ?></span>
            </a>
        <?php endforeach; ?>
    </div>


    <div class="relative flex justify-between items-center p-4">
        <h2 class="font-semibold"><?php _e("For you", "lumi"); ?></h2>
    </div>

    <div class="relative px-4 grid <?php echo !wp_is_mobile() ? "gap-4" : "xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 grid-cols-2 gap-4" ?>">

        <!-- pagination here -->

        <!-- the loop -->
        <?php

        // get products
        $products = lumi_get_products([
            // "post__in" => lumi_get_wishlist()
        ]);

        ?>

        <?php while ($products->have_posts()) : $products->the_post(); ?>
            <?php
            // Get product details
            $product = wc_get_product(get_the_ID());

            // You can access product data like this:
            $product_id = $product->get_id();
            $product_name = $product->get_name();
            $product_price = $product->get_price();
            $product_sku = $product->get_sku();

            ?>

            <!-- start for small device -->
            <form class="relative add-to-cart-from-wishlist border xl:rounded-3xl rounded-2xl overflow-hidden md:hidden <?php echo !wp_is_mobile() ? "hidden" : "" ?> " method="POST">
                <input type="hidden" name="product_sku" value="<?php echo $product_sku; ?>">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <button class="absolute top-2.5 right-2.5 cursor-pointer" id="add-to-wishlist" data-product="<?php the_ID() ?>">
                    <div class="relative glass rounded-full flex justify-center items-center p-1 text-white">
                        <?php if (!in_array(get_the_ID(), lumi_get_wishlist())) : ?>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 product-wishlist-item product-wishlist-<?php the_ID() ?>">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        <?php else : ?>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 product-wishlist-item product-wishlist-<?php the_ID() ?> text-red-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        <?php endif ?>
                    </div>
                </button>
                <img class="aspect-[3/4] w-full bg-slate-100 dark:bg-slate-400 cursor-pointer" src="<?php the_post_thumbnail_url() ?>" alt="<?php the_title(); ?>">
                <div class="relative w-full flex justify-between items-end p-2 ">
                    <div class="relative grid w-full">
                        <a href="<?php the_permalink() ?>" class="text-xs font-normal truncate w-[95%]">
                            <?php the_title() ?>
                            <?php the_title() ?>
                        </a>
                        <span class="text-primary-600 text-lg font-medium">
                            <?php echo wc_price($product_price); ?>
                        </span>
                    </div>

                    <button type="submit" class="relative flex justify-end items-end text-slate-600 dark:text-white">
                        <svg id="add-to-bag" class="h-6 w-6 p-1" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.235 22.5H3.76499C3.41021 22.5002 3.05946 22.4248 2.73605 22.2789C2.41264 22.1331 2.12398 21.92 1.88925 21.654C1.65453 21.388 1.47911 21.075 1.37467 20.736C1.27023 20.3969 1.23915 20.0395 1.28349 19.6875L2.78349 7.6875C2.86035 7.08347 3.15471 6.52816 3.61148 6.12551C4.06824 5.72286 4.65609 5.50048 5.26499 5.5H12.1845C12.3171 5.5 12.4443 5.55268 12.538 5.64645C12.6318 5.74021 12.6845 5.86739 12.6845 6C12.6845 6.13261 12.6318 6.25979 12.538 6.35355C12.4443 6.44732 12.3171 6.5 12.1845 6.5H5.26499C4.89959 6.4998 4.54667 6.63299 4.27251 6.87456C3.99835 7.11613 3.82179 7.44947 3.77599 7.812L2.27599 19.812C2.24972 20.0232 2.26861 20.2375 2.3314 20.4408C2.39419 20.6442 2.49946 20.8318 2.64023 20.9914C2.781 21.151 2.95407 21.2789 3.14797 21.3666C3.34188 21.4542 3.55219 21.4997 3.76499 21.5H17.235C17.299 21.4879 17.3648 21.4886 17.4286 21.502C17.4923 21.5154 17.5528 21.5413 17.6066 21.5781C17.6603 21.615 17.7063 21.662 17.7418 21.7167C17.7773 21.7713 17.8017 21.8324 17.8135 21.8965C17.8373 22.0276 17.8088 22.1628 17.734 22.273C17.6592 22.3832 17.5441 22.4597 17.4135 22.486C17.3545 22.496 17.2948 22.5007 17.235 22.5ZM18.3845 13.585C18.2626 13.585 18.1449 13.5404 18.0535 13.4596C17.9622 13.3788 17.9035 13.2675 17.8885 13.1465L17.224 7.812C17.1782 7.44947 17.0016 7.11613 16.7275 6.87456C16.4533 6.63299 16.1004 6.4998 15.735 6.5H14.076C13.9434 6.5 13.8162 6.44732 13.7224 6.35355C13.6287 6.25979 13.576 6.13261 13.576 6C13.576 5.86739 13.6287 5.74021 13.7224 5.64645C13.8162 5.55268 13.9434 5.5 14.076 5.5H15.735C16.344 5.5005 16.9319 5.72295 17.3887 6.1257C17.8454 6.52845 18.1397 7.08388 18.2165 7.688L18.881 13.023C18.8974 13.1545 18.8609 13.2872 18.7795 13.3918C18.6981 13.4965 18.5785 13.5645 18.447 13.581C18.4263 13.5836 18.4054 13.5849 18.3845 13.585Z" fill="currentColor" />
                            <path d="M14 9C13.8674 9 13.7402 8.94732 13.6464 8.85355C13.5527 8.75979 13.5 8.63261 13.5 8.5V5.5C13.5 4.70435 13.1839 3.94129 12.6213 3.37868C12.0587 2.81607 11.2956 2.5 10.5 2.5C9.70435 2.5 8.94129 2.81607 8.37868 3.37868C7.81607 3.94129 7.5 4.70435 7.5 5.5V8.5C7.5 8.63261 7.44732 8.75979 7.35355 8.85355C7.25979 8.94732 7.13261 9 7 9C6.86739 9 6.74021 8.94732 6.64645 8.85355C6.55268 8.75979 6.5 8.63261 6.5 8.5V5.5C6.5 4.43913 6.92143 3.42172 7.67157 2.67157C8.42172 1.92143 9.43913 1.5 10.5 1.5C11.5609 1.5 12.5783 1.92143 13.3284 2.67157C14.0786 3.42172 14.5 4.43913 14.5 5.5V8.5C14.5 8.63261 14.4473 8.75979 14.3536 8.85355C14.2598 8.94732 14.1326 9 14 9Z" fill="currentColor" />
                            <path d="M17.5 22.5C16.5111 22.5 15.5444 22.2068 14.7222 21.6574C13.8999 21.1079 13.259 20.3271 12.8806 19.4134C12.5022 18.4998 12.4031 17.4945 12.5961 16.5246C12.789 15.5546 13.2652 14.6637 13.9645 13.9645C14.6637 13.2652 15.5546 12.789 16.5246 12.5961C17.4945 12.4031 18.4998 12.5022 19.4134 12.8806C20.3271 13.259 21.1079 13.8999 21.6574 14.7222C22.2068 15.5444 22.5 16.5111 22.5 17.5C22.4985 18.8256 21.9713 20.0966 21.0339 21.0339C20.0966 21.9713 18.8256 22.4985 17.5 22.5ZM17.5 13.5C16.7089 13.5 15.9355 13.7346 15.2777 14.1741C14.6199 14.6137 14.1072 15.2384 13.8045 15.9693C13.5017 16.7002 13.4225 17.5044 13.5769 18.2804C13.7312 19.0563 14.1122 19.769 14.6716 20.3284C15.231 20.8878 15.9437 21.2688 16.7196 21.4231C17.4956 21.5775 18.2998 21.4983 19.0307 21.1955C19.7616 20.8928 20.3864 20.3801 20.8259 19.7223C21.2654 19.0645 21.5 18.2911 21.5 17.5C21.4988 16.4395 21.077 15.4228 20.3271 14.6729C19.5772 13.923 18.5605 13.5012 17.5 13.5Z" fill="currentColor" class="text-primary-500" />
                            <path d="M17.5 19.5C17.3674 19.5 17.2402 19.4473 17.1464 19.3536C17.0527 19.2598 17 19.1326 17 19V16C17 15.8674 17.0527 15.7402 17.1464 15.6464C17.2402 15.5527 17.3674 15.5 17.5 15.5C17.6326 15.5 17.7598 15.5527 17.8536 15.6464C17.9473 15.7402 18 15.8674 18 16V19C18 19.1326 17.9473 19.2598 17.8536 19.3536C17.7598 19.4473 17.6326 19.5 17.5 19.5Z" fill="currentColor" class="text-primary-500" />
                            <path d="M19 18H16C15.8674 18 15.7402 17.9473 15.6464 17.8536C15.5527 17.7598 15.5 17.6326 15.5 17.5C15.5 17.3674 15.5527 17.2402 15.6464 17.1464C15.7402 17.0527 15.8674 17 16 17H19C19.1326 17 19.2598 17.0527 19.3536 17.1464C19.4473 17.2402 19.5 17.3674 19.5 17.5C19.5 17.6326 19.4473 17.7598 19.3536 17.8536C19.2598 17.9473 19.1326 18 19 18Z" fill="currentColor" class="text-primary-500" />
                        </svg>
                        <!-- start:category sidebar -->
                        <?php get_template_part("template/components/loading", null, [
                            "class" => "text-slate-300 hidden",
                            "id" => "add-to-cart-loading"
                        ]); ?>
                    </button>
                </div>
            </form>
            <!-- end for small device -->

            <!-- start for large device -->
            <form class="relative add-to-cart-from-wishlist md:flex hidden justify-between items-end rounded-lg border p-4  <?php echo wp_is_mobile() ? "hidden" : "" ?>">
                <input type="hidden" name="product_sku" value="<?php echo $product_sku; ?>">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <div class="relative h-full flex items-center gap-4">
                    <div class="relative glass rounded-full flex justify-center items-center p-1 text-primary-500 cursor-pointer" id="add-to-wishlist" data-product="<?php the_ID() ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 product-wishlist-item product-wishlist-<?php the_ID() ?> text-red-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                    </div>
                    <img class="rounded-xl xl:aspect-[3/4] lg:aspect-[3/4] md:aspect-[3/4] w-20 bg-slate-100 dark:bg-slate-400 cursor-pointer" src="<?php the_post_thumbnail_url() ?>" alt="<?php the_title(); ?>">
                    <div class="relative">
                        <h2 class="text-lg font-semibold"><?php the_title(); ?></h2>
                        <span class="text-primary-600 text-xl font-medium">
                            <?php echo wc_price($product_price); ?>
                        </span>
                        <div class="relative flex">
                            <button class="h-5 w-5 border flex justify-center items-center" id="wishlist-quantity-decrement">-</button>
                            <input name="quantity" id="wishlist-quantity" class="p-0 m-0 w-10 h-5 leading-none text-xs px-2 border placeholder:text-primary-300 text-primary-500 font-semibold outline-none border-none border-transparent outline-transparent focus:outline-none focus-visible:outline-none focus:ring-transparent text-center" type="number" min="1" value="1">
                            <button class="h-5 w-5 border flex justify-center items-center" id="wishlist-quantity-increment">+</button>
                        </div>
                    </div>
                </div>


                <div class="relative">
                    <button type="submit" class="relative bg-primary-500 px-5 py-2 flex justify-center items-center gap-2 text-white rounded-lg">
                        <svg id="add-to-bag" class="h-6 w-6 p-1" width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.651 5.5984C14.651 3.21232 12.7167 1.27799 10.3307 1.27799C9.18168 1.27316 8.07806 1.72619 7.26387 2.53695C6.44968 3.3477 5.992 4.44939 5.992 5.5984M14.5137 20.5H6.16592C3.09955 20.5 0.747152 19.3924 1.41534 14.9348L2.19338 8.89359C2.60528 6.66934 4.02404 5.81808 5.26889 5.81808H15.4474C16.7105 5.81808 18.0469 6.73341 18.5229 8.89359L19.3009 14.9348C19.8684 18.889 17.5801 20.5 14.5137 20.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M13.296 10.102H13.251" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M7.46601 10.102H7.42001" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <!-- start:category sidebar -->
                        <?php get_template_part("template/components/loading", null, [
                            "class" => "hidden",
                            "id" => "add-to-cart-loading"
                        ]); ?>
                        <!-- start:category sidebar -->
                        <?php _e("Add to Bag", "lumi") ?>
                    </button>
                </div>
            </form>
            <!-- end for large device -->

        <?php endwhile; ?>
        <!-- end of the loop -->

        <!-- pagination here -->

        <?php wp_reset_postdata(); ?>
    </div>
</section>



<?php get_footer(); ?>