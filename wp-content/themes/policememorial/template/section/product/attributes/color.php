<?php

global $product;

?>


<?php if ($product->get_attribute('pa_color')) : ?>
    <?php $colors = wc_get_product_terms($product->get_id(), 'pa_color'); ?>
    <h2 class="text-base font-semibold"><?php _e("Select Color", "lumi") ?></h2>
    <div class="relative flex flex-wrap gap-3 product-colors">
        <?php foreach ($colors as $key => $color) : ?>
            <div class="w-9 h-9 flex justify-center items-center cursor-pointer rounded-lg border product-colors-item <?php echo $key == 0 ? "active" : "" ?>" data-color="<?php echo $color?->slug; ?>" id="product-colors-item" style="background: <?php echo get_lumi_product_color($color->term_id) ?>;">
                <?php if (in_array($color->slug, get_lumi_request_colors() ?? [])) : ?>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 <?php echo in_array($color->slug, ["white", "orange"]) ? "text-slate-700" : "text-white" ?>">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>