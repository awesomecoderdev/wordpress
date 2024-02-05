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

// get products
$products = lumi_get_products([
    "post__in" => lumi_get_wishlist()
]);

?>

<?php get_header(); ?>

<?php if ($products->have_posts()) : ?>

    <main id="main" class="<?php echo lumi_container("not-prose"); ?>">
        <div class="relative w-full md:flex hidden justify-between items-center py-5 ">
            <h2 class="text-xl font-semibold"><?php _e("Wishlist", "lumi") ?>(<?php echo $products->found_posts ?>)</h2>

            <button id="add-all-bag" class="relative bg-primary-500 px-4 py-2 flex justify-center items-center gap-2 text-white">
                <svg id="add-to-bag-svg" class="h-6 w-6 p-1" width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.651 5.5984C14.651 3.21232 12.7167 1.27799 10.3307 1.27799C9.18168 1.27316 8.07806 1.72619 7.26387 2.53695C6.44968 3.3477 5.992 4.44939 5.992 5.5984M14.5137 20.5H6.16592C3.09955 20.5 0.747152 19.3924 1.41534 14.9348L2.19338 8.89359C2.60528 6.66934 4.02404 5.81808 5.26889 5.81808H15.4474C16.7105 5.81808 18.0469 6.73341 18.5229 8.89359L19.3009 14.9348C19.8684 18.889 17.5801 20.5 14.5137 20.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M13.296 10.102H13.251" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7.46601 10.102H7.42001" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <!-- start:category sidebar -->
                <?php get_template_part("template/components/loading", null, [
                    "class" => "text-slate-300 hidden",
                    "id" => "add-all-cart-loading"
                ]); ?>
                <?php _e("Move all to Bag", "lumi") ?>
            </button>
        </div>

        <div class="relative py-4 grid <?php echo !wp_is_mobile() ? "gap-4" : "xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 grid-cols-2 gap-4" ?>">

            <!-- pagination here -->

            <!-- the loop -->

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
                <form class="relative add-all-to-wishlist add-to-cart-from-wishlist border xl:rounded-3xl rounded-2xl overflow-hidden md:hidden <?php echo !wp_is_mobile() ? "hidden" : "" ?> " method="POST">
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
                                <input name="quantity" id="wishlist-quantity" class="p-0 m-0 w-10 h-5 bg-transparent leading-none text-xs px-2 border placeholder:text-primary-300 text-primary-500 font-semibold outline-none border-none border-transparent outline-transparent focus:outline-none focus-visible:outline-none focus:ring-transparent text-center" type="number" min="1" value="1">
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
    </main>
<?php else : ?>
    <section id="empty-wishlist-page" class="relative py-10 md:mt-14 mt-10 prose dark:prose-invert min-h-[calc(60vh-112px)] lg:px-8 sm:px-7 xs:px-5 px-4 xl:overflow-visible overflow-hidden not-prose bg-[#F4FFFB] flex justify-center items-center">
        <div class="relative container h-full flex justify-center items-center gap-4">
            <div class="relative h-24 w-24 rounded-full bg-primary-500 flex justify-center items-center">
                <svg width="50" height="45" viewBox="0 0 50 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M45.43 4.69768C42.7799 2.0407 39.267 0.419029 35.5258 0.125604C31.7847 -0.167821 28.0619 0.886344 25.03 3.09768C21.8491 0.731773 17.89 -0.341043 13.9498 0.0952725C10.0096 0.531588 6.38109 2.44462 3.79492 5.44914C1.20875 8.45366 -0.142959 12.3265 0.0119885 16.2877C0.166936 20.2489 1.81703 24.0044 4.62998 26.7977L20.155 42.3477C21.455 43.6271 23.206 44.3442 25.03 44.3442C26.854 44.3442 28.6049 43.6271 29.905 42.3477L45.43 26.7977C48.3489 23.8608 49.9873 19.8884 49.9873 15.7477C49.9873 11.607 48.3489 7.63451 45.43 4.69768ZM41.905 23.3477L26.38 38.8727C26.2033 39.0511 25.9931 39.1927 25.7613 39.2893C25.5296 39.3859 25.281 39.4357 25.03 39.4357C24.7789 39.4357 24.5304 39.3859 24.2986 39.2893C24.0669 39.1927 23.8567 39.0511 23.68 38.8727L8.15499 23.2727C6.19438 21.2685 5.09651 18.5763 5.09651 15.7727C5.09651 12.969 6.19438 10.2768 8.15499 8.27268C10.1529 6.30015 12.8474 5.1941 15.655 5.1941C18.4626 5.1941 21.1571 6.30015 23.155 8.27268C23.3874 8.507 23.6639 8.69299 23.9685 8.81991C24.2732 8.94683 24.6 9.01217 24.93 9.01217C25.26 9.01217 25.5868 8.94683 25.8914 8.81991C26.1961 8.69299 26.4726 8.507 26.705 8.27268C28.7029 6.30015 31.3974 5.1941 34.205 5.1941C37.0126 5.1941 39.7071 6.30015 41.705 8.27268C43.6925 10.2506 44.8265 12.9282 44.8638 15.7319C44.9012 18.5356 43.8391 21.2425 41.905 23.2727V23.3477Z" fill="#2D2D2D" />
                    <path d="M25.03 22.6976C21.4798 22.6976 18.4929 24.7348 17.0453 27.6976H33.0148C31.5671 24.7348 28.5803 22.6976 25.03 22.6976Z" fill="#2D2D2D" />
                    <path d="M30.7175 18.5726C32.099 18.5726 33.1551 17.5165 33.1551 16.1351C33.1551 14.7537 32.0989 13.6976 30.7175 13.6976C29.3361 13.6976 28.28 14.7537 28.28 16.1351C28.28 17.5165 29.3361 18.5726 30.7175 18.5726ZM19.3425 18.5726C20.7239 18.5726 21.78 17.5165 21.78 16.1351C21.78 14.7537 20.7239 13.6976 19.3425 13.6976C17.961 13.6976 16.905 14.7537 16.905 16.1351C16.905 17.5165 17.9611 18.5726 19.3425 18.5726Z" fill="#2D2D2D" />
                </svg>
            </div>

            <div class="relative grid">
                <h2 class="text-sm font-semibold"><?php _e("Empty Wishlist.", "lumi") ?></h2>
                <a class="text-primary-500 underline hover:underline" href="<?php echo site_url("/shop") ?>">
                    <?php _e("Start Shopping.", "lumi") ?>
                </a>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php get_footer(); ?>