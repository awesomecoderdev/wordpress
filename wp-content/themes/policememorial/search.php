<?php

/**
 * The page template file.
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
<!-- start:category header -->
<?php get_template_part("template/section/category/header"); ?>
<!-- start:category header -->


<main id="main" class="<?php echo lumi_container("not-prose"); ?>">
    <div class="relative w-full grid xl:grid-cols-10 lg:grid-cols-8 gap-8">

        <div class="relative xl:col-span-2 lg:col-span-2 space-y-3 lg:p-4 lg:pb-0 lg:pl-0 font-normal lg:border-r ">
            <!-- start:category sidebar -->
            <?php get_template_part("template/section/category/sidebar", null, [
                "class" => "relative"
            ]); ?>
            <!-- start:category sidebar -->

            <!-- start:tags sidebar -->
            <?php get_template_part("template/section/tags/sidebar", null, [
                "class" => "relative"
            ]); ?>
            <!-- start:tags sidebar -->

            <!-- start:colors sidebar -->
            <?php get_template_part("template/section/colors/sidebar", null, [
                "class" => "relative"
            ]); ?>
            <!-- start:colors sidebar -->
        </div>


        <div class="relative xl:col-span-8 lg:col-span-6 py-4">
            <?php
            $query = get_queried_object();
            $paged = isset($_GET["page"]) ? intval($_GET["page"]) : 1;


            $props = [
                // "post__in" => lumi_get_wishlist()
                'posts_per_page' => 12, // Adjust the number of posts per page as needed
                'paged' => $paged, // Use the current page number
            ];
            $colors = isset($_GET["colors"]) && !empty($_GET["colors"]) ? sanitize_text_field(strtolower($_GET["colors"])) : null;

            if (isset($_GET["s"]) && !empty($_GET["s"])) {
                $props['s'] = get_search_query();
            }

            if ($colors) {
                $colors = explode(",", $colors);

                $props['tax_query'] = [
                    // 'relation' => 'OR', // Use 'AND' if you want posts that have all specified terms.
                    'relation' => 'AND', // Change to 'OR' if you want posts that match either taxonomy term.
                    // [
                    //     'taxonomy' => $query?->taxonomy ?? "pa_color",
                    //     'field'    => 'slug',
                    //     'terms'    => $query->slug, // Custom taxonomy terms
                    // ],
                    [
                        'taxonomy' => "pa_color", // old product_color
                        'field'    => 'slug',
                        'terms'    => $colors ?? ["lumi"],
                    ],
                ];
            } else {
                // $props['tax_query'] = [
                //     'relation' => 'OR', // Use 'AND' if you want posts that have all specified terms.
                //     [
                //         'taxonomy' => $query->taxonomy,
                //         'field'    => 'slug',
                //         'terms'    => $query->slug, // Custom taxonomy terms
                //     ]
                // ];
            }

            // get products
            $products = lumi_get_products($props);

            ?>

            <?php if ($products->have_posts()) : ?>
                <div class="relative w-full grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 gap-8 pb-10">

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

                        <form class="relative add-to-cart" method="POST">
                            <input type="hidden" name="product_sku" value="<?php echo $product_sku; ?>">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button class="absolute top-4 right-4 cursor-pointer" id="add-to-wishlist" data-product="<?php the_ID() ?>">
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
                            <img class="rounded-xl xl:aspect-[3/4] lg:aspect-[3/4] md:aspect-[3/4] w-full  bg-slate-100 dark:bg-slate-400 cursor-pointer" src="<?php the_post_thumbnail_url() ?>" alt="<?php the_title(); ?>">
                            <div class="relative w-full flex justify-between items-center pt-2 ">
                                <a href="<?php the_permalink() ?>" class="not-prose text-sm font-semibold">
                                    <?php the_title(); ?>
                                </a>
                                <button class="text-slate-600 dark:text-white flex justify-center items-center" type="submit">
                                    <svg id="add-to-bag" class="" width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.651 5.5984C14.651 3.21232 12.7167 1.27799 10.3307 1.27799C9.18168 1.27316 8.07806 1.72619 7.26387 2.53695C6.44968 3.3477 5.992 4.44939 5.992 5.5984M14.5137 20.5H6.16592C3.09955 20.5 0.747152 19.3924 1.41534 14.9348L2.19338 8.89359C2.60528 6.66934 4.02404 5.81808 5.26889 5.81808H15.4474C16.7105 5.81808 18.0469 6.73341 18.5229 8.89359L19.3009 14.9348C19.8684 18.889 17.5801 20.5 14.5137 20.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M13.296 10.102H13.251" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M7.46601 10.102H7.42001" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <svg id="add-to-cart-loading" class="hidden h-6 w-6 p-1 animate-spin fill-slate-600 text-slate-100" aria-hidden="true" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                                    </svg>
                                </button>
                            </div>
                            <a href="<?php the_permalink() ?>" class="text-sm font-semibold product-loop-price"><?php echo $product->get_price_html(); ?></a>
                        </form>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="absolute bottom-0 w-full">

                    <!-- start:Pagination header -->
                    <div class="relative w-full flex items-center justify-center gap-3 pt-10">
                        <?php echo paginate_links(array(
                            'base'         => '%_%',
                            'format'       => '?page=%#%',
                            'current'            => isset($_GET["page"]) ? intval($_GET["page"]) : 1,
                            'total'              => $products->max_num_pages,
                            'prev_text'          => __('<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>'),
                            'next_text'          => __('<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>'),
                        ));
                        ?>
                    </div>
                    <!-- start:Pagination header -->

                </div>

                <?php wp_reset_postdata(); ?>

            <?php else : ?>
                <div class="relative w-full flex justify-center items-center h-full">
                    <div class="relative max-w-sm space-y-2">
                        <div class="relative flex items-center justify-center rounded-full bg-primary-50/15 overflow-hidden p-20">
                            <svg class="h-full w-full text-primary-500" width="141" height="67" viewBox="0 0 141 67" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.3651 1.14544C9.75881 3.74075 3.86037 11.5267 1.26506 21.0822C-0.268534 26.8626 -0.150565 36.2411 1.61897 40.724C4.98108 49.5126 11.2334 52.1669 19.1963 48.156C23.9151 45.7966 28.1619 41.1368 31.1701 34.9435C34.2373 28.5142 35.417 22.9697 35.1221 15.4786C34.9451 10.288 34.7092 9.2263 33.1756 6.39505C30.8162 2.08919 27.926 0.26067 23.2072 0.0247345C20.6119 -0.093235 18.7244 0.201687 16.3651 1.14544ZM28.4569 5.15637C31.1112 7.6927 32.2908 11.4087 32.2908 16.9532C32.2908 28.9271 25.9795 41.5497 18.0166 45.5017C12.4131 48.3329 7.93029 46.9763 5.276 41.6677C0.439279 31.8763 3.86037 14.7118 12.1182 7.45676C17.8987 2.38411 24.6229 1.44036 28.4569 5.15637Z" fill="#92B193" />
                                <path d="M17.6627 7.2798C9.58187 11.2907 4.45023 24.0314 6.33773 35.1794C7.98929 45.0298 13.7108 46.8583 20.7299 39.7802C26.3924 34.0587 29.6366 24.9161 29.2237 15.7735C28.8108 6.45401 24.9768 3.62277 17.6627 7.2798ZM25.3307 11.0548C28.1619 16.6583 25.2127 29.8708 19.6682 36.713C17.3088 39.5442 13.2389 41.6677 11.7643 40.7829C9.10999 39.0724 8.28421 28.4552 10.3487 21.8489C12.767 14.122 18.1936 8.51847 22.8534 8.87238C23.9151 8.93136 24.6229 9.58019 25.3307 11.0548Z" fill="#92B193" />
                                <path d="M133.567 1.14541C132.151 2.26611 131.797 3.62275 129.025 18.4868C127.433 26.9216 126.666 32.7021 126.902 33.7048C127.374 35.5923 130.382 37.1259 132.21 36.4181C134.688 35.5333 135.396 33.2919 138.109 18.8407C140.881 3.79971 140.94 2.3251 138.522 1.08642C136.988 0.201656 134.747 0.260643 133.567 1.14541ZM137.401 4.09463C137.637 4.80244 132.977 30.9325 132.269 32.7021C131.856 33.8228 129.615 33.6458 129.615 32.5251C129.615 30.8735 134.334 6.1001 134.924 4.68447C135.514 3.26884 136.988 2.91494 137.401 4.09463Z" fill="#92B193" />
                                <path d="M48.3937 9.1082C42.9081 10.9957 37.5405 17.8969 35.5351 25.5059C34.4144 29.8707 34.4144 37.7156 35.4761 41.3727C37.1276 46.8582 40.7257 49.9844 45.3855 49.9844C55.1769 49.9254 64.2015 37.1258 64.3784 23.1465C64.3784 18.3098 64.2605 17.425 62.6679 14.2988C59.8366 8.57734 54.8819 6.80781 48.3937 9.1082ZM58.0671 12.8832C60.4265 15.0656 61.1933 17.602 61.1933 23.0285C61.1933 32.9969 56.3565 42.6113 49.8093 45.7965C42.8491 49.1586 38.2483 45.2066 37.7175 35.2973C37.1276 24.6801 41.3155 15.8324 48.5116 12.4113C52.1687 10.6418 55.8257 10.8187 58.0671 12.8832Z" fill="#92B193" />
                                <path d="M49.6912 15.0066C44.0877 17.8968 41.0205 23.8542 40.6666 32.348C40.4307 37.1257 40.6076 38.4234 41.6103 40.7238C43.1439 44.2038 44.9135 44.7937 48.5705 43.0242C56.5924 39.1312 61.665 21.023 56.3564 15.3605C54.8818 13.7679 52.2865 13.6499 49.6912 15.0066ZM54.7639 18.2507C55.9435 20.4331 55.1767 28.573 53.3482 32.466C51.0478 37.4796 47.7447 41.1367 45.4443 41.1367C44.3826 41.1367 43.4978 37.7156 43.4978 33.4687C43.4978 26.5675 46.565 19.9613 50.6939 17.9558C53.2892 16.6581 53.9381 16.7171 54.7639 18.2507Z" fill="#92B193" />
                                <path d="M117.995 11.7626C116.403 13.5322 112.215 35.0025 113.099 37.2439C114.043 39.7802 117.582 40.7829 119.706 39.1314C121.18 38.0107 121.593 36.654 123.717 24.7392L125.722 14.004L124.483 12.3525C122.891 10.17 119.765 9.87513 117.995 11.7626ZM122.242 14.122C122.655 15.2427 118.703 35.7693 117.936 36.5361C117.464 37.0079 117.051 37.0079 116.462 36.5361C115.754 35.9462 115.931 34.2357 117.582 25.388C119.883 13.2962 119.824 13.4142 121.062 13.4142C121.593 13.4142 122.124 13.7681 122.242 14.122Z" fill="#92B193" />
                                <path d="M74.7006 15.1247C70.2768 16.8352 68.3303 18.2509 67.6815 20.1974C67.3866 21.1411 65.912 27.3934 64.4374 33.9997C61.5471 47.1532 61.5471 48.4509 64.7913 49.6306C68.5073 50.9282 70.3948 49.0407 71.7514 42.8474C72.4003 39.7212 72.5772 39.5442 75.5264 38.0696C80.1272 35.8282 85.7307 31.4634 87.5003 28.7501C90.6264 24.0313 89.8006 17.602 85.8487 15.1837C83.3713 13.7091 78.4756 13.6501 74.7006 15.1247ZM84.2561 17.72C86.9694 19.7845 87.2053 23.4415 84.9639 26.8626C82.7815 29.9888 79.5963 32.4661 74.1108 35.2384L69.628 37.5388L68.8612 41.2548C68.5073 43.3192 67.9174 45.4427 67.6225 45.9735C66.9737 47.1532 65.5581 47.3892 65.2042 46.3274C64.7913 45.1477 70.4538 21.0231 71.3385 20.1384C73.8159 17.661 82.1327 16.1274 84.2561 17.72Z" fill="#92B193" />
                                <path d="M75.9393 20.9641L73.285 21.9668L72.2233 26.6266C70.5717 33.7047 71.8104 34.1766 78.9475 28.986C82.1917 26.6266 83.9612 23.6774 83.3714 21.495C83.0764 20.1383 82.7225 19.9024 80.776 19.9614C79.5964 19.9614 77.4139 20.4332 75.9393 20.9641ZM78.4756 25.3289C75.8803 27.9243 74.9366 27.9832 75.5854 25.5649C75.7624 24.7391 76.5881 23.9133 77.5319 23.5594C80.7171 22.3797 80.953 22.8516 78.4756 25.3289Z" fill="#92B193" />
                                <path d="M98.0584 15.4195C96.7607 15.8914 94.5783 17.484 93.2807 18.9586C87.9721 24.7391 88.6799 31.9941 95.0502 38.1285C99.1201 42.0805 96.8197 42.3754 92.4549 38.4824C89.0338 35.4152 86.9104 35.0613 84.9049 37.1848C82.7225 39.4852 83.1943 41.9035 86.2615 45.0297C91.0982 49.8074 96.1709 51.1051 101.008 48.8047C105.667 46.5633 107.732 41.5496 105.726 37.5387C105.137 36.418 103.721 34.4715 102.482 33.1148C98.8842 29.1629 98.2354 27.9242 98.8842 26.2137C99.2381 25.3879 100.005 24.3852 100.713 24.0312C101.833 23.4414 101.892 23.5594 101.892 26.6855C101.892 30.6375 103.19 32.2891 106.257 32.2891C109.383 32.2891 110.563 30.3426 111.035 24.3852C111.271 21.6719 111.271 18.8996 111.035 18.1918C110.15 15.3605 102.659 13.768 98.0584 15.4195ZM106.198 18.1918L108.499 18.7816L108.086 23.6184C107.614 28.809 107.26 29.6937 105.667 29.1039C104.842 28.809 104.724 28.2191 105.019 25.2699C105.49 21.082 104.783 20.1383 101.538 20.6691C98.9432 21.082 97.2916 22.4977 96.1709 25.1519C94.9322 28.0422 95.64 29.9297 99.592 34.4125C101.538 36.5949 103.249 39.0723 103.485 39.898C103.957 41.7855 102.718 43.968 100.182 45.6785C96.7018 48.0379 92.8088 47.1531 88.6799 43.1422C86.3795 40.9008 86.0256 39.5441 87.5002 38.9543C88.09 38.7184 89.2697 39.4852 90.9213 41.0777C94.1654 44.2629 97.1146 44.9117 99.2381 42.9062C100.064 42.1394 100.713 41.1957 100.713 40.7828C100.713 40.3699 99.2971 38.3644 97.5275 36.418C93.3986 31.7582 92.101 28.632 93.0447 25.2699C94.6373 19.3125 99.9459 16.4223 106.198 18.1918Z" fill="#92B193" />
                                <path d="M113.453 42.3755C111.507 43.9091 111.33 47.0353 113.099 48.8048C115.931 51.6361 121.298 48.9228 120.531 45.0888C119.824 41.4318 116.403 40.0751 113.453 42.3755ZM117.228 44.9708C117.995 45.9146 117.582 47.0353 116.344 47.0353C115.282 47.0353 114.692 46.0326 115.105 44.9708C115.518 43.8501 116.285 43.8501 117.228 44.9708Z" fill="#92B193" />
                                <path d="M127.02 42.3754C124.011 44.7348 125.663 49.9844 129.497 49.9844C133.036 49.9844 135.101 46.6812 133.508 43.5551C132.092 40.8418 129.556 40.3699 127.02 42.3754ZM130.618 44.7348C131.443 45.5605 130.972 47.0352 129.91 47.0352C128.848 47.0352 128.258 46.0324 128.671 44.9707C129.025 43.909 129.733 43.85 130.618 44.7348Z" fill="#92B193" />
                                <path d="M76.824 54.1133C57.1822 54.8211 33.2935 57.4164 14.0057 60.9555C0.262298 63.4918 -0.858404 63.9047 0.380268 65.7922C0.734174 66.441 2.56269 66.2641 9.93574 64.7895C26.9822 61.4274 46.86 58.95 67.0916 57.5934C77.1189 56.9446 112.51 57.1805 122.419 58.0063C126.43 58.3602 126.666 58.3012 126.666 57.1805C126.666 56.4727 126.489 55.8239 126.253 55.7059C125.545 55.293 107.909 54.1723 98.0584 53.9364C93.2217 53.8184 83.6662 53.8774 76.824 54.1133Z" fill="#92B193" />
                            </svg>
                        </div>
                        <div class="text-base py-4 font-semibold text-center"><?php _e("Your search", "lumi") ?> <strong>“<?php echo get_search_query(); ?>”</strong> <?php _e('didn’t match any products.', 'lumi') ?></div>
                        <div class="relative flex justify-center">
                            <button class="relative flex items-center bg-primary-500 rounded-full px-4 py-2 text-sm text-slate-50 mx-auto  space-x-2" onclick="history.back();">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <?php _e("Go Back", "lumi") ?>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>